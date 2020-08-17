<?php

class appImageTagHelper
{
    public static function hydrateResponse(ResultSet $rs) 
    {
        sfLoader::loadHelpers(array('Helper', 'stProductImage'));

        $suggestions = array();
        $data = array();

        $rs->setFetchmode(ResultSet::FETCHMODE_ASSOC);

        while($rs->next())
        {
            $row = $rs->getRow();

            $name = $row['NAME'] ? $row['NAME'] : $row['OPT_NAME'];

            $suggestions[] = $row['CODE'].': '.$name;

            $data[] = array('id' => $row['ID'], 'icon' => st_product_image_path($row['OPT_IMAGE'], 'icon'), 'thumb' => st_product_image_path($row['OPT_IMAGE'], 'thumb'), 'code' => $row['CODE'], 'name' => $name);
        }

        return array('suggestions' => $suggestions, 'data' => $data);
    }

    public static function renderTags($tags, $thumb_type = 'small')
    {
        sfLoader::loadHelpers(array('Helper', 'stProductImage', 'stCategoryImage', 'stUrl', 'stCurrency', 'stBasket'));

        $results = array();

        if (tags)
        {
            $c = new Criteria();
            ProductPeer::addFilterCriteria(null, $c);
            $c->add(ProductPeer::ID, array_keys($tags), Criteria::IN);
            
            $products = ProductPeer::doSelectWithI18n($c, sfContext::getInstance()->getUser()->getCulture());

            foreach ($products as $product) 
            {
                if ($product->getOptHasOptions() <= 1)
                {
                    $quantity = st_basket_add_quantity('basket', $product);
                }
                else
                {
                    $quantity = '';
                }

                $basket = st_basket_add_link('basket', $product, '');
                $price = $product->getConfiguration()->get('global_price_netto') ? st_currency_format($product->getPriceNetto(true)) : st_currency_format($product->getPriceBrutto(true));
                $link = st_url_for('stProduct/show?url='.$product->getFriendlyUrl());
                $thumb = st_product_image_path($product, $thumb_type); 
                $id = $product->getId();                
                $content = '<a href="'.$link.'"><img src="'.$thumb.'"  alt="" /></a><p class="app-product-name"><a href="'.$link.'">'.$product->getName().'</a></p>';
                
                if ($product->isPriceVisible())
                {
                    $content .= '<p class="app-product-price">'.$price.'</p><div class="quantity">'.$quantity.'</div><div class="basket">'.$basket.'</div>';
                }

                $results[] = array(
                    'id' => $id,
                    'x' => $tags[$id]['x'],
                    'y' => $tags[$id]['y'],
                    'text' => $content,
                );            
            } 

        } 

        return $results;      
    }    
}