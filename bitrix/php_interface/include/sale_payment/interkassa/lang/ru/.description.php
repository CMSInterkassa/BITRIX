<?php
global $MESS;

$MESS["SCI_TEST_MODE"] = "Тестовый режим";
$MESS["SCI_TEXT_YES"] = "Да";
$MESS["SCI_TEXT_NO"] = "Нет";

$MESS["SCI_MERCHANT_ID"] = "id Кассы";
$MESS["SCI_SECRET_KEY"] = "Секретный ключ";
$MESS["SCI_TEST_KEY"] = "Тестовый ключ";

$MESS["SCI_API_ENABLE"] = "Включить API";
$MESS["SCI_API_ID"] = "ID API";
$MESS["SCI_API_KEY"] = "Ключ API";

$MESS["SCI_PAGE_SUCC"] = "URL страницы при успешной оплате";
$MESS["SCI_PAGE_FAIL"] = "URL страницы при неуспешной оплате";

$MESS["SCI_TEST_MODE_DESC"] = 'Тестовый режим, платежи в системе не засчитываются';

$MESS["SCI_ORDER_ID"] = "Номер заказа";
$MESS["SCI_AMOUNT"] = "Сумма к оплате";
$MESS["SCI_CURRENCY"] = "Валюта платежа";
$MESS["SCI_MODULE_TITLE"] = "Интеркасса";
$MESS["SCI_DESC"] = "<div style='background: #c7f9a5; border-radius: 5px; border: 1px solid; border-color: #409605; color: #000; display: inline-block; margin: 16px 0; padding: 15px 30px 15px 18px;'>
Платежный сервис <a href='https://interkassa.com/' target='_blank'>interkassa.com</a>
<p>URL взаимодействия<br/>
<input type='text' readonly value='#response_url#' size='90' /></p>

<p>Внимание: после создания Платежной системы сайта, ей будет присвоен <b>ID</b>(идентификатор), который надо будет ввести в значение переменной 'PAY_SYSTEM_ID_NEW' в файле расположеного по пути <b>[корень_сайта]/payment-interkassa/callback.php</b></b></p>
</div>";

$MESS["SCI_EMAIL_CLIENT"] = "Email покупателя";
