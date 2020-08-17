<?php

use_helper('Asset', 'stPrice', 'I18N', 'stProductImage', 'stCurrency', 'stText', 'stCategory', 'stProducer');

function object_product_is_stock_validated(Product $product, $method, $options)
{
	return checkbox_tag($options['control_name'], true, $product->getIsStockValidated(true), $options); 
}

function object_product_stock_in_decimals(Product $product, $method, $options)
{
   if ($product->getStepQty() > 0)
   {
      $options['disabled'] = true;
   }

   return select_tag($options['control_name'], options_for_select(array(
      0 => __('Wyłączone', null, 'stProduct'), 
      1 => __('Do 1 miejsca po przecinku', null, 'stProduct'), 
      2 => __('Do 2 miejsc po przecinku', null, 'stProduct'),
   ), $product->getStockInDecimals()), $options);
}

function list_product_image(Product $product, $target = null)
{
   if ($target)
   {
      return '<a target="'.$target.'" href="'.st_url_for('@stProductEdit?id='.$product->getId()).'" class="list_product_image" style="background-image: url('.st_product_image_path($product, 'icon').')"></a>';      
   }
   else
   {
      return '<a href="'.st_url_for('@stProductEdit?id='.$product->getId()).'" class="list_product_image" style="background-image: url('.st_product_image_path($product, 'icon').')"></a>';
   }
}

function object_product_hide_price($product, $method, $options)
{
   return _product_hide_price($options['control_name'], $product->$method(), array(), array('include_custom' => __('Wyłączone', null, 'stProduct')));
}

function object_config_hide_price($config, $method, $options)
{
   return _product_hide_price($options['control_name'], $config->get($method), array('default' => false), array('include_custom' => __('Wyłączone', null, 'stProduct')));
}

function _product_hide_price($name, $value, $options = array(), $html_options = array())
{
   if (isset($options['default']))
   {
      $default = $options['default'];
      unset($options['default']);
   }
   else
   {
      $default = true;
   }

   $values = _product_hide_price_options($default);  

   return select_tag($name, options_for_select($values, $value, $html_options), $options);   
}

function _product_hide_price_options($default = true)
{
   $options = array(
      1 => __('Dla wszystkich klientów', null, 'stProduct'),
      2 => __('Dla klientów niezalogowanych', null, 'stProduct'),
      3 => __('Dla klientów niezweryfikowanych', null, 'stProduct'),
   ); 

   if ($default)
   {
      $options = array(__('Zgodnie z globalną konfiguracją', null, 'stProduct')) + $options;
   }


   return $options;
}

function object_product_dimension(Product $product, $method, $options)
{
   $dimensions = ProductDimensionPeer::doSelectNamesCached();

   $dimensions = array("" => "---") + $dimensions;

   $id = get_id_from_name($options['control_name']);

   $js =<<<JS
   <script type="text/javascript">
      jQuery(function($) {
         $('#$id').change(function() {
            var select = $(this);
            var w = $('.row_width input');
            var h = $('.row_height input');
            var d = $('.row_depth input');            
            if (this.selectedIndex) {
               var option = select.children(":selected");
               var values = option.text().match(/\(([^x]+)x([^x]+)x([^ ]+) cm\)/);               
               w.val(values[1]).attr('disabled', true);
               h.val(values[2]).attr('disabled', true);
               d.val(values[3]).attr('disabled', true);
            } else {
               w.removeAttr('disabled');
               h.removeAttr('disabled');
               d.removeAttr('disabled');
          
            }
         }).change();
      });
   </script>
JS;

   $link = st_link_to(__('Konfiguracja rozmiarów', null, 'stProduct'), '@stProduct?action=dimensionList');

   return select_tag($options['control_name'], options_for_select($dimensions, $product->$method()), $options).$js.$link;
}

function list_product_name(Product $product)
{
   $user = sfContext::getInstance()->getUser();

   if ($user->getAttribute('list.mode', null, 'soteshop/stAdminGenerator/'.sfContext::getInstance()->getModuleName().'/config') == 'edit')
   {
      return input_tag('product['.$product->getId().'][name]', $product->getName());
   }
   else
   {
      if (st_check_strlen($product->getName()) > '64') {
         return st_truncate_text($product->getName(), '65', '...');   
      } else {
         return $product->getName();
      }
      
   }
}

