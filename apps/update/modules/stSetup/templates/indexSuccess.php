<?php use_helper('I18N', 'stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php echo form_tag('stSetup/index');?>
    <div id="sf_admin_container">
        <?php include_partial('header');?>
        <div class="bg_content">
            <div class="stSetup-left_menu">
                <?php include_component('stSetup', 'leftMenu', array('step' => 'index'));?>
            </div>
            <div id="stSetup-right_menu">
                <h2 class="title">
                    <?php echo __('Witamy w programie instalacyjnym').' '.st_program_name();?>
                </h2>
                <p>
                    <?php echo __('Przed przystąpieniem do instalacji oprogramowania').' '.st_program_name().', '.__('proponujemy zapoznanie się z');?>
                    <strong><?php echo link_to(__('podręcznikiem instalacji'), __('http://www.sote.pl/docs/instalacja'), array('target' => '_blank'));?></strong>
                </p>
                <fieldset>
                    <?php if($error):?>
                        <div class="form-errors">
                            <h2><?php echo __('Popraw dane w formularzu');?></h2>
                            <dl>
                                <dt><?php echo __('Problem:')?></dt>
                                <dd><?php echo __($errorMsg); ?></dd>
                            </dl>
                        </div>
                    <?php endif;?>
                    <div class="st_fieldset-content" id="license-form">
                        <div class="form-row" style="padding: 0px; border: none">
                            <label><?php echo __('Numer licencji');?></label>
                            <div>
                                <?php echo input_tag('license', $license, array('size' => '25'));?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="stSetup-actions">
                    <?php echo st_get_update_actions_head('style="float:right"');?>
                        <?php echo st_get_update_action('next', __('Dalej'), null);?>
                    <?php echo st_get_update_actions_foot();?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</form>