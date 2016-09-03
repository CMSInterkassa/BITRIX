<?php
/**
 * Разработка модуля GateOn
 * www.gateon.net
 * www@smartbyte.pro
 * Версия 1.1 2016
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$APPLICATION->IncludeComponent('bitrix:sale.order.payment.receive','',
	Array(
		'PAY_SYSTEM_ID' => '10', // Укажите ID платежной системы
		'PERSON_TYPE_ID' => array('1') // Укажите ID типов плательщиков
	)
);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>