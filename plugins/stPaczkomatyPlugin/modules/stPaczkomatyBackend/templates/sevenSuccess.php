<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php echo st_get_admin_head('stPaczkomatyPlugin', __('Konfiguracja', array()), __('',array()),array('stPayment', 'stProduct','stDeliveryPlugin'));?>
    <div id="sf_admin_content">
        <div id="sf_admin_content_config">
            <form>
                <fieldset>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <a href="<?php echo get_7_link();?>" target="_blank">Zamów aktualizację do wersji 7</a>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>