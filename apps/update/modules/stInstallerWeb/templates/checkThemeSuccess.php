<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php use_stylesheet('/css/update/setup.css?v2'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">    
    <div id="sf_admin_container"  style="width: auto;">
        <?php echo get_partial('menu');?>
        <div class="content">
            <div class="st_head_txt_installer_sync">
                <?php echo __('Weryfikacja tematu graficznego sklepu');?>
            </div>
            <div class="content" style="padding-left: 0px;">
                <?php if ($check === true):?>
                    <?php echo __('Weryfikacja została zakończona pomyślnie.');?>
                <?php elseif ($check === false):?>
                    <?php echo __('Dostępna jest nowa wersja SOTESHOP 6:');?>
                    <a href="<?php echo __('http://www.sote.pl/soteshop6');?>" target="_blank"><?php echo __('więcej');?></a><br />
                    <?php echo __('Jeśli chcesz pobrać aktualizacje do wersji 6, musisz zaktualizować grafikę do nowszej wersji:');?>
                    <a href="<?php echo __('http://www.sote.pl/soteshop6/update');?>" target="_blank"><?php echo __('więcej');?></a>
                <?php elseif ($check == -1):?>
                    <?php echo __('Nie można połączyć sie z bazą danych w celu wykonania weryfikacji.');?><br />
                    <?php echo __('Prosze o kontakt z serwisem oprogramowania www.serwis.sote.pl.');?>
                <?php elseif ($check == -2):?>
                    <?php echo __('Wystąpił błąd podczas weryfikacja tematu graficznego.');?><br />
                    <?php echo __('Prosze o kontakt z serwisem oprogramowania www.serwis.sote.pl.');?> 
                <?php endif;?> 
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>