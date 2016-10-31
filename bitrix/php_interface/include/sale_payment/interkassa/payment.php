<?php 
/**
 * Разработка модуля GateOn
 * www.gateon.net
 * www@smartbyte.pro
 * Версия 1.1 2016
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\IO\Path; 
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $ik_config;

$ik_config = array();
$action = "https://sci.interkassa.com/";
$secret_key = CSalePaySystemAction::GetParamValue("secur_key");
$test_key = CSalePaySystemAction::GetParamValue("test_key");
$test_mode = CSalePaySystemAction::GetParamValue("test_mode");

$ik_config['ik_co_id'] = CSalePaySystemAction::GetParamValue("merchant_id");
$ik_config['ik_pm_no'] = CSalePaySystemAction::GetParamValue("order_id");
$ik_config['ik_am'] = number_format(CSalePaySystemAction::GetParamValue("amount"), 2, '.', '');
$ik_config['ik_cli'] = CSalePaySystemAction::GetParamValue("email_client");
$ik_config['ik_cur'] = CSalePaySystemAction::GetParamValue("cur");
$ik_config['ik_desc'] = "#".$ik_config['ik_pm_no'];


ksort($ik_config, SORT_STRING);
$ik_config['secret'] = $secret_key;

$signString = implode(':', $ik_config);

$signature = base64_encode(md5($signString, true));
unset($ik_config["secret"]);
$ik_config["ik_sign"] = $signature;

include(dirname(__FILE__).'/tmpl/form.php');
