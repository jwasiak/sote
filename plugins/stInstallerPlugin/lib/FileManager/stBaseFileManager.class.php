<?php
/**
 * SOTESHOP/stInstallerPlugin
 *
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stBaseFileManager.class.php 3782 2010-03-05 13:39:42Z marek $
 */

/**
 * Rozszerzenie funkcjonalności klasy sfFinder
 *
 * @see sfFinder
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stFinder extends sfFinder
{
    /**
     * Usuwa wszystkie kryteria filtrowania
     *
     * @return   stFinder
     */
    public function clear()
    {
        $this->discards = array();
        $this->prunes = array();
        $this->maxdepth = 1000;
        $this->mindepth = 0;
        $this->names = array();
        $this->sizes = array();
        $this->ignore_version_control();
        return $this;
    }

    /**
     * Zwracaj ścieżki absolutne
     */
    public function absolute()
    {
        $this->relative = false;
    }

    /**
     * Tworzy nowa instancje stFinder
     *
     * @param   string      $type               typ wyświetlanych wyników ('any' - wszystkie pliki, 'dir' - tylko katalogi, 'file' - tylko pliki)  
     * @return   stFinder
     */
    public static function create($type = 'file')
    {
        $finder = new self();

        if (strtolower(substr($type, 0, 3)) == 'dir')
        {
            $finder->type = 'directory';
        }
        else
        if (strtolower($type) == 'any')
        {
            $finder->type = 'any';
        }
        else
        {
            $finder->type = 'file';
        }

        return $finder;
    }
}

