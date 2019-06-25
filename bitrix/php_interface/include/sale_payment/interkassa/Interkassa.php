<?php
class Interkassa
{
	public $actionUrl = 'https://sci.interkassa.com/';

    const ikUrlSCI = 'https://sci.interkassa.com/';
    const ikUrlAPI = 'https://api.interkassa.com/v1/';
	
	public function initParams()
    {
		$this -> test_mode = (CSalePaySystemAction::GetParamValue('TEST_MODE') == 'Y')? 1 : 0;
		$this -> merchant_id = CSalePaySystemAction::GetParamValue('MERCHANT_ID');
		$this -> secret_key = CSalePaySystemAction::GetParamValue('SECRET_KEY');
		$this -> test_key = CSalePaySystemAction::GetParamValue('TEST_KEY');
		$this -> api_enable = (CSalePaySystemAction::GetParamValue('API_ENABLE') == 'Y')? 1 : 0;
		$this -> api_id = CSalePaySystemAction::GetParamValue('API_ID');
		$this -> api_key = CSalePaySystemAction::GetParamValue('API_KEY');		
		
		$this -> order_id = (int)CSalePaySystemAction::GetParamValue('ORDER_ID');
		$this -> amount = number_format(CSalePaySystemAction::GetParamValue('AMOUNT'), 2, '.', '');
		$this -> currency = CSalePaySystemAction::GetParamValue('CURRENCY');
		
		$this -> page_succ = CSalePaySystemAction::GetParamValue('PAGE_SUCC');
		$this -> page_fail = CSalePaySystemAction::GetParamValue('PAGE_FAIL');
	}   

    public function getDataForm()
    {        
        $FormData = array();
        $FormData['ik_am'] = $this -> amount;
        $FormData['ik_pm_no'] = $this -> order_id;
        $FormData['ik_co_id'] = $this -> merchant_id;
        $FormData['ik_desc'] = "Payment for order " . $this -> order_id;
        $FormData['ik_cur'] = $this -> currency;

        $def_url = 'http://' . SITE_SERVER_NAME . '/personal/orders/';

        $FormData['ik_ia_u'] = 'http://' . SITE_SERVER_NAME . '/payment-interkassa/callback.php';
        $FormData['ik_suc_u'] = !empty($this -> page_succ)? $this -> page_succ : $def_url;
        $FormData['ik_fal_u'] = !empty($this -> page_fail)? $this -> page_fail : $def_url;
        $FormData['ik_pnd_u'] = $def_url;

        if($FormData['ik_cur'] == 'RUR')
            $FormData['ik_cur'] = 'RUB';

        $secret_key = $this -> secret_key;

        if ($this -> test_mode) {
            $FormData['ik_pw_via'] = 'test_interkassa_test_xts';
        }

        $FormData['ik_sign'] = self::IkSignFormation($FormData, $secret_key);

        return $FormData;
    }

    public static function IkSignFormation($data, $secret_key)
    {
        if (!empty($data['ik_sign'])) unset($data['ik_sign']);

        $dataSet = array();
        foreach ($data as $key => $value) {
            if (!preg_match('/ik_/', $key)) continue;
			
            $dataSet[$key] = $value;
        }

        ksort($dataSet, SORT_STRING);
        array_push($dataSet, $secret_key);
        $arg = implode(':', $dataSet);
        $ik_sign = base64_encode(md5($arg, true));

        return $ik_sign;
    }    

    public static function getAnswerFromAPI($data)
    {
        $ch = curl_init(self::ikUrlSCI);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        return $result;
    }

    public function getPaymentSystems()
    {
        $username = $this -> api_id;
        $password = $this -> api_key;
        $remote_url = self::ikUrlAPI . 'paysystem-input-payway?checkoutId=' . $this -> merchant_id;

        $businessAcc = $this->getIkBusinessAcc($username, $password);

        $ikHeaders = [];
        $ikHeaders[] = "Authorization: Basic " . base64_encode("$username:$password");
        if(!empty($businessAcc)) {
            $ikHeaders[] = "Ik-Api-Account-Id: " . $businessAcc;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ikHeaders);
        $response = curl_exec($ch);

        if(empty($response))
            return '<strong style="color:red;">Error!!! System response empty!</strong>';

        $json_data = json_decode($response);
        if ($json_data->status != 'error') {
            $payment_systems = array();
            if(!empty($json_data->data)){
                foreach ($json_data->data as $ps => $info) {
                    $payment_system = $info->ser;
                    if (!array_key_exists($payment_system, $payment_systems)) {
                        $payment_systems[$payment_system] = array();
                        foreach ($info->name as $name) {
                            if ($name->l == 'en') {
                                $payment_systems[$payment_system]['title'] = ucfirst($name->v);
                            }
                            $payment_systems[$payment_system]['name'][$name->l] = $name->v;
                        }
                    }
                    $payment_systems[$payment_system]['currency'][strtoupper($info->curAls)] = $info->als;
                }
            }

            return !empty($payment_systems)? $payment_systems : '<strong style="color:red;">API connection error or system response empty!</strong>';
        } else {
            if(!empty($json_data->message))
                return '<strong style="color:red;">API connection error!<br>' . $json_data->message . '</strong>';
            else
                return '<strong style="color:red;">API connection error or system response empty!</strong>';
        }
    }

    public function getIkBusinessAcc($username = '', $password = '')
    {
        $tmpLocationFile = __DIR__ . '/tmpLocalStorageBusinessAcc.ini';
        $dataBusinessAcc = function_exists('file_get_contents')? file_get_contents($tmpLocationFile) : '{}';
        $dataBusinessAcc = json_decode($dataBusinessAcc, 1);
        $businessAcc = is_string($dataBusinessAcc['businessAcc'])? trim($dataBusinessAcc['businessAcc']) : '';
        if(empty($businessAcc) || sha1($username . $password) !== $dataBusinessAcc['hash']) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::ikUrlAPI . 'account');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode("$username:$password")]);
            $response = curl_exec($curl);

            if (!empty($response['data'])) {
                foreach ($response['data'] as $id => $data) {
                    if ($data['tp'] == 'b') {
                        $businessAcc = $id;
                        break;
                    }
                }
            }

            if(function_exists('file_put_contents')){
                $updData = [
                    'businessAcc' => $businessAcc,
                    'hash' => sha1($username . $password)
                ];
                file_put_contents($tmpLocationFile, json_encode($updData, JSON_PRETTY_PRINT));
            }

            return $businessAcc;
        }

        return $businessAcc;
    }
}