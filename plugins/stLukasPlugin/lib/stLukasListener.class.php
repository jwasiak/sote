<?php
/**
 * SOTESHOP/stLukasPlugin
 *
 * Ten plik należy do aplikacji stLukasPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLukasPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stLukas.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLukasListener
 *
 * @package stLukasPlugin
 * @subpackage libs
 */
class stLukasListener
{
    /**
     * Dodawania dodatkowych pól do edycji produktu
     *
     * @param sfEvent $event
     */
    public static function generate(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stLukasPlugin', 'stProduct.yml');
    }

    /**
     * Przeciążanie zapisu w karcie produktu
     *
     * @param sfEvent $event
     */
    public static function postUpdateLukasFromRequest(sfEvent $event)
    {
        if (isset($event['requestParameters']['disable']) && $event['requestParameters']['disable'] == 1) $v = true;
        else $v = false;

        $object = $event['modelInstance'];
        $object->setDisable($v);
        $object->save();
    }

    /**
     * Funkcja postGetLukasOrCreate przeciążająca zapis
     *
     * @param sfEvent $event
     */
    public static function postGetLukasOrCreate(sfEvent $event)
    {
        $action = $event->getSubject();
        if (!$action->getRequestParameter('id'))
        {
            $c = new Criteria();
            $c->add(LukasProductPeer::PRODUCT_ID, $action->forward_parameters['product_id']);
            $object = LukasProductPeer::doSelectOne($c);
            if (!$object)
            {
                $object = new LukasProduct();
                $object->setProductId($action->forward_parameters['product_id']);
            }
            $action->lukas_product = $object;
        }
    }
}