function object_product_image(Product $product) 
{
   $images = array();

   if (!$product->isNew())
   {
      $c = new Criteria();

      $c->addSelectColumn(sfAssetPeer::ID);

      $c->addSelectColumn(sfAssetPeer::FILENAME);

      $c->addJoin(sfAssetPeer::ID, ProductHasSfAssetPeer::SF_ASSET_ID);

      $c->add(ProductHasSfAssetPeer::PRODUCT_ID, $product->getId());

      $c->addDescendingOrderByColumn(ProductHasSfAssetPeer::IS_DEFAULT);

      $c->addAscendingOrderByColumn(ProductHasSfAssetPeer::ID);

      $rs = sfAssetPeer::doSelectRs($c);

      while($rs->next())
      {
         $images[$rs->getInt(1)] = '/media/products/'.$product->getAssetFolder().'/images/'.$rs->getString(2);
      }
   }

   return plupload_images_tag('product_images', $images, array('edit_url' => 'stProduct/imageGalleryEdit?culture='.$product->getCulture(), 'crop' => 'product'));
}

function list_product_price_label($label)
{
   $currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();

   return __($label, null, 'stProduct').' ['.$currency->getFrontSymbol().$currency->getBackSymbol().']';
}

function list_product_price(Product $product)
{
   $user = sfContext::getInstance()->getUser();

   if ($user->getAttribute('list.mode', null, 'soteshop/stAdminGenerator/'.sfContext::getInstance()->getModuleName().'/config') == 'edit')
   {
      $request =  sfContext::getInstance()->getRequest();

      $name = 'product['.$product->getId().'][price_brutto]';

      $value = $request->hasErrors() && $product->getCurrencyExchange() == 1 ?  $request->getParameter($name) : stPrice::round($product->getPriceBrutto());

      $js =<<<JS
jQuery(function($) {      
   var field = $('#product_{$product->getId()}_price_brutto');
   field.change(function() {
      this.value = stPrice.fixNumberFormat(this.value);
   });

   field.keypress(function(event) {
      if (event.keyCode == Event.KEY_RETURN)
      {
         this.value = stPrice.fixNumberFormat(this.value);
      }
   });
});
JS;
      return input_tag($name, $value, array(
         'class' => 'editable', 
         'disabled' => $product->getCurrencyExchange() != 1
      )).javascript_tag($js);
   }
   else
   {
      return '<p style="text-align: right">'.st_format_price($product->getPriceBrutto()).'</p>';
   } 
}

function list_product_info(Product $product)
{
   $user = sfContext::getInstance()->getUser();

   if ($user->getAttribute('list.mode', null, 'soteshop/stAdminGenerator/'.sfContext::getInstance()->getModuleName().'/config') == 'edit')
   {
      $code = input_tag('product['.$product->getId().'][code]', $product->getCode());
   }
   else
   {
      $code = $product->getCode();
   }

   return '<a href="'.st_url_for('@stProduct?id='.$product->getId()).'">'.$product->getName().'</a><p>'.__('Kod produktu').':&nbsp;&nbsp;'.$code.'</p>';
}

function object_product_producer(Product $product, $method, $options)
{
   return producer_select_tag($options['control_name'], $product->getProducer(), array('include_custom' => __('Brak')));
}

function list_product_producer(Product $product)
{
   $user = sfContext::getInstance()->getUser();

   if ($user->getAttribute('list.mode', null, 'soteshop/stAdminGenerator/'.sfContext::getInstance()->getModuleName().'/config') == 'edit')
   {
      return producer_select_tag('product['.$product->getId().'][producer_id]', $product->getProducer(), array('include_custom' => __('Brak')));
   }
   else 
   {
      return $product->getProducer();
   }
}

function object_product_tax(Product $product, $method, $options = array())
{
   use_helper('stPrice');

   $cache = new stFunctionCache('stTax');

   $tax_info = $cache->cacheCall('_object_product_tax_helper');

   st_price_tax_managment_init(array(
           'taxField' => 'product_vat',
           'taxValues' => $tax_info['values'],
           'priceFields' => array(
                   array('price' => 'product_price_netto', 'priceWithTax' => 'product_price_brutto'),
                   array('price' => 'product_old_price_netto', 'priceWithTax' => 'product_old_price_brutto'),
           ))); 

   return select_tag('product[vat]', options_for_select($tax_info['names'], $product->getTaxId() ? $product->getTaxId() : $tax_info['default'])); 
}

