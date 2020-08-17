<?php     
/** 
 * SOTESHOP/stBackend 
 * 
 * Ten plik należy do aplikacji stBackend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBackend
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 16777 2012-01-18 14:57:18Z bartek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/** 
 * Akcje modułu stBackendMain.
 *
 * @package     stBackend
 * @subpackage  actions
 */
class stBackendMainActions extends stActions
{                       
     
    /**
     * Lista aplikacji.
     * Lista wyświetlana na głównej stronie backend w postaci ikonek.
     */
    public function executeList()
    {
        $backendMainConfig = stConfig::getInstance($this->getContext(), 'stBackendMain');

        if($backendMainConfig->get('is_icon_menu') == 1)
        {
            $this->apps = stApplication::getDefaultDesktopApps();
        } elseif($backendMainConfig->get('is_icon_menu') == 2) {
            $this->apps = stApplication::getDefaultDesktopApps('app_default_all_desktop');
        }

    }



    public function executeChangeBackendView()
    {
            $backendMainConfig = stConfig::getInstance($this->getContext(), 'stBackendMain');

            $backendView = $this->getRequestParameter('backend_view');

            if($backendView == "icon")
            {
                $backendMainConfig->set('is_icon_menu', 1);
                $backendMainConfig->save();
            }
            
            if($backendView == "icon_all")
            {
                $backendMainConfig->set('is_icon_menu', 2);
                $backendMainConfig->save();
            }

            if($backendView == "info")
            {
                $backendMainConfig->set('is_icon_menu', 0);
                $backendMainConfig->save();
            }

        $this->redirect('@homepage');
    }
    
    /** 
     * Lista wszystkich zainstalowanych aplikacji.
     * Lista wyświetlana na głównej stronie backend w postaci ikonek.
     */
    public function executeListAll()
    {
        $this->apps = stApplication::getApps();   
    }
    
    public function executeOpen()
    {

        $action_stack = $this->getContext()->getActionStack();

        if ($action_stack->getEntry($action_stack->getSize() - 2))
        { 

            $this->module_name = $action_stack->getEntry($action_stack->getSize() - 2)->getModuleName();

            $this->action_name = $action_stack->getEntry($action_stack->getSize() - 2)->getActionName();

        } 

        $this->lang = $this->getUser()->getCulture();

        $this->showChangeLicenseButton = false;
        
        if (stLicense::isOpen()) $this->showChangeLicenseButton = true;
    }
    
    public function executeTimeRequestAjax() {
        return sfView::NONE;
    }
}