/**
 * Podstawowa klasa do obsługi operacji plikowych
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @verison $Id: stBaseFileManager.class.php 3782 2010-03-05 13:39:42Z marek $
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
abstract class stBaseFileManager
{
    protected $protected_files = array();

    /**
     * Instancja obiektu stFinder
     * @var stFinder
     */
    protected $filter = null;

    /**
     * Domyślne prawa ustalane na katalogi i pliki
     * @var array
     */
    protected $perm = array('file' => 0644, 'dir' => 0755);

    /**
     * Kopiuje plik lub pusty katalog (według ustalonych reguł filtru)
     * Zależne od systemu plików 
     *
     * @param   string      $origin_path        Ścieżka przenoszonego pliku  
     * @param   string      $target_path        Ścieżka docelowa przenoszonego pliku lub pustego katalogu  
     * @param        string      $force_override
     */
    abstract protected function _copy($origin_path, $target_path, $perm = null);

    /**
     * Tworzy katalog o podanej ścieżce
     * Zależne od systemu plików
     *
     * @param   string      $path               Ścieżka do katalogu  
     */
    abstract protected function _mkdir($path, $perm = null);

    /**
     * Usuwa plik lub zawartość katalogu (według ustalonych reguł filtru)
     * Zależne od systemu plików
     *
     * @param   string      $file               Ścieżka usuwanego pliku lub katalogu  
     */
    abstract protected function _remove($file);

    /**
     * Synchronizuje katalogi
     *
     * @param   string      $origin_path        Ścieżka synchronizowanego katalogu  
     * @param   string      $target_path        Ścieżka docelowa  
     * @param   string      $sync_dir           Ścieżka katalogu dla plików synchronizacji   
     * @param   string      $disereg            Wyrażenie regularne dla plików, ktore niegdy nie będą synchornizowane, fix do pomijania katalogów postaci stAppName/stAppName
     * @param   array       $ignore             Lista wyrażeń regularnych dla ignorowanych plików.
     */
    public function sync($origin_path, $target_path, $sync_dir, $force_override = false, $disereg = '', $ignore = array())
    {
        if (!is_dir($origin_path))
        {
            throw new Exception(sprintf("The path '%s' must be a directory...", $origin_path));
        }

        $remove_list = array();

        $file_list = array();

        $files = $this->filter()->in($origin_path);

        if ($disereg) {
            $files = stFileManagerFilter::diseregFilter($files, $disereg);
        }

        $sync_file = $sync_dir . DIRECTORY_SEPARATOR . self::computeSyncNameFromPath($origin_path);

        foreach ($files as $file)
        {
            $target_file = $target_path . $this->computeRelativePath($file, $origin_path);

            $file_list[$file] = $target_file;


        }
            
        if (is_file($sync_file))
        {
            $target_files = file($sync_file, FILE_IGNORE_NEW_LINES);

            $remove_list = array_diff($target_files, $file_list, $this->protected_files);
        }
        else
        {
            $this->_mkdir(dirname($sync_file));
        }

        rsort($remove_list);

        $this->remove($remove_list,null,$ignore);

        foreach ($file_list as $file => $target_file)
        {
            $target_file = $target_path . $this->computeRelativePath($file, $origin_path);

            if (!$this->isSync($file, $target_file) || $force_override)
            {
                $this->_mkdir(dirname($target_file));
                    
                // sprawdz czy mozna kopiowac plik, czy nie jest on na liscie plikow ignorowanych
                if (null === $ignore || (!stFileManagerFilter::ignoreFile($target_file,$ignore) && stFileManagerFilter::replaceFile($file, $target_file)))
                {
                    $this->_copy($file, $target_file);
                }
            }

            $this->protected_files[$file] = $target_file;
        }

        file_put_contents($sync_file, implode("\n", $file_list));
    }

    /**
     * Czyści nieistniejące katalogi synchronizacji 
     *
     * @param   string      $origin_path        ścieżka usuniętego katalogu źródłowego  
     * @param   string      $sync_dir           ścieżka katalogu  
     */
    public function syncClean($origin_path, $sync_dir)
    {
        $sync_file = $sync_dir . DIRECTORY_SEPARATOR . self::computeSyncNameFromPath($origin_path);

        $filter = new stFileManagerFilter('any');

        $filter->ignore_version_control()->name('*.sync')->maxdepth(0);

        if (!file_exists($origin_path) && is_file($sync_file))
        {
            $files = file($sync_file, FILE_IGNORE_NEW_LINES);
            rsort($files);
            $this->remove($files, $filter);
            $this->remove($sync_file);
        }
    }

    /**
     * Kopiuje plik lub zawartość katalogu (według ustalonych reguł filtru)
     *
     * @param   mixed       $origin_path        Ścieżka/Lista ścieżek kopiowanego pliku lub katalogu  
     * @param   string      $target_path        Ścieżka docelowa kopiowanego pliku lub katalogu  
     * @param   bool        $force_override     Określa wymuszenie nadpisania docelowego pliku 
     * @param   bool        $act_as_move        Określa czy funkcja ma przenosić plik (usuwać plik kopiowany)  
     * @param   integer     $perm               Domyślne prawa dla zapisywanego pliku (w przypadku podania null brane są prawa domyślne)  
     */
    public function copy($origin_path, $target_path, $force_override = false, $act_as_move = false, $perm = null)
    {
        if (is_string($origin_path))
        {
            $paths = array($origin_path);
        }
        elseif (is_array($origin_path))
        {
            $paths = $origin_path;
        }

        rsort($paths);

        foreach ($paths as $path)
        {
            $path = self::fixPath($path);

            if (is_dir($path))
            {
                $files = $this->filter()->in($path);

                rsort($files);

                foreach ($files as $file)
                {
                    $target_file = $target_path . $this->computeRelativePath($file, $path);

                    if (!$this->isSync($file, $target_file) || $force_override)
                    {
                        $this->mkdir(dirname($target_file), $perm);

                        if (!$this->_copy($file, $target_file, $perm))
                        return false;

                        if ($act_as_move)
                        {
                            $this->_remove($file);
                        }
                    }
                }
            }
            elseif (!$this->isSync($file, $target_path) || $force_override)
            {
                $this->mkdir(dirname($target_path), $perm);

                if (!$this->_copy($origin_path, $target_path, $perm))
                return false;

                if ($act_as_move)
                {
                    $this->_remove($file);
                }
            }
        }

        return true;
    }

    public function move($origin_path, $target_path, $force_override = false, $perm = null)
    {
        return $this->copy($origin_path, $target_path, $force_override, true, $perm);
    }

    /**
     * Tworzy katalog o podanej ścieżce
     *
     * @param   string      $path               Ścieżka do katalogu  
     * @param   integer     $perm               Domyślne prawa dla zapisywanego pliku (w przypadku podania null brane są prawa domyślne)  
     */
    public function mkdir($path, $perm = null)
    {
        return $this->_mkdir($path, $perm);
    }

    /**
     * Usuwa plik lub katalog wraz z jego zawartością (według ustalonych reguł filtru)
     *
     * @param   string      $target_path        Ścieżka usuwanego pliku lub katalogu  
     * @param   stFileManagerFilter $filter     Opcjonalny obiekt filtru (nadpisuje kryteria filtrów ustalonych za pomocą ->filter())  
     * @param   array       lista plików ignorowanych
     */
    public function remove($path, $filter = null, $ignore = null)
    {
        $paths = array();
  
        if (is_array($path))
        {
            $paths = $path;
        }
        elseif (is_dir($path))
        {
            if (is_null($filter))
            {
                $filter = $this->filter();
            }

            $paths = $filter->in(self::fixPath($path));
            $paths[] = $path;
        }
        elseif (is_file($path))
        {
            $paths = array($path);
        }

        rsort($paths);

        foreach ($paths as $path)
        {
            // sprawdz czy mozna usunac plik, czy nie jest on na liscie plikow ignorowanych
            // sprawdz czy mozna usunac plik, czy nie jest on na liscie plikow ignorowanych
            if (! stFileManagerFilter::ignoreFile(self::fixPath($path),$ignore))
            {
                $this->_remove(self::fixPath($path));
            }
        }
    }

    /**
     * Zapisuje dane do pliku
     *
     * @param   string      $filename           Scieżka zapisywanego pliku 
     * @param   mixed       $data               Dane do zapisania
     * @param   bool        $append             Jeśli plik istnieje dopisuj do niego dane zamiast je nadpisywać  
     * @param   integer     $perm               Domyślne prawa dla zapisywanego pliku (w przypadku podania null brane są prawa domyślne)  
     * @return  bool        W przypadku powodzenia zwraca ilość zapisanych bajtów w innym wypadku zwraca FALSE  
     */
    public function fileWrite($filename, $data, $append = false, $perm = null)
    {
        $bytes = @file_put_contents($filename, $data, $append ? FILE_APPEND : null);

        if ($bytes)
        {
            $this->chmod($filename, $perm);
        }

        return $bytes;
    }

    /**
     * Odczytuje plik
     *
     * @param   string      $filename           Scieżka odczytywanego pliku 
     * @param   bool        $read_as_array      Odczytaj w formie tablicy (działa identycznie jak file z włączoną flagą FILE_IGNORE_NEW_LINES)  
     * @return  mixed       Odczytane dane
     */
    public function fileRead($filename, $read_as_array)
    {
        if ($read_as_array)
        {
            return @file($filename, FILE_IGNORE_NEW_LINES);
        }

        return @file_get_contents($filename);
    }

    /**
     * Zwraca instancję filtru
     *
     * @return   stFileManagerFilter
     */
    public function filter()
    {
        if (is_null($this->filter))
        {
            $this->filter = new stFileManagerFilter('any');
        }

        return $this->filter;
    }

    /**
     * Ustawia domyslne uprawnienia dla plików i katalogów wykorzystywane podczas operacji tworzenia, zapisywania, przenoszenia itp.
     *
     * @param   integer     $file               Ustawia prawa dla plików (w przypadku podania null brane są poprzednio ustawione prawa)  
     * @param   integer     $dir                Ustawia prawa dla katalogów (w przypadku podania null brane są poprzednio ustawione prawa)  
     */
    public function setPermissions($file = null, $dir = null)
    {
        if ($file)
        {
            $this->perm['file'] = $file;
        }

        if ($dir)
        {
            $this->perm['dir'] = $dir;
        }
    }

    /**
     * Ustala uprawnienia dla plików lub katalogów
     *
     * @param   string      $filename           Ścieżka do pliku lub katalogu  
     * @param   integer     $perm               Prawa (w przypadku podania null brane są prawa domyślne)  
     */
    public function chmod($filename, $perm = null)
    {
        if (is_null($perm))
        {
            $perm = is_dir($filename) ? $this->perm['dir'] : $this->perm['file'];
        }

        return chmod($filename, $perm);
    }

    /**
     * Sprawdza synchronizację pliku źródłowego z plikiem docelowym
     *
     * @param   string      $origin_file        Ścieżka pliku źródłowego  
     * @param   string      $target_file        Ścieżka pliku docelowego  
     * @return   bool
     */
    protected function isSync($origin_file, $target_file)
    {
        $is_sync = false;

        if (file_exists($target_file))
        {
            $stat_target = stat($target_file);

            $stat_origin = stat($origin_file);

            $is_sync = ($stat_origin['mtime'] > $stat_target['mtime']) ? false : true;
        }

        return $is_sync;
    }

    /**
     * Zwraca scieżke relatywną dla podanego pliku
     *
     * @param   string      $origin_file        Ścieżka do pliku  
     * @param   string      $origin_root        Ścieżka od której ma zostać utworzona ścieżka relatywna dla pliku  
     * @return  string      scieżka relatywna 
     */
    protected function computeRelativePath($origin_file, $origin_root)
    {
        if (stripos($origin_file, $origin_root) !== 0)
        {
            throw new Exception(sprintf("File: '%s' must be within the origin root path '%s'", $origin_file, $origin_root));
        }

        return substr($origin_file, strlen($origin_root));
    }

    /**
     * Zamienia ścieżkę katalogu źródłowego na nazwę pliku synchronizacji
     *
     * @param   string      $path               ścieżka do katalogu źródłowego  
     * @return  string      nazwa pliku synchronizacji
     */
    public static function computeSyncNameFromPath($path)
    {
        return urlencode($path) . '.sync';
    }

    /**
     * Zamienia nazwę pliku synchronizacji na ścieżkę katalogu źródłowego
     *
     * @param   string      $sync_name          Nazwa pliku lub pełna scieżka  
     * @return  string      ścieżka do katalogu źródłowego  
     */
    public static function computePathFromSyncName($sync_name)
    {
        return urldecode(basename($sync_name, '.sync'));
    }

    /**
     * Naprawia ścieżke do katalogu lub pliku
     * Zamienia separator katalogów na prawidłowy DIRECTORY_SEPARATOR i usuwa ostatni separator w przypadku scieżki do katalogu
     *
     * @param        string      $path
     * @return   unknown
     */
    public static function fixPath($path)
    {
        $path = strtr($path, '\\', DIRECTORY_SEPARATOR);
        $path = strtr($path, '/', DIRECTORY_SEPARATOR);
        return rtrim($path, DIRECTORY_SEPARATOR);
    }

}

