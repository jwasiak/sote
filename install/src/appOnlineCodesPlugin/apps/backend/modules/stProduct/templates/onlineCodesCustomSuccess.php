<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin', 'stDate') ?>
<?php $related_object =  ProductPeer::retrieveByPk($sf_params->get('product_id')) ?>
<?php st_include_partial('stProduct/header', array('related_object' => $related_object, 'title' => __('Pliki i kody online', array(), 'appOnlineCodesBackend'), 'route' => 'stProduct/onlineCodesList')) ?>

<?php st_include_component('stProduct', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' =>$related_object )) ?>

<div id="sf_admin_content">
    <div class="application_shortcuts" style="height: 50px; border: 1px solid #ccc; padding: 10px;">
        <ul>
            <li>
                <div class="icon" style="float: left;">
                    <a style="background-image: url(<?php echo get_app_icon('/images/backend/beta/icons/48x48/appOnlineCodesPlugin_audio.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/onlineAudioCreate?product_id='.$related_object->getId());?>"></a>
                </div>
                <div class="name">
                    <?php echo link_to(__('Audio', array(), 'appOnlineCodesBackend'), 'stProduct/onlineAudioCreate?product_id='.$related_object->getId());?>
                </div>
            </li>
            <li>
                <div class="icon" style="float: left;">
                    <a style="background-image: url(<?php echo get_app_icon('/images/backend/beta/icons/48x48/appOnlineCodesPlugin_images.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/onlineImagesCreate?product_id='.$related_object->getId());?>"></a>
                </div>
                <div class="name">
                    <?php echo link_to(__('Zdjęcia', array(), 'appOnlineCodesBackend'), 'stProduct/onlineImagesCreate?product_id='.$related_object->getId());?>
                </div>
            </li>
            <li>
                <div class="icon" style="float: left;">
                    <a style="background-image: url(<?php echo get_app_icon('/images/backend/beta/icons/48x48/appOnlineCodesPlugin_docs.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/onlineDocsCreate?product_id='.$related_object->getId());?>"></a>
                </div>
                <div class="name">
                    <?php echo link_to(__('Dokumenty', array(), 'appOnlineCodesBackend'), 'stProduct/onlineDocsCreate?product_id='.$related_object->getId());?>
                </div>
            </li>
            <li>
                <div class="icon" style="float: left;">
                    <a style="background-image: url(<?php echo get_app_icon('/images/backend/beta/icons/48x48/appOnlineCodesPlugin_codes.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/onlineCodesCreate?product_id='.$related_object->getId());?>"></a>
                </div>
                <div class="name">
                    <?php echo link_to(__('Kody', array(), 'appOnlineCodesBackend'), 'stProduct/onlineCodesCreate?product_id='.$related_object->getId());?>
                </div>
            </li>
        </ul>
    </div>
    <div style="clear: both;">
    <br />
    <div>
        <?php echo st_get_component('appOnlineCodesBackend','showFileList',array('related_object'=>$related_object )); ?></br>
        <?php echo st_get_component('appOnlineCodesBackend','showCodeList',array('related_object'=>$related_object )); ?>
    </div>

    <div class="clr"></div>
</div>

<?php st_include_partial('stProduct/footer', array('related_object' => $related_object)) ?>
<script type="text/javascript">
jQuery(function($) {
      $('#list_actions').stickyBox();
});
</script>
