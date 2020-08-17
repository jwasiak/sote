<?php use_helper('I18N', 'stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<div id="sf_admin_container">
    <?php include_partial('header');?>
    <div class="bg_content">
        <div class="stSetup-left_menu">
           <?php include_component('stSetup', 'leftMenu', array('step' => 'finish'));?>
        </div>
        <div id="stSetup-right_menu">   
            <h2 class="title">
                <?php echo __('Informacje końcowe');?>
            </h2>
            <h3 style="display: inline-block; padding: 0 11px 30px 17px;">
                <?php echo __('Sklep został pomyślnie zainstalowany');?>
            </h3>
            <div class="clear"></div> 
            <div class="install_success_links">  
               <div>
                    <div style="float: left; width: 170px; text-align: left; padding-left: 17px;"><?php echo __('Adres sklepu');?>:</div>
                    <div style="float: left;"><a href="<?php echo $frontend;?>" target="frontend"><?php echo $frontend;?></a></div>
               </div>
               <div style="margin: 10px 0px;">
                    <div style="float: left; width: 170px; text-align: left; padding-left: 17px;"><?php echo __('Panel administracyjny');?>:</div>
                    <div style="float: left;"><a href="<?php echo $backend;?>" target="frontend"><?php echo $backend;?></a></div>
                </div>
                <div>
                    <div style="float: left; width: 170px; text-align: left; padding-left: 17px;"><?php echo __('Panel aktualizacji');?>:</div>
                    <div style="float: left;"><a href="<?php echo $update;?>" target="frontend"><?php echo $update;?></a></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="stSetup-actions">
                <?php echo st_get_update_actions_head();?>
                    <?php echo st_get_update_action('next', __('Dalej'), '../backend.php');?>
                <?php echo st_get_update_actions_foot();?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
