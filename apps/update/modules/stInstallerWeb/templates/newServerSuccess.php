<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
    <div class="box_content">
        <ul id="st_list_installer" class="content" style="min-height: 130px;">                      
          <li>
            <div><?php echo image_tag('/images/update/installerweb/change_server.png') ?></div>                               
          </li>    
          <li>
          <div class="st_head_txt_installer" style="text-align: left;">
              <?php echo __('System wykrył zmianę serwera.');?>
          </div>
              <?php echo __('Program został dostosowany do nowej lokalizacji.');?>
              <?php echo link_to(__('Uaktualnij dostęp do bazy danych'),"stSetup/reconfigure?newServer=true"); ?>

          </li>  
          <div style="clear:both"></div>
        </ul>    
    </div>
</div>


