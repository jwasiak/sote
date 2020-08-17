<?php
/** 
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 2589 2009-08-14 12:44:40Z pawel $
 */

/** 
 * Akcje dostępności
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>, Paweł Byszewski <pawel.byszewski@sote.pl> 
 *
 * @package     stAvailabilityPlugin
 * @subpackage  actions
 */
class stAvailabilityBackendActions extends autostAvailabilityBackendActions
{
    protected function saveConfig() 
    {      
        $ret = parent::saveConfig();

        $this->clearCache();

        return $ret;
    }

    protected function saveAvailabilityImage($availability)
    {
        if ($this->getRequest()->getFileError('availability[image]') == UPLOAD_ERR_OK)
        {
            $filename = $this->getRequest()->getFileName('availability[image]');

            $filepath = $this->getRequest()->getFilePath('availability[image]');

            $ext = sfAssetsLibraryTools::getFileExtension($filename);

            $availability->createAsset($availability->getId() . '.' . $ext, $filepath);

            $availability->save();
        }
    }

    protected function saveAvailability($availability)
    {
        if ($this->hasRequestParameter('availability[delete_image]'))
        {
            $availability->destroyAsset();
        }

        parent::saveAvailability($availability);

        $this->clearCache();

        $this->saveAvailabilityImage($availability);
    }

    public function validateEdit()
    {
      if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->hasRequestParameter('availability[delete_image]'))
      {
         $validator = new stAssetFileValidator();

         $validator->initialize($this->getContext(), array('mime_types' => '@web_images'));

         $value = $this->getRequest()->getFileValues('availability[image]');

         if (!$validator->execute($value, $error))
         {
            $this->getRequest()->setError('availability{image}', $error);

            return false;
         }
      }

      return true;
    }

    protected function clearCache()
    {
        stFastCacheManager::clearCache();

        stTheme::clearSmartyCache(true);

        ProductGroupPeer::cleanCache();

        ProducerPeer::clearCache();
    }
}