function _object_product_tax_helper()
{
    $arr = array('values' => array());

    $taxes =  TaxPeer::doSelect(new Criteria());

    foreach ($taxes as $tax)
    {
        $arr['values'][] = $tax->getVat();

        $arr['names'][$tax->getId()] = $tax->getVatName();

        if ($tax->getIsDefault())
        {
            $arr['default'] = $tax->getId();
        }
    }

    return $arr;   
}

function object_product_group(Product $product, $method, $options = array())
{
   $cache = new stFunctionCache('stProductGroup');

   $groups =  $cache->cacheCall('_object_product_group_helper');

   $request = sfContext::getInstance()->getRequest();
   
   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
   }
   else
   {
      $defaults = ProductPeer::doSelectProductGroupsForTokenInput($product);
   }

   return st_tokenizer_input_tag($options['control_name'], $groups, $defaults, array('tokenizer' => array('preventDuplicates' => true, 'hintText' => __('Wpisz szukana grupę'))));
}

function _object_product_group_helper() 
{
   $groups = array();

   $c = new Criteria();
   $c->add(ProductGroupPeer::FROM_BASKET_VALUE, null, Criteria::ISNULL);
   foreach (ProductGroupPeer::doSelect($c) as $group)
   {
      $groups[] = array('id' => $group->getId(), 'name' => $group->getName());
   }   

   return $groups;
}

function object_product_delivery(Product $product, $method, $options = array())
{
   $cache = new stFunctionCache('stDelivery');

   $deliveries = $cache->cacheCall('_object_product_delivery_helper');

   $request = sfContext::getInstance()->getRequest();
   
   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = array(
         'mode' => $parameters['mode'],
         'ids' => stJQueryToolsHelper::parseTokensFromRequest($parameters['ids'])
      );
   }
   else
   {
      $defaults = $product->getDeliveries();

      if ($defaults['ids']) 
      {
         $tokens = array();

         foreach ($defaults['ids'] as $id)
         {
            if (isset($deliveries[$id]))
            {
               $tokens[] = array(
                  'id' => $id,
                  'name' => $deliveries[$id]['name'],
               );
            }
         }

         $defaults['ids'] = $tokens;
      }

      if (!$defaults['ids'])
      {
         $defaults = null;
      }
   }

   $select = select_tag($options['control_name'].'[mode]', options_for_select(array('' => __('Wszystkie', null, 'stProduct'), 'allow' => __('Zezwalaj', null, 'stProduct'), 'exclude' => __('Wykluczaj', null, 'stProduct')), $defaults ? $defaults['mode'] : null));

   $token = st_tokenizer_input_tag($options['control_name'].'[ids]', array_values($deliveries), $defaults ? $defaults['ids'] : null, array('tokenizer' => array('preventDuplicates' => true, 'hintText' => __('Wpisz szukana dostawę', null, 'stProduct'))));

   $content =<<< HTML
      $select
      <div id="product_delivery_token" style="margin-top: 5px; display: none">$token</div>
      <script type="text/javascript">
         jQuery(function(\$) {
            \$('#product_delivery_mode').change(function() {
               if (\$(this).val()) {
                  \$('#product_delivery_token').show();
               } else {
                  \$('#product_delivery_token').hide();
               }
            }).change();
         });
      </script>
HTML;

   return $content;
}

function _object_product_delivery_helper() 
{
   $deliveries = array();

   $c = new Criteria();
   $c->add(DeliveryPeer::ACTIVE, true);
   $c->addAscendingOrderByColumn(DeliveryPeer::OPT_NAME);
   foreach (DeliveryPeer::doSelect($c) as $delivery)
   {
      $id = $delivery->getId();
      $deliveries[$id] = array('id' => $id, 'name' => $delivery->getOptName()." (".$id.")");
   }   

   return $deliveries;
}

function object_product_category(Product $product, $method, $options = array())
{
   $context = sfContext::getInstance();

   $request = $context->getRequest();

   $defaults = array();

   $default = 0;

   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
      $default = $request->getParameter('product_default_category');
   }
   elseif ($product->isNew())
   {
      $category_id = $context->getUser()->getAttribute('category_filter', null, 'soteshop/stProduct');

      if ($category_id) 
      {   
         $category = CategoryPeer::retrieveByPK($category_id);

         if ($category)
         {
            $path = array();
            
            foreach ($category->getPath() as $c)
            {
               $path[] = $c->getOptName();
            }

            $path[] = $category->getOptName();

            $defaults = array(
               array('id' => $category->getId(), 'name' => implode(' / ', $path))
            );

            $default = $category->getId();
         }
      }
   }
   else
   {   
      $defaults = ProductPeer::doSelectCategoriesForTokenInput($product);
      $default = ProductPeer::doSelectDefaultCategoryId($product);

      if (!$default && $defaults) {
         $default = $defaults[0]['id'];
      }
   }

   return category_picker_input_tag($options['control_name'], $defaults, array('default' => $default));
}

