<?php
/** 
 * SOTESHOP/stWebApiPlugin 
 * 
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebApiPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Definicje
 */
define ('NO_CONFIG_FILE','Brak pliku konfiguracyjnego');

/** 
 * WebApiClientDemo actions.
 *
 * @package     stWebApiPlugin
 * @subpackage  actions
 */
class stWebApiDemoBackendActions extends sfActions
{
    /** 
     * Executes index action, zwraca komunikat błedu w przypadku błędu SOAP lub braku pliku konfiguracyjnego
     * @throws zwraca błąd wygenerowan przez serwer SOAP
     */
    public function executeIndex()
    {
        // Pobiera nazwe modułu, w przypadku braku wstawia webapi
        $module = strtolower($this->getRequestParameter('apiModule','webapi'));

        // ustalamy pliki konfiguracyjne
        $moduleConfigFile=sfConfig::get('sf_app_module_dir').DIRECTORY_SEPARATOR.'webapiclient'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'webapiclient.yml';

        // sprawdzamy czy plik instnieje 
        if (!is_readable($moduleConfigFile)) {
            
            // wczytujemy plik
            $this->config = sfYaml::load($moduleConfigFile);

            // towrzymy polaczenie SOAP
            $client = new SoapClient("http://".$this->config['webapicliet']['host']."/backend.php/$module/soap?wsdl", array('trace' => 1));

            // wykonujemy zapytania
            try {

                $obj = new stdClass();
                $obj->_offset = $this->getRequestParameter('offset',0);
                $obj->_limit = $this->getRequestParameter('limit',0);

                // jezeli modul nie jest webapi, to wyswietl liste
                if ($module != "webapi") {
                    $functionName = "Get".ucfirst($module)."List";
                    $this->responseApi = $client->$functionName($obj);

                // gdy jest to webapi, wykonaj funkcje  HelloWorld
                } else {
                    $functionName = "HelloWorld";
                    $this->responseApi = $client->$functionName();
                }

            // w przypadku bledu zweroc komunikat bledu
            } catch ( Exception $e ) {
                $this->responseApi = $e;
            }
        // w przypadku braku pliku konfiguracyjnego zwroc komunikat bledu
        } else {
            $this->responseApi = NO_CONFIG_FILE;
        }
    }

    /** 
     * Funkcja napisana na potrzeby prezentacji
     */
    public function executeTest() {


    }
}
