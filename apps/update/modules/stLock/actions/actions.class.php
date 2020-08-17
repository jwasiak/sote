<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: actions.class.php 3183 2010-01-27 14:01:12Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Lock actions.
 *
 * @package     stUpdate
 * @subpackage  actions
 */
class stLockActions extends sfActions
{
    /** 
     * Lock configuration.
     */
    public function executeIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $req = $this->getRequestParameter('lock[unlock]', 0);

            if ($req == 1)
            {
                stUpdateLock::lock('frontend');
                stUpdateLock::lock('backend');
            } elseif($req == 0)
            {
                stUpdateLock::unlock('backend');
                stUpdateLock::unlock('frontend');
            }
            
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
    }
}