<?php
/**
 * SOTESHOP/stQuestionPlugin 
 * 
 * Ten plik należy do aplikacji stQuestionPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stQuestionPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 2113 2009-11-16 15:18:49Z pawel $
 */

/**
 * Komponenty dla modułu stQuestionBackend
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>
 *
 * @package     stQuestionPlugin
 * @subpackage  actions
 */
class stQuestionBackendComponents extends autostQuestionBackendComponents
{
    public function executeQuestionStatusType()
    {
        $this->select_options = array();

        $i18n = $this->getContext()->getI18N();

        foreach (QuestionStatusPeer::getTypes() as $type => $label)
        {
            $this->select_options[$type] = $i18n->__($label);
        }
    }
}