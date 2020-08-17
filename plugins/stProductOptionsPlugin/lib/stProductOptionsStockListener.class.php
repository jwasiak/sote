<?php
/**
 * SOTESHOP/stProductOptionsPlugin
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stProductOptionsPlugin
 * @subpackage  libs
 */
class stProductOptionsStockListener
{
    public static function updateOptionsStockListItem(sfEvent $event)
    {
        $request = $event->getSubject()->getRequestParameter('product_options_value');     

        $option = $event['modelInstance'];        
                    
        if ($request[$option->getId()]['disabled'])
        {
            $option->setStock(null);
        }  
    }

    public static function postExecuteOptionsStockList(sfEvent $event)
    {
       $action = $event->getSubject();

       $c = $action->pager->getCriteria();

       $c->add(ProductOptionsValuePeer::PRODUCT_ID, $action->forward_parameters['id']);

       $action->pager->init();

       $action->getUser()->setAttribute('optionsStockList.mode', 'edit', 'soteshop/stAdminGenerator/stProduct/config');
    }

    public static function preExecuteOptionsStockDelete(sfEvent $event)
    {
        $options = $event->getSubject()->getRequest()->getParameter('product_options_value');
        $value = $event->getSubject()->getRequest()->getParameter('value', null);
        if(count($options['selected']) > 0)
        {
            foreach($options['selected'] as $selected)
            {
                $option = ProductOptionsValuePeer::retrieveByPk($selected);
                $option->setStock($value);
                $option->save();
            }
            $product = $option->getProduct();

            foreach($product->getProductOptionsValues() as $option)
            {
                if(empty($total))
                {
                    $total = $option->getStock();
                }
                else
                {
                    $total += $option->getStock();
                }
            }
            if(empty($total))
            {
                $product->setStock(null);
            }
            else
            {
                $product->setStock($total);
            }
            $product->save();
            $event->getSubject()->getRequest()->setParameter('product_options_value', array('selected' => array()));
        }
        $request = $event->getSubject()->getRequest();
        $params = '?id='.$request->getParameter('id');
        if($request->hasParameter('page'))
        {
            $params .= '&page='.$request->getParameter('page');
        }

        $event->getSubject()->redirect('stProduct/optionsStockList'.$params);
    }

    public static function postProductSave(sfEvent $event) {
        $product = $event['modelInstance'];

        if ($product->getOptHasOptions()>1 && $event->getSubject()->getRequestParameter('product[is_depository]')==1) {
            $product->setStock(ProductOptionsValuePeer::getProductOptionsStock($product));
            $product->resetModifiers();
        }
    }

    public static function clearFastCache()
    {
        stFastCacheManager::clearCache();
    }

    public static function validateProductConfig(sfEvent $event,$args) {
        $context = sfContext::getInstance();
        $request = $context->getRequest();

        if ($request->getMethod() == sfRequest::POST &&  $request->hasParameter('config[nb_colors_on_list]')) {
            if (intval($request->getParameter('config[nb_colors_on_list]'))<0 || !is_numeric($request->getParameter('config[nb_colors_on_list]'))) {
                $request->setError('config{nb_colors_on_list}',$context->getI18n()->__('Proszę podać liczbę całkowitą nieujemną',null,'stProductOptionsBackend'));
                $args = false;
            }
        }

        
        return $args;
    }
}
