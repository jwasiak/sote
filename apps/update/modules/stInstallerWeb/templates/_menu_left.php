<?php use_helper('Javascript');?>
<div id="menu_left">
    <?php if (stLockUpdate::isLocked()):?>
            <?php if($selected=='rescue') echo "<div class=\"selected\">"; else echo "<div>";?>            
                <?php echo link_to(__('Naprawa aktualizacji', null, 'stInstallerWeb'),'stInstallerWeb/rescue');?>
			</div>
    <?php endif;?>
    <?php if($selected=='upgradeList') echo "<div class=\"selected\">"; else echo "<div>";?>
            <?php if(($selected=='upgradeList') || ($selected=='syncList')):?>
                <?php echo link_to(__('Pobierz', null, 'stInstallerWeb'),'stInstallerWeb/upgradeList');?>
            <?php else:?>
				<nobr><?php echo link_to(__('Pobierz', null, 'stInstallerWeb')."&nbsp;<span class=\"font_normal\" id=\"upgradeList_ajax\" style=\"font-weight:bold\">".image_tag('update/icons/indicator.gif')."</span>",'stInstallerWeb/upgradeList');?></nobr>                        
                <?php echo javascript_tag(
                    remote_function(array(
                    	'update'  => 'upgradeList_ajax',
                    	'url'     => 'stInstallerWeb/upgradeList?ajax=1',
                    ))
                );?>
            <?php endif;?>
	</div>
    <?php if($selected=='syncList') echo "<div class=\"selected\">"; else echo "<div>";?>
            <?php if($selected=='syncList'):?>
                <?php echo link_to(__('Instaluj', null, 'stInstallerWeb'),'stInstallerWeb/syncList');?>
            <?php else:?>
				<nobr><?php echo link_to(__('Instaluj',null, 'stInstallerWeb')."&nbsp;<span class=\"font_normal\" id=\"syncList_ajax\" style=\"font-weight:bold\">".image_tag('update/icons/indicator.gif')."</span>",'stInstallerWeb/syncList');?></nobr>
                <?php echo javascript_tag(
                    remote_function(array(
                    	'update'  => 'syncList_ajax',
                    	'url'     => 'stInstallerWeb/syncList?ajax=1',
                    ))
                );?>
            <?php endif;?>
    </div>
    <?php if($selected=='upload') echo "<div class=\"selected\">"; else echo "<div>";?>		
        <?php echo link_to(__('Dodaj', null, 'stInstallerWeb'),'stInstallerWeb/upload');?>
	</div>
	<?php if($selected=='webstore') echo "<div class=\"selected\">"; else echo "<div>";?>
        <?php echo link_to(__('WebStore', null, 'stWebStore'), 'stWebStore/index');?>
	</div>
</div>