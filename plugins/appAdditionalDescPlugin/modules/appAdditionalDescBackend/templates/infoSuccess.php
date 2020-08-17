<?php use_helper('I18N', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('appAdditionalDescPlugin', __('Dodatkowy opis produktu'), __('Informacje o module'), NULL) ?> 

<div id="sf_admin_header">
    <?php include_partial('menu', array()) ?><br /><br />
</div>

<div style="text-align:center">
    <b>appAdditionalDescPlugin <?php echo __('wersja').' '.stRegisterSync::getPackageVersion('appAdditionalDescPlugin');?></b><br>
    <br>
    <?php echo __('Więcej informacji o aplikacji można znaleźć na stronie') ?><br>
    <?php if ($lang == 'pl_PL'): ?>
        <a href="http://www.apes-apps.pl/?p=94" target="_blank">http://www.apes-apps.pl/?p=94</a>
    <?php else: ?>
        <a href="http://www.apes-apps.com/?p=58" target="_blank">http://www.apes-apps.com/?p=58</a>
    <?php endif; ?>
</div>

<br class="st_clear_all">

<?php echo st_get_admin_foot() ?>