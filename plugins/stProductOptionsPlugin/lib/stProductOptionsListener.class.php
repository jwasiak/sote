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
class stProductOptionsPluginListener
{
    static $postClear = array();
    static $inBasket = array();

    const DUPLICATE_LIMIT = 50;
    /**
     * Podpięcie zdarzenia do generatora produktu.
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stProductOptionsPlugin', 'stProduct.yml');
    }

    public static function productPreSave(sfEvent $event)
    {
    	if ($event->getSubject()->isNew())
    	{
    		$event->getSubject()->setOptHasOptions($event->getSubject()->countProductOptionsValues());
    	}
    }

    public static function addOptionsFiltersFiltersCriteria(sfEvent $event)
    {
        $event['criteria']->add(ProductOptionsFilterPeer::FILTER_TYPE, 3, Criteria::NOT_EQUAL);
    }

    public static function productGetHasOptions(sfEvent $event)
    {
    	if ($event->getSubject()->getOptHasOptions() !== null)
    	{
    		$event->setReturnValue($event->getSubject()->getOptHasOptions());
    	}
    	elseif (!$event->getSubject()->isNew())
    	{
    		$count = $event->getSubject()->countProductOptionsValues();

    		$con = Propel::getConnection();

    		$con->executeQuery(sprintf('UPDATE %s SET %s = %s WHERE %s = %s',
    			ProductPeer::TABLE_NAME,
    			ProductPeer::OPT_HAS_OPTIONS,
    			$count,
    			ProductPeer::ID,
    			$event->getSubject()->getId()
    		));

    		$event->setReturnValue($count);
    	}

    	return true;
    }

	public static function productPostExecuteDuplicate(sfEvent $event)
	{
		$duplicate = $event['duplicate'];

		$product = $event['product'];

		$duplicated_assets = $event['duplicated_assets'];

		$default_culture = stLanguage::getOptLanguage();

		$c = new Criteria();

		$c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());

		$c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);

		$count = ProductOptionsValuePeer::doCount($c);	

		if ($count > 1)	
		{
			$fields = array();

			$parents = array();

			for ($offset = 0; $offset < $count; $offset += self::DUPLICATE_LIMIT)
			{
				$c->setOffset($offset);

				$c->setLimit(self::DUPLICATE_LIMIT);

				$options = ProductOptionsValuePeer::doSelect($c);

				foreach ($options as $option)
				{
					$field_id = $option->getProductOptionsFieldId();

					$duplicated_option = new ProductOptionsValue();

					$option->copyInto($duplicated_option);

					$asset_id = isset($duplicated_assets[$option->getSfAssetId()]) ? $duplicated_assets[$option->getSfAssetId()] : null; 

					if ($duplicated_option->getDepth() > 0)
					{
						$duplicated_option->setProductOptionsValueId($parents[$duplicated_option->getDepth() - 1]);
					}

					$duplicated_option->setProductId($duplicate->getId());

					$duplicated_option->setSfAssetId($asset_id);

					if ($field_id)
					{
						if (!isset($fields[$field_id])) 
						{
							$field = $option->getProductOptionsField();

							$duplicated_field = new ProductOptionsField();

							$field->copyInto($duplicated_field);

							$duplicated_field->save();

							foreach ($field->getProductOptionsFieldI18ns() as $i18n)
							{
								if ($i18n->getCulture() != $default_culture)
								{
									$duplicated_i18n = new ProductOptionsFieldI18n();

									$i18n->copyInto($duplicated_i18n);

									$duplicated_i18n->setCulture($i18n->getCulture());

									$duplicated_i18n->setId($duplicated_field->getId());

									$duplicated_i18n->save();
								}
							}

							$field->clearI18ns();

							$fields[$field_id] = $duplicated_field->getId();
						}

						$duplicated_option->setProductOptionsFieldId($fields[$field_id]);
					}

					$duplicated_option->save();

                    if ($option->getUseImageAsColor())
                    {
                        if (!is_dir($duplicated_option->getColorImageDir(true)))
                        {
                            mkdir($duplicated_option->getColorImageDir(true), 0755, true);
                        }

                        copy($option->getColorImagePath(true), $duplicated_option->getColorImagePath(true));
                    }                    

					foreach ($option->getProductOptionsValueI18ns() as $i18n)
					{
						if ($i18n->getCulture() != $default_culture)
						{
							$duplicated_i18n = new ProductOptionsValueI18n();

							$i18n->copyInto($duplicated_i18n);

							$duplicated_i18n->setCulture($i18n->getCulture());

							$duplicated_i18n->setId($duplicated_option->getId());

							$duplicated_i18n->save();
						}
					}	

					$option->clearI18ns();				

					if ($duplicated_option->hasChildren())
					{
						$parents[$duplicated_option->getDepth()] = $duplicated_option->getId();
					}					
				}

				unset($options);
			}

			$duplicate->setStock($product->getStock());

			$duplicate->setOptHasOptions($product->getOptHasOptions());

			$duplicate->save();
		}
	}    

    /**
     *
     * @param sfEvent $event
     */
    public static function preExecuteOptionsEdit(sfEvent $event)
    {
        $subject = $event->getSubject();
        if(!$subject->getRequest()->hasParameter('id'))
        {
            $forward_parameters = $subject->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProduct/options_forward_parameters');
            $subject->redirectIf(isset($forward_parameters['id']), 'stProduct/optionsEdit?id='.$forward_parameters['id']);
        }
    }