function object_product_accessories(Product $product, $method, $options = array())
{
   $request = sfContext::getInstance()->getRequest();
   
   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
   }
   else
   {   
      $defaults = ProductPeer::doSelectAccessoriesForTokenInput($product); 
   }

   $results_formatter = _token_input_product_results_formatter();

   $token_formatter = _token_input_product_token_formatter();

   return st_tokenizer_input_tag($options['control_name'], st_url_for('@stProductEdit?action=ajaxProductsToken&id='.$product->getId()), $defaults, array('tokenizer' => array(
      'preventDuplicates' => true, 
      'resultsFormatter' => $results_formatter, 
      'tokenFormatter' => $token_formatter,
      'hintText' => __('Wpisz kod/nazwę szukanego produktu'), 
      'additionalDataFields' => array('code'),
      'tokenLimit' => 20,
      'sortable' => true
   )));
}


function object_product_recommend(Product $product, $method, $options = array())
{
   $request = sfContext::getInstance()->getRequest();
   
   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
   }
   else
   {   
      $defaults = ProductPeer::doSelectRecommendForTokenInput($product); 
   }

   $results_formatter = _token_input_product_results_formatter();

   $token_formatter = _token_input_product_token_formatter();

   return st_tokenizer_input_tag($options['control_name'], st_url_for('@stProductEdit?action=ajaxProductsToken&id='.$product->getId()), $defaults, array('tokenizer' => array(
      'preventDuplicates' => true, 
      'resultsFormatter' => $results_formatter, 
      'tokenFormatter' => $token_formatter,
      'hintText' => __('Wpisz kod/nazwę szukanego produktu'), 
      'additionalDataFields' => array('code'),
      'tokenLimit' => 20
   )));
}

function object_product_discount_group(Product $product, $method, $options = array())
{
   $cache = new stFunctionCache('stDiscount');

   $groups =  $cache->cacheCall('_object_product_discount_group_helper');   
 
   $request = sfContext::getInstance()->getRequest();
   
   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
   }
   else
   {  
      $defaults = ProductPeer::doSelectDiscountGroupsForTokenInput($product);
   }

   return st_tokenizer_input_tag($options['control_name'], $groups, $defaults, array('tokenizer' => array('preventDuplicates' => true, 'hintText' => __('Wpisz nazwę szukanej grupy'))));
}

function _token_input_product_token_formatter()
{
   return "function (item) { 
      return '<li class=\"product_token\">'+item.name+' <span class=\"code\">('+item.code+')</span></li>';
   }";   
}

function _token_input_product_results_formatter()
{
   return "function (item, token_input, query) { 
      return '<li class=\"product_token\"><div class=\"image\"><div style=\"background-image: url('+item.image+')\"></div></div><span class=\"name\">'+item.name+' <span class=\"code\">('+item.code+')</span></span></li>';
   }";    
}



function _object_product_discount_group_helper()
{
   $groups = array();

   $c = new Criteria();

   foreach (DiscountPeer::doSelect($c) as $group)
   {
      $groups[] = array('id' => $group->getId(), 'name' => $group->getName().' ('.$group->getValue().'%)');
   }
   
   return $groups;   
}

function object_product_availability($product, $method, $options = array())
{
   $c = new Criteria();

   $select_options = array('' => __('Ustaw według magazynu'));

   foreach (AvailabilityPeer::doSelectWithI18n($c) as $availability)
   {
      $select_options[$availability->getId()] = $availability->getAvailabilityName();
   }

   return select_tag($options['control_name'], options_for_select($select_options, $product->getAvailabilityId()), $options);
}

function object_product_step_qty(Product $product, $method, $options)
{
   $id = get_id_from_name($options['control_name']);
   
   $js =<<<JS
   <script type="text/javascript">
      jQuery(function($)
      {
         $('#$id').change(function(){
            $('#product_stock_in_decimals').attr('checked' , this.value > 0);
            $('#product_stock_in_decimals').attr('disabled' , this.value > 0);
         });
      });
   </script>
JS;
   
   return object_product_price($product, $method, $options).$js;
}

