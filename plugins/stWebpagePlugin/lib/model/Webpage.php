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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: Webpage.php 12416 2011-04-21 11:50:51Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * Klasa Webpage
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class Webpage extends BaseWebpage
{

    /**
     * Pobieranie nazwy strony
     *
     * @return  string      nazwa strony
     */
    public function __toString()
    {
        return $this->getName();
    }
    
    public function getTextFilters($content)
    {
                        
        $i18n = sfContext::getInstance()->getI18N();
                                
        if(stConfig::getInstance('appTermsBackend')->get('terms_on')==1 && SF_APP == "frontend" && $this->getState()=="TERMS"){
            $config = stConfig::getInstance('appTermsBackend');
            $config->setCulture(sfContext::getInstance()->getUser()->getCulture());      
                  
            $content = preg_replace('/{SHOP_URL}/', $config->get('terms_field1', null, true), $content);
            $content = preg_replace('/{MERCHANT}/', $config->get('terms_field2', null, true), $content);
            $content = preg_replace('/{COMPANY_NAME}/', $config->get('terms_field3', null, true), $content);
            $content = preg_replace('/{COMPANY_ADDRESS}/', $config->get('terms_field4', null, true), $content);
            $content = preg_replace('/{PHONE}/', $config->get('terms_field5', null, true), $content);
            $content = preg_replace('/{EMAIL}/', $config->get('terms_field6', null, true), $content);
            $content = preg_replace('/{BANK_NAME}/', $config->get('terms_field7', null, true), $content);
            $content = preg_replace('/{BANK_ACCOUNT}/', $config->get('terms_field8', null, true), $content);
            $content = preg_replace('/{DELIVERY_1}/', $config->get('terms_field9', null, true), $content);
            $content = preg_replace('/{DELIVERY_1_PRICE_INFO}/', $config->get('terms_field10', null, true), $content);
            $content = preg_replace('/{DELIVERY_2}/', $config->get('terms_field11', null, true), $content);
            $content = preg_replace('/{DELIVERY_2_PRICE_INFO}/', $config->get('terms_field12', null, true), $content);
            $content = preg_replace('/{DELIVERY_FREE_FROM}/', $config->get('terms_field13', null, true), $content);
            $content = preg_replace('/{SHOW_PARTNER_URL}/', '', $content);               

        };
        if(stConfig::getInstance('appTermsBackend')->get('privacy_on')==1 && SF_APP == "frontend" && $this->getState()=="PRIVACY"){
            $config = stConfig::getInstance('appTermsBackend');
            $config->setCulture(sfContext::getInstance()->getUser()->getCulture());      
                              
            $content = preg_replace('/{SHOP_URL}/', $config->get('privacy_field1', null, true), $content);
            $content = preg_replace('/{EMAIL}/', $config->get('privacy_field2', null, true), $content);
            $content = preg_replace('/{COMPANY_NAME}/', $config->get('privacy_field3', null, true), $content);
            $content = preg_replace('/{COMPANY_ADDRESS}/', $config->get('privacy_field4', null, true), $content);
            $content = preg_replace('/{PHONE}/', $config->get('privacy_field5', null, true), $content);             
            $content = preg_replace('/{SHOW_PARTNER_URL}/', '', $content);                                    
        };
        
        if(stConfig::getInstance('appTermsBackend')->get('right2cancel_on')==1 && SF_APP == "frontend" && $this->getState()=="RIGHT2CANCEL"){
            $config = stConfig::getInstance('appTermsBackend');
            $config->setCulture(sfContext::getInstance()->getUser()->getCulture());
            
            $path = $this->getPdfAttachmentPath(); 
            $url = $this->getPdfAttachmentPath(false); 
                
            if (is_file($path)){
                if(sfContext::getInstance()->getModuleName()=="stOrder"){   
                    $content = preg_replace('/{RIGHT_TO_CANCEL_PDF}/', $i18n->__('Formularz odstąpienia od umowy:').' <a target="_blank" href="'.$_SERVER['HTTP_HOST'].$url.'?v'.filemtime($path).'">'.$i18n->__('Pobierz').'</a>', $content);
                }else{
                    $content = preg_replace('/{RIGHT_TO_CANCEL_PDF}/', $i18n->__('Formularz odstąpienia od umowy:').' <a target="_blank" href="'.$url.'?v'.filemtime($path).'">'.$i18n->__('Pobierz').'</a>', $content);
                }                                  
            }else{
                $content = preg_replace('/{RIGHT_TO_CANCEL_PDF}/', "", $content);
            }    
            $content = preg_replace('/{SHOW_PARTNER_URL}/', '', $content);
        }            
        
        return $content;
    }
    

    /**
     * Pobieranie obiektu WebpageGroup
     *
     * @return  object      obiekt WebpageGroup
     */
    public function getWebpageGroup()
    {
        $c = new Criteria();
        $c->add(WebpageGroupHasWebpagePeer::WEBPAGE_ID,$this->getId());
        $c->addJoin(WebpageGroupHasWebpagePeer::WEBPAGE_GROUP_ID,WebpageGroupPeer::ID);
        $this->webpageGroup = WebpageGroupPeer::doSelect($c);
        return $this->webpageGroup;
    }

    /**
     * Pobieranie obiektu WebpageGroupHasWebpage
     */
    public function getWebpageGroupHasWebpage()
    {
        $c = new Criteria();
        $this->webpageGroup = WebpageGroupHasWebpagePeer::doSelectJoinAll();
    }

    /**
     * Pobiera zawartość przyciętą do określonej długości.
     * Funkcja nie dzieli słów.
     *
     * @param   integer     $length             Ilość znaków  
     * @return  string      Przycięty tekst 
     */
    public function getContentTrimed($length = 50)
    {
        $content = $this->getContent();
        $content = strip_tags($content);
        $contentLength = strlen($content);

        //sprawdzenie czy istnieje potrzeba przyciecia
        if($contentLength <= $length)
        {
            return strip_tags($this->getContent());
        }

        $content = trim(wordwrap($content, $length, "\n"));
        $table = explode("\n", $content);

        if(count($table) > 0)
        {
            return $table[0]."...";
        }
        return "";
    }
    /**
     * Zapisuje wartości domyślne dla zapisanej strony
     *
     * @param   string      domyślna           wartość stron $page  
     */
    public function setDefaultPages($page)
    {
        if ($page=="NONE") $page=NULL;
        $this->setPage($page);
    }

    /**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());
        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }
        $v = parent::getName();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie setName
     *
     * @param string $v
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setName($v);
    }

    /**
     * Przeciążenie getContent
     *
     * @return string
     */
    public function getContent()
    {
        
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return $this->getTextFilters(stLanguage::getDefaultValue($this, __METHOD__));
        }
        $v = parent::getContent();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $this->getTextFilters($v);
        
    }

    /**
     * Przeciążenie setContent
     *
     * @param string $v
     */
    public function setContent($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setContent($v);
    }

    /**
     * Przeciążenie getUrl
     *
     * @return string
     */
    public function getUrl()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getUrl();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie setUrl
     *
     * @param string $v
     */
    public function setUrl($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setUrl($v);
    }

    public function urlFilter($friendly_url)
    {
        $c = new Criteria();

        $c->add(WebpageI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

        $c->add(WebpageI18nPeer::URL, $friendly_url);

        if (WebpageI18nPeer::doCount($c) > 0)
        {
            return $friendly_url . '-' . $this->getPrimaryKey();
        }

        return false;
    }

    public function save($con = null)
    {
        $ret = parent::save($con);

        WebpagePeer::clearCache();

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        WebpagePeer::clearCache();

        $this->deleteAttachment();

        return $ret;
    }

    public function deleteAttachment()
    {
        $path = $this->getPdfAttachmentPath();

        if (is_file($path))
        {
            unlink($path);
        }
    }

    public function getPdfAttachmentPath($system = true)
    {
        $path = '/uploads/webpage/'.$this->getCulture().'/'.$this->getState().'.pdf';

        if ($system)
        {
            return sfConfig::get('sf_web_dir').$path;
        }

        return $path;
    }    

    /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getOtherLink()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }
        $v = parent::getOtherLink();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }  

    public function getTarget()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }
        $v = parent::getTarget();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
}

sfPropelBehavior::add('Webpage', array('stPropelSeoUrlBehavior' => array('source_column' => 'Name', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));