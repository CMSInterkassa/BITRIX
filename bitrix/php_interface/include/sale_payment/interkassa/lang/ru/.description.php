<?php
global $MESS;

$MESS["MERCHANT_ID"] = "������������� �������";
$MESS["MERCHANT_ID_DESCR"] = '������ ��� ����� � https://www.interkassa.com/account/checkout/';

$MESS["SECRET_KEY"] = "��������� ����";
$MESS["SECRET_KEY_DESCR"] = '������ ��������� � ��������� ������, ��������� � https://www.interkassa.com/account/checkout/ "��������� -> ������������"';

$MESS["SECRET_TEST_KEY"] = "�������� ����";
$MESS["SECRET_TEST_KEY_DESCR"] = '������ ��������� � �������� ������, ��������� � www.interkassa.com/account/checkout/ "��������� -> ������������" ��� �� ��������� �������� �����: "��� �������� �������" ������� "�������� ��������� �������"';

$MESS["ORDER_DESCRIPTION"] = "�������� ������";
$MESS["ORDER_DESCRIPTION_DESCR"] = "�������������� �����������, ������������ ��� ������.#ID# ����� ������� �� ����� ������.";
$MESS["ORDER_DESCRIPTION_VALUE"] = "������ ������ �#ID#";

$MESS["INTERKASSA_TEST"] = "�������� �����";
$MESS["INTERKASSA_YES"] = "��";
$MESS["INTERKASSA_NO"] = "���";
$MESS["INTERKASSA_TEST_DESCR"] = '����� �������, ������� � ������� �� �������������';

$MESS["ORDER_ID"] = "����� ������";
$MESS["SHOULD_PAY"] = "����� � ������";

$MESS["INTERKASSA_MAIN_TITLE"] = "����������";
$MESS["INTERKASSA_MAIN_DESCR"] = "<div class='adm-info-message'>
	��������� ������ <a href='https://interkassa.com/' target='_blank'>interkassa.com</a>
<p>URL ��������������, ������������� � <a target='_blank' href='https://www.interkassa.com/account/checkout/'>��� �����</a> -> ��������� -> ���������:<br/>
<input type='text' readonly value='#RESULT_URL#' size='90' /><br/><i>��������� <strong>bitrix:sale.order.payment.receive</strong> �� ��� ��������� �������.</i></p>

<p>����������� URL �������� ����� �������� ������, ������������� � <a target='_blank' href='https://www.interkassa.com/account/checkout/'>��� �����</a> -> ��������� -> ���������:<br/>
<input type='text' readonly value='#OK_URL#' size='90' /></p>

<p>����������� URL �������� ��������� ������, ������������� � <a target='_blank' href='https://www.interkassa.com/account/checkout/'>��� �����</a> -> ��������� -> ���������:<br/>
<input type='text' readonly value='#ERR_URL#' size='90' /></p>

<p>����������� ��������� <a target='_blank' href='https://www.interkassa.com/account/checkout/'>��� �����</a> -> ��������� -> ��������� -> �������������:<br/>����� ��������� ������: <b>OK</b><br>������������� -> Http ��� ��������� ������: <b>200</b></p>
</div>";

$MESS["ORDER_EMAIL"] = "Email ����������";
$MESS["ORDER_EMAIL_DESCR"] = "������������� ����������� � �������� �������";

$MESS["CURRENCY"] = "������ �������";
$MESS["CURRENCY_DESCR"] = "������������ ��������, ���� � ����� ���������� ������ ��� ���� ������.";

$MESS["SALE_TYPE_PAYMENT"] = "��� �������� �������";
$MESS["SALE_TYPE_PAYMENT_DESCR"] = "������ ��������� ������� ���������� ������������ � https://www.interkassa.com/account/checkout/";

$MESS["AMOUNT_TYPE"] = "��� ����� �������";
$MESS["AMOUNT_TYPE_DESCR"] = "��������� ������� ��������� ������� ����� ������� ����� � ��������� �������. � ����������� �� ��� ������ ���� �� ��� ��� ���� �����. ���� ������ ��� ����� invoice, �� ����� ������� � ��������� ������� �������������� �� ����� ������� �����. ���� �� ��� ����� payway - �� ��������. �� ��������� - invoice";