function object_product_weight(Product $product, $method, $options)
{
   return object_product_price($product, $method, $options).' kg';
}

function object_product_stock_managment(Product $product, $method, $options)
{
   $name = $options['control_name'];
   unset($options['control_name']);

   return select_tag($name, options_for_select(array(
      ProductPeer::STOCK_PRODUCT_OPTIONS => __('z opcjami produktu'),
      ProductPeer::STOCK_PRODUCT => __('bez opcji produktu')
   ), $product->getStockManagment()), $options);
}

function object_product_stock(Product $product, $method, $options)
{
   $option_link = $product->getOptHasOptions() > 1 ? st_link_to(__('Edytuj', null, 'stProduct'), 'stProduct/optionsStockList?id='.$product->getId()) : '';

   $product_stock = object_product_price($product, $method, $options);   

   $spo = ProductPeer::STOCK_PRODUCT_OPTIONS;
   $sp = ProductPeer::STOCK_PRODUCT;

   $dsp = $dspo = '';

   if ($product->hasStockManagmentWithOptions())
   {
      $dsp = 'style="display: none"'; 
   }
   else 
   {
      $dspo = 'style="display: none"';
   }

   $html =<<<HTML
   <div class="stock_managment" id="stock_managment_$spo" $dspo>$option_link</div>
   <div class="stock_managment" id="stock_managment_$sp" $dsp>$product_stock</div>
   <script type="text/javascript">
      jQuery(function($) {
         $('#product_stock_managment').change(function() {
            var select = $(this);
            var index = select.val();
            var container = $('#stock_managment_'+index);
            if (!container.is(':empty')) {
               $('.stock_managment').hide();
               container.show();
            }
         });
      });
   </script>
HTML;

   return $html;
}

function object_product_uom($product, $method, $options)
{
   return input_tag($options['control_name'], st_product_uom($product), $options);
}

function object_product_price(Product $product, $method, $options)
{
   $name = $options['control_name'];

   unset($options['control_name']);

   if (!isset($options['size']))
   {
      $options['size'] = 8;
   }
   if (!isset($options['maxlength']))
   {
      $options['maxlength'] = 11;
   }

   $js = st_price_add_format_behavior(get_id_from_name($name));

   return input_tag($name, st_price_format($product->$method()), $options).$js;
}

function st_product_uom($product)
{
   static $uom = null;

   if (null === $uom)
   {
      $uom = __('szt.', null, 'stDepositoryBackend');
   }

   return $product && $product->getUom() ? $product->getUom() : $uom;
}

function st_product_check_price_type()
{
   $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

   return $config->get('price_type');
}

function st_product_get_attachment_icon($attachment)
{
   $types = array('archive' => true, 'txt' => true, 'image' => true, 'pdf' => true);

   $type = isset($types[$attachment->getType()]) ? $attachment->getType() : 'txt';

   return image_tag('/images/frontend/theme/default/attachments/'.$type.'.gif', array('alt' => ''));
}

function st_product_category_filter($parent)
{
   if (is_object($parent))
   {
      $children = $parent->getChildren();
   }
   else
   {
      $children = $parent;
   }

   $content = '';

   $is_first = true;

   foreach ($children as $child)
   {
      $content .= _st_category_filter_item($child, strtr(microtime(true), '.', '-').'-'.$child->getId(), $is_first);

      $is_first = false;
   }

   return content_tag('ul', $content);
}

function _st_category_filter_item(Category $item, $item_id, $is_first = false)
{
   $params = array();

   $has_children = $item->hasChildren();

   if ($has_children)
   {
      $params['class'] = 'expandable loadable';

      $children = content_tag('div', strtotime($item->getUpdatedAt()), array('id' => 'sub-categories-'.$item_id, 'class' => 'sub-categories', 'style' => 'display: none;'));

      $expand_icon = content_tag('span', '&rsaquo;');
   }
   else
   {
      $children = '';

      $expand_icon = '';
   }

   if ($is_first)
   {
      $params['class'] = isset($params['class']) ? $params['class'].' first' : 'first';
   }

   return content_tag('li', $children.link_to($item->getName().$expand_icon, '@stProductCategoryFilter?category_id='.$item->getId()), $params);
}