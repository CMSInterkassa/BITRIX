<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();/**
 * ���������� ������ - Divasoft, inc.
 * http://divasoft.ru
 * ������ 1.0
 * 2016
 */ ?><form action="<?php echo $payment->getFormAction(); ?>" method="post" accept-charset="UTF-8">
    <?php foreach ($payment->getFormValues() as $field => $value): ?>
        <input type="hidden" name="<?php echo $field; ?>" value="<?php echo $value; ?>"/>
    <?php endforeach; ?>
    <button type="submit">��������</button>
</form>