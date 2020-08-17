<?php use_stylesheet('/css/update/stDevel.css?version=1');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
    <?php echo get_partial('stInstallerWeb/menu');?>
    <div class="content">
        <div class="st_head_txt_installer">
            <?php echo __('Włączanie i wyłączanie sklepu');?>
        </div>
        <div id="stDevel_form">
            <?php echo form_tag('lock/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
                <div class="main">
                    <div class="row">
                        <div class="column"><?php echo  __('Wyłącz sklep');?>:</div>
                        <div class="column" style="padding-left: 7px;"><?php echo checkbox_tag('lock[unlock]', 1, !stLock::check('frontend'));?></div>
                    </div>
                    <div id="frame_buttons">
                        <?php echo st_get_update_actions_head('style="float:left"');?>
                        <?php echo st_get_update_action('save', __('Zapisz'));?>
                        <?php echo st_get_update_actions_foot();?>
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        </div>
    </div>
</div>