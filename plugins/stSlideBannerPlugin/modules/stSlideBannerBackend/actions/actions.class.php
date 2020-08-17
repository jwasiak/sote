<?php

/**
 * SOTESHOP/stAdminGeneratorPlugin
 *
 * Ten plik należy do aplikacji stAdminGeneratorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 396 2009-09-09 07:59:20Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * stSlideBannerBackend actions.
 *
 * @author Your name here
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 */
class stSlideBannerBackendActions extends autostSlideBannerBackendActions
{
   public function executeSaveConfigContent()
   {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
            
            $updateBanner = $this->getRequestParameter('banner');

            $this->bannerConfig = stConfig::getInstance($this->getContext(), 'stSlideBannerBackend');

            $this->bannerConfig->load();

            if(isset($updateBanner['banner_on'])){
                $this->bannerConfig->set('banner_on',$updateBanner['banner_on']);
            }
            else
            {
                $this->bannerConfig->set('banner_on',0);
            }
            
            if(isset($updateBanner['group_field_on'])){
                $this->bannerConfig->set('group_field_on',$updateBanner['group_field_on']);
            }
            else
            {
                $this->bannerConfig->set('group_field_on',0);
            }                       
            
            $this->bannerConfig->set('banner_version',$updateBanner['banner_version']);

            $this->bannerConfig->set('effect',$updateBanner['effect']);

            $this->bannerConfig->set('caption_background_color',$updateBanner['caption_background_color']);

            $this->bannerConfig->set('caption_text_color',$updateBanner['caption_text_color']);

            $this->bannerConfig->set('ignore_language',$updateBanner['ignore_language']);

            $this->bannerConfig->set('anim',$updateBanner['anim']);

            $this->bannerConfig->set('pause',$updateBanner['pause']);
            
            $this->bannerConfig->save(true);

            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
         
            stFastCacheManager::clearCache();
            SlideBannerPeer::clearCache();

            $this->redirect('stSlideBannerBackend/configCustom');
        }
    }

    /** 
     * Sortowanie cen czasowych - rekord zmienia swoją pozycję na wyższą
     */
    public function executeMoveUp()
    {
        $id = $this->getRequestParameter('id');
        $webpage = SlideBannerPeer::retrieveByPK($id);
        $webpage->moveUp();
        $webpage->save();
        $this->redirect('slideBanner/list');
    }

    /** 
     * Sortowanie cen czasowych - rekord zmienia swoją pozycję na niższą
     */
    public function executeMoveDown()
    {
        $id = $this->getRequestParameter('id');
        $webpage = SlideBannerPeer::retrieveByPK($id);
        $webpage->moveDown();
        $webpage->save();
        $this->redirect('slideBanner/list');
    }

    public function validateEdit()
    {
        $request = $this->getRequest();

        if ($request->getMethod() == sfRequest::POST)
        {
            $slider_banner_image = stJQueryToolsHelper::parsePluploadFromRequest($request->getParameter('slider_banner_image'));
            
            if (!$slider_banner_image['modified'] && ($slider_banner_image['delete'] || !$request->getParameter('id')))
            {
                $request->setError('slide_banner{image}', $this->getContext()->getI18N()->__('Załącz obrazek'));
            }
        }
           

        return !$request->hasErrors();
    }

    protected function saveSlideBanner($slide_banner)
    {
        parent::saveSlideBanner($slide_banner);

        $this->saveSlideBannerImage($slide_banner);
    }

    protected function saveSlideBannerImage($slide_banner)
    {
        $plupload = stJQueryToolsHelper::parsePluploadFromRequest($this->getRequestParameter('slider_banner_image'));

        if ($plupload['delete'])
        {
            $slide_banner->removeImage();
        }

        if ($plupload['modified'])
        {
            $slide_banner->removeImage();

            foreach ($plupload['modified'] as $filename)
            {
                $source = $plupload['dir'].'/'.$filename;
                $dest = $slide_banner->genImagePath($filename, true);
                stJQueryToolsHelper::pluploadCopy($source, $dest);
                $slide_banner->setImage($slide_banner->genImagePath($filename));   
            }      
        }

        stJQueryToolsHelper::pluploadCleanup($plupload);

        $plupload = stJQueryToolsHelper::parsePluploadFromRequest($this->getRequestParameter('slider_banner_image_small'));

        if ($plupload['delete'])
        {
            $slide_banner->removeImageSmall();
        }
        
        if ($plupload['modified'])
        {
            $slide_banner->removeImageSmall();

            foreach ($plupload['modified'] as $filename)
            {
                $source = $plupload['dir'].'/'.$filename;
                $dest = $slide_banner->genImagePath('mobile-'.$filename, true);
                stJQueryToolsHelper::pluploadCopy($source, $dest);
                $slide_banner->setImageSmall($slide_banner->genImagePath('mobile-'.$filename));   
            }      
        }

        stJQueryToolsHelper::pluploadCleanup($plupload);

        $slide_banner->save();
    }

   public function executeBannerEnable()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

      $banners = SlideBannerPeer::retrieveByPKs($this->getRequestParameter('slide_banner[selected]', array()));

      foreach ($banners as $banner)
      {
         $banner->setIsActive(true);

         $banner->save();
      }

      return $this->redirect('stSlideBannerBackend/list?page='.$this->getRequestParameter('page', 1));
   }

   public function executeBannerDisable()
   {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
      
      $banners = SlideBannerPeer::retrieveByPKs($this->getRequestParameter('slide_banner[selected]', array()));

      foreach ($banners as $banner)
      {
         $banner->setIsActive(false);

         $banner->save();
      }

      return $this->redirect('stSlideBannerBackend/list?page='.$this->getRequestParameter('page', 1));
   }
}