/**
 * Wrapper klasy stFinder dla stBaseFileManager
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @verison $Id: stBaseFileManager.class.php 3782 2010-03-05 13:39:42Z marek $
 *
 * @package     stInstallerPlugin
 * @subpackage  libs
 */
class stFileManagerFilter
{
    /**
     * Instancja obiektu stFinder
     * @var stFinder
     */
    protected $finder;

    public function __construct($type = 'file')
    {
        $this->finder = stFinder::create($type);
    }

    /**
     * Ustawia maksymalny poziom zagłębienia
     *
     * @param   integer     level               Pozion zagłębienia  
     * @return   stFileManagerFilter
     */
    public function maxdepth($level)
    {
        $this->finder->maxdepth($level);

        return $this;
    }

    /**
     * Ustawia minimalny poziom zagłębienia od którego będą zwracane wyniki.
     *
     * @param   integer     level               Pozion zagłębienia  
     * @return   stFileManagerFiltert
     */
    public function mindepth($level)
    {
        $this->finder->mindepth($level);

        return $this;
    }

    /**
     * Dodaje kryteria filtrowania plików (tylko pasujące pliki)
     * $file_manager_filter->name('*.php') <- tylko pliki o rozszerzeniu .php
     * $file_manager_filter->name('*test.php') <- tylko pliki ktorych nazwa kończy się na test.php
     * $file_manager_filter->name('test.php') <- tylko pliki o nazwie test.php
     *
     * @param   list        Lista               parametrów lub prosty string 
     * @return   stFileManagerFilter
     */
    public function name()
    {
        $args = func_get_args();

        call_user_func_array(array($this->finder, 'name'), $args);

        return $this;
    }

