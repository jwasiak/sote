<?php
/** 
 * SOTESHOP/stFrontend
 *
 * Ten plik należy do aplikacji stFrontend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stFrontend
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 13980 2011-07-08 09:25:22Z krzysiek $
 */

/** 
 * Akcje komponentu produktu
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>
 *
 * @package     stFrontend
 * @subpackage  actions
 */
class stFrontendMainComponents extends sfComponents
{
    public function executeMainText()
    {
        $this->smarty = new stSmarty('stFrontendMain');
        if (class_exists('TextPeer'))
        {
            if ($this->system_name)
            {
                $this->main_text=TextPeer::retrieveBySystemName($this->system_name);
            }
            else
            {
                $this->main_text=TextPeer::retrieveBySystemName('stFrontendMain-middle');
            }
            

            if (!$this->main_text)
            {
                return sfView::NONE;
            }
        }
        else
        {
            return sfView::NONE;
        }
    }

    public function executeCopyright()
    {
        $this->lang = $this->getUser()->getCulture();
    }

}