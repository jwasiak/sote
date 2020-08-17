<?php
/** 
 * SOTESHOP/stDepositoryPlugin 
 * 
 * Ten plik należy do aplikacji stDepositoryPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDepositoryPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

/** 
 * stDepositoryFrontend components.
 *
 * @package    stDepositoryPlugin
 * @subpackage stDepositoryFrontend
 * @author     Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

class stDepositoryFrontendComponents extends sfComponents
{
    /** 
     * Pokaż stan magazynowy produktu, wyciągnij dane z kofniguracji
     */
    public function executeDepository()
    {
        $this->stock = $this->product->getStock();

        $this->smarty = new stSmarty('stDepositoryFrontend');
        
        $config = $this->product->getConfiguration();
        
        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stDepositoryFrontendComponents.myExecuteDepository'));
      
        $this->show_depository=$config->get('show_depository');
        $this->show_availability=$config->get('show_availability');
        
    }
    
}