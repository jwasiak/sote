<?php
/** 
 * SOTESHOP/stAllegroPlugin
 *
 * Ten plik należy do aplikacji stAllegroPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAllegroPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Klasa zawierajaca komponenty
 *
 * @package     stAllegroPlugin
 * @subpackage  actions
 */
class stAllegroBackendComponents extends autoStAllegroBackendComponents {

    public function executeProductAllegroCustom() {
        $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStProduct/allegro_forward_parameters');
        if (isset($this->forward_parameters['product_id']))
            $this->productId = $this->forward_parameters['product_id'];

        $this->environments = array();

        $environments = stAllegroEnv::getEnvironments();
        
        foreach ($environments as $environment => $name) {
            $environment = stAllegro::parseEnvironment($environment);
            $stAllegroCategory = new stAllegroCategory($environment);
            $this->environments[$environment]['name'] = $name;
            $this->environments[$environment]['htmlEnvironment'] = stAllegro::parseHtmlEnvironment($environment);
            $this->environments[$environment]['environment'] = $environment;
            $this->environments[$environment]['config'] = stAllegro::getInstance($environment)->getConfig();
            $this->environments[$environment]['stAllegroCategory'] = $stAllegroCategory;
            $this->environments[$environment]['categoriesStatus'] = $stAllegroCategory->checkStatus();
            $this->environments[$environment]['hasCategories'] = ($this->environments[$environment]['categoriesStatus'] >= 0);
            $this->environments[$environment]['auctions'] = AllegroAuctionPeer::doSelectByProduct($this->productId, $environment);
            $this->environments[$environment]['description'] = stAllegroEnv::getDescription($environment, 'CREATE_AUCTION'); 
        }
    }

    public function executeCategoryParameters()
    {
        $api = stAllegroApi::getInstance();
        
        $this->parameters = $api->getCategoryParameters($this->offer->category->id);

        $this->values = isset($this->offer->parameters) ? $this->offer->parameters : array();

        // die("<pre>".var_export($this->parameters, true)."</pre>");
    }

    public function executeOfferForm()
    {
        if (isset($this->category_id))
        {
            $this->offer->category->id = $this->category_id;
        }
    }

    public function executePricingFeePreview()
    {
        $api = stAllegroApi::getInstance();

        $this->quotes = array();

        try
        {
            $this->fees = $api->getPricingFeePreview(array(
                'includeQuotingBundles' => true,
                'offer' => array(
                    'category' => array(
                        'id' => $this->category
                    ),
                    'quantity' => intval($this->quantity ? $this->quantity : 1),
                    'type' => 'OFFER',
                    'unitPrice' => $this->price,
                    "bold" => $this->bold,
                    "highlight" => $this->highlight,
                    "departmentPage" => $this->departmentPage,
                    "emphasized" => $this->emphasized,
                    "emphasizedHighlightBoldPackage" => $this->emphasizedHighlightBoldPackage,
                )
            ));

            if ($this->offerId)
            {
                $this->quotes = $api->getOfferQuotes($this->offerId);
            }
        }
        catch(stAllegroException $e)
        {
            $this->fees = stAllegroApi::arrayToObject(array(
                'quotes' => array(
                    array(
                        'name' => 'Wystawienie przedmiotu',
                        'fee' => array(
                            'amount' => 0,
                            'currency' => 'PLN',
                        ),
                        'cycleDuration' => 'PT240H',
                    ),
                )
            ));
        }
    }

    public function executeGetAttributes() {
        $this->attributes = array();

        if ($this->category)
        {
            try 
            {
                $this->attributes = stAllegro::getInstance($this->environment)->getAttributes($this->category);
            }
            catch(Exception $e)
            {
                if (sfConfig::get('sf_debug'))
                {
                    throw $e;
                }
            }
        }
    }

    public function executeDescription()
    {
        $this->config = stConfig::getInstance('stAllegroPlugin');
    }

    public function executeAllegroPlState() {
        $i18n = $this->getContext()->getI18n();

        $this->default = $this->config->get('allegro_pl_state');

        $this->states = array();

        $states = array(
            'dolnoslaskie' => 'dolnośląskie',
            'kujawsko_pomorskie' => 'kujawsko-pomorskie',
            'lubelskie' => 'lubelskie',
            'lubuskie' => 'lubuskie',
            'lodzkie' => 'łódzkie',
            'malopolskie' => 'małopolskie',
            'mazowieckie' => 'mazowieckie',
            'opolskie' => 'opolskie',
            'podkarpackie' => 'podkarpackie',
            'podlaskie' => 'podlaskie',
            'pomorskie' => 'pomorskie',
            'slaskie' => 'śląskie',
            'swietokrzyskie' => 'świętokrzyskie',
            'warminsko_mazurskie' => 'warmińsko-mazurskie',
            'wielkopolskie' => 'wielkopolskie',
            'zachodniopomorskie' => 'zachodniopomorskie',
        );

        if (is_array($states)) 
            foreach ($states as $id => $state)
                $this->states[$id] = $i18n->__($state, null, 'stAllegroMessages');
    }
}
