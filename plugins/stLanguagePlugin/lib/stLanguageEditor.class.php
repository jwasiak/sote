<?php 

class stLanguageEditor {

    protected $culture = null;
    protected $language = null;
    protected $backendCulture = null;
    protected $catalogues = array();
    protected $cacheCatalogues = array();
    protected $phrases = array();

    protected static $instance = array();

    public static function getInstance($culture, $ignoreBackendCulture = false) {
        $hash = md5($culture.$ignoreBackendCulture);

        if (!isset(self::$instance[$hash]))
            self::$instance[$hash] = new stLanguageEditor($culture, $ignoreBackendCulture);

        return self::$instance[$hash];
    }

    public function __construct($culture, $ignoreBackendCulture = false) {
        $this->culture = $culture;

        $c = new Criteria();
        $c->add(LanguagePeer::SHORTCUT, $this->culture);
        $this->language = LanguagePeer::doSelectOne($c);
        if (!is_object($this->language))
            throw new Exception("Language don\'t exists.", 1);

        if (!$ignoreBackendCulture)
            $this->backendCulture = sfContext::getInstance()->getUser()->getCulture();
        else
            $this->backendCulture = null;

        $this->buildDictionary('en', true);

        if ($this->culture != 'en')
            $this->buildDictionary($this->culture);

        $this->setCacheToDictionary();
    }

    protected function buildDictionary($culture, $baseBuild = false) {
        foreach (glob(sfConfig::get('sf_root_dir').'/apps/frontend/i18n/*.'.$culture.'.xml') as $file) {
            $fileName = pathinfo($file, PATHINFO_BASENAME);
            $catalogue = substr($fileName, 0, strpos($fileName, '.'));

            if (preg_match('/^(st|sm|app)[A-Za-z]*\.'.$culture.'\.xml$/', $fileName)) {
                $this->catalogues[$catalogue] = $catalogue;

                $xml = simplexml_load_file($file);

                foreach ($xml->file->body->{"trans-unit"} as $item) {
                    $index = substr(md5((string)$item->source), 0, 8);
                    $this->phrases[$catalogue][$index]['phrase'] = (string)$item->source;
                    $this->phrases[$catalogue][$index]['shop'] = (string)$item->target;

                    if ($this->backendCulture == 'en_US' && isset($this->phrases[$catalogue][$index]['shop']))
                        $this->phrases[$catalogue][$index]['phrase'] = $this->phrases[$catalogue][$index]['shop'];

                    if ($this->culture == 'pl')
                        $this->phrases[$catalogue][$index]['shop'] = (string)$item->source;
                }
            } elseif (preg_match('/^(st|sm|app)[A-Za-z]*\.user\.'.$culture.'\.xml$/', $fileName)) {
                $xml = simplexml_load_file($file);

                foreach ($xml->file->body->{"trans-unit"} as $item) {
                    $index = substr(md5((string)$item->source), 0, 8);

                    if (isset($this->phrases[$catalogue][$index]) && !($this->culture == 'pl' && $culture == 'en'))
                        if ($baseBuild && $this->culture != 'en')
                            $this->phrases[$catalogue][$index]['shop'] = (string)$item->target;
                        else
                            $this->phrases[$catalogue][$index]['user'] = (string)$item->target;
                }
            }
        }
    }

    protected function setCacheToDictionary() {
        $stmt = Propel::getConnection()->prepareStatement(sprintf('SELECT %s, %s, %s FROM %s WHERE %s = '.$this->language->getId(), 
            TranslationCachePeer::CATALOGUE,
            TranslationCachePeer::CATALOGUE_INDEX,
            TranslationCachePeer::VALUE,
            TranslationCachePeer::TABLE_NAME,
            TranslationCachePeer::LANGUAGE_ID
        ));

        $cache = array();
        if ($stmt) {
            $rs = $stmt->executeQuery();
            while($rs->next())
                if (isset($this->phrases[$rs->get('CATALOGUE')][$rs->get('CATALOGUE_INDEX')])) {
                    $this->phrases[$rs->get('CATALOGUE')][$rs->get('CATALOGUE_INDEX')]['cache'] = $rs->get('VALUE');
                    if (!isset($this->cacheCatalogues[$rs->get('CATALOGUE')]))
                        $this->cacheCatalogues[] = $rs->get('CATALOGUE');
                }
        }
    }

    public function getCatalogues($onlyWithCache = false) {
        if ($onlyWithCache === true)
            return $this->cacheCatalogues;
        return $this->catalogues;
    }

