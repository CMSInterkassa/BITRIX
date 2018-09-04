<?php 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\IO\Path; 
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

require_once(dirname(__FILE__) . '/Interkassa.php');

$interkassa = new Interkassa();
$interkassa -> initParams();

if(isset($_REQUEST['paysys'])){
	
	$APPLICATION->RestartBuffer(); 	
	
    $secret_key = $interkassa -> secret_key;
    
	if (isset($_POST['ik_act']) && $_POST['ik_act'] == 'process'){
		$form = $_POST;
        $form['ik_sign'] = self::IkSignFormation($form, $secret_key);
		echo Interkassa::getAnswerFromAPI($form);
	}
	else
		echo Interkassa::IkSignFormation($_POST, $secret_key);

	exit;
}

$dataForm = $interkassa -> getDataForm();

include(dirname(__FILE__).'/tmpl/form.php');
