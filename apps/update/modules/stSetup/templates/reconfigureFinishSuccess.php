<?php use_helper('I18N', 'Date', 'Text', 'Object', 'Validation', 'ObjectAdmin', 'stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>

<div id="frame_update"> 
  <?php echo get_partial('stInstallerWeb/menu_tools',array('selected'=>'reconfigure'));?>
    <div class="content">
        <h2 class="title"><?php echo __('Tryb developerski', null, 'stInstallerWeb');?></h2>
	  <div class="content_update_box">  
	    	
		   <h2 class="subhead_txt_module"><?php echo __("Rekonfiguracja bazy danych"); ?></h2>
		   
	        <div class="ok_message" style="width: 247px;">
		          <?php echo __("Dane zostały zmienione");?>
		    </div>
		    
	            <table border="0" cellspacing="5">
		            <tr>
			            <td><?php echo __("Adres serwera bazy danych")?></td>
						<td><?php echo $dbHost; ?> </td>
					</tr>
					<tr>
						<td><?php echo __("Nazwa bazy danych")?></td>
						<td><?php echo $dbDatabase; ?></td>
		            </tr>	        
		            <tr>
						<td><?php echo __("Nazwa użytkownika bazy danych")?></td>
						<td><?php echo $dbUsername; ?></td>
				    </tr>
				    <tr>
						<td><?php echo __("Hasło")?></td>
						<td><?php echo ($dbPassword)?$dbPassword:"-"; ?></td>
				    </tr>
				</table>
		</div>
  </div>
  <div class="clear"></div>
</div>