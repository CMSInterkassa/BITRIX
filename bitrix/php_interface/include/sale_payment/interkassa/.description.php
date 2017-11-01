<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$psTitle = Loc::getMessage("SCI_MODULE_TITLE");

$psDescription = str_replace("#response_url#", 'http://' . $_SERVER['SERVER_NAME'] . '/payment-interkassa/callback.php', Loc::getMessage("SCI_DESC"));

$psTypeDescr = Loc::getMessage("SCI_DESC");

$arPSCorrespondence = array(
	"TEST_MODE" => array(
		"SORT" => 101,
        "NAME" => Loc::getMessage("SCI_TEST_MODE"),
        "DESCR" => Loc::getMessage("SCI_TEST_MODE_DESC"),
        "VALUE" => array(
			"Y" => array("NAME" => Loc::getMessage("SCI_TEXT_YES")),
			"N" => array("NAME" => Loc::getMessage("SCI_TEXT_NO"))
		),
		"TYPE" => "SELECT",
    ),   
    "MERCHANT_ID" => array(
		"SORT" => 102,
        "NAME" => Loc::getMessage("SCI_MERCHANT_ID"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),
    "SECRET_KEY" => array(
		"SORT" => 103,
        "NAME" => Loc::getMessage("SCI_SECRET_KEY"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),
    "TEST_KEY" => array(
		"SORT" => 104,
        "NAME" => Loc::getMessage("SCI_TEST_KEY"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),	
	"API_ENABLE" => array(
		"SORT" => 105,
        "NAME" => Loc::getMessage("SCI_API_ENABLE"),       
        "VALUE" => array(
			"Y" => array("NAME" => Loc::getMessage("SCI_TEXT_YES")),
			"N" => array("NAME" => Loc::getMessage("SCI_TEXT_NO"))
		),
		"TYPE" => "SELECT",
    ),
	"API_ID" => array(
		"SORT" => 105,
        "NAME" => Loc::getMessage("SCI_API_ID"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),
	"API_KEY" => array(
		"SORT" => 106,
        "NAME" => Loc::getMessage("SCI_API_KEY"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => ""
    ),   
	"ORDER_ID" => array(
		"SORT" => 108,
		"NAME" => Loc::getMessage("SCI_ORDER_ID"),
		"DEFAULT" => array(
			"PROVIDER_KEY" => "ORDER",
			"PROVIDER_VALUE" => "ID"
		)
	),
	"AMOUNT" => array(
		"SORT" => 109,
		"NAME" => Loc::getMessage("SCI_AMOUNT"),
		"DEFAULT" => array(
			"PROVIDER_KEY" => "ORDER",
			"PROVIDER_VALUE" => "SHOULD_PAY"
		)
	),
	"CURRENCY" => array(
		"SORT" => 110,
		"NAME" => Loc::getMessage("SCI_CURRENCY"),
		"DEFAULT" => array(
				"PROVIDER_KEY" => "ORDER",
				"PROVIDER_VALUE" => "CURRENCY",
		)
	),	
	"PAGE_SUCC" => array(
		"SORT" => 121,
        "NAME" => Loc::getMessage("SCI_PAGE_SUCC"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => "",
		"DEFAULT" => array(
				"PROVIDER_VALUE" => 'http://' . $_SERVER['SERVER_NAME'] . '/personal/orders/',
		)
    ),
	"PAGE_FAIL" => array(
		"SORT" => 122,
        "NAME" => Loc::getMessage("SCI_PAGE_FAIL"),
        "DESCR" => "",
        "VALUE" => "",
        "TYPE" => "",
		"DEFAULT" => array(				
				"PROVIDER_VALUE" => 'http://' . $_SERVER['SERVER_NAME'] . '/personal/orders/',
		)
    ),    
);
