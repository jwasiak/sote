<?php use_helper('stAdminGenerator', 'stProgressBar');?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css');?>
<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php st_include_partial('stAllegroBackend/header', array('title' => __('Wystawianie aukcji w serwisie aukcyjnym', null, 'stAllegroBackend'), 'culture' => null, 'route' => 'stAllegroBackend/createMany'));?>
<?php st_include_component('stAllegroBackend', 'listMenu', array('forward_parameters' => $forward_parameters));?>

<div id="sf_admin_content">
    <?php echo progress_bar('stAllegroPluginCreateAuctions', 'stAllegroCreateAuctionsBar', 'createAuction', $steps);?>
</div>

<?php st_include_partial('stAllegroBackend/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters));?>