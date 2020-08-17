<?php
/**
 * SOTESHOP/stLockPlugin
 *
 * Ten plik należy do aplikacji stLockPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLockPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stUnavailableBackendActions
 *
 * @package     stLockPlugin
 * @subpackage  actions
 */
class stLockBackendActions extends stActions
{
    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $req = $this->getRequestParameter('lock[unlock]', 0);

            if ($req == 1)
            {
                stLock::lock('frontend');
            } elseif($req == 0)
            {
                stLock::unlock('frontend');
            }

            file_put_contents(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'error_title.txt',$this->getRequestParameter('lock[title]'));
            file_put_contents(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'error_content.txt',$this->getRequestParameter('lock[content]'));
             
            $filename = $this->getRequest()->getFileName('lock[image]');
            if (!empty($filename)) {
                $this->getRequest()->moveFile('lock[image]',sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'error'.DIRECTORY_SEPARATOR.'custom_page_error.jpg');
            }

            if ($this->getRequestParameter('lock[default_image]')) {
                if (file_exists(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'error'.DIRECTORY_SEPARATOR.'custom_page_error.jpg')) {
                    unlink(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'theme'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'error'.DIRECTORY_SEPARATOR.'custom_page_error.jpg');
                }
            }
            
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
            
            stFastCacheManager::clearCache();
        }



        $this->error_title = sfContext::getInstance()->getI18N()->__('Przerwa techniczna.');
        $this->error_content = sfContext::getInstance()->getI18N()->__('Proszę spróbować później.');
        if (file_exists(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'error_title.txt')){
            $this->error_title = file_get_contents(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'error_title.txt');
        }
        if (file_exists(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'error_content.txt')){
            $this->error_content = file_get_contents(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'error_content.txt');
        }


    }
}