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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Szablon dla akcji attributeList
 *
 * @package stAttributeTemplatePlugin
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Zwraca wartosc dla danego atrybutu
 *
 * @param   array       $attributes         tablica obiektów ProductHasAttributeField  
 * @param   integer     $attribute_field_id id atrybutu
 * @return   string
 */
function st_get_attribute_value($attributes, $attribute_field_id)
{
    foreach ($attributes as $attribute)
    {
        if ($attribute->getAttributeField()->getId() == $attribute_field_id)
        {
            return $attribute->getValue();
        }
    }

    return '';
}