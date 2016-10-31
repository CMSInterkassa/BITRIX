<?php
/**
 * Разработка модуля GateOn
 * www.gateon.net
 * www@smartbyte.pro
 * Версия 1.1 2016
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$psTitle = Loc::getMessage("module_title");
$psDescription = str_replace("#response_url#", "http://" . $_SERVER['SERVER_NAME'] . "/payment/interkassa/st.php", Loc::getMessage("desc"));
$psDescription = str_replace("#suc_url#", "http://" . $_SERVER['SERVER_NAME'] . "/payment/interkassa/success.php", $psDescription);
$psDescription = str_replace("#fail_url#", "http://" . $_SERVER['SERVER_NAME'] . "/payment/interkassa/fail.php", $psDescription);

$psTypeDescr = Loc::getMessage("desc");

$arPSCorrespondence = array(
    "merchant_id" => array(
        "NAME" => Loc::getMessage("merchant_id"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),
    "secur_key" => array(
        "NAME" => Loc::getMessage("secur_key"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),
    "test_key" => array(
        "NAME" => Loc::getMessage("test_key"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),
    "email_client" => array(
      "NAME" => Loc::getMessage("email_client"),
      "DESCR" => "",
      "VALUE" => "",
      "TYPE" => "ORDER"
    ),
    "order_id" => array(
        "NAME" => Loc::getMessage("order_id"),
        "DESCR" => "",
        "VALUE" => "order_id",
        "TYPE" => "ORDER"
    ),
    "amount" => array(
        "NAME" => Loc::getMessage("amount"),
        "DESCR" => "",
        "VALUE" => "amount",
        "TYPE" => "ORDER"
    ),
    "cur" => array(
        "NAME" => Loc::getMessage("cur"),
        "DESCR" => "",
        "VALUE" => "cur",
        "TYPE" => "ORDER"
    ),
    "test_mode" => array(
        "NAME" => Loc::getMessage("test_mode"),
        "DESCR" => "",
        "VALUE" => array(
            'Y' => array('NAME' => Loc::getMessage("test_yes")),
            'N' => array('NAME' => Loc::getMessage("test_no"))
        ),
        "TYPE" => "SELECT"
    ),
);
