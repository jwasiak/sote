<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 3343 2010-02-05 12:50:57Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/**
 * Klasa serwera Soap
 *
 * @package     stWebApiPlugin
 * @subpackage  actions
 */
class stWebApiBackendActions extends autostWebApiBackendActions {

	public function executeDeleteLogs() {
		$webapiConfig = stConfig::getInstance('stWebApiBackend');
		$timeLimit = $webapiConfig->get('session_time');

		$c = new Criteria();
		$cc = $c->getNewCriterion(WebApiSessionPeer::ACTIVE, 0);
		$cr = $c->getNewCriterion(WebApiSessionPeer::UPDATED_AT, time()-$timeLimit, Criteria::LESS_THAN);
		$cc->addOr($cr);
		$c->add($cc);
		WebApiSessionPeer::doDelete($c);

		$this->setFlash('notice', 'Nieaktualne sesje zostały usunięte z listy logowań.');
		$this->redirect('stWebApiBackend/list');
	}
}