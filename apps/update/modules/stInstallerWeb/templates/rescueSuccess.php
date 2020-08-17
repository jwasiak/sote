<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">                        
    <?php echo get_partial('menu_home',array('selected'=>'rescue'));?>
    <div content="content">
      <div class="content_update_box">
        <h2 class="title"><?php echo __('Naprawa aktualizacji') ?></h2>
   

        <?php echo __('Wykryto błędne zakończenie aktualizacji. Wywołaj automatyczną naprawę aktualizacji.')?><br />

        <ul id="st_list_installer"> 
          <li>
             <div><?php echo link_to(image_tag('/images/update/installerweb/rescue.png'), 'stInstallerWeb/rescueReboot'); ?></div>
             <div><?php echo link_to(__('Naprawa aktualizacji'),'stInstallerWeb/rescueReboot');?></div>
          </li>
        </ul>
      </div>
    </div>
    <div class="clear"></div>
</div>