<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\IO\Path;
include(GetLangFileName(dirname(__FILE__) . "/", "/lang.php"));

//proccess request
if (count($_REQUEST) && iKcheckIP()) {
	
	file_put_contents(__DIR__ . '/temp.log', json_encode($_POST, JSON_PRETTY_PRINT));
	
	$data = $_POST;
	
	$order_id = intval($data['ik_pm_no']);
    if (!($arOrder = CSaleOrder::GetByID($order_id))) {
		header('HTTP/1.0 400 Bad Request');
        exit;
	}

    if($data['ik_co_id']){
        require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/sale_payment/interkassa/Interkassa.php');
		$interkassa = new Interkassa();
		$interkassa -> initParams();
 
		$secret_key = $interkassa -> secret_key;
		if (isset($data['ik_pw_via']) && $data['ik_pw_via'] == 'test_interkassa_test_xts')
			$secret_key = $interkassa -> test_key;

        $sign = Interkassa::IkSignFormation($data, $secret_key);

        if ($sign === $data['ik_sign'] && $data['ik_co_id'] === $interkassa -> merchant_id) {
            if ($arOrder["PAYED"] == "N") {
                $arFields = array(
                    "PS_STATUS" => "Y",
                    "PS_STATUS_CODE" => "-",
                    "PS_STATUS_DESCRIPTION" => $order_id,
                    "PS_STATUS_MESSAGE" => $data['ik_inv_st'],
                    "PS_SUM" => $data['ik_am'],
                    "PS_CURRENCY" => $data['ik_cur'],
                    "PS_RESPONSE_DATE" => date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
                    "USER_ID" => $arOrder["USER_ID"],
                );

                if (CSaleOrder::Update($arOrder["ID"], $arFields)) {
                    if ($arOrder["PRICE"] == $data['ik_am']) {
                        CSaleOrder::PayOrder($arOrder["ID"], "Y", false);
                        CSaleOrder::StatusOrder($arOrder["ID"], "P");
                    }
                }
            }
        } else {
            $arFields = array(
					"PAYED" => "N",
					"PS_STATUS" => "N",
					"PS_SUM" => $data['ik_am'],
					"PS_CURRENCY" => $data['ik_cur'],
					"PAY_VOUCHER_NUM" => $data["ik_inv_id"],
					"PS_STATUS_DESCRIPTION" => '',
					"DATE_PAYED" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
			);
			CSaleOrder::PayOrder($ID, "N", true, true, 0, $arFields);
        }
    }
}

header('HTTP/1.0 400 Bad Request');
exit;


function iKcheckIP(){
    $ip_stack = array(
        'ip_begin'=>'151.80.190.97',
        'ip_end'=>'151.80.190.104'
    );

    if(!ip2long($_SERVER['REMOTE_ADDR'])>=ip2long($ip_stack['ip_begin']) && !ip2long($_SERVER['REMOTE_ADDR'])<=ip2long($ip_stack['ip_end'])){
        return false;
    }
	
    return true;
}
