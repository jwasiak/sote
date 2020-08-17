<?php use_helper('stAdminGenerator', 'stProgressBar', 'stUrl', 'stAllegro');?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css');?>
<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php st_include_partial('stAllegroBackend/header', array('related_object' => null, 'title' => __('Problem w komunikacji z API'), 'culture' => null, 'route' => 'stAllegroBackend/categoryCustom'));?>
<?php st_include_component('stAllegroBackend', 'listMenu', array('forward_parameters' => null, 'related_object' => null));?>

<?php st_include_partial('stAllegroBackend/list_messages', array('forward_parameters' => null));?>
<div id="sf_admin_content">
   <div class="admin_form">
        <fieldset>
            <h2><?php echo __('Problem w komunikacji z API', null, 'stAllegroBackend');?></h2>
            <div class="st_fieldset-content">
                <div class="row" style="margin: 10px 0px;">
                    <?php echo __('Wystąpił problem w połączeniu z API.', null, 'stAllegroBackend');?>
                </div>           
            </div>
        </fieldset>
    </div>
</div>
<?php st_include_partial('stAllegroBackend/footer', array('related_object' => null, 'forward_parameters' => null));?>