    /**
     * Odrzuca katalogi o podanych nazwach
     *
     * @param   list        Lista               parametrów lub prosty string 
     * @return   stFileManagerFilter
     */
    public function discard()
    {
        $args = func_get_args();

        call_user_func_array(array($this->finder, 'discard'), $args);

        return $this;
    }

    /**
     * Dodaje kryteria filtrowania nazw katalogów (blokuje dalsze wyszkuwanie w podanych katalogach)
     *
     * @param   list        Lista               parametrów lub prosty string 
     * @return   stFileManagerFilter
     */
    public function prune()
    {
        $args = func_get_args();

        call_user_func_array(array($this->finder, 'prune'), $args);

        return $this;
    }

    /**
     * Dodaje kryteria filtrowania plików (odrzuca pasujące pliki)
     *
     * @see ->name()
     * @param   list        Lista               parametrów lub prosty string 
     * @return   stFileManagerFilter
     */
    public function not_name()
    {
        $args = func_get_args();

        call_user_func_array(array($this->finder, 'not_name'), $args);

        return $this;
    }

    /**
     * Ignoruj katalogi podlegające kontroli wersji (.svn, CVS itp) 
     *
     * @return   stFileManagerFilter
     */
    public function ignore_version_control()
    {
        $this->finder->ignore_version_control();

        return $this;
    }

