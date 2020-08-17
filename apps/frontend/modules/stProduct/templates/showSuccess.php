<?php if ($themeVersion >= 2 && $themeVersion < 7 && $product->getDefaultAssetImage()): ?>
<script type="text/javascript">
   //<![CDATA[
   jQuery(function ($) {
      $(document).ready(function () {

         var trigger = $('.zoom_image_trigger');

         var links = $('.gallery a');

         links.add(trigger).lightBox({
            txtImage:   '<?php echo __('Obrazek') ?>',
            txtOf:      '<?php echo __('z') ?>'
         });

         links.unbind('click');

         trigger.jqzoom({
            zoomType:'innerzoom',
            lens:true,
            preloadImages:false,
            showEffect:'fadein',
            hideEffect:'fadeout',
            title:false
         });

      });

   });
   //]]>
</script>
<?php endif; ?>
<?php
use_helper('stCurrency', 'stProductPrice', 'stTabNavigator','stText', 'stProductImage', 'stUrl', 'stProducerImage', 'stProduct');

if ($themeVersion >= 2 && $themeVersion < 7){
use_helper('stPhotoGallery');    
st_theme_use_stylesheet('stProduct.css');
st_theme_use_stylesheet('stReview.css');
st_theme_use_stylesheet('stAttachment.css');
use_javascript('photoGallery/textGallery.js', 'last');

$smarty->assign('show_image', $config->get('show_image'));
}


$th = st_asset_thumbnail_setting('height', 'large');

$smarty->assign('photo_dimension', "style='height:". $th . "px'");

if($themeVersion >= 2 && $themeVersion < 7)
{  
    if($themeVersion < 2)
    {  
       $image_large = st_product_image_tag($product, 'large', array('id' => 'st_product-default-image'));

       $smarty->assign('photo', content_tag('a', $image_large, array(
          'href' => st_product_image_path($product, 'big'),
          'rel' => 'lightbox[product_image_gallery]',
          'title' => $product->getOptImageDescription(),
          'id' => 'st_product-default-image-link'
       )));
    }
    else
    {
       $image_large = st_product_image_tag($product, 'large', array('id' => 'st_product-default-image'));

       $smarty->assign('photo', content_tag('a', $image_large, array(
          'href' => st_product_image_path($product, 'big'),
          'rel' => 'zoom_gallery',
          'class' => 'zoom_image_trigger',
          'title' => $product->getOptImageDescription(),
          'id' => 'st_product-default-image-link'
       )));
    }
}
elseif($themeVersion >= 7){
    $image_id = $product->getDefaultAssetImage() ? $product->getDefaultAssetImage()->getId() : 0;
    $smarty->assign('photo', array(
        'thumb' => st_product_image_path($product, 'large'),
        'big' => st_product_image_path($product, 'big'),
        'gallery' => st_product_image_path($product, 'gallery'),
        'title' => $product->getOptImageDescription(),
        'id' => isset($images_in_options[$image_id]) ? $images_in_options[$image_id] : '',
        'desc' => $product->getOptImageDescription(),
    ));  
    
}

if ($product->getOptImageDescription())
{
  $smarty->assign("photo_alt", $product->getOptImageDescription());
}else{
  $smarty->assign("photo_alt", $product->getName());
}

$smarty->assign('show_galery', $config->get('show_galery'));
$smarty->assignComponent('photos', "stProduct", "imageGallery", array("product" => $product, 'images_in_options' => $images_in_options));
$smarty->assign('show_name', $config->get('show_name'));
$smarty->assign('name', $product->getName());
$smarty->assign('id', $product->getId());
$smarty->assign('show_code', $config->get('show_code'));
$smarty->assign('code', $product->getCode());
$smarty->assign('discount_type', $config->get('discount_type'));
$smarty->assign('show_discount', $config->get('show_discount'));
$smarty->assign('show_saved_price', $config->get('show_saved_price'));
$saved_price_types = array(
  'only_net' => 'only_net_saved',
  'only_gross' => 'only_gross_saved',
  'net_gross' => 'net_saved',
  'gross_net' => 'gross_saved',
);
$smarty->assign('saved_price_type', $saved_price_types[$config->get('price_view')]);
if (($config->get('show_producer') == 'name') ||  ($config->get('show_producer') == 'logo'))
{
  $smarty->assign('show_producer',1);  
}
else
{
   $smarty->assign('show_producer',0);  
}

$smarty->assign("show_manufacturer", $config->get('show_manufacturer'));

if($themeVersion < 2)
{
    $smarty->assign('show_review',$config->get('show_review'));  
}

