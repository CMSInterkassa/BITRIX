<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<form action="<?php echo $action; ?>" method="post" accept-charset="UTF-8">
    <?php foreach ($ik_config as $field => $value): ?>
        <input type="hidden" name="<?php echo $field; ?>" value="<?php echo $value; ?>"/>
    <?php endforeach; ?>
    <button type="submit">Оплатить</button>
</form>