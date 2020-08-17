<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php 
echo st_get_admin_head('stPositioningPlugin', __('Mapy witryn dla Google'), '',array (
  0 => 'stLanguagePlugin',
  1 => 'stProduct',
  2 => 'stCategory',
  3 => 'stWebpagePlugin',
  4 => 'stProducer',
  5 => 'stBlogPlugin',
));

if ($related_object):
    st_include_component('stPositioningBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object, 'positioning' => null));
else:
    $related_object = PositioningPeer::retrieveByPk(1); 
    st_include_component('stPositioningBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object, 'positioning' => null));
endif;
;?>
<?php st_include_partial('stAdminGenerator/message') ?>

<div id="sf_admin_header">
   <?php echo stSocketView::openComponents('stPositioningBackend.sitemapCustom.Header'); ?>
</div>
    
<div id="sf_admin_content">
   <?php echo stSocketView::openComponents('stPositioningBackend.sitemapCustom.Content'); ?>
</div>
    
<div id="sf_admin_footer">
   <?php echo stSocketView::openComponents('stPositioningBackend.sitemapCustom.Footer'); ?>
</div>
<?php st_include_partial('stPositioningBackend/footer', array('related_object' => null, 'forward_parameters' => $forward_parameters)) ?>