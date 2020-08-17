<?php
class stSearch {

	protected static $stopwords = array( " a's ", " able ", " about ", " above ", " according ", " accordingly ",
	" across ", " actually ", " after ", " afterwards ", " again ", " against ", " ain't ", " all ", " allow ", " allows ", 
	" almost ", " alone ", " along ", " already ", " also ", " although ", " always ", " am ", " among ", " amongst ", " an ", " and ", 
	" another ", " any ", " anybody ", " anyhow ", " anyone ", " anything ", " anyway ", " anyways ", " anywhere ", " apart ", " appear ", 
	" appreciate ", " appropriate ", " are ", " aren't ", " around ", " as ", " aside ", " ask ", " asking ", " associated ", " at ", 
	" available ", " away ", " awfully ", " be ", " became ", " because ", " become ", " becomes ", " becoming ", " been ", " before ", 
	" beforehand ", " behind ", " being ", " believe ", " below ", " beside ", " besides ", " best ", " better ", " between ", " beyond ", 
	" both ", " brief ", " but ", " by ", " c'mon ", " c's ", " came ", " can ", " can't ", " cannot ", " cant ", " cause ", " causes ", 
	" certain ", " certainly ", " changes ", " clearly ", " co ", " com ", " come ", " comes ", " concerning ", " consequently ", 
	" consider ", " considering ", " contain ", " containing ", " contains ", " corresponding ", " could ", " couldn't ", " course ", 
	" currently ", " definitely ", " described ", " despite ", " did ", " didn't ", " different ", " do ", " does ", " doesn't ", 
	" doing ", " don't ", " done ", " down ", " downwards ", " during ", " each ", " edu ", " eg ", " eight ", " either ", " else ", 
	" elsewhere ", " enough ", " entirely ", " especially ", " et ", " etc ", " even ", " ever ", " every ", " everybody ", " everyone ", 
	" everything ", " everywhere ", " ex ", " exactly ", " example ", " except ", " far ", " few ", " fifth ", " first ", " five ", 
	" followed ", " following ", " follows ", " for ", " former ", " formerly ", " forth ", " four ", " from ", " further ", 
	" furthermore ", " get ", " gets ", " getting ", " given ", " gives ", " go ", " goes ", " going ", " gone ", " got ", " gotten ", 
	" greetings ", " had ", " hadn't ", " happens ", " hardly ", " has ", " hasn't ", " have ", " haven't ", " having ", " he ", 
	" he's ", " hello ", " help ", " hence ", " her ", " here ", " here's ", " hereafter ", " hereby ", " herein ", " hereupon ", 
	" hers ", " herself ", " hi ", " him ", " himself ", " his ", " hither ", " hopefully ", " how ", " howbeit ", " however ", " i'd ", 
	" i'll ", " i'm ", " i've ", " ie ", " if ", " ignored ", " immediate ", " in ", " inasmuch ", " inc ", " indeed ", " indicate ", 
	" indicated ", " indicates ", " inner ", " insofar ", " instead ", " into ", " inward ", " is ", " isn't ", " it ", " it'd ", 
	" it'll ", " it's ", " its ", " itself ", " just ", " keep ", " keeps ", " kept ", " know ", " knows ", " known ", " last ", 
	" lately ", " later ", " latter ", " latterly ", " least ", " less ", " lest ", " let ", " let's ", " like ", " liked ", 
	" likely ", " little ", " look ", " looking ", " looks ", " ltd ", " mainly ", " many ", " may ", " maybe ", " me ", " mean ", 
	" meanwhile ", " merely ", " might ", " more ", " moreover ", " most ", " mostly ", " much ", " must ", " my ", " myself ", 
	" name ", " namely ", " nd ", " near ", " nearly ", " necessary ", " need ", " needs ", " neither ", " never ", " nevertheless ", 
	" new ", " next ", " nine ", " no ", " nobody ", " non ", " none ", " noone ", " nor ", " normally ", " not ", " nothing ", 
	" novel ", " now ", " nowhere ", " obviously ", " of ", " off ", " often ", " oh ", " ok ", " okay ", " old ", " on ", " once ", 
	" one ", " ones ", " only ", " onto ", " or ", " other ", " others ", " otherwise ", " ought ", " our ", " ours ", " ourselves ", 
	" out ", " outside ", " over ", " overall ", " own ", " particular ", " particularly ", " per ", " perhaps ", " placed ", " please ", 
	" plus ", " possible ", " presumably ", " probably ", " provides ", " que ", " quite ", " qv ", " rather ", " rd ", " re ", 
	" really ", " reasonably ", " regarding ", " regardless ", " regards ", " relatively ", " respectively ", " right ", " said ", 
	" same ", " saw ", " say ", " saying ", " says ", " second ", " secondly ", " see ", " seeing ", " seem ", " seemed ", " seeming ", 
	" seems ", " seen ", " self ", " selves ", " sensible ", " sent ", " serious ", " seriously ", " seven ", " several ", " shall ", 
	" she ", " should ", " shouldn't ", " since ", " six ", " so ", " some ", " somebody ", " somehow ", " someone ", " something ", 
	" sometime ", " sometimes ", " somewhat ", " somewhere ", " soon ", " sorry ", " specified ", " specify ", " specifying ", " still ", 
	" sub ", " such ", " sup ", " sure ", " t's ", " take ", " taken ", " tell ", " tends ", " th ", " than ", " thank ", " thanks ", 
	" thanx ", " that ", " that's ", " thats ", " the ", " their ", " theirs ", " them ", " themselves ", " then ", " thence ", 
	" there ", " there's ", " thereafter ", " thereby ", " therefore ", " therein ", " theres ", " thereupon ", " these ", " they ", 
	" they'd ", " they'll ", " they're ", " they've ", " think ", " third ", " this ", " thorough ", " thoroughly ", " those ", 
	" though ", " three ", " through ", " throughout ", " thru ", " thus ", " to ", " together ", " too ", " took ", " toward ", 
	" towards ", " tried ", " tries ", " truly ", " try ", " trying ", " twice ", " two ", " un ", " under ", " unfortunately ", 
	" unless ", " unlikely ", " until ", " unto ", " up ", " upon ", " us ", " use ", " used ", " useful ", " uses ", " using ", 
	" usually ", " value ", " various ", " very ", " via ", " viz ", " vs ", " want ", " wants ", " was ", " wasn't ", " way ", 
	" we ", " we'd ", " we'll ", " we're ", " we've ", " welcome ", " well ", " went ", " were ", " weren't ", " what ", " what's ", 
	" whatever ", " when ", " whence ", " whenever ", " where ", " where's ", " whereafter ", " whereas ", " whereby ", " wherein ", 
	" whereupon ", " wherever ", " whether ", " which ", " while ", " whither ", " who ", " who's ", " whoever ", " whole ", " whom ", 
	" whose ", " why ", " will ", " willing ", " wish ", " with ", " within ", " without ", " won't ", " wonder ", " would ", " would ", 
	" wouldn't ", " yes ", " yet ", " you ", " you'd ", " you'll ", " you're ", " you've ", " your ", " yours ", " yourself ", 
	" yourselves ", " zero");
	
