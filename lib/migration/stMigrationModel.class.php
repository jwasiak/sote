<?php
/** 
 * SOTESHOP/stMigration
 *
 * Ten plik należy do aplikacji stMigration opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMigration
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationModel.class.php 1417 2009-05-27 10:01:46Z marcin $
 */

/** 
 * Podstawowy model danych
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigration
 * @subpackage  libs
 */
class stMigrationModel implements stMigrationModelInterface 
{
    protected $migrationParams = array();

    /**
     *
     * @var sfLogger
     */
    protected $logger = null;

    public function  __construct()
    {
        $this->logger = new sfLogger();

        $logger = new sfFileLogger();

        $logger->initialize(array('file' => sfConfig::get('sf_log_dir') . DIRECTORY_SEPARATOR . 'migration.log'));

        $this->logger->registerLogger($logger);

        $this->logger->setLogLevel(SF_LOG_DEBUG);
    }

    public function  __destruct()
    {
        $this->logger->shutdown();

        unset($this->logger);
    }

    public function setMigrationParam($object, $params = array())
    {
        $this->migrationParams = $params;
    }

    public function getMigrationParam($param_name)
    {
        return isset($this->migrationParams[$param_name]) ? $this->migrationParams[$param_name] : null;
    }

    public function getPluginName()
    {
        list($plugin_name) = explode(':', $this->migrationParams['type']);

        return $plugin_name;
    }

    public function getMigrationType()
    {
        list(, $migration_type) = explode(':', $this->migrationParams['type']);

        return $migration_type;
    }

    /**
     * Zwraca obiekt stMigrationDataRetriever
     *
     * @return stMigrationDataRetriever
     */
    public function getDataRetriever()
    {
        return stMigrationDataRetriever::getInstance();
    }

    /**
     *
     * Zwraca obiekt loggera
     *
     * @return sfLogger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    public function uploadImage($url)
    {
        static $b = null;

        if (is_null($b))
        {
            $b = new sfWebBrowser(array(), 'sfCurlAdapter');
        }

        $content = $b->get($url);

        if ($content->getResponseCode() == 200 && $this->validateImageType($content->getResponseHeader('content-type')))
        {
            $image_data = $content->getResponseText();

            $pathinfo = pathinfo($url);

            $filename = stMigrationSoteshopHelper::fixString(rawurldecode($pathinfo['filename'])) . '.' . $pathinfo['extension'];

            $image_file = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . $filename;

            if (file_put_contents($image_file, $image_data))
            {
                list($w, $h, $type) = getimagesize($image_file);

                $mime_type = image_type_to_mime_type($type);

                if (($w * $h * 4 >= 1280 * 1280 * 4) || !$this->validateImageType($mime_type))
                {

                    if (!$this->validateImageType($content->getResponseHeader('content-type')))
                    {
                        $this->getLogger()->notice(sprintf('Obraz "%s" [%s] nie posiada formatu jpg, gif lub png', $url, $mime_type));
                    }
                    else
                    {
                        $this->getLogger()->notice(sprintf('Obraz "%s" [%d x %d] przekracza dozwolony rozmiar 1280 x 1280', $url, $w, $h));
                    }

                    unlink($image_file);
                }
                else
                {
                    return $image_file;
                }
            }
        }
        elseif ($content->getResponseCode() != 200)
        {
            $this->getLogger()->warning(sprintf('Obraz "%s" nie istnieje', $url));
        }
        else
        {
            $this->getLogger()->notice(sprintf('Obraz "%s" [%s] nie posiada formatu jpg, gif lub png', $url, $content->getResponseHeader('content-type')));
        }

        return null;
    }

    protected function validateImageType($mime_type)
    {
        return in_array($mime_type, array('image/jpeg', 'image/png', 'image/gif'));
    }

    protected function getDictionary($wordbase)
    {
        $data_retriever = $this->getDataRetriever();

        $stmt = $data_retriever->prepareStatement('SELECT d.en, d.de, d.cz, d.ru FROM dictionary d WHERE d.wordbase = ?');

        $stmt->setString(1, $wordbase);

        $stmt->setLimit(1);

        $rs = $stmt->executeQuery();

        if ($rs->next()) {
            return array(
                'en_US' => $rs->getString('en'),
                'de' => $rs->getString('de'),
                'cs' => $rs->getString('cz'),
                'ru' => html_entity_decode($rs->getString('ru'), ENT_QUOTES, 'UTF-8')
            );
        }

        return null;
    }

    public function validateFillin($object, $data = array())
    {
        return true;
    }

    public function preSave($object)
    {

    }

    public function postSave($object)
    {

    }

    public function postCreate($object)
    {

    }
    
    public static function preProcess(stMigrationDataRetriever $data_retriever)
    {
       
    }
    
    public static function postProcess(stMigrationDataRetriever $data_retriever)
    {
       
    }
}
?>