<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 392 2009-09-08 14:55:35Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * stWebpageBackend actions.
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl>  
 *
 * @package     stWebpagePlugin
 * @subpackage  actions
 */
class stWebpageGroupHasWebpageBackendActions extends autostWebpageGroupHasWebpageBackendActions
{
    /** 
     * Sortowanie cen czasowych - rekord zmienia swoją pozycję na wyższą
     */
    public function executeMoveUp()
    {
        $id = $this->getRequestParameter('id');
        $webpage = WebpageGroupHasWebpagePeer::retrieveByPK($id);
        $webpage->moveUp();
        $webpage->save();
        $this->redirect('webpage_group_has_webpage/list');
    }

    /** 
     * Sortowanie cen czasowych - rekord zmienia swoją pozycję na niższą
     */
    public function executeMoveDown()
    {
        $id = $this->getRequestParameter('id');
        $webpage = WebpageGroupHasWebpagePeer::retrieveByPK($id);
        $webpage->moveDown();
        $webpage->save();
        $this->redirect('webpage_group_has_webpage/list');
    }
    
    protected function addFiltersCriteria($c)
    {
        parent::addFiltersCriteria($c);
        
        /** 
         * Filtr kolumny 'Grupa'
         */
        if (isset($this->filters['filter_webpage_group']) && !empty($this->filters['filter_webpage_group']))
        {

                $c->addJoin(WebpageGroupPeer::ID, WebpageGroupHasWebpagePeer::WEBPAGE_GROUP_ID);
               
                $c->add(WebpageGroupPeer::NAME, $this->filters['filter_webpage_group'], Criteria::LIKE);

        }
        
        /** 
         * Filtr kolumny 'Nazwa strony www'
         */
        if (isset($this->filters['filter_webpage']) && !empty($this->filters['filter_webpage']))
        {

                $c->addJoin(WebpagePeer::ID, WebpageGroupHasWebpagePeer::WEBPAGE_ID);
               
                $c->add(WebpagePeer::NAME, $this->filters['filter_webpage'], Criteria::LIKE);

        }        
    }
}