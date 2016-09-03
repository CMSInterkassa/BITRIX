<?php
/**
 * Разработка модуля GateOn
 * www.gateon.net
 * www@smartbyte.pro
 * Версия 1.1 2016
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use \Bitrix\Main\Localization\Loc; Loc::loadMessages(__FILE__);

echo Loc::getMessage("XBILL_FAIL");
echo '<p><a href="/personal/order/"> ' . Loc::getMessage("PAYEER_USER_ORDERS") . '</a></p>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>


