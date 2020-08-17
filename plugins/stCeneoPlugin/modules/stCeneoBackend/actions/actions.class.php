<?php
/**
 * SOTESHOP/stCeneoPlugin
 *
 * Ten plik należy do aplikacji stCeneoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stCeneoPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 16435 2011-12-12 08:34:51Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stCeneoBackendActions
 *
 * @package     stCeneoPlugin
 * @subpackage  actions
 */
class stCeneoBackendActions extends autostCeneoBackendActions
{
	/**
	 * Walidacja akcji Config
	 */
	public function validateConfig()
	{
		$error = false;
		$request = $this->getRequest();

		$data = $request->getParameter('config');

		if (isset($data['trusted_opinion_on']) && $data['trusted_opinion_on'] == 1)
		{
			if (isset($data['trusted_opinion_id']) && empty($data['trusted_opinion_id']))
			{
				$request->setError('config{trusted_opinion_id}', 'Proszę uzupełnić pole.');
				$error = true;
			}
		}

		if ($error == true)
		{
			return false;
		}
		return true;
	}

	/**
	 * Przeciążenie aktualizacji config'a
	 */
	protected function updateConfigFromRequest()
	{
		$config = $this->getRequestParameter('config');
        foreach (stCeneo::getAvailabilities() as $availability)
        {
            $this->config->set('availability_'.$availability->getId(), $config['availability_'.$availability->getId()]);
        }
        parent::updateConfigFromRequest();
        
        $this->dispatcher->notify(new sfEvent($this, 'stCeneoBackendActions.updateConfigFromRequest'), array('config' => $this->config));
	}

	public function executeProductEnable() {
        $list = $this->getRequestParameter('ceneo[selected]', array());
        foreach ($list as $id) {
            $c = new Criteria();
            $c->add(CeneoPeer::PRODUCT_ID, $id);
            $object = CeneoPeer::doSelectOne($c);
            if (!$object) {
                $object = new Ceneo();
                $object->setProductId($id);
            }
            $object->setActive(true);
            $object->save();
        }

        return $this->redirect('stCeneoBackend/list?page='.$this->getRequestParameter('page', 1));
    }
    
    protected function filterCriteriaByCeneoActive($c, $active)
    {
        if (!$active)
        {
            $cc = $c->getNewCriterion(CeneoPeer::ACTIVE, null, Criteria::ISNULL);
            $cc->addOr($c->getNewCriterion(CeneoPeer::ACTIVE, 0));
            $c->add($cc);
            
            return true;
        }
        
        return false;
    }

    public function executeProductDisable() {
        $list = $this->getRequestParameter('ceneo[selected]', array());
        foreach ($list as $id) {
            $c = new Criteria();
            $c->add(CeneoPeer::PRODUCT_ID, $id);
            $object = CeneoPeer::doSelectOne($c);
            if (!$object) {
                $object = new Ceneo();
                $object->setProductId($id);
            }
            $object->setActive(false);
            $object->save();
        }

        return $this->redirect('stCeneoBackend/list?page='.$this->getRequestParameter('page', 1));
    }
}