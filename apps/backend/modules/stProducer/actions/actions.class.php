<?php
/** 
 * SOTESHOP/stProducer 
 * 
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProducer
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Klasa wymagana do poprawnej pracy modułu producentów
 *
 * @package     stProducer
 * @subpackage  actions
 */
class stProducerActions extends autostProducerActions
{
    public function executeAjaxSearchToken()
    {
        $query = $this->getRequestParameter('q');

        $ids = $this->getRequestParameter('ids');

        $c = new Criteria();

        if ($query)
        {
            $duplicates = explode(',', $this->getRequestParameter('d'));

            $c->add(ProducerPeer::ID, $duplicates, Criteria::NOT_IN);

            $c->add(ProducerPeer::OPT_NAME, $query.'%', Criteria::LIKE);              

            $c->setLimit(100);
        }
        elseif ($ids)
        {
            $c->add(ProducerPeer::ID, $ids, Criteria::IN);
        }

        $tokens = ProducerPeer::doSelectTokens($c);

        return $this->renderJson($tokens);
    }

    protected function saveProducerImage($producer)
    {
        $producer_images = $this->getRequestParameter('producer_images');
        $plupload = stJQueryToolsHelper::parsePluploadFromRequest($producer_images);

        if ($plupload['delete'])
        {
            $producer->destroyAsset();
        }
        
        if ($plupload['modified'])
        {
            $producer->destroyAsset();
            
            foreach ($plupload['modified'] as $filename)
            {
                $ext = sfAssetsLibraryTools::getFileExtension($filename);
                $producer->createAsset($producer->getId() . '.' . $ext, $plupload['dir'].'/'.$filename);
                $producer->save();      
            }      
        }

        stJQueryToolsHelper::pluploadCleanup($plupload);
    }

    protected function saveProducer($producer)
    {
        parent::saveProducer($producer);

        $this->saveProducerImage($producer);
    }
}