<?php use_helper('I18N', 'stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">
    <?php if(!$newServer):?>
        <?php echo get_partial('stInstallerWeb/menu_tools', array('selected' => 'reconfigure'));?>
    <?php endif;?>
    <div class="content">
        <h2 class="title"><?php echo __('Tryb developerski', null, 'stInstallerWeb');?></h2>
        <div class="content_update_box" id="reconfigure_db">
            <?php echo form_tag('stSetup/reconfigure');?>
                <h2 class="subhead_txt_module"><?php echo __("Rekonfiguracja bazy danych");?></h2>
                <?php if($dbError):?>
        	       <div class="form-errors">
        	           <dl>
                            <dt class="error_message"><?php echo __("Problem:");?> <?php echo __($dbErrorMsg);?></dt>
        	           </dl>
        	       </div>
        	    <?php endif;?>
                <table border="0" cellspacing="5">
                    <tr>
        	            <td width="200px;"><?php echo __("Adres serwera bazy danych");?></td>
        	            <td><?php echo input_tag('host', $dbHost, array('size' => '25'));?></td>
        	        </tr>
        	        <tr>
                        <td><?php echo __("Nazwa bazy danych");?></td>
        	            <td><?php echo input_tag('database', $dbDatabase, array('size' => '25'));?></td>
        	        </tr>
                    <tr>
                        <td><?php echo __("Nazwa użytkownika bazy danych");?></td>
                        <td><?php echo input_tag('username', $dbUsername, array('size' => '25'));?></td>
                    </tr>
                    <tr>
                        <td><?php echo __("Hasło");?></td>
                        <td><?php echo input_password_tag('password', $dbPassword, array('size' => '25'));?></td>
                    </tr>
                </table>
                <?php if($newServer):?>
                    <?php echo input_hidden_tag('newServer', 1);?>
                    <h2 class="subhead_txt_module" style="padding-top: 15px;"><?php echo __('Zmiana numeru licencji');?></h2>
                    <table border="0" cellspacing="5">
                    <tr>
                        <td width="200px;"><?php echo __('Numer licencji');?></td>
                        <td><?php echo input_tag('license', $license, array('size' => '25'));?></td>
                    </tr>
                </table>
                <?php endif;?>
                <div class="stSetup-actions">
                    <?php echo st_get_update_actions_head('style="float:right"');?>
                    <?php echo st_get_update_action('save', __('Zapisz'), null);?>
                    <?php echo st_get_update_actions_foot();?>
                </div>
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="st_clear_all"></div>