if (isset($producer))
{ 
    $smarty->assign('producer_instance', $producer);

    $producer_url = st_url_for('stProduct/producerList?url=' . $producer->getFriendlyUrl());

    if (($config->get('show_producer')=='logo') && ($producer->getSfAssetId()))
    {
        $smarty->assign('producer', content_tag('a',st_producer_image_tag($producer, 'thumb'),array('href' => $producer_url)));
    }
    else
    {
        $smarty->assign('producer', content_tag('a', $producer->getName(), array('href' => $producer_url, 'class' => 'product_name')));
    }

    if ($producer->getSfAssetId())
    {
       $smarty->assign('producer_logo', content_tag('a',st_producer_image_tag($producer, 'thumb'),array('href' => $producer_url)));
    }
    
    $smarty->assign('producer_name', content_tag('a', $producer->getName(), array('href' => $producer_url, 'class' => 'producer_name')));
}

$smarty->assign('show_category',$config->get('show_category'));

if ($category)
{
    $smarty->assign('main_category', $category);
    $smarty->assign('default_category', $category->getName());
    
}

$smarty->assign('instance', $product);
$smarty->assign('description_long', $product->getDescription());
$smarty->assign('show_short_description',$config->get('show_short_description'));

if ($product->getShortDescription())
{
    $smarty->assign("description", $product->getShortDescription());
}
elseif($themeVersion < 7)
{
    $smarty->assign("description", st_truncate_text($product->getDescription(),500,''));
}

$smarty->assignComponent('depository', 'stDepositoryFrontend', 'depository', array('product' => $product));
$smarty->assignComponent('availability', 'stAvailabilityFrontend', 'availability', array('product' => $product));

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_card_show_points'));
$smarty->assign('display_type', $config_points->get('product_card_display_type'));
$smarty->assign('points_value', $product->getPointsValue());
$smarty->assign('points_earn', $product->getPointsEarn());
$smarty->assign('points_only', $product->getPointsOnly());
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('points_login_status', stPoints::getLoginStatusPoints());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());
$smarty->assign('is_release', stPoints::isReleasePointsSystemForUser());


if ($product->isPriceVisible())
{
    if ($config->get('show_uom') && $product->getUom())
    {
      $uom = " / ".$product->getUom();
    }else{
      $uom = "";
    }



    $smarty->assign('price_brutto', content_tag('span', st_currency_format($product->getPriceBrutto(true)), array('id' => 'st_product_options-price-brutto')).$uom);
    
    if ($config->get('show_basic_price') && $product->hasBasicPrice() && $product->getBasicPriceBrutto()!=0)
    {
        $smarty->assign('basic_price', array(
            'netto' => '<span id="basic-price-netto">'.st_currency_format($product->getBasicPriceNetto(true)).'</span>',
            'brutto' => '<span id="basic-price-brutto">'.st_currency_format($product->getBasicPriceBrutto(true)).'</span>',
            'quantity' => '<span id="basic-price-quantity">'.st_product_basic_price_quantity($product).'</span>',
            'for_quantity' => '<span id="basic-price-for-quantity">'.st_product_basic_price_for_quantity($product).'</span>',
        ));
    }

    $smarty->assign('price_net', content_tag('span', st_currency_format($product->getPriceNetto(true)), array('id' => 'st_product_options-price-netto')).$uom);
    $smarty->assign('price_brutto_pure', $product->getPriceBrutto(true).$uom);
    $smarty->assign('price_netto_pure', $product->getPriceNetto(true).$uom);
    $currency = stCurrency::getInstance(sfContext::getInstance());
    $smarty->assign('currency_iso', stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut());
    if ($currency->getFrontSymbol())
    {
      $smarty->assign('currency', $currency->getFrontSymbol());
    }
    else
    {
      $smarty->assign('currency', $currency->getBackSymbol());
    }

    $check_old_price = $product->getOldPriceBrutto(true) != 0 && $config->get('show_old_price');
    $smarty->assign('check_old_price', $config->get('show_old_price'));
    $smarty->assign('old_price_brutto', $check_old_price ? st_currency_format($product->getOldPriceBrutto(true)) : '');
    $smarty->assign('old_price_net', $check_old_price ? st_currency_format($product->getOldPriceNetto(true)) : '');
    $smarty->assignComponent('basket', 'stBasket', 'add', array('product' => $product, 'info' => true));
    $smarty->assign('check_price', false);

    if($product->hasDiscount())
    { 
        $saved_price_in_percent = $product->getDiscountInPercent();
        $smarty->assign('you_safe', true);
        $smarty->assign('price_discount', content_tag('span', st_currency_format($product->getDiscountNetto(true)), array('id' => 'st_product_options-discount-netto')));
        $smarty->assign('price_discount_percent', $saved_price_in_percent);
        $smarty->assign('price_catalogue', content_tag('span', st_currency_format($product->getPriceNetto(true, false)), array('id' => 'st_product_options-catalogue-netto')));
        $smarty->assign('price_catalogue_brutto', content_tag('span', st_currency_format($product->getPriceBrutto(true, false)), array('id' => 'st_product_options-catalogue-brutto')));
        $smarty->assign('price_discount_brutto', content_tag('span', st_currency_format($product->getDiscountBrutto(true)), array('id' => 'st_product_options-discount-brutto')));
        $smarty->assign('price_discount_percent_brutto', $saved_price_in_percent);
    }

    if ($product->getHasWholesalePrice())
    {
       $smarty->assign('retail_price_netto', st_currency_format($product->getRetailPriceNetto(true)));
       $smarty->assign('retail_price_brutto', st_currency_format($product->getRetailPriceBrutto(true)));
       $smarty->assign('has_wholesale_price', true);
    }
    else
    {
       $smarty->assign('has_wholesale_price', false);
    }
}
else
{
    $smarty->assign('check_price', true);
}