    /**
     * Podpięcie zdarzenia dla edycji opcji produktu.
     *
     * @param       sfEvent     $event
     */
    public static function postExecuteOptionsEdit(sfEvent $event)
    {
        $product_id = $event->getSubject()->getRequestParameter('id');

        //fix w przypadku zmiany wartosci opcji
        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::OPT_VERSION, ProductOptionsValuePeer::version, Criteria::NOT_EQUAL);
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
        $all_options = ProductOptionsValuePeer::doSelect($c);
        foreach ($all_options as $option)
        {
            $option->save();
        }

        $user = $event->getSubject()->getUser();
        if($user->hasAttribute('remeber', 'symfony/user/sfUser/attributes'))
        {
            $user->getAttributeHolder()->remove('remeber', 'symfony/user/sfUser/attributes');
            $product_id = empty($product_id) ? $user->getAttribute('id') : $product_id;
            $event->getSubject()->redirect('stProduct/optionsEdit?id='.$product_id);
        }

        $c = new Criteria();
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product_id);
        $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, null, Criteria::ISNULL);

        $root = ProductOptionsValuePeer::doSelectOne($c);

        if(!$root)
        {
            $root = new ProductOptionsValue();
            $root->setProductId($product_id);
            $root->setPriceType('netto');
            $root->makeRoot();
            $root->save();
        }

        $event->getSubject()->getContext()->root = $root;
    }

    /**
     * Podpięcie zdarzenia dla edycji szablonów opcji.
     *
     * @param sfEvent $event
     */
    public static function preExecuteOptionsTemplatesEdit(sfEvent $event)
    {
        $id = $event->getSubject()->getRequestParameter('id');

        if($event->getSubject()->getRequest()->hasParameter('remeber'))
        {
            $event->getSubject()->getUser()->setAttribute('remeber', 1);
            $event->getSubject()->redirect('stProduct/optionsTemplatesCreate');
        }

        if($id)
        {
            $c = new Criteria();
            $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_TEMPLATE_ID, $id);
            $c->add(ProductOptionsDefaultValuePeer::PRODUCT_OPTIONS_DEFAULT_VALUE_ID, null, Criteria::ISNULL);
            $root = ProductOptionsDefaultValuePeer::doSelectOne($c);

            if($root === null)
            {
                $root = new ProductOptionsDefaultValue();
                $root->setProductOptionsTemplateId($id);
                $root->setPriceType('netto');
                $root->makeRoot();
                $root->save();
            }

            $event->getSubject()->getContext()->root = $root;
        }

    }

    /**
     * Funkcja wywoływana przed wyświetleniem listy szablonów opcji.
     * Usuwa szablony które nie mają określonej nazwy.
     *
     * @param sfEvent $event
     */
    public static function preExecuteOptionsTemplatesList(sfEvent $event)
    {
        if($event->getSubject()->getRequest()->hasParameter('remeber'))
        {
            $event->getSubject()->getUser()->setAttribute('remeber', 1);
            $event->getSubject()->redirect('stProduct/optionsTemplatesList');
        }
    }

    /**
     * Usuwa produkt z koszyka oznaczony przez funkcję modBasketExecuteAddItem()
     *
     * @param sfEvent $event
     */
    public static function postBasketExecuteAddItem(sfEvent $event)
    {
        if($event->getSubject()->getItem(-1))
        {
            $event->getSubject()->removeItem(-1);
        }
    }

    /**
     *
     *
     * @param sfEvent $event
     */
    public static function filterMirrorOrderProduct(sfEvent $event)
    {
        $event['order_product']->setOptions($event['basket_product']->getOptions());

        return $event['order_product'];
    }

    /**
     * Tworzy łańcuch znaków z tablicy zawierającej idki opcji dla produktu.
     *
     * @param $options_ids - tablica id opcji
     */
    public static function createStringOptions($options_ids)
    {
        if(!empty($options_ids))
        {
            $result = '<ul>';
            foreach($options_ids as $option_id)
            {
                $option = ProductOptionsValuePeer::retrieveByPk($option_id);
                $result .= '<li>'.$option->getValue().'</li>';
                if($option->isLeaf())
                {
                    $id = $option->getId();
                }
            }
            $result .= '</ul>';

            return $result;
        }
    }

    public static function productPostExecuteShow(sfEvent $event)
    {
        $action = $event->getSubject();

        $product = $action->product;

        if ($product->getOptHasOptions() > 0) 
        {
        	ProductOptionsValue::setProductPool($product);

        	stNewProductOptions::updateProduct($product);
    	}
    }

    public static function basketGenerateItemId(sfEvent $event, $id)
    {
        $ids = self::getRequest()->getParameter('option_list');

        if ($ids && $id == self::getRequest()->getParameter('product_id'))
        {
            return md5($id.$ids);
        }

        return $id;
    }

    public static function basketModAddItem(sfEvent $event)
    {
        $item = $event['item'];

        $product = $event['product'];

        $ids = self::getRequest()->getParameter('option_list');

        if ($ids)
        {
        	ProductOptionsValue::setProductPool($product);
        	
            $ids = explode('-', $ids);

            $options = ProductOptionsValuePeer::retrieveByPKs($ids);

            $price_type = ProductOptionsValuePeer::getPriceType($product);

            $image = null;

            $stock = $item->getMaxQuantity();

            foreach ($ids as $id)
            {

               foreach ($options as $option)
               {
                  if ($option->getId() == $id) break;
               }
               
               stNewProductOptions::addProductPriceModifier($item, $option->getPrice(), $option->getDepth(), $price_type, array('id' => $option->getId(), 'label' => $option->getValue(), 'type' => 'product_options'));

               if ($option->getUseProduct())
               {
                  $item->setCode($option->getUseProduct());
               }

               if ($option->getsfAssetId())
               {
                  $image = $option->getsfAssetId();
               }

               if (null !== $option->getStock() && $stock > $option->getStock())
               {
                  $stock = $option->getStock();
               }
            }

            if ($image && ($sf_asset = sfAssetPeer::retrieveByPK($image)))
            {
               $item->setImage($sf_asset->getRelativePath());
            }

            if ($stock)
            {
               $item->setMaxQuantity($stock);
            }
        }
    }

    public static function preBasketExecuteAddItem(sfEvent $event)
    {
        if (sfContext::getInstance()->getRequest()->hasParameter('options_list'))
            ProductOptionsValuePeer::setSelectedItems($event['id_product'], explode('-',sfContext::getInstance()->getRequest()->getParameter('options_list')));
    }

    public static function getRequest()
    {
        static $request = null;

        if (null === $request)
        {
            $request = sfContext::getInstance()->getRequest();
        }

        return $request;
    }

    public static function postAddItem(sfEvent $event)
    {
        if (!empty(self::$postClear['item'])) {
           stBasket::getInstance(sfContext::getInstance()->getUser())->updateItem(self::$postClear['item'], self::$postClear['quantity']);
        }
    }

    public static function postInstall(sfEvent $event)
    {
        sfLoader::loadHelpers('stProgressBar');
        sfLoader::loadHelpers('Partial');

        stProductOptionsStockFix::initDatabase();
        $count = stProductOptionsStockFix::count();
        stProductOptionsStockFix::shutdownDatabase();

        $event->getSubject()->msg .= progress_bar('stProductOptionsStockFix', 'stProductOptionsStockFix', 'executeUpdate', $count);
    }  

   public static function postExecuteFilter(sfEvent $event)
   {
        $action = $event->getSubject();

        if ($action->getRequest()->getMethod() == sfRequest::POST && $action->hasRequestParameter('options_filters'))
        {
            $options_filters = $action->getRequestParameter('options_filters');

            stNewProductOptions::setFilters($action->getContext(), $options_filters);
        }      
   }   

    public static function postExecuteClearFilter(sfEvent $event)
    {
        $action = $event->getSubject();

        if ($action->getRequestParameter('scope') == 'options')
        {
            $filter = $action->getRequestParameter('filter');

            $filters = stNewProductOptions::getFilters($action->getContext());

            if ('all' == $filter)
            {
                stNewProductOptions::clearFilters($action->getContext());
            }
            elseif (isset($filters[$filter]))
            {
                unset($filters[$filter]);

                stNewProductOptions::setFilters($action->getContext(), $filters);
            }
        }
        
    }  
}
