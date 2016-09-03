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

include __DIR__.'/lib/interkassa.php';

Interkassa::register();

$shop = Interkassa_Shop::factory(array(
    'id' => CSalePaySystemAction::GetParamValue("MERCHANT_ID"),
    'secret_key' => ((CSalePaySystemAction::GetParamValue("PAYMENT_VALUE")=="test_interkassa_test_xts")?CSalePaySystemAction::GetParamValue("SECRET_TEST_KEY"):CSalePaySystemAction::GetParamValue("SECRET_KEY"))
));


if (count($_REQUEST)) {
    if($_POST['ik_co_id']){
        $merchant_id = $shop->getId();
        $sekret = $shop->getSecretKey();

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

        if ($sign === $ik_sign || $data['ik_co_id'] === $merchant_id) {

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
exit();
