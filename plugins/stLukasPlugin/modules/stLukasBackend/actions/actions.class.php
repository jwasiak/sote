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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLukasBackendActions
 *
 * @package     stLukasPlugin
 * @subpackage  actions
 */
class stLukasBackendActions extends stActions
{
	/**
	 * Wyświetla konfigurację modułu
	 */
	public function executeIndex()
	{
		$this->webRequest = new stWebRequest();
		$context = $this->getContext();
		$this->config = stConfig::getInstance($context);

		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			$this->config->setFromRequest('config');
			$this->config->save();
			$this->setFlash('notice', $context->getI18N()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
		}
		$this->config->load();
	}

   public function validateIndex()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
      }
      
      return true;
   }

	/**
	 * Akcja w przypadku błędu w uzupełnianiu pó
	 */
	public function handleErrorIndex()
	{
		$this->webRequest = new stWebRequest();
		$context = $this->getContext();
		$this->config = stConfig::getInstance($context);
		$this->labels = array('config{param_profile}' => $context->getI18n()->__('Identyfikator'));
		return sfView::SUCCESS;
	}
}