	protected static $nonstopwords = array( " _a's ", " _able ", " _about ", " _above ", " _according ", " _accordingly ", 
	" _across ", " _actually ", " _after ", " _afterwards ", " _again ", " _against ", " _ain't ", " _all ", " _allow ", " _allows ", 
	" _almost ", " _alone ", " _along ", " _already ", " _also ", " _although ", " _always ", " _am ", " _among ", " _amongst ", " _an ", " _and ", 
	" _another ", " _any ", " _anybody ", " _anyhow ", " _anyone ", " _anything ", " _anyway ", " _anyways ", " _anywhere ", " _apart ", 
	" _appear ", " _appreciate ", " _appropriate ", " _are ", " _aren't ", " _around ", " _as ", " _aside ", " _ask ", " _asking ", 
	" _associated ", " _at ", " _available ", " _away ", " _awfully ", " _be ", " _became ", " _because ", " _become ", " _becomes ", 
	" _becoming ", " _been ", " _before ", " _beforehand ", " _behind ", " _being ", " _believe ", " _below ", " _beside ", " _besides ", 
	" _best ", " _better ", " _between ", " _beyond ", " _both ", " _brief ", " _but ", " _by ", " _c'mon ", " _c's ", " _came ", " _can ", 
	" _can't ", " _cannot ", " _cant ", " _cause ", " _causes ", " _certain ", " _certainly ", " _changes ", " _clearly ", " _co ", 
	" _com ", " _come ", " _comes ", " _concerning ", " _consequently ", " _consider ", " _considering ", " _contain ", " _containing ", 
	" _contains ", " _corresponding ", " _could ", " _couldn't ", " _course ", " _currently ", " _definitely ", " _described ", 
	" _despite ", " _did ", " _didn't ", " _different ", " _do ", " _does ", " _doesn't ", " _doing ", " _don't ", " _done ", 
	" _down ", " _downwards ", " _during ", " _each ", " _edu ", " _eg ", " _eight ", " _either ", " _else ", " _elsewhere ", 
	" _enough ", " _entirely ", " _especially ", " _et ", " _etc ", " _even ", " _ever ", " _every ", " _everybody ", 
	" _everyone ", " _everything ", " _everywhere ", " _ex ", " _exactly ", " _example ", " _except ", " _far ", 
	" _few ", " _fifth ", " _first ", " _five ", " _followed ", " _following ", " _follows ", " _for ", " _former ", 
	" _formerly ", " _forth ", " _four ", " _from ", " _further ", " _furthermore ", " _get ", " _gets ", " _getting ", 
	" _given ", " _gives ", " _go ", " _goes ", " _going ", " _gone ", " _got ", " _gotten ", " _greetings ", " _had ", 
	" _hadn't ", " _happens ", " _hardly ", " _has ", " _hasn't ", " _have ", " _haven't ", " _having ", " _he ", " _he's ", 
	" _hello ", " _help ", " _hence ", " _her ", " _here ", " _here's ", " _hereafter ", " _hereby ", " _herein ", 
	" _hereupon ", " _hers ", " _herself ", " _hi ", " _him ", " _himself ", " _his ", " _hither ", " _hopefully ", 
	" _how ", " _howbeit ", " _however ", " _i'd ", " _i'll ", " _i'm ", " _i've ", " _ie ", " _if ", " _ignored ", 
	" _immediate ", " _in ", " _inasmuch ", " _inc ", " _indeed ", " _indicate ", " _indicated ", " _indicates ", 
	" _inner ", " _insofar ", " _instead ", " _into ", " _inward ", " _is ", " _isn't ", " _it ", " _it'd ", " _it'll ", 
	" _it's ", " _its ", " _itself ", " _just ", " _keep ", " _keeps ", " _kept ", " _know ", " _knows ", " _known ", 
	" _last ", " _lately ", " _later ", " _latter ", " _latterly ", " _least ", " _less ", " _lest ", " _let ", " _let's ", 
	" _like ", " _liked ", " _likely ", " _little ", " _look ", " _looking ", " _looks ", " _ltd ", " _mainly ", " _many ", 
	" _may ", " _maybe ", " _me ", " _mean ", " _meanwhile ", " _merely ", " _might ", " _more ", " _moreover ", " _most ", 
	" _mostly ", " _much ", " _must ", " _my ", " _myself ", " _name ", " _namely ", " _nd ", " _near ", " _nearly ", 
	" _necessary ", " _need ", " _needs ", " _neither ", " _never ", " _nevertheless ", " _new ", " _next ", " _nine ", 
	" _no ", " _nobody ", " _non ", " _none ", " _noone ", " _nor ", " _normally ", " _not ", " _nothing ", " _novel ", 
	" _now ", " _nowhere ", " _obviously ", " _of ", " _off ", " _often ", " _oh ", " _ok ", " _okay ", " _old ", " _on ", " _once ", 
	" _one ", " _ones ", " _only ", " _onto ", " _or ", " _other ", " _others ", " _otherwise ", " _ought ", " _our ", " _ours ", 
	" _ourselves ", " _out ", " _outside ", " _over ", " _overall ", " _own ", " _particular ", " _particularly ", " _per ", 
	" _perhaps ", " _placed ", " _please ", " _plus ", " _possible ", " _presumably ", " _probably ", " _provides ", " _que ", 
	" _quite ", " _qv ", " _rather ", " _rd ", " _re ", " _really ", " _reasonably ", " _regarding ", " _regardless ", " _regards ", 
	" _relatively ", " _respectively ", " _right ", " _said ", " _same ", " _saw ", " _say ", " _saying ", " _says ", " _second ", 
	" _secondly ", " _see ", " _seeing ", " _seem ", " _seemed ", " _seeming ", " _seems ", " _seen ", " _self ", " _selves ", 
	" _sensible ", " _sent ", " _serious ", " _seriously ", " _seven ", " _several ", " _shall ", " _she ", " _should ", 
	" _shouldn't ", " _since ", " _six ", " _so ", " _some ", " _somebody ", " _somehow ", " _someone ", " _something ", 
	" _sometime ", " _sometimes ", " _somewhat ", " _somewhere ", " _soon ", " _sorry ", " _specified ", " _specify ", " _specifying ", 
	" _still ", " _sub ", " _such ", " _sup ", " _sure ", " _t's ", " _take ", " _taken ", " _tell ", " _tends ", " _th ", " _than ", 
	" _thank ", " _thanks ", " _thanx ", " _that ", " _that's ", " _thats ", " _the ", " _their ", " _theirs ", " _them ", " _themselves ", 
	" _then ", " _thence ", " _there ", " _there's ", " _thereafter ", " _thereby ", " _therefore ", " _therein ", " _theres ", 
	" _thereupon ", " _these ", " _they ", " _they'd ", " _they'll ", " _they're ", " _they've ", " _think ", " _third ", " _this ", 
	" _thorough ", " _thoroughly ", " _those ", " _though ", " _three ", " _through ", " _throughout ", " _thru ", " _thus ", " _to ", 
	" _together ", " _too ", " _took ", " _toward ", " _towards ", " _tried ", " _tries ", " _truly ", " _try ", " _trying ", " _twice ", 
	" _two ", " _un ", " _under ", " _unfortunately ", " _unless ", " _unlikely ", " _until ", " _unto ", " _up ", " _upon ", " _us ", 
	" _use ", " _used ", " _useful ", " _uses ", " _using ", " _usually ", " _value ", " _various ", " _very ", " _via ", " _viz ", 
	" _vs ", " _want ", " _wants ", " _was ", " _wasn't ", " _way ", " _we ", " _we'd ", " _we'll ", " _we're ", " _we've ", " _welcome ", 
	" _well ", " _went ", " _were ", " _weren't ", " _what ", " _what's ", " _whatever ", " _when ", " _whence ", " _whenever ", 
	" _where ", " _where's ", " _whereafter ", " _whereas ", " _whereby ", " _wherein ", " _whereupon ", " _wherever ", " _whether ", 
	" _which ", " _while ", " _whither ", " _who ", " _who's ", " _whoever ", " _whole ", " _whom ", " _whose ", " _why ", " _will ", 
	" _willing ", " _wish ", " _with ", " _within ", " _without ", " _won't ", " _wonder ", " _would ", " _would ", " _wouldn't ", 
	" _yes ", " _yet ", " _you ", " _you'd ", " _you'll ", " _you're ", " _you've ", " _your ", " _yours ", 
	" _yourself ", " _yourselves ", " _zero");

