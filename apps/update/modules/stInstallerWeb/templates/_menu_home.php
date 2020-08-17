<?php use_helper('Javascript');?>
<ul id="st_list_installer">
    <?php if (stLockUpdate::isLocked()):?>
        <div class="img_icons">
            <?php if($selected=='rescue') echo "<div class=\"img_icons img_icons_selected\">"; else echo "<div class=\"img_icons\">";?>            
               	<div class="box_icons">
                    <?php echo link_to(image_tag('/images/update/red/modules/rescue.png'), 'stInstallerWeb/rescue');?>
               	</div>
               	<div class="font_normal">
                    <?php echo link_to(__('Naprawa aktualizacji', null, 'stInstallerWeb'),'stInstallerWeb/rescue');?>
               	</div>
			</div>
        </div>
    <?php endif;?>
    <?php if($selected=='upgradeList') echo "<div class=\"img_icons img_icons_selected\">"; else echo "<div class=\"img_icons\">";?>
		<div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/download.png'), 'stInstallerWeb/upgradeList');?>
        </div>
        <div class="font_normal">
            <?php if(($selected=='upgradeList') || ($selected=='syncList')):?>
                <?php echo link_to(__('Pobierz', null, 'stInstallerWeb'),'stInstallerWeb/upgradeList');?>
            <?php else:?>
				<nobr><?php echo link_to(__('Pobierz', null, 'stInstallerWeb')."&nbsp;<span class=\"font_normal\" id=\"upgradeList_ajax\" style=\"font-weight:bold; padding: 0px;\">".image_tag('update/icons/indicator.gif')."</span>",'stInstallerWeb/upgradeList');?></nobr>                        
                <?php echo javascript_tag(
                    remote_function(array(
                    	'update'  => 'upgradeList_ajax',
                    	'url'     => 'stInstallerWeb/upgradeList?ajax=1',
                    ))
                );?>
            <?php endif;?>
        </div>
	</div>
    <?php if($selected=='syncList') echo "<div class=\"img_icons img_icons_selected\">"; else echo "<div class=\"img_icons\">";?>
        <div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/install.png'), 'stInstallerWeb/syncList');?>
        </div>
        <div class="font_normal">
            <?php if($selected=='syncList'):?>
                <?php echo link_to(__('Instaluj', null, 'stInstallerWeb'),'stInstallerWeb/syncList');?>
            <?php else:?>
				<nobr><?php echo link_to(__('Instaluj',null, 'stInstallerWeb')."&nbsp;<span class=\"font_normal\" id=\"syncList_ajax\" style=\"font-weight:bold; padding: 0px;\">".image_tag('update/icons/indicator.gif')."</span>",'stInstallerWeb/syncList');?></nobr>
                <?php echo javascript_tag(
                    remote_function(array(
                    	'update'  => 'syncList_ajax',
                    	'url'     => 'stInstallerWeb/syncList?ajax=1',
                    ))
                );?>
            <?php endif;?>
        </div>
    </div>
    <?php if($selected=='upload') echo "<div class=\"img_icons img_icons_selected\">"; else echo "<div class=\"img_icons\">";?>
		<div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/upload.png'), 'stInstallerWeb/upload');?>
		</div>
		<div class="font_normal">
            <?php echo link_to(__('Dodaj', null, 'stInstallerWeb'),'stInstallerWeb/upload');?>
		</div>
	</div>
	<?php if($selected=='webstore') echo "<div class=\"img_icons img_icons_selected\">"; else echo "<div class=\"img_icons\">";?>
		<div class="box_icons">
            <?php echo link_to(image_tag('/images/update/red/modules/webstore.png'), 'stWebStore/index');?>
		</div>
		<div class="font_normal">
            <?php echo link_to(__('WebStore', null, 'stWebStore'), 'stWebStore/index');?>
		</div>
	</div>
    <div style="clear:both"></div> 
</ul>