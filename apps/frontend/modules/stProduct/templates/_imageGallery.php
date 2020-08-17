 <?php
use_helper('stProductImage');

st_theme_use_stylesheet('stProduct.css');

$tw = st_asset_thumbnail_setting('width', 'gallery');

$th = st_asset_thumbnail_setting('height', 'gallery');

$photos = array();

foreach ($images as $index => $image)
{
   $image_large = st_product_image_tag($image, 'gallery', array('alt' => ''));
   $image_thumb = st_product_image_path($image, 'gallery');
   $image_big = st_product_image_path($image, 'big');
   
   if($themeVersion < 2 && $themeVersion < 7)
   {
      $photos[$index]['photo'] = content_tag('a', $image_large, array(
         'href' => $image_big,
         'style' => 'width:' . $tw . 'px;height:' . $th . 'px',
         'rel' => 'lightbox[product_image_gallery]',
         'title' => $image->getDescription(),
         'id' => isset($images_in_options[$image->getId()]) ? $product->getId().":".$image->getId() : '',
      ));      

      $photos[$index]['desc'] = $image->getDescription();       
   
   }elseif($themeVersion >= 7) {
      if ($image->getId() != $product->getDefaultAssetImage()->getId())
      {
         $photos[$index]['photo'] = content_tag('a', $image_large, array(
            'href' => $image_big,
            'alt' => $image->getDescription() ? $image->getDescription() : $product->getName(),
            'id' => isset($images_in_options[$image->getId()]) ? $product->getId().":".$image->getId() : '',
         ));      

         $photos[$index]['thumb_url'] = $image_thumb;  
         $photos[$index]['big_url'] =  $image_big;
         $photos[$index]['id'] =  isset($images_in_options[$image->getId()]) ? $image->getId() : '';
         $photos[$index]['desc'] = $image->getDescription();
         $photos[$index]['product_name'] = $product->getName();
      }
       
   }else{
      $photos[$index]['photo'] = content_tag('a', $image_large, array(
         'href' => $image_big,
         'style' => 'width:' . $tw . 'px;height:' . $th . 'px',
         'rel' => "{gallery: 'zoom_gallery', smallimage: '".st_product_image_path($image, 'large')."', largeimage: '".$image_big."'}",
         'title' => $image->getDescription(),
         'id' => isset($images_in_options[$image->getId()]) ? $product->getId().":".$image->getId() : '',
      ));      

      $photos[$index]['desc'] = $image->getDescription(); 
   }

}


if($themeVersion < 2 && $themeVersion < 7)
{
    if(count($photos)==1)
    {
       $photos = array();
    }
 }elseif($themeVersion >= 7) {
    if(count($photos)==0)
    {
       $photos = array();
    }
 }  

$smarty->assign('photos_count', count($photos));
$smarty->assign('photos', $photos);

$smarty->display('product_image_gallery.html');
?>

<?php if ($themeVersion < 7 && $product->getOptHasOptions() > 1): ?>
<script type="text/javascript" language="javascript">
//<![CDATA[   
jQuery(function ($)
{
    $(document).ready(function ()
    {
        $('.photo a').click(function() {
            var data = $(this).attr('id');
            if (data) {
              var data = data.split(":");

              var options_data = $('#st_update_product_options_form').serialize();

              var basket_add_button = $('#basket_button_container > .basket_add_button');

              var namespace = '';

              if (basket_add_button.length > 0) {
                  namespace = basket_add_button.attr('id').replace(/_[0-9]+/, '');
              }

              $.ajax({
                  url: '<?php echo url_for('stProductOptionsFrontend/changeOptionFromGallery') ?>?product_id='+data[0]+'&image_id='+data[1]+'&namespace='+namespace, 
                  dataType: 'script', 
                  type: 'POST',
                  'data': options_data
              });
            }
        });
    });
});
//]]>
</script>
<?php endif ?>