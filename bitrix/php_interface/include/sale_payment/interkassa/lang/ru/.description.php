<?php
global $MESS;

$MESS["merchant_id"] = "Номер кошелька";
$MESS["secur_key"] = "Секретный ключ";
$MESS["test_key"] = "Тестовый ключ";

$MESS["test_mode"] = "Тестовый режим";

$MESS["test_yes"] = "Да";
$MESS["test_no"] = "Нет";

$MESS["test_mode_desc"] = 'Режим отладки, платежи в системе не засчитываются';

$MESS["order_id"] = "Номер заказа";
$MESS["amount"] = "Сумма к оплате";
$MESS["cur"] = "Валюта платежа";
$MESS["module_title"] = "Интеркасса";
$MESS["desc"] = "<div style='background: #c7f9a5; border-radius: 5px; border: 1px solid; border-color: #409605; color: #000; display: inline-block; margin: 16px 0; padding: 15px 30px 15px 18px;'>
Платежный сервис <a href='https://interkassa.com/' target='_blank'>interkassa.com</a>
<p>URL взаимодействия<br/>
<input type='text' readonly value='#response_url#' size='90' /></p>

<p>URL успешной оплаты<br/>
<input type='text' readonly value='#suc_url#' size='90' /></p>

<p>URL неудачной оплаты<br/>
<input type='text' readonly value='#fail_url#' size='90' /></p>

<p>Внимание: Нужно настроить: Мои кассы -> Настройки -> Интерфейс -> Дополнительно:<br/>Текст успешного ответа: <b>OK</b><br>Дополнительно -> Http код успешного ответа: <b>200</b></p>
</div>";

$MESS["email_client"] = "Email покупателя";


