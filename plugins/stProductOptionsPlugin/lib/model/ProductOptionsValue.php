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
class ProductOptionsValue extends BaseProductOptionsValue
{

    protected static
            $productPool = array();

    protected $childOptions = null;

    public $_duplicated = null;

    public function copyInto($copyObj, $deepCopy = false)
    {
        parent::copyInto($copyObj, $deepCopy);

        $copyObj->_duplicated = true;
    }   

    /**
     * Przeciazenie setPrice, zeby nie zapisywalo pustego stringa
     *
     * @return void
     **/
    public function setPrice($v)
    {
        if($v === '')
        {
            $v = null;
        }

        parent::setPrice($v);
    }

    public function setProductOptionsDefaultValueId($v) 
    {
        $this->setProductOptionsValueId($v);
    }

    public function getChildOptions($hide_with_empty_stock = false)
    {
        if (null === $this->childOptions)
        {
            $c = new Criteria();

            $c->addAscendingOrderByColumn(ProductOptionsFieldPeer::FIELD_ORDER);

            $c->addAscendingOrderByColumn(ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);

            $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);

            $c->add(ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID, $this->getId());

            if ($this->getProduct()->hasStockManagmentWithOptions() && $hide_with_empty_stock)
            {
                $c->add(ProductOptionsValuePeer::STOCK, 0, Criteria::GREATER_THAN);
            }

            $this->childOptions = ProductOptionsValuePeer::doSelectJoinProductOptionsField($c);
        }

        return $this->childOptions;
    }

    /**
     * Funckja tworząca rekurencyjnie tablice obiektów stProductOptionsField
     * z uwzględnieniem głębokości występowania w drzewie.
     *
     * @param $path
     * @return array of stProductOptionsField
     */
    public function getFields($path = '', $selected = array())
    {
        $c = new Criteria();
        $c->addJoin(ProductOptionsFieldPeer::ID, ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID);
        $c->addAscendingOrderByColumn(ProductOptionsFieldPeer::FIELD_ORDER);
        $c->addAscendingOrderByColumn(ProductOptionsValuePeer::LFT);
        $c->addGroupByColumn(ProductOptionsFieldPeer::ID);
        if (ProductOptionsValuePeer::$hide_no_stock) $c->add(ProductOptionsValuePeer::STOCK,0,Criteria::GREATER_THAN);
        if($nodes = $this->getChildren('doSelect', $c))
        {

            foreach($nodes as $node)
            {
                $field = $node->getProductOptionsField();
                $field->setCulture($this->getCulture());
                $field->level = $node->getLevel();
                $field->path = ($path!='' ? $path.'_' : '').$field->getId();
                $result[] = $field;
                if(count($selected) && (!empty($selected[$field->getId()]) || !empty($selected[$field->path])))
                {
                    if(!empty($selected[$field->getId()]))
                    {
                        $node_path = explode('_', $selected[$field->getId()]);
                    }
                    else
                    {
                        $node_path = explode('_', $selected[$field->path]);
                    }
                    $defaultNode = ProductOptionsValuePeer::retrieveByPK(end($node_path));
                    end($result)->selected = $defaultNode->getId();
                    $result = array_merge($result, $defaultNode->getFields($field->path, $selected));
                }
                elseif(($field->getOptDefaultValue()!==null) && $field->getOptDefaultValue() != $node->getOptValue())
                {
                    if($defaultNode = $field->getDefaultNode($this->getProductId()))
                    {
                        end($result)->selected = $defaultNode->getId();
                        $result = array_merge($result, $defaultNode->getFields($field->path));
                    }
                    else
                    {
                        end($result)->selected = $node->getId();
                        $result = array_merge($result, $node->getFields($field->path));
                    }
                }
                else
                {
                    end($result)->selected = $node->getId();
                    $result = array_merge($result, $node->getFields($field->path));
                }
            }
            return $result;
        }
        return array();
    }

    /**
     * Przeciążenie getPriceType
     *
     * @return string
     */
    public function getPriceType($check = false)
    {
        return ProductOptionsValuePeer::getPriceType($this->getProductId());
    }

    public function getModifiedPrice($price, $vat, $type = 'netto')
    {
        $optionType = ProductOptionsValuePeer::getRoot($this->getProductId())->getPriceType()=='brutto'?'brutto':'netto';

        $mod_price = $this->getPrice();
        if($mod_price !== null)
        {
            if(preg_match('/^\s*([-+])\s*([0-9]+(\.[0-9]{2})?)\s*$/', $mod_price, $value))
            {
                if ($optionType=='netto' && $type == 'brutto') $value[2] = stCurrency::calculateBruttoFromNetto($value[2], $vat);
                if ($optionType=='brutto' && $type == 'netto') $value[2] =stCurrency::extractNettoFromBrutto($value[2], $vat);

                if($value[1]=='+')
                {
                    $price += $value[2];
                }
                else
                {
                    $price -= $value[2];
                }
            }
            else if(preg_match('/^\s*([-+])\s*([0-9]+(\.[0-9]{2})?)\s*%\s*$/', $mod_price, $value))
            {
                if($value[1]=='+')
                {
                    $price += $value[2]*$price/100;
                }
                else
                {
                    $price -= $value[2]*$price/100;
                }
            }
            else if(preg_match('/^\s*[0-9]+(\.[0-9]{2})?\s*$/', $mod_price, $value))
            {
                if ($optionType=='netto' && $type == 'brutto') $value[0] = stCurrency::calculateBruttoFromNetto($value[0], $vat);
                if ($optionType=='brutto' && $type == 'netto') $value[0] =stCurrency::extractNettoFromBrutto($value[0], $vat);
                $price = $value[0];
            }
        }

        return $price < 0 ? 0 : $price;
    }

