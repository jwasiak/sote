<?php
/** 
 * SOTESHOP/stAttributeTemplatePlugin 
 * 
 * Ten plik należy do aplikacji stAttributeTemplatePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAttributeTemplatePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Podpięcie pod generator stProduct modułu stAttributeTemplatePlugin
 *
 * @author Daniel Mendalka <daniel.mendalka@sote.pl>
 *
 * @package     stAttributeTemplatePlugin
 * @subpackage  libs
 */
class stAttributeTemplatePluginListener
{
    /** 
     * Podpięcie zdarzenia dla generatora produktu
     *
     * @param                sfEvent     $event              zdarzenie
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stAttributeTemplatePlugin', 'stProduct.yml');
    }
    
    public static function postSave(sfEvent $event)
    {
        $attributes = $event->getSubject()->getRequestParameter('attributes');
        foreach($attributes as $index => $attribute)
        {
            $c = new Criteria();
            $c->add(ProductHasAttributeFieldPeer::PRODUCT_ID, $event->getSubject()->getRequestParameter('id'));
            $c->add(ProductHasAttributeFieldPeer::ATTRIBUTE_FIELD_ID, $index);
            
            if(!$productValue = ProductHasAttributeFieldPeer::doSelectOne($c))
            {
                $productValue = new ProductHasAttributeField();
                $productValue->setProductId($event->getSubject()->getRequestParameter('id'));
                $productValue->setAttributeFieldId($index);
            }
            $productValue->setValue($attribute);
            $productValue->save();
        }
    }
    
}
    