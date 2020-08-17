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
 * @version     $Id: stPositioning.class.php 13379 2011-06-02 09:58:45Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPositioning
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class stPositioning
{
    /**
     * Typ domyślny
     *
     * @var int
     */
    const TYPE_DEFAULT = 0;

    /**
     * Typ użytkownika 
     *
     * @var int
     */
    const TYPE_USER = 1;

    /**
     * Typ automatycznego generowania
     *
     * @var int
     */
    const TYPE_GENERATE = 2;

    /**
     *
     * @param string $module
     * @param integer $id
     * @param sfResponse $response
     */
    public static function setHeaders($module, $param)
    {
        if ($module == "Product" || $module == 'Category' || $module == 'Webpage' || $module == 'ProductGroup' || $module == 'Producer' || $module == 'Blog')
        {
            $sf_context = sfContext::getInstance();
            $instance =  $sf_context->getUser()->getParameter('selected', null, 'soteshop/st'.$module);

            if (null === $instance)
            {
                $c = new Criteria();
                $c->addSelectColumn(constant($module.'I18nPeer::ID'));
                $c->add(constant($module.'I18nPeer::URL'), $param);
                $c->setLimit(1);
                $rs = call_user_func(array($module.'I18nPeer', 'doSelectRS'), $c);

                if ($rs->next())
                {  
                    $row = $rs->getRow();
                    $c = new Criteria();
                    $c->add(constant($module.'Peer::ID'), $row[0]);
                    $c->setLimit(1);
                    $tmp = call_user_func(array($module.'Peer', 'doSelectWithI18n'), $c); 
                    $instance = $tmp ? $tmp[0] : null;
                }
            }

            if (null !== $instance)
            {                
                $c = new Criteria();
                $c->add(constant($module.'HasPositioningPeer::'.strtoupper(sfInflector::underscore($module)).'_ID'), $instance->getId());
                $positioning = call_user_func($module.'HasPositioningPeer::doSelectOne', $c);
                
                $metaTagsGeneratorName = 'st'.$module.'MetaTagsGenerator';
                if (!class_exists($metaTagsGeneratorName)) $metaTagsGeneratorName = 'stMetaTagsGenerator';

                if (is_object($positioning))
                {
                    if ($positioning->getType() == stPositioning::TYPE_DEFAULT) $object = new stMetaTagsGenerator();
                    if ($positioning->getType() == stPositioning::TYPE_USER)
                    {
                        $object = new stMetaTagsGenerator();

                        if ($positioning->getTitle()) $title = $positioning->getTitle();
                        if ($positioning->getKeywords()) $keywords = $positioning->getKeywords();
                        if ($positioning->getDescription()) $description = $positioning->getDescription();
                    }
                    if ($positioning->getType() == stPositioning::TYPE_GENERATE)
                    {
                        $object = new $metaTagsGeneratorName();
                        $object->generate($instance);
                    } 
                } else {
                    $object = new $metaTagsGeneratorName();
                    $object->generate($instance);
                }

                try {
                    $response =  $sf_context->getResponse();

                    if (!isset($title)) {
                        $title = $object->getTitle();
                    }

                    if (!isset($keywords)) {
                        $keywords = $object->getKeywords();
                    }

                    if (!isset($description)) {
                        $description = $object->getDescription();
                    }

                    if ($module != 'Producer' && $sf_context->getRequest()->hasParameter('producer') && stProducer::getSelectedProducer())
                    {
                        $title = stProducer::getSelectedProducer()->getName() . ' - ' . $title; 
                        
                        if ($keywords)
                        {
                            $keywords = stProducer::getSelectedProducer()->getName() . ', ' . $keywords;
                        }

                        if ($description)
                        {
                            $description = stProducer::getSelectedProducer()->getName() . ' - ' . $description;
                        }
                    }
                    $response->setTitle($title);

                    $keywords = trim($keywords);
                    
                    if (!empty($keywords)) 
                    {
                        $response->addMeta('keywords',  $keywords);
                    }

                    $response->addMeta('description', $description);
                    return true;
                } catch (Exception $e) {}
            }
        }
        return false;
    }
}
