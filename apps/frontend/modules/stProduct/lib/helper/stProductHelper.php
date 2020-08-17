<?php
use_helper('stTheme', 'I18N');

function st_product_uom($product)
{
   static $uom = null;
   
   if (null === $uom)
   {
      $uom = __('szt.', null, 'stDepositoryFrontend');
   }
   
   return $product && $product->getUom() ? $product->getUom() : $uom;
}

function st_product_basic_price_quantity(Product $product)
{
   if ($product->hasBasicPrice())
   {
      $bpum = BasicPriceUnitMeasurePeer::retrieveCachedArrayByPK($product->getBpumDefaultId());
      return $product->getBpumDefaultValue().' '.$bpum['unit'];
   }

   return '';
}

function st_product_basic_price_for_quantity(Product $product)
{
   if ($product->hasBasicPrice())
   {
      $bpum = BasicPriceUnitMeasurePeer::retrieveCachedArrayByPK($product->getBpumId());
      return $product->getBpumValue().' '.$bpum['unit'];
   }

   return '';
}

function st_product_quantity_list($name, Product $product, $value = null, $html_options = array())
{
   $config =  stConfig::getInstance('stBasket');
   
   if (isset($html_options['max']))
   {
      $max = $html_options['max'];
      
      unset($html_options['max']);
   }
   else
   {
      $stock_validated = $product->getIsStockValidated();
      
      $check_stock = null === $stock_validated && $product->getConfiguration()->get('depository_basket') || null !== $stock_validated && $stock_validated;
      
      $stock = $check_stock && $product->getStock() ? $product->getStock() : $config->get('max_quantity');
   
      $max_qty = $product->getMaxQty() ? $product->getMaxQty() : $config->get('max_quantity');
      
      $max = $max_qty < $stock ? $max_qty : $stock;
   }
  
   $options = array();
      
   $has_decimals = $product->getStepQty() != intval($product->getStepQty()) || $product->getMinQty() != intval($product->getMinQty());

   for ($i = $product->getMinQty(); $i <= $max; $i += $product->getStepQty())
   {
      $options[$has_decimals ? number_format($i, 2, '.', '') : (string)$i] = $has_decimals ? st_format_price($i) : $i;
   }
   
   if (!$options)
   {
      $options[] = $product->getStock();
   }
   
   end($options);
   
   $last = key($options);
   
   $value = $has_decimals ? number_format($value, 2, '.', '') : (string)$value;
      
   if ($last < $value)
   {
      $value = $last;
   }
   
   return select_tag($name, options_for_select($options, $value), $html_options);
}

function st_product_group_labels(Product $product, $product_url, $culture)
{
    static $group_labels = null;

    if (null === $group_labels)
    {
        $cache = new stFunctionCache('stProductGroup');
      
        $group_labels = $cache->cacheCall(array('ProductGroupPeer', 'doSelectLabelsArray'), array($culture));  
        
        $group_labels = stEventDispatcher::getInstance()->filter(new sfEvent($product, 'group_labels.filter'), $group_labels)->getReturnValue();
    }

    $results = array();

    if ($group_labels)
    {
        $product_group_labels = unserialize($product->getOptProductGroup());

        $product_group_labels = stEventDispatcher::getInstance()->filter(new sfEvent($product, 'product_group_labels.filter'), $product_group_labels)->getReturnValue();

        if ($product_group_labels)
        {
            $config = stConfig::getInstance('stProductGroup');

            $i = 0;

            sort($product_group_labels);

            foreach($product_group_labels as $id)
            {
                if (isset($group_labels[$id])) 
                {
                    $i++;

                    if ($i <= $config->get('label_count'))
                    {
                        $image = $group_labels[$id]['image'][0] == '/' ? $group_labels[$id]['image'] : '/uploads/product_group/' . $group_labels[$id]['image'];
                        $img = '<img src="'.$image.'" class="group_label" alt="'.$group_labels[$id]['name'].'" />';
                        
                        $url = $config->get('label_link') && isset($group_labels[$id]['url']) && $group_labels[$id]['url'] ? st_url_for(array('module' => 'stProduct', 'action' => 'groupList', 'url' => $group_labels[$id]['url'])) : $product_url;

                        $results[$id] = '<a href="'.$url.'">'.$img.'</a>';
                    } 
                }
            }
        }
    }

    return $results;    
}

function st_product_link_to($label, $action, $for_link, $for_link_custom = array(), $params = array())
{
   if (sfContext::getInstance()->getRequest()->hasParameter('sort_by'))
   {
      $params['rel'] = 'nofollow';
   }

   $params['href'] = st_product_url_for($action, $for_link, $for_link_custom);

   return content_tag('a', $label, $params);
}

function st_product_url_for($action, $for_link, $for_link_custom = array(), $absolute = false)
{
   if (defined('ST_FAST_CACHE_SAVE_MODE') && (ST_FAST_CACHE_SAVE_MODE==1))
   {
      $query = '';
   }
   else
   {
      $query = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
   }
   
   return st_url_for(_st_product_link_to($action, $for_link, $for_link_custom), $absolute).$query;

}

function _st_product_link_to($action, $for_link, $for_link_custom = array())
{
   if ($for_link_custom)
   {
      $for_link = array_merge($for_link, $for_link_custom);
   }

   if (!isset($for_link['module']))
   {
      $for_link['module'] = 'stProduct';
   }  
    
   $for_link['action'] = $action;
     
   return $for_link;
}

function st_product_get_attachment_icon($attachment)
{
    $types = array('archive' => true, 'txt' => true, 'image' => true, 'pdf' => true);

    $type = isset($types[$attachment->getType()]) ? $attachment->getType() : 'txt';

    return st_theme_image_tag('attachments/'.$type.'.gif', array('alt' => ''));
}