<?php use_helper('I18N', 'stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<div id="sf_admin_container">
    <?php include_partial('header');?>
    <div class="bg_content">
        <div class="stSetup-left_menu">
            <?php include_component('stSetup', 'leftMenu', array('step' => 'configure'));?>
        </div>
        <div id="stSetup-right_menu">
            <h2 class="title"><?php echo __("Konfiguracja systemu");?></h2>
            <div style="margin: 0px 30px;">
                <div class="download-content"><?php echo progress_bar('stSetupDefaultData', 'stSetupDefaultData', 'step', stSetupDefaultData::getSteps());?></div>
            </div>
            <div class="stSetup-actions" id='stSetup-install_actions' style="visibility: hidden;">
                <?php echo st_get_update_actions_head();?>
                    <?php echo st_get_update_action('next', __('Dalej'), 'stSetup/finish');?>
                <?php echo st_get_update_actions_foot();?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
