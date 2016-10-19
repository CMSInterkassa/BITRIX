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

$ik_config['sid'] = CSalePaySystemAction::GetParamValue("MERCHANT_ID");
$ik_config['key'] = CSalePaySystemAction::GetParamValue("SECRET_KEY");

$ik_config['payment'] = CSalePaySystemAction::GetParamValue("PAYMENT_VALUE");

$ik_config['oid'] = CSalePaySystemAction::GetParamValue("ORDER_ID");
$ik_config['price'] = number_format(CSalePaySystemAction::GetParamValue("SHOULD_PAY"), 2, '.', '');

$ik_config['amount_type'] = CSalePaySystemAction::GetParamValue("AMOUNT_TYPE");

$ik_config['test_key'] = CSalePaySystemAction::GetParamValue("SECRET_TEST_KEY");
$ik_config['test'] = (($ik_config['payment']=="test_interkassa_test_xts")?"Y":"N");

$ik_config['email'] = CSalePaySystemAction::GetParamValue("ORDER_EMAIL");

$ik_config['cur'] = CSalePaySystemAction::GetParamValue("CURRENCY");

$ik_config['desc'] = CSalePaySystemAction::GetParamValue("ORDER_DESCRIPTION");
$ik_config['desc'] = str_replace("#ID#", $ik_config['oid'], $ik_config['desc']);

include __DIR__.'/lib/interkassa.php';
Interkassa::register();

$shop = Interkassa_Shop::factory(array(
    'id' => $ik_config['sid'],
    'secret_key' => (($ik_config['test']==="Y")?$ik_config['test_key']:$ik_config['key']),
    'test_key' => $ik_config['test_key']
));

$payment = $shop->createPayment(array(
    'id' => $ik_config['oid'],
    'amount' => $ik_config['price'],
    'description' => "#".$ik_config['desc'],
    'amount_type' => $ik_config['amount_type'],
    'payment' => $ik_config['payment'],
    'email' => $ik_config['email'],
    'locale' => 'ru',
    'currency' => $ik_config['cur'],
));

//$payment->setBaggage('test_baggage');

include(dirname(__FILE__).'/tmpl/form.php');
