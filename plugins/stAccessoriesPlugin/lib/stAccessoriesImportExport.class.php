<?php
/**
 * SOTESHOP/stAccessoriesPlugin
 *
 * Ten plik należy do aplikacji stAccessoriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAccessoriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stAccessoriesImportExport.class.php 1985 2009-11-04 11:34:58Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Podpięcie pod generator stProduct modułu ststAccessoriesPlugin
 *
 * @author Piotr Hałas <piotr.halas@sote.pl>
 *
 * @package     stAccessoriesImportExport
 * @subpackage  libs
 */
class stAccessoriesImportExport {

    public static function getProductAccessories(Product $object) {
        $accessories = $object->getProductHasAccessoriessRelatedByProductId();
        if (is_array($accessories)) {
            $ids = array();
            foreach($accessories as $item) {
                if (is_object($item) && !is_null($item->getCode()))
                $ids[] = $item->getCode();
            }
            return implode(',',$ids);
        }
        return '';
    }

    public static function setProductAccessories(Product $object, $value) {
        $accessories = $object->getProductHasAccessoriessRelatedByProductId();

        // usuń w przypadku gdy pole puste
        if (!strlen(trim($value))) {
            if (is_array($accessories)) {
                foreach($accessories as $item) {
                    $item->delete();
                }
            }
            return ;
        }

        $idsNew = explode(',',$value);
        foreach ($idsNew as $key=>$itemValue) {
            if (strlen(trim($itemValue))) {
                $idsNew[$key] = trim($itemValue); 
            } else {
                unset($idsNew[$key]);
            }
        }

        $ids = array();

        if (is_array($accessories)) {
            foreach($accessories as $item) {
                $ids[] = $item->getCode();
            }
        }
        $old = array_diff($ids, $idsNew);
        $idsNew = array_unique(array_diff($idsNew, $ids));

        foreach($accessories as $item) {
            if (array_search($item->getCode(),$old)!== false) {
                $item->delete();
            }
        }

        foreach ($idsNew as $id) {
            $c = new Criteria();
            $c->add(ProductPeer::CODE,$id);
            $accessory = ProductPeer::doSelectOne($c);

            if (is_object($accessory) && $object->getId()!=$accessory->getId()) {
                $tmp = new ProductHasAccessories();
                $tmp->setProductId($object->getId());
                $tmp->setAccessoriesId($accessory->getId());
                $tmp->save(); 
            }
        }

    }
}
