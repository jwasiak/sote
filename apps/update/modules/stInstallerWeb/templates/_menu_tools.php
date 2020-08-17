<?php if (!isset($selected)) $selected = '';?>
<ul id="st_list_installer">
    <div class="img_icons<?php if($selected == 'verifyall'):?> img_icons_selected<?php endif;?>">
        <div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/verify.png'), 'stInstallerWeb/verifyall');?>
        </div>
        <div class="font_normal">
            <?php echo link_to(__('Weryfikacja systemu', null, 'stInstallerWeb'),'stInstallerWeb/verifyall');?>
        </div>
    </div>
    <div class="img_icons<?php if($selected == 'devel'):?> img_icons_selected<?php endif;?>">
        <div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/devel.png'), 'devel');?>
        </div>
        <div class="font_normal">
            <?php echo link_to(__('Tryb developerski', null, 'stInstallerWeb'),'devel');?>
        </div>
    </div>
    <div class="img_icons<?php if($selected == 'history'):?> img_icons_selected<?php endif;?>">
        <div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/history.png'), 'stInstallerWeb/history');?>
        </div>
        <div class="font_normal">
            <?php echo link_to(__('Historia aktualizacji', null, 'stInstallerWeb'),'stInstallerWeb/history');?>
        </div>
    </div>
    <div class="img_icons<?php if($selected == 'reconfigure'):?> img_icons_selected<?php endif;?>">
        <div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/reconfigure.png'), 'stSetup/reconfigure');?>
        </div>
        <div class="font_normal">
            <?php echo link_to(__('Konfiguracja MySQL', null, 'stInstallerWeb'),'stSetup/reconfigure');?>
        </div>
    </div>
    <div style="clear:both"></div>
</ul>