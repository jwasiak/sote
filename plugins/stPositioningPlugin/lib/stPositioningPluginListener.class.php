<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPositioningPluginListener.class.php 13376 2011-06-02 09:45:19Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPositioningPluginListener
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stPositioningPluginListener
{
    /**
     * Ładownie pliku stProduct.yml
     *
     * @param sfEvent $event
     */
    public static function generateStProduct(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPositioningPlugin', 'stProduct.yml');
    }

    /**
     * Zapisywanie id produktu oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveProduct(sfEvent $event)
    {
        $event['modelInstance']->setProductId($event->getSubject()->forward_parameters['product_id']);
        $event['modelInstance']->setType($event->getSubject()->getRequestParameter('product_has_positioning[type]'));
    }

    /**
     * Ładowanie obiektu pozycjonowania dla produktu
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateProduct(sfEvent $event)
    {
        stPluginHelper::addRouting('stPositioningProductLangUrl', '/:lang/:url.html', 'stProduct', 'frontendShow', 'backend', array(), array('lang' => '[a-z]{2,4}'));

        stPluginHelper::addRouting('stPositioningProductUrl', '/:url.html', 'stProduct', 'frontendShow', 'backend');

        $event->setProcessed(true);

        $action = $event->getSubject();

        $c = new Criteria();
        
        $c->add(ProductHasPositioningPeer::PRODUCT_ID, $action->forward_parameters['product_id']);

        $action->product_has_positioning = ProductHasPositioningPeer::doSelectOne($c);

        if (!$action->product_has_positioning)
        {
            $action->product_has_positioning = new ProductHasPositioning();

            $action->product_has_positioning->setProductId($action->forward_parameters['product_id']);
        }

        $action->product_has_positioning->getProduct()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
    }

    /**
     * Dodawanie nagłówków w karcie produktu
     *
     * @param sfEvent $event
     */
    public static function preProductShow(sfEvent $event)
    {
        $context = $event->getSubject()->getContext();
        if ($context->getRequest()->hasParameter('url'))
        {
            stPositioning::setHeaders('Product', $context->getRequest()->getParameter('url'));
        }
    }

    /**
     * Ładownie pliku stCategory.yml
     *
     * @param sfEvent $event
     */
    public static function generateStCategory(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPositioningPlugin', 'stCategory.yml');
    }

    /**
     * Zapisywanie id kategorii oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveCategory(sfEvent $event)
    {
        $event['modelInstance']->setCategoryId($event->getSubject()->forward_parameters['category_id']);
        $event['modelInstance']->setType($event->getSubject()->getRequestParameter('category_has_positioning[type]'));
    }

    /**
     * Ładowanie obiektu pozycjonowania dla kategorii
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateCategory(sfEvent $event)
    {
        stPluginHelper::addRouting('stPositioningProductCategoryUrlLang', '/category/:lang/:url', 'stProduct', 'frontendList', 'backend', array(), array('lang' => '[a-z]{2,4}'));

        stPluginHelper::addRouting('stPositioningProductCategoryUrl', '/category/:url', 'stProduct', 'frontendList', 'backend');

        $event->setProcessed(true);
        
        $action = $event->getSubject();

        $c = new Criteria();

        $c->add(CategoryHasPositioningPeer::CATEGORY_ID, $action->forward_parameters['category_id']);

        $action->category_has_positioning = CategoryHasPositioningPeer::doSelectOne($c);

        if (!$action->category_has_positioning)
        {
            $action->category_has_positioning = new CategoryHasPositioning();

            $action->category_has_positioning->setCategoryId($action->forward_parameters['category_id']);
        }

        $action->category_has_positioning->getCategory()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
    }

    /**
     * Dodawanie nagłówków przy wyświetlaniu kategorii
     *
     * @param sfEvent $event
     */
    public static function preProductList(sfEvent $event)
    {
        $context = $event->getSubject()->getContext();
        if ($context->getRequest()->hasParameter('url'))
        {
            stPositioning::setHeaders('Category', $context->getRequest()->getParameter('url'));
        }
    }

    /**
     * Ładownie pliku stProductGroup.yml
     *
     * @param sfEvent $event
     */
    public static function generateStProductGroup(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPositioningPlugin', 'stProductGroup.yml');
    }

    /**
     * Zapisywanie id grupy produktów oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveProductGroup(sfEvent $event)
    {
        $event['modelInstance']->setProductGroupId($event->getSubject()->forward_parameters['group_id']);
        $event['modelInstance']->setType($event->getSubject()->getRequestParameter('product_group_has_positioning[type]'));

    }

    /**
     * Ładowanie obiektu pozycjonowania dla grup produktu
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateProductGroup(sfEvent $event)
    {
        stPluginHelper::addRouting('stPositioningProductGroupUrlLang', '/group/:lang/:url', 'stProduct', 'frontendGroupList', 'backend', array(), array('lang' => '[a-z]{2,4}'));

        stPluginHelper::addRouting('stPositioningProductGroupUrl', '/group/:url', 'stProduct', 'frontendGroupList', 'backend');

        $event->setProcessed(true);
        
        $action = $event->getSubject();

        $c = new Criteria();

        $c->add(ProductGroupHasPositioningPeer::PRODUCT_GROUP_ID, $action->forward_parameters['group_id']);

        $action->product_group_has_positioning = ProductGroupHasPositioningPeer::doSelectOne($c);

        if (!$action->product_group_has_positioning)
        {
            $action->product_group_has_positioning = new ProductGroupHasPositioning();

            $action->product_group_has_positioning->setProductGroupId($action->forward_parameters['group_id']);
        }

        $action->product_group_has_positioning->getProductGroup()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
    }

    /**
     * Dodawanie nagłówków przy wyświetlaniu grup produktów
     *
     * @param sfEvent $event
     */
    public static function preProductGroupList(sfEvent $event)
    {
        $context = $event->getSubject()->getContext();
        if ($context->getRequest()->hasParameter('url'))
        {
            stPositioning::setHeaders('ProductGroup', $context->getRequest()->getParameter('url'));
        }
    }

    /**
     * Ładownie pliku stWebpage.yml
     *
     * @param sfEvent $event
     */
    public static function generateStWebpage(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPositioningPlugin', 'stWebpage.yml');
    }

    /**
     * Zapisywanie id strony www oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveWebpage(sfEvent $event)
    {
        $event['modelInstance']->setWebpageId($event->getSubject()->forward_parameters['webpage_id']);
        $event['modelInstance']->setType($event->getSubject()->getRequestParameter('webpage_has_positioning[type]'));
    }

    /**
     * Ładowanie obiektu pozycjonowania dla stron www
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateWebpage(sfEvent $event)
    {
        stPluginHelper::addRouting('stPositioningWebpageUrlLang', '/webpage/:lang/:url.html', 'stWebpageFrontend', 'frontendIndex', 'backend');

        stPluginHelper::addRouting('stPositioningWebpageUrl', '/webpage/:url.html', 'stWebpageFrontend', 'frontendIndex', 'backend');

        $event->setProcessed(true);
        
        $action = $event->getSubject();

        $c = new Criteria();
        
        $c->add(WebpageHasPositioningPeer::WEBPAGE_ID, $action->forward_parameters['webpage_id']);

        $action->webpage_has_positioning = WebpageHasPositioningPeer::doSelectOne($c);

        if (!$action->webpage_has_positioning)
        {
            $action->webpage_has_positioning = new WebpageHasPositioning();

            $action->webpage_has_positioning->setWebpageId($action->forward_parameters['webpage_id']);
        }

        $action->webpage_has_positioning->getWebpage()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
    }

    /**
     * Dodawanie nagłówków przy wyświetlaniu kategorii i grup produktów
     *
     * @param sfEvent $event
     */
    public static function postWebpageIndex(sfEvent $event)
    {
        $context = $event->getSubject()->getContext();
        if ($context->getRequest()->hasParameter('url'))
        {
            stPositioning::setHeaders('Webpage', $context->getRequest()->getParameter('url'));
        }
    }

    /**
     * Ładownie pliku stWebpage.yml
     *
     * @param sfEvent $event
     */
    public static function generateStProducer(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPositioningPlugin', 'stProducer.yml');

    }

    /**
     * Zapisywanie id strony www oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveProducer(sfEvent $event)
    {
        $event['modelInstance']->setProducerId($event->getSubject()->forward_parameters['producer_id']);
        $event['modelInstance']->setType($event->getSubject()->getRequestParameter('producer_has_positioning[type]'));
    }

    /**
     * Ładowanie obiektu pozycjonowania dla stron www
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateProducer(sfEvent $event)
    {
        stPluginHelper::addRouting('stPositioningProducerUrlLang', '/manufacturer/:lang/:url', 'stProductFrontend', 'producerList', 'backend', array(), array('lang' => '[a-z]{2,4}'));

        stPluginHelper::addRouting('stPositioningProducerUrl', '/manufacturer/:url', 'stProductFrontend', 'producerList', 'backend');

        $event->setProcessed(true);

        $action = $event->getSubject();

        $c = new Criteria();

        $c->add(ProducerHasPositioningPeer::PRODUCER_ID, $action->forward_parameters['producer_id']);

        $action->producer_has_positioning = ProducerHasPositioningPeer::doSelectOne($c);

        if (!$action->producer_has_positioning)
        {
            $action->producer_has_positioning = new ProducerHasPositioning();

            $action->producer_has_positioning->setProducerId($action->forward_parameters['producer_id']);
        }

        $action->producer_has_positioning->getProducer()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
    }

    /**
     * Dodawanie nagłówków przy wyświetlaniu kategorii i grup produktów
     *
     * @param sfEvent $event
     */
    public static function postProducerIndex(sfEvent $event)
    {
        $context = $event->getSubject()->getContext();
        if ($context->getRequest()->hasParameter('url'))
        {
            stPositioning::setHeaders('Producer', $context->getRequest()->getParameter('url'));
        }
    }

    /**
     * Ładownie pliku stBlog.yml
     *
     * @param sfEvent $event
     */
    public static function generateStBlog(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stPositioningPlugin', 'stBlog.yml');
    }

    /**
     * Zapisywanie id strony www oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveBlog(sfEvent $event)
    {
        $event['modelInstance']->setBlogId($event->getSubject()->forward_parameters['blog_id']);
        $event['modelInstance']->setType($event->getSubject()->getRequestParameter('blog_has_positioning[type]'));
    }

    /**
     * Ładowanie obiektu pozycjonowania dla bloga
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateBlog(sfEvent $event)
    {
        stPluginHelper::addRouting('stPositioningBlogUrlLang', '/blog/:lang/:url.html', 'stBlogFrontend', 'frontendIndex', 'backend');

        stPluginHelper::addRouting('stPositioningBlogUrl', '/blog/:url.html', 'stBlogFrontend', 'frontendIndex', 'backend');

        $event->setProcessed(true);
        
        $action = $event->getSubject();

        $c = new Criteria();
        
        $c->add(BlogHasPositioningPeer::BLOG_ID, $action->forward_parameters['blog_id']);

        $action->blog_has_positioning = BlogHasPositioningPeer::doSelectOne($c);

        if (!$action->blog_has_positioning)
        {
            $action->blog_has_positioning = new BlogHasPositioning();

            $action->blog_has_positioning->setBlogId($action->forward_parameters['blog_id']);
        }

        $action->blog_has_positioning->getBlog()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
    }

    /**
     * Dodawanie nagłówków przy wyświetlaniu bloga
     *
     * @param sfEvent $event
     */
    public static function postBlogIndex(sfEvent $event)
    {
        $context = $event->getSubject()->getContext();
        if ($context->getRequest()->hasParameter('url'))
        {
            stPositioning::setHeaders('Blog', $context->getRequest()->getParameter('url'));
        }
    }

    public static function showRebuildSeoLinks(sfEvent $event){
        $context = sfContext::getInstance();
        $i18n = $context->getI18N();
        $config = stConfig::getInstance($context, 'stPositioningBackend');
        $config->load();
        
        if (file_exists(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductUpdate.log') &&
            file_exists(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_CategoryUpdate.log') &&
            file_exists(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductGroupUpdate.log') &&
            file_exists(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_WebpageUpdate.log') &&
            file_exists(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProducerUpdate.log') &&
            file_exists(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_BlogUpdate.log'))
        {
            $config->set('build_seo_links',0);
            $config->save();             
        }

        $webRequest = new stWebRequest();
        if (preg_match("/^[0-9]{4,5}.quad.sote.pl$/",$webRequest->getHost()) && $config->get('build_seo_links'))
        {
            $config->set('build_seo_links',0);
            $config->save();             
        }
        
        if ( $config->get('build_seo_links'))
        {
            sfLoader::loadHelpers(array('Helper','Url','stAdminGenerator'));
            stReminder::add('stPositioningBackend', '<font color="#f00">'.$i18n->__('Przyjazne linki nie zostały wygenerowane. Kliknij', array(), 'stPositioningBackend').' '.link_to($i18n->__('tutaj', array(), 'stPositioningBackend'),'stPositioningBackend/rebuildSeoLinks').' '.$i18n->__('aby je wygenerować', array(), 'stPositioningBackend').'.'.'</font>');
        }
    }

    public static function hideRebuildSeoLinks(sfEvent $event){
        $context = sfContext::getInstance();
        $config = stConfig::getInstance($context, 'stPositioningBackend');
        $config->load();
        
        $config->set('build_seo_links',0);
        $config->save();             
    }

    public static function noIndex(sfEvent $event)
    {
        sfContext::getInstance()->getResponse()->addMeta('robots', "noindex");
    }

    public static function redirect(sfEvent $event) {
        
        $file = sfConfig::get('sf_web_dir') . '/404_links.txt';

        if (is_file($file))
        {   
            $url = $event->getSubject()->getRequest()->getPathInfo();
            $url = strtolower($url);  
             
            $links = file(sfConfig::get('sf_web_dir') . '/404_links.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach($links as $link)
            {
                list($old_link, $new_link) = explode(" ", $link);
                
                if (strpos($old_link, "*")!== false){
                    $old_link = substr($old_link, 1);
                    if (strpos($url, $old_link)!== false)
                    {
                        $event->getSubject()->redirect($new_link, "301");
                    }
                }else{
                    if ($url == $old_link) $event->getSubject()->redirect($new_link, "301");
                }
            }
        }          
    }

}