//   public function getsfAsset($con = null)
//   {
//      if ($this->asfAsset === null && ($this->sf_asset_id !== null) && ($this->sf_asset_id != 0))
//      {
//         $this->asfAsset = sfAssetPeer::retrieveByPK($this->sf_asset_id, $con);
//      }
//      elseif($this->getParent())
//      {
//         $this->asfAsset = $this->getParent()->getsfAsset();
//      }
//      return $this->asfAsset;
//   }

    /**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());
        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getValue
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }
        $v = parent::getValue();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie setValue
     *
     * @param string $v
     */
    public function setValue($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setValue($v);
    }

    public function getProduct($con = null)
    {
        $id = $this->getProductId();

        if ($id && !isset(self::$productPool[$id]))
        {
            self::$productPool[$id] = parent::getProduct($con);
        }

        return self::$productPool[$id];
    }

    /**
     * Przeciążenie funkcji save
     *
     * @param $con
     */
    public function save($con = null)
    {
        if ($this->getOptVersion()!=ProductOptionsValuePeer::version)
        {
            $this->setOptVersion(ProductOptionsValuePeer::version);
        }  


        if (!$this->isNew() && ($this->isColumnModified(ProductOptionsValuePeer::STOCK) || $this->isColumnModified(ProductOptionsValuePeer::PRICE)))
        {
            AllegroAuctionPeer::updateRequiresSync($this->getProductId(), $this->getId());   
        }
              
        if (!isset($this->_duplicated))
        {
            if($this->isNew())
            {
                $con = Propel::getConnection();
                $sql = sprintf('UPDATE %1$s SET %2$s = %2$s + 1 WHERE %3$s = %4$s',
                    ProductPeer::TABLE_NAME,
                    ProductPeer::OPT_HAS_OPTIONS,
                    ProductPeer::ID,
                    $this->getProductId()
                );
                $con->executeQuery($sql);

                if (null === $this->opt_filter_id && $this->product_options_field_id && $this->getProductOptionsField()) 
                {
                    $filter_id = $this->getProductOptionsField()->getProductOptionsFilterId();

                    $this->setOptFilterId($filter_id);
                }
            }

            $modified = $this->modifiedColumns;

            $ret = parent::save($con);

            $this->modifiedColumns = $modified;

            if ($this->product_id && !$this->isRoot()) 
            {
                if ($this->isColumnModified(ProductOptionsValuePeer::STOCK))
                {
                    ProductOptionsValuePeer::updateStock($this->getProduct());
                }

                if ($this->color && ($this->isColumnModified(ProductOptionsValuePeer::STOCK) || $this->isColumnModified(ProductOptionsValuePeer::COLOR))) 
                {
                    ProductOptionsValuePeer::updateProductColor($this->product_id);
                }
            }

            $this->resetModified();
        }
        else
        {
            $ret = parent::save($con);
        }

        return $ret;
    }

    /**
     * Przeciążenie funkcji delete
     *
     * @param $con
     **/
    public function delete($con = null)
    {
        $con = Propel::getConnection();
        $sql = sprintf('UPDATE %1$s SET %2$s = %2$s - 1 WHERE %3$s = %4$s',
            ProductPeer::TABLE_NAME,
            ProductPeer::OPT_HAS_OPTIONS,
            ProductPeer::ID,
            $this->getProductId()
        );
        $con->executeQuery($sql);

        $sql = sprintf('DELETE %1$s, %2$s FROM %1$s LEFT JOIN %2$s ON %8$s = %7$s, %3$s WHERE %10$s = %11$s AND %4$s > %5$s AND %4$s < %6$s AND %7$s = %9$s',
            ProductOptionsFieldPeer::TABLE_NAME,
            ProductOptionsFieldI18nPeer::TABLE_NAME,
            ProductOptionsValuePeer::TABLE_NAME,
            ProductOptionsValuePeer::LFT,
            $this->getLft(),
            $this->getRgt(),
            ProductOptionsFieldPeer::ID,
            ProductOptionsFieldI18nPeer::ID,
            ProductOptionsValuePeer::PRODUCT_OPTIONS_FIELD_ID, 
            ProductOptionsValuePeer::PRODUCT_ID,
            $this->getProductId()
        );        

        $con->executeQuery($sql);    

        parent::delete($con);
        $this->deleteColorImage();

        if ($this->product_id)
        {
            ProductOptionsValuePeer::updateStock($this->product_id);
            if ($this->color)
            {
                ProductOptionsValuePeer::updateProductColor($this->product_id);
            }
        }
    }

    public function getParentId()
    {
        return $this->getProductOptionsValueId();
    }

    public function isRoot()
    {
        return $this->product_options_value_id === null;
    }

    public function isLeaf()
    {
        return $this->rgt - $this->lft == 1;
    }

    public function getLevel()
    {
        return $this->depth;
    }

    public function hasChildren()
    {
        return $this->rgt - $this->lft > 1;
    } 

    public function clearI18ns()
    {
        if ($this->collProductOptionsValueI18ns)
        {
            unset($this->collProductOptionsValueI18ns);
            $this->collProductOptionsValueI18ns = null;
        }
    }

    public static function setProductPool(Product $product)
    {
        self::$productPool[$product->getId()] = $product;
    } 

    public function getColorImagePath($system = false)
    {
        return ProductOptionsValuePeer::getColorImagePath($this->getProductId(), $this->getId(), $this->getColor(), $system);
    }

    public function deleteColorImage()
    {
        if ($this->getUseImageAsColor() && is_file($this->getColorImagePath(true)))
        {
            unlink($this->getColorImagePath(true));
        }
    }

    public function getColorImageDir($system = false)
    {
        return ProductOptionsValuePeer::getColorImageDir($this->getProductId(), $system);
    } 

    public function setColorImage($v)
    {
        $this->setColor($v);
    } 

    public function getColorImage()
    {
        return $this->getColor();
    }

    public static function clearStaticPool()
    {
       self::$productPool = array();
    }
}

$columns = array('left' => ProductOptionsValuePeer::LFT,
        'right' => ProductOptionsValuePeer::RGT,
        'parent' => ProductOptionsValuePeer::PRODUCT_OPTIONS_VALUE_ID,
        'scope' => ProductOptionsValuePeer::PRODUCT_ID,
        'depth' => ProductOptionsValuePeer::DEPTH);

sfPropelBehavior::add('ProductOptionsValue', array('actasnestedset' => array('columns' => $columns)));