$smarty->assign('show_price',$config->get('show_price'));
$smarty->assign('show_old_price',$config->get('show_old_price'));
$smarty->assign('price_view',$config->get('price_view'));

if ($themeVersion < 7)
{
    $smarty->assign('product_list', st_get_tab_navigator($productList));
    $smarty->assign('product_description', st_get_tab_navigator($productDescription));
}
else
{
    $smarty->assign('tab_navigator', $tabNavigator);
}

$smarty->assign('show_compare', $config->get('show_compare')); 
$smarty->assignComponent('product_compare', 'stProductsCompareFrontend', 'productCompareButton', array('product' => $product));

if ($config->get('show_review'))
{
    $smarty->assignComponent('product_review', 'stReview', 'showStars', array('product'=> $product));
}

if ($sf_context->getController()->getTheme()->getVersion() >= 2)
{
   $smarty->assignComponent('product_question', 'stQuestionFrontend', 'showQuestion', array('product' => $product));
}
else
{
   $smarty->assignComponent('product_question', 'stQuestionFrontend', 'ask', array('product'=> $product, 'smarty' => $smarty));   
}

$smarty->assignComponent('product_recommend', 'stRecommendProductFrontend', 'showRecommend', array('product' => $product));

$smarty->assignComponent('product_payment_info', 'stPayment', 'showInfoInProduct', array('product' => $product));

$smarty->assignComponent('product_add_this', 'stAddThisFrontend', 'shareButtons', array('view' => 'product'));

$smarty->assignComponent('product_attributes', 'appProductAttributeFrontend', 'list', array('product' => $product));

$smarty->assignComponent('product_set_discounts', 'stDiscountFrontend', 'discountProductSetList', array('product' => $product));

$smarty->assignComponent('product_trust', 'stTrustFrontend', 'show', array('product' => $product));

$smarty->assign('show_product_attributes', $config->get('show_product_attributes', 'after_desc'));
$smarty->assign('show_weight', $config->get('show_weight'));
$smarty->assign('weight', $product->getWeight()); 
$smarty->assign('weight_unit', $config->get('weight_unit'));
$smarty->assign('stock', $product->getStock());
$smarty->assign('max_execute',$product->getExecutionTime());
$smarty->assign('uom', st_product_uom($product));
$smarty->assign('show_depository',$config->get('show_depository'));
$smarty->assign('show_availability',$config->get('show_availability'));
$smarty->assign('show_short_description',$config->get('show_short_description'));
$smarty->assign('show_description',$config->get('show_description'));

$smarty->assign('show_man_code',$config->get('show_man_code'));
$smarty->assign('man_code', $product->getManCode());
$smarty->assign('show_execute_time',$config->get('show_execute_time'));
$smarty->assign('execute_time',$product->getExecutionTime());

$config_google_shopping  = stConfig::getInstance('stGoogleShoppingBackend');

if ($product->getFrontendAvailability())
{
  $avail = 'availability_'.$product->getFrontendAvailability()->getId();
  $availabilities = array(
  0 => 'InStock',
  1 => 'OutOfStock',
  2 => 'PreOrder',
  );
  
  $avail_true = $config_google_shopping->get($avail);

  if ($avail_true){
  $smarty->assign('structure_avail', $availabilities[$avail_true]);
  }else{
  $smarty->assign('structure_avail', 'InStock'); 
  }
  
}

$sku_type = $config_google_shopping->get('type_id');

if ($sku_type == "product_id")
{
  $smarty->assign('sku', $product->getId());                
}elseif ($sku_type == "product_code"){
  $smarty->assign('sku', $product->getCode());  
}

$smarty->assign('price_brutto_structure', $product->getPriceBrutto(true));
$smarty->assign('price_netto_structure', $product->getPriceNetto(true));
$smarty->assign('url', st_url_for('stProduct/show?url='.$product->getFriendlyUrl(), true, null, stLanguage::getInstance(sfContext::getInstance())->getDomain()));
$smarty->assign('price_valid_until', date('Y-m-d',strtotime('+2 weeks')));

if(is_object($structure_review))
{
  $smarty->assign('check_review', 1);
  $smarty->assign('review_person', $structure_review->getUsername());
  $smarty->assign('review_score', $structure_review->getScore());
}else{
  $smarty->assign('check_review', 0);
}


$smarty->display('product_show_default.html');


?>