<?php use_helper('stUpdate') ?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php use_stylesheet('/css/update/stDevel.css?version=1'); ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
        <?php echo get_partial('stInstallerWeb/menu_tools',array('selected'=>'devel'));?>
        <div class="box_content">
            <h2 class="title"><?php echo __('Tryb developerski', null, 'stInstallerWeb');?></h2>
            <div class="content_update_box">     
                <div> 
                    <h2 class="subhead_txt_module"><?php echo __('Ustawienia trybu developerskiego')?></h2>
                </div>
                <br />
                <div id="stDevel_form">
                    <?php echo form_tag('devel/devel', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
                        <div class="main">
                            <div class="row">
                                <div class="column" id="txt1"><?php echo __('Adres IP');?>:</div>
                                <div class="column"><?php echo input_tag('devel[ip]',$stWebRequest->getRemoteAddress());?></div>
                            </div>
                            <div class="row">
                                <div class="column" id="txt2"><?php echo __('Włącz tryb developerski');?>:</div>
                                <div class="column"><?php echo checkbox_tag('devel[devel]',1,$hasDevel);?></div>
                            </div>
                            <div id="frame_buttons">
                                <?php echo st_get_update_actions_head('style="float:left"') ?>
                                <?php echo st_get_update_action('save', __('Zapisz')) ?>
                                <?php echo st_get_update_action('more', __('PHPINFO'), 'stDevel/phpInfo') ?>
                                <?php echo st_get_update_actions_foot() ?>
                            </div>
                        </div>
                    </form>
                    
                    <br />
                    <?php if ($hasDevel): ?>
                    <?php echo __('Linki do stron w trybie developerskim dostępne tylko dla wskazanego IP:') ?>
                    <table style="margin-bottom: 15px;">
                    <tr>
                      <td>
                        <?php echo __('Sklep:')?>
                      </td>
                      <td><a href="<?php echo "http://$hostname/frontend_dev.php" ?>" target="frontend"><?php echo __('http://'.$hostname.'/frontend_dev.php')?></a></td>
                    </tr>
                    <tr>
                      <td><?php echo __('Panel sklepu:')?></td>
                      <td><a href="<?php echo "http://$hostname/backend_dev.php" ?>" target="frontend"><?php echo __('http://'.$hostname.'/backend_dev.php')?></a></td>
                    </tr>      
                    </table>
                    <?php endif ?>
                    
                </div>
            </div>
    </div>
    <div class="clear"></div>
</div>