	/**
	 * fulltext ft_min_word_len
	 * @var integer
	 */
	protected static $min_len = null;

	/**
	 * Instance of  stSimpleSearch
	 * @var stCurrency object
	 */
	protected static $instance = null;

	/**
	 * Search parameters
	 * @var array
	 */
	protected $params = array();


	/**
	 * Search string
	 * @var string
	 */
	public $what = '';

	/**
	 * Splited words from search string
	 * @var array
	 */
	public $words = array();

	/**
	 * Module config
	 * @var object
	 */
	public $searchConfig = null;

	/**
	 * Search culterue
	 * @var string
	 */
	public $culture = '';

	/**
	 * User custom criteria
	 * @var object
	 */
	public $customCriteria = null;

	public static $locale = null;

	/**
	 * Incjalizacja klasy stSimpleSearch
	 *
	 * @param        string      $context
	 */
	public function initialize()
	{
	}

	/**
	 * Zwraca instancje obiektu
	 *
	 * @param        string      $context
	 * @return   stCurrency  $instance
	 */
	public static function getInstance()
	{
		if ( ! isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class();
			self::$instance->initialize();
		}
		return self::$instance;
	}

	/**
	 * Tworzy zapytanie do bazy danych na podsawie frazy, zwraca obiekt z kryteriami
	 *
	 * @param        string      $what
	 * @return   object
	 */
	public function search($what = '') {
		$this->context = sfContext::getInstance();
		$this->searchConfig = stConfig::getInstance($this->context, 'stSearchBackend');

		$this->culture = $this->context->getUser()->getCulture();
		$this->currency = $this->context->getUser()->getAttribute('currency');

		$c = new Criteria();
		$this->showWithoutPrice($c);

        $c->add(ProductPeer::IS_GIFT, 0);

		return $c;
	}

