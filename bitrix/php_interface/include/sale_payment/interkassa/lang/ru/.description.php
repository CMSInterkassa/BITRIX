<?php
global $MESS;

$MESS["MERCHANT_ID"] = "Идентификатор проекта";
$MESS["MERCHANT_ID_DESCR"] = 'Узнать его можно в https://www.interkassa.com/account/checkout/';

$MESS["SECRET_KEY"] = "Секретный ключ";
$MESS["SECRET_KEY_DESCR"] = 'Должен совпадать с секретным ключом, указанным в https://www.interkassa.com/account/checkout/ "Настройки -> Безопасность"';

$MESS["SECRET_TEST_KEY"] = "Тестовый ключ";
$MESS["SECRET_TEST_KEY_DESCR"] = 'Должен совпадать с тестовым ключом, указанным в www.interkassa.com/account/checkout/ "Настройки -> Безопасность" Что бы заработал тестовый режим: "Тип платёжной системы" выбрать "Тестовая платежная система"';

$MESS["ORDER_DESCRIPTION"] = "Описание заказа";
$MESS["ORDER_DESCRIPTION_DESCR"] = "Дополнительный комментарий, отображаемый при оплате.#ID# Будет заменен на номер заказа.";
$MESS["ORDER_DESCRIPTION_VALUE"] = "Оплата заказа №#ID#";

$MESS["INTERKASSA_TEST"] = "Тестовый режим";
$MESS["INTERKASSA_YES"] = "Да";
$MESS["INTERKASSA_NO"] = "Нет";
$MESS["INTERKASSA_TEST_DESCR"] = 'Режим отладки, платежи в системе не засчитываются';

$MESS["ORDER_ID"] = "Номер заказа";
$MESS["SHOULD_PAY"] = "Сумма к оплате";

$MESS["INTERKASSA_MAIN_TITLE"] = "Интеркасса";
$MESS["INTERKASSA_MAIN_DESCR"] = "<div class='adm-info-message'>
	Платежный сервис <a href='https://interkassa.com/' target='_blank'>interkassa.com</a>
<p>URL взаимодействия, настраивается в <a target='_blank' href='https://www.interkassa.com/account/checkout/'>Мои кассы</a> -> Настройки -> Интерфейс:<br/>
<input type='text' readonly value='#RESULT_URL#' size='90' /><br/><i>Настройте <strong>bitrix:sale.order.payment.receive</strong> на эту платежную систему.</i></p>

<p>Стандартный URL страницы после успешной оплаты, настраивается в <a target='_blank' href='https://www.interkassa.com/account/checkout/'>Мои кассы</a> -> Настройки -> Интерфейс:<br/>
<input type='text' readonly value='#OK_URL#' size='90' /></p>

<p>Стандартный URL страницы неудачной оплаты, настраивается в <a target='_blank' href='https://www.interkassa.com/account/checkout/'>Мои кассы</a> -> Настройки -> Интерфейс:<br/>
<input type='text' readonly value='#ERR_URL#' size='90' /></p>

<p>Обязательно настроить <a target='_blank' href='https://www.interkassa.com/account/checkout/'>Мои кассы</a> -> Настройки -> Интерфейс -> Дополнительно:<br/>Текст успешного ответа: <b>OK</b><br>Дополнительно -> Http код успешного ответа: <b>200</b></p>
</div>";

$MESS["ORDER_EMAIL"] = "Email покупателя";
$MESS["ORDER_EMAIL_DESCR"] = "Автоматически заполняется в платёжной системе";

$MESS["CURRENCY"] = "Валюта платежа";
$MESS["CURRENCY_DESCR"] = "Обязательный параметр, если к кассе подключено больше чем одна валюта.";

$MESS["SALE_TYPE_PAYMENT"] = "Тип платёжной системы";
$MESS["SALE_TYPE_PAYMENT_DESCR"] = "Нужные платежные системы необходимо активировать в https://www.interkassa.com/account/checkout/";

$MESS["AMOUNT_TYPE"] = "Тип суммы платежа";
$MESS["AMOUNT_TYPE_DESCR"] = "Позволяет указать стратегию расчета суммы платежа кассы и платежной системы. В зависимости от нее расчет идет по той или иной сумме. Если указан тип суммы invoice, то сумма платежа в платежной системе рассчитывается от суммы платежа кассы. Если же тип суммы payway - то наоборот. По умолчанию - invoice";
