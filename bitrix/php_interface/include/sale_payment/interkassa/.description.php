<?php
/**
 * Разработка модуля GateOn
 * www.gateon.net
 * www@smartbyte.pro
 * Версия 1.3 2016
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$psTitle = Loc::getMessage("INTERKASSA_MAIN_TITLE");
$psDescription = str_replace("#RESULT_URL#", "http://" . $_SERVER['SERVER_NAME'] . "/payment/interkassa/st.php", Loc::getMessage("INTERKASSA_MAIN_DESCR"));
$psDescription = str_replace("#OK_URL#", "http://" . $_SERVER['SERVER_NAME'] . "/payment/interkassa/success.php", $psDescription);
$psDescription = str_replace("#ERR_URL#", "http://" . $_SERVER['SERVER_NAME'] . "/payment/interkassa/fail.php", $psDescription);

$psTypeDescr = Loc::getMessage("INTERKASSA_TYPE_DESCR");

// Загружаем все платежные системы
$interkassaPayments = array("_dvsmanual"=>array("NAME"=>"Пользователь сам выбирает систему оплаты"));
$jsonPaymentsString = json_decode(file_get_contents('https://api.interkassa.com/v1/paysystem-input-payway'));
foreach ($jsonPaymentsString->data as $payInfo) {
    $interkassaPayments[$payInfo->als]=array("NAME"=>("[".$payInfo->name[0]->v."] ".$payInfo->ps." - ".$payInfo->curAls." - ".$payInfo->inAls) );
}
ksort($interkassaPayments);

$arPSCorrespondence = array(
    "MERCHANT_ID" => array(
        "NAME" => Loc::getMessage("MERCHANT_ID"),
        "DESCR" => Loc::getMessage("MERCHANT_ID_DESCR"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "SECRET_KEY" => array(
        "NAME" => Loc::getMessage("SECRET_KEY"),
        "DESCR" => Loc::getMessage("SECRET_KEY_DESCR"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "SECRET_TEST_KEY" => array(
        "NAME" => Loc::getMessage("SECRET_TEST_KEY"),
        "DESCR" => Loc::getMessage("SECRET_TEST_KEY_DESCR"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "PAYMENT_VALUE" => array(
        "NAME" => GetMessage("SALE_TYPE_PAYMENT"),
        "DESCR" => GetMessage("SALE_TYPE_PAYMENT_DESCR"),
        "TYPE" => "SELECT",
        "VALUE" => $interkassaPayments,
    ),
    "ORDER_EMAIL" => array(
      "NAME" => Loc::getMessage("ORDER_EMAIL"),
      "DESCR" => Loc::getMessage("ORDER_EMAIL_DESCR"),
      "VALUE" => "",
      "TYPE" => "ORDER"
    ),
    "ORDER_ID" => array(
        "NAME" => Loc::getMessage("ORDER_ID"),
        "DESCR" => "",
        "VALUE" => "ID",
        "TYPE" => "ORDER"
    ),
    "SHOULD_PAY" => array(
        "NAME" => Loc::getMessage("SHOULD_PAY"),
        "DESCR" => "",
        "VALUE" => "SHOULD_PAY",
        "TYPE" => "ORDER"
    ),
    "CURRENCY" => array(
        "NAME" => Loc::getMessage("CURRENCY"),
        "DESCR" => Loc::getMessage("CURRENCY_DESCR"),
        "VALUE" => "CURRENCY",
        "TYPE" => "ORDER"
    ),
    "ORDER_DESCRIPTION" => array(
        "NAME" => Loc::getMessage("ORDER_DESCRIPTION"),
        "DESCR" => Loc::getMessage("ORDER_DESCRIPTION_DESCR"),
        "VALUE" => Loc::getMessage("ORDER_DESCRIPTION_VALUE"),
        "TYPE" => ""
    ),
    "INTERKASSA_TEST" => array(
        "NAME" => Loc::getMessage("INTERKASSA_TEST"),
        "DESCR" => Loc::getMessage("INTERKASSA_TEST_DESCR"),
        "VALUE" => array(
            'Y' => array('NAME' => Loc::getMessage("INTERKASSA_YES")),
            'N' => array('NAME' => Loc::getMessage("INTERKASSA_NO"))
        ),
        "TYPE" => "SELECT"
    ),
    "AMOUNT_TYPE" => array(
        "NAME" => Loc::getMessage("AMOUNT_TYPE"),
        "DESCR" => Loc::getMessage("AMOUNT_TYPE_DESCR"),
        "VALUE" => array(
            'invoice' => array('NAME' => 'invoice'),
            'payway' => array('NAME' => 'payway')
        ),
        "TYPE" => "SELECT"
    )
);
