<?php use_helper('stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">
    <?php echo get_partial('menu_home',array('selected'=>'upgradeList'));?>
    <div class="content">
        <div class="content_update_box">
            <h2 class="subhead_txt_module"><?php echo __('SOTESHOP 6');?></h2>
            <div>
                <?php echo __('UWAGA: Instalujesz aktualizację do wersji SOTESHOP 6.');?>
                <?php echo __('Program różni się od wersji 5 procesem zamówienia i panelem administracyjnym.');?>
                <?php echo __('Więcej informacji o zmianach:');?> <a href="<?php echo __('http://www.sote.pl');?>" target="_blank"><?php echo __('http://www.sote.pl');?></a>
                <br /><br />
                <?php echo __('Możesz zainstalować aktualizację automatycznie (wymagane zrobienie archiwizacji sklepu przed instalacją) lub możesz zlecić aktualizację pod nadzorem serwisu, więcej informacji:');?>
                <a href="<?php echo __('http://www.sote.pl/update6.html');?>" target="_blank"><?php echo __('http://www.sote.pl/update6.html');?></a>
                <?php if ($error):?>
                    <div style="color: #ff0000; padding-top: 20px;">
                        <?php echo __('Nie można wykonać automatycznej aktualizacji do wersji SOTESHOP 6, gdyż w Twoim sklepie są indywidualne modyfikacje.');?> 
                        <?php echo __('Skontaktuj się z nami');?>
                        <a href="<?php echo __('http://www.sote.pl/page/contact');?>" target="_blank"><?php echo __('http://www.sote.pl/page/contact');?></a>
                    </div>
                <?php endif;?>
                <div class="clear"></div>
                <div style="float: right">
                    <?php echo st_get_update_actions_head('style="float:right"') ?>
                    <?php echo st_get_update_action('next', __('Dalej'), 'stInstallerWeb/upgradeList?confirm=1', 'post=true') ?>
                    <?php echo st_get_update_actions_foot() ?>
                </div>
                <div class="st_clear_all"></div>
            </div>
        </div>
    </div>
</div>