    public function getPhrases($catalogue = null) {
        if (!is_null($catalogue) && isset($this->phrases[$catalogue]))
            return array($catalogue => $this->phrases[$catalogue]);
        else 
            return array();
        return $this->phrases;
    }

    public function searchPhrase($search, $searchCatalogue = null) {
        return $this->search($search, $searchCatalogue, 'phrase');
    }

    public function searchTranslation($search, $searchCatalogue = null) {
        return $this->search($search, $searchCatalogue, 'user');
    }

    public function search($search, $searchCatalogue, $type) {
        $result = array();

        if(strlen($search) <= 2)
            $search = '^'.$search.'$';
        
        foreach ($this->phrases as $catalogue => $phrases) {
            if ($searchCatalogue !== null && $catalogue !== $searchCatalogue)
                continue;

            foreach ($phrases as $index => $phrases) {
                if (isset($phrases[$type]) && preg_match('/'.trim($search).'/i', $phrases[$type])) {
                    $result[$catalogue][$index] = $phrases;
                }
            }
        }
        return $result;
    }

    public function getPhraseByIndex($catalogue, $index) {
        if (isset($this->phrases[$catalogue][$index]))
            return $this->phrases[$catalogue][$index];
        return null;
    }

    protected $xmlFileHeader = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff version=\"1.0\">\n\t<file orginal=\"global\" source-language=\"pl_PL\" target-language=\"%s\" datatype=\"plaintext\" date=\"%s\">\n\t\t<body>\n";
    protected $xmlFileRecord = "\t\t\t<trans-unit id=\"%s\">\n\t\t\t\t<source><![CDATA[%s]]></source>\n\t\t\t\t<target><![CDATA[%s]]></target>\n\t\t\t</trans-unit>\n";
    protected $xmlFileFooter = "\t\t</body>\n\t</file>\n</xliff>\n";

    public function saveXliffFile($type, $catalogue = 'messages', $phrases = null) {
        
        if (is_array($type))
            list($type, $outputType) = $type;
        else 
            $outputType = $type;

        if ($catalogue === 'messages')
            $cataloguesToSave = $this->getCatalogues();
        else
            $cataloguesToSave = array($catalogue);

        if ($phrases === null)
            $phrases = $this->phrases;

        $xmlFile = sfConfig::get('sf_root_dir').'/apps/frontend/i18n/'.$catalogue.'.'.$outputType.'.'.$this->language->getLanguage().'.xml';

        $fileHandler = fopen($xmlFile, 'w');
        fwrite($fileHandler, sprintf($this->xmlFileHeader, $this->language->getOriginalLanguage(), date("Y-m-d\Th:i:s\Z")));

        foreach ($cataloguesToSave as $catalogue) {
            if (isset($phrases[$catalogue])) {
                $i = 1;
                foreach ($phrases[$catalogue] as $index => $record) {
                    $id = $catalogue."_".$i;
                    switch ($type) {
                        case 'edit':
                            fwrite($fileHandler, sprintf($this->xmlFileRecord, $id, $record['phrase'], ''));
                            break;
                        case 'shop':
                            fwrite($fileHandler, sprintf($this->xmlFileRecord, $id, $record['phrase'], $record['shop']));
                            break;
                        case 'user':
                            fwrite($fileHandler, sprintf($this->xmlFileRecord, $id, $record['phrase'], (isset($record['user']) ? $record['user'] : $record['shop'])));
                            break;
                        case 'cache':
                            fwrite($fileHandler, sprintf($this->xmlFileRecord, $id, $record['phrase'], 
                                isset($record['cache']) ? $record['cache'] : (isset($record['user']) ? $record['user'] : $record['shop'])
                            ));
                    }
                    $i++;
                }
            }
        }

        fwrite($fileHandler, $this->xmlFileFooter);
        fclose($fileHandler);
    }

    public static function parseXliffFile($filePath) {
        $phrases = array();

        if (!file_exists($filePath))
            return $phrases;

        $xml = simplexml_load_file($filePath, null, LIBXML_NOCDATA);

        if (false === $xml) {
            return false;
        }

        foreach ($xml->file->body->{"trans-unit"} as $item) {
            $attributes = $item->attributes();

            list($catalogue, ) = explode('_', $attributes['id'], 2);

            $index = substr(md5((string)$item->source), 0, 8);

            $phrases[$catalogue][$index]['phrase'] = (string)$item->source;
            $phrases[$catalogue][$index]['user'] = (string)$item->target;
        }

        return $phrases;
    }
}