	/**
	 * Ustawia ktore produkty maja byc wyswietlane
	 *
	 * @param       $object     $c
	 */
	protected function showWithoutPrice($c = null) {

		$config = stConfig::getInstance(sfContext::getInstance(), array( 'show_without_price' => stConfig::BOOL),'stProduct' );
		$config->load();
		$c->add(ProductPeer::ACTIVE,1);
		if ($config->get('show_without_price'))
		{
			$c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);
		}
		stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stProductActions.postAddProductCriteria', array('criteria' => $c)));
	}

	/**
	 * Usuwa zbedne tagi
	 *
	 * @param        string      $word
	 * @return   string
	 */
	public static function removeTags($word) {
		if (is_string($word)) {
			$tmp = mb_strtolower($word,'UTF-8');
			$tmp = strip_tags($tmp);
			return html_entity_decode($tmp,ENT_NOQUOTES,'UTF-8');
		}
		return '';
	}

	/**
	 * Dodaje parametr do wyszukiwania
	 *
	 * @param        string      $name
	 * @param         mixed       $value
	 */
	public function addParam($name = '', $value = null) {
		if (mb_strlen($name) && !empty($value)) {
			if (!is_array($value)) $this->params[$name] = $value;
			else $this->params[$name] = $this->cleanArray($value);
		}
	}

	public function cleanArray($array) {
		if (is_array($array)) {
			foreach ($array as $key=>$value)
			{
				$array[$key] = $this->cleanArray($value);
				if (is_string($array[$key]) && strlen(trim($array[$key]))==0) unset($array[$key]);
			}
		} elseif (is_string($array)) {
			return $array;
		}
		return $array;
	}

	public function setParams($params = array(), $prefix='st_search') {
		if (is_array($params)) 
		foreach ($params as $key=>$param) {
			$this->addParam("{$prefix}[{$key}]",$param);
		}
	}
	/**
	 * Pobiera parameter
	 *
	 * @param        string      $name
	 * @return   mixed
	 */
	public function getParam($name = '') {
		if (isset($this->params[$name])) {
			return $this->params[$name];
		}
	}

	/**
	 * Pobiera wszystkie paramtery
	 *
	 * @return   array
	 */
	public function getAllParams() {
		return $this->params;
	}

	/**
	 * Tworzy linki w postaic param1=y&param2=x
	 *
	 * @return   string
	 */
	public function getPagerParams($as_array = false) {
		if ($as_array) return $this->params;
		return (http_build_query($this->params,'','&'));
	}

	public function getRequestParameter($param, $default)
	{
		return sfContext::getInstance()->getRequest()->getParameter($param, $default);
	}

	function addStats($searched_word = '', $results = -1) {
		// sprawdz czy slowo juz bylo wyszukiwane
		$c = new Criteria();
		$c->add(SearchedWordsPeer::WORD,mb_strtolower($searched_word,'utf-8'));
		$searched = SearchedWordsPeer::doSelectOne($c);

		// jezeli nie to stworz nowe
		if (!$searched) {
			$searched=new SearchedWords();
			$searched->setWord($searched_word);

		}

		// ustaw i zapisz zmiany
		$searched->setSearched(($searched->getSearched()+1));
		$searched->setResults($results);
		$searched->save();

	}
	/**
	 * Removes local symbol and special char for fulltext search
	 * @param string $str
	 * @return srting
	 */
	public static function removeLocalSymbols($str)
	{
		mb_internal_encoding('UTF-8');

		mb_regex_encoding("UTF-8");

		$search = array("/\+/","/'/", '/\./','/-/', '/ä/', '/ö/', '/ü/', '/Ä/', '/Ö/', '/Ü/', '/ß/',
            '/ą/', '/Ą/', '/ć/', '/Ć/', '/ę/', '/Ę/', '/ł/', '/Ł/' ,'/ń/', '/Ń/', '/ó/', '/Ó/', '/ś/', '/Ś/', '/ź/', '/Ź/', '/ż/', '/Ż/',
            '/Š/','/Ž/','/š/','/ž/','/Ÿ/','/Ŕ/','/Á/','/Â/','/Ă/','/Ä/','/Ĺ/','/Ç/','/Č/','/É/','/Ę/','/Ë/','/Ě/','/Í/','/Î/','/Ď/','/Ń/',
            '/Ň/','/Ó/','/Ô/','/Ő/','/Ö/','/Ř/','/Ů/','/Ú/','/Ű/','/Ü/','/Ý/','/ŕ/','/á/','/â/','/ă/','/ä/','/ĺ/','/ç/','/č/','/é/','/ę/',
            '/ë/','/ě/','/í/','/î/','/ď/','/ń/','/ň/','/ó/','/ô/','/ő/','/ö/','/ř/','/ů/','/ú/','/ű/','/ü/','/ý/','/˙/',
            '/Ţ/','/ţ/','/Đ/','/đ/','/ß/','/Œ/','/œ/','/Ć/','/ć/','/ľ/');

		$replace   = array('_', '_', '_','_', 'ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss',
            'a', 'A', 'c', 'C', 'e', 'E', 'l', 'L', 'n', 'N', 'o', 'O', 's', 'S', 'z', 'Z', 'z', 'Z',
            'S','Z','s','z','Y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N',
            'O','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e',
            'e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y',
            'TH','th','DH','dh','ss','OE','oe','AE','ae','u');

		$str = preg_replace($search, $replace, $str);

		return mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
	}


	/**
	 * Build string with no special chars, html tags
	 * @param string $data
	 * @return string
	 */
	public static function rebuildSearchIndex($data) {
		$data = stSearch::removeTags($data);
		$items = split("[\(\)\n\r\t ]+",stSearch::removeLocalSymbols($data).' '.$data);

		
		// add '_' to words shorten than ft_min_word_len but longer than stSearch::getMinLen()
		foreach ($items as $key=>$value) {
			$value = trim($value,"'\"!:;.,_");
			if (strlen($value)) $items[$key] = str_pad($value, stSearch::getMinLen(), '_', STR_PAD_RIGHT);
		}
		$tmp = ' '.implode('  ', $items).' ';
		return str_replace(self::$stopwords, self::$nonstopwords, $tmp);
	}

	public static function productGetCode($product)
	{
		return $product->getCode();
	}

	/**
	 * Retrurns ft_min_word_len for mysql
	 * @return integer
	 */
	public static function getMinLen()
	{
		// if ft_min_word_len is not set get from database
		if (stSearch::$min_len==null)
		{
			// default value is 3
			stSearch::$min_len = 3;

			// get ft_min_word_len from database
			$con = Propel::getConnection();
			$sql = "SHOW GLOBAL VARIABLES LIKE 'ft_min_word_len'";
			$stmt = $con->PrepareStatement($sql);
			$rs = $stmt->executeQuery();
			if ($rs->next())  {
				stSearch::$min_len = $rs->getInt('Value');
			}
		}

		return stSearch::$min_len;

	}

	/**
	 * Gets product code for search
	 * @param object $product
	 * @return string
	 */
	public static function productGetName($product)
	{
		return $product->getName();
	}

	/**
	 * Return product keywords as a string
	 * @param object $product
	 * @return string
	 */
	public static function productGetKeywords($product)
	{
		$c = new Criteria();
		$c->add(ProductHasPositioningPeer::PRODUCT_ID, $product->getId());
		$positioning = ProductHasPositioningPeer::doSelectOne($c);
		if (is_object($positioning)) {
			$positioning->setCulture($product->getCulture());
			return $positioning->getKeywords();
		}
		return '';
	}

	/**
	 * Returns producer of the product as a string
	 * @param object $product
	 * @return string
	 */
	public static function productGetProducer($product)
	{
		if (is_object($product->getProducer())) return $product->getProducer()->getName();
		return '';
	}

	public static function productGetLongDesc($product)
	{
		return strip_tags($product->getDescription());
	}

	public static function productGetShortDesc($product)
	{
		return strip_tags($product->getShortDescription());
	}


	public static function useFriendlyLink($friendly = true)
	{
		ini_set('arg_separator.output','&');
		sfConfig::set('sf_url_format', $friendly?'PATH':'GET');
	}

}
?>