    /**
     * Zwraca listę plików lib katalogów spełniających ustalone kryteria filtrowania
     *
     * @param   Lista       katalogów          zawierających pliki  
     */
    public function in()
    {
        return $this->finder->in(func_get_args());
    }

    /**
     * Filtruje listę wyszukanych plików wg wyrażeń regularnych.
     * Filtr dotyczy nazwy i ścieżki do pliku.
     *
     * @param   array       $files   Lista              plikow.
     * @param   string      $disereg Wyrażenie          regularne określające, które pliki będą pomijane.  
     * @return  array       Lista plików. 
     */
    static public function diseregFilter($files, $disereg)
    {
        if (empty($disereg))
        return $files;
        $d = array();
        foreach ($files as $file)
        {
            if (strpos($file, $disereg) === false)     // poprawka synchronizacji dla Windows (michal.prochowski@sote.pl)
            $d[] = $file;
        }
        return $d;
    }

    /**
     * Sprawdza czy dany plik można skopiować.
     * Jeśli plik jest oznaczony jako ignoroany to przy synchronizacji jeśli taki plik istnieje, to nie jest nadrgywany.
     *
     * @param   array       $files    Lista  plikow.
     * @param   array       $ignore   Wyrażenia  regularne określające, które pliki będą pomijane.  array('ereg'=>(ignore|discard)) 
     *                                ignore - plik pomijany w aktualizacji, discard - zawsze
     * @return  bool        true - plik jest ignorowany, false w p.w.
     */
     static public function ignoreFile($file, $ignores) {
        if ($ignores) 
            foreach ($ignores as $ignore)
                if (strpos($file, $ignore) !== false) 
                    if ((is_file($file)) && (file_exists($file))) {
                        echo '[~ skip] $file'."\n";
                        return true;
                    }

        return false;
    }

    public static function replaceFile($sourcefile, $targetFile)
    {
        if (file_exists($targetFile) && is_file($targetFile))
        {
            list($shopPath, $filePath) = explode('install/src/', $sourcefile, 2);
            list($appName) = explode('/', $filePath, 2);

            $file = str_replace($shopPath, '', $targetFile);

            foreach (stInstallerIgnore::getIgnoreReplace($appName) as $pattern)
            {
                if (preg_match($pattern, $file))
                {
                    $regFiles = self::loadLastRegFilelist($appName);

                    if (!empty($regFiles))
                    {
                        foreach($regFiles as $regFile => $regData)
                        {
                            if (str_replace($appName.'/'.$appName.'/', $appName.'/', $filePath) == $regFile)
                            {
                                if ($regData['md5sum'] != md5_file($targetFile)) return false;
                            }
                        }
                    }
                }
            }
        }
        
        return true;
    }

    static private $loadedLastRegApplication = null;
    static private $loadedLastRegFilelist = array();

    public static function loadLastRegFilelist($appName)
    {
        if (self::$loadedLastRegApplication == $appName) return self::$loadedLastRegFilelist;
        else {
            self::$loadedLastRegApplication = $appName;
            self::$loadedLastRegFilelist = array();

            $file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.md5sum'.DIRECTORY_SEPARATOR.strtolower($appName).'.reg';
            if(file_exists($file))
            {
                $data = unserialize(file_get_contents($file));
                if (isset($data['filelist']))
                {
                    self::$loadedLastRegFilelist = $data['filelist'];
                    unset($data);
                }
            }
            return self::$loadedLastRegFilelist;
        }
    }
}