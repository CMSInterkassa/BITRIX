<?php
/**
 * Разработка модуля GateOn
 * www.gateon.net
 * www@smartbyte.pro
 * Версия 1.1 2016
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

use Bitrix\Main\IO\Path;
include(GetLangFileName(dirname(__FILE__) . "/", "/lang.php"));

$merchant_id = CSalePaySystemAction::GetParamValue("merchant_id");
$secret_key = CSalePaySystemAction::GetParamValue("secur_key");
$test_key = CSalePaySystemAction::GetParamValue("test_key");

//proccess request
if (count($_REQUEST) && checkIP()) {
    if($_POST['ik_co_id']){
        
        if(isset($_POST['ik_pw_via']) && $_POST['ik_pw_via'] == 'test_interkassa_test_xts'){
            $sekret = $test_key;
        } else {
            $sekret = $secret_key;
        }

        $data = array();
        foreach ($_REQUEST as $key => $value) {
            if (!preg_match('/ik_/', $key)) continue;
            $data[$key] = $value;
        }

        $ik_sign = $data['ik_sign'];
        unset($data['ik_sign']);
        ksort($data, SORT_STRING);
        array_push($data, $sekret);
        $signString = implode(':', $data);
        $sign = base64_encode(md5($signString, true));

        if ($sign === $ik_sign && $data['ik_co_id'] === $merchant_id) {

            $order_id = $data['ik_pm_no'];
            if (!($arOrder = CSaleOrder::GetByID(intval($order_id)))) {
                header('HTTP/1.0 400 Bad Request');
                exit;
            }

            CSalePaySystemAction::InitParamArrays($arOrder, $arOrder["ID"]);

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
                        CSaleOrder::StatusOrder($arOrder["ID"], "F");
                        exit("OK");
                    } else {
                        header('HTTP/1.0 400 Bad Request');
                        exit();
                    }
                }
            } else {
                header('HTTP/1.0 400 Bad Request');
                exit();
            }  
            
        } else {
            header('HTTP/1.0 400 Bad Request');
            exit();
        }
    }   
}
function checkIP(){
    $ip_stack = array(
        'ip_begin'=>'151.80.190.97',
        'ip_end'=>'151.80.190.104'
    );

    if(!ip2long($_SERVER['REMOTE_ADDR'])>=ip2long($ip_stack['ip_begin']) && !ip2long($_SERVER['REMOTE_ADDR'])<=ip2long($ip_stack['ip_end'])){
        exit();
    }
    return true;
}
exit();
