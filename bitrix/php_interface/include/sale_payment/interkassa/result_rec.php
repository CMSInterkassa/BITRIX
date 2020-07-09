<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\IO\Path;
include(GetLangFileName(dirname(__FILE__) . "/", "/lang.php"));

//proccess request
if (count($_REQUEST) && iKcheckIP()) {
	
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


function iKcheckIP()
{
    $ip_stack = array(
        '151.80.190.97',
        '35.233.69.55',
    );

    $ip = !empty($_SERVER['HTTP_CF_CONNECTING_IP'])? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
	$ip_callback = ip2long($ip) ? ip2long($ip) : !ip2long($ip);

	if ($ip_callback == ip2long($ip_stack[0]) || $ip_callback == ip2long($ip_stack[1])) {
		return true;
	} else {
		return false;
    }
}
