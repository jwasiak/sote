<?php use_helper('I18N', 'stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo form_tag('stSetup/license');?>
    <div id="sf_admin_container">
        <?php include_partial('header');?>
        <div class="bg_content">
            <div class="stSetup-left_menu">
                <?php include_component('stSetup', 'leftMenu', array('step' => 'license'));?>
            </div>
            <div id="stSetup-right_menu">
                <h2 class="title"><?php echo __('Licencja') ?></h2>
                <fieldset>
                    <?php if($notAccepted):?>
                        <div class="form-errors">
                            <h2><?php echo __('Popraw dane w formularzu');?></h2>
                            <dl>
                                <dt><?php echo __('Problem:');?></dt>
                                <dd><?php echo __('Aby kontynuować musisz zaakceptować licencje.');?></dd>
                            </dl>
                        </div>
                    <?php endif;?>
                    <p><?php echo __('Treść licencji:');?></p>
                    <div id="stSetup-license" class="stSetup-license">
                        <?php echo get_partial($partial);?>
                    </div>
                    <div id="license_accept">
                        <?php echo checkbox_tag('accept', 1, false);?>
                        <?php echo __('Akceptuje licencje');?>
                    </div>
                </fieldset>
                <div class="stSetup-actions">
                    <?php echo st_get_update_actions_head();?>
                        <?php echo st_get_update_action('previous', __('Wstecz'), 'stSetup/index');?>
                        <?php echo st_get_update_action('next', __('Dalej'), null);?>
                    <?php echo st_get_update_actions_foot();?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</form>