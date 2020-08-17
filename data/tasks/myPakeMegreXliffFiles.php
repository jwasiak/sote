<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: myPakeMegreXliffFiles.php 4830 2010-05-04 15:10:37Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

pake_desc('(SOTE) merge Xliff files');
pake_task('xliff-merge-files', 'project_exists');

pake_desc('(SOTE) merge Xliff files and clear tagret');
pake_task('xliff-merge-clear-files', 'project_exists');

pake_desc('(SOTE) split Xliff files');
pake_task('xliff-split-files', 'project_exists');

pake_desc('(SOTE) delete user Xliff files');
pake_task('xliff-delete-user-files', 'project_exists');

define("HEADER", "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff version=\"1.0\">\n\t<file orginal=\"%s\" source-language=\"%s\" target-language=\"%s\" datatype=\"plaintext\" date=\"%s\">\n\t\t<body>\n");
define("BODY","\t\t\t<trans-unit id=\"%s\">\n\t\t\t\t<source>%s</source>\n\t\t\t\t<target>%s</target>\n\t\t\t</trans-unit>\n");
define("FOOTER","\t\t</body>\n\t</file>\n</xliff>");

/**
 * Włączenie przekazywania błędów podczas parsowania plików xml
 */
libxml_use_internal_errors(true);

/**
 * Łączy pliki z tłumaczeniami.
 *
 * @param $task
 * @param $args
 */
function run_xliff_merge_files($task, $args)
{
    if (!$args[1])
    {
        throw new Exception('example: ./symfony xliff-merge-files frontend en');
    }

    $application = $args[0];
    $language = $args[1];

    $xliffDirectory = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.$application.DIRECTORY_SEPARATOR.'i18n';
    $files = stFinder::type('file')->name('*'.$language.'.xml')->discard('.svn', 'messages.shop.'.$language.'.xml', '*.user.'.$language.'.xml')->in($xliffDirectory);

    if ($application == 'frontend') {
        if ($language == 'en') $languageBackend = 'cs'; else $languageBackend = $language;
        $filesBackend = array(sfConfig::get('sf_root_dir').'/apps/backend/i18n/stOrder.'.$languageBackend.'.xml');
        $files = array_merge($files, $filesBackend);
    }

    $data = array();
    foreach($files as $file)
    {
        $lang = simplexml_load_file($file);
        if (!$lang)
        {
            $errors = libxml_get_errors();
            if ($errors) throw new Exception('Parsing errors');
        }

        $attr = $lang->file->attributes();
            
        $i = 1;
        $key = pathinfo($file,PATHINFO_BASENAME);
        $key = substr($key,0,strpos($key,'.'));

        $langBackend = false;
        if ($application == 'frontend') {
            if (preg_match('/\/backend\//', $file)) {
                $key = $key.'Backend';

                if ($language == 'en') {
                    $langBackend = simplexml_load_file(preg_replace('/\.cs\./', '.'.$language.'.', $file));
                    if (!$langBackend) {
                        if (libxml_get_errors()) throw new Exception('Parsing errors');
                    }
                }
            }
        }

        foreach($lang->file->body->{"trans-unit"} as $item) {
            $data[$key][$i]['source'] = (string)$item->source;
            $data[$key][$i]['target'] = (string)$item->target;

            if ($langBackend) {
                $data[$key][$i]['target'] = '';
                $j = 1;
                foreach($langBackend->file->body->{"trans-unit"} as $itemBackend) {
                    if ((string)$itemBackend->source == (string)$item->source) {
                        $data[$key][$i]['target'] = (string)$itemBackend->target;
                    }
                    $j++;
                }
            }
            $i++;
        }
    }

    $fileName = $xliffDirectory.DIRECTORY_SEPARATOR.'messages.shop.'.$language.'.xml';

    $fh = fopen($fileName, 'w');
    fwrite($fh, sprintf(HEADER, $attr['orginal'], $attr['source-language'], $attr['target-language'], date("Y-m-d\Th:i:s\Z")));

    foreach ($data as $langFile => $fileData)
    {
        foreach ($fileData as $key=>$value) {
            fwrite($fh, sprintf(BODY, ($langFile."_".$key), $value['source'], $value['target']));
        }
    }

    fwrite($fh,sprintf(FOOTER));
    fclose($fh);
}

/**
 * Łączy pliki z tłumaczeniami i usuwa tłumaczenia.
 *
 * @param $task
 * @param $args
 */
function run_xliff_merge_clear_files($task, $args)
{
    if (!$args[1])
    {
        throw new Exception('example: ./symfony xliff-merge-clear-files frontend en');
    }

    $application = $args[0];
    $language = $args[1];

    $xliffDirectory = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.$application.DIRECTORY_SEPARATOR.'i18n';
    $files = stFinder::type('file')->name('*.en.xml')->discard('.svn', 'messages.shop.*.xml', '*.user.*.xml')->in($xliffDirectory);

    if ($application == 'frontend') {
        if (in_array($language, array('en', 'pl'))) $languageBackend = 'cs'; else $languageBackend = $language;
        $filesBackend = array(sfConfig::get('sf_root_dir').'/apps/backend/i18n/stOrder.'.$languageBackend.'.xml');
        $files = array_merge($files, $filesBackend);
    }

    $data = array();
    foreach($files as $file)
    {
        $lang = simplexml_load_file($file);
        if (!$lang)
        {
            $errors = libxml_get_errors();
            if ($errors) throw new Exception('Parsing errors');
        }

        $attr = $lang->file->attributes();
            
        $i = 1;
        $key = pathinfo($file,PATHINFO_BASENAME);
        $key = substr($key,0,strpos($key,'.'));

        if ($application == 'frontend') {
            if (preg_match('/\/backend\//', $file)) {
                $key = $key.'Backend';
            }
        }

        foreach($lang->file->body->{"trans-unit"} as $item) {
            $data[$key][$i]['source'] = (string)$item->source;
            $data[$key][$i]['target'] = '';
            $i++;
        }
    }

    $fileName = $xliffDirectory.DIRECTORY_SEPARATOR.'messages.shop.'.$language.'.xml';

    $fh = fopen($fileName, 'w');
    fwrite($fh, sprintf(HEADER, $attr['orginal'], $attr['source-language'], $language, date("Y-m-d\Th:i:s\Z")));

    foreach ($data as $langFile => $fileData)
    {
        foreach ($fileData as $key=>$value) {
            fwrite($fh, sprintf(BODY, ($langFile."_".$key), $value['source'], $value['target']));
        }
    }

    fwrite($fh,sprintf(FOOTER));
    fclose($fh);
}

/**
 * Dzieli plik definicji na moduły.
 *
 * @param $task
 * @param $args
 */
function run_xliff_split_files($task, $args)
{
    if (!$args[1])
    {
        throw new Exception('example: ./symfony xliff-merge-files frontend en');
    }

    $application = $args[0];
    $language = $args[1];

    $xliffDirectory = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.$application.DIRECTORY_SEPARATOR.'i18n';
    $fileName = $xliffDirectory.DIRECTORY_SEPARATOR.'messages.user.'.$language.'.xml';

    if (!is_readable($fileName)) {
        throw new Exception('Can\'t read file '.$fileName);
    }

    $lang = simplexml_load_file($fileName);
    if (!$lang)
    {
        $errors = libxml_get_errors();
        if ($errors) throw new Exception('Parsing error');
    }

    $attr = $lang->file->attributes();

    foreach($lang->file->body->{"trans-unit"} as $item) {
        $key = $item->attributes();

        $file = substr($key['id'],0,stripos($key['id'],'_'));
        $i = substr($key['id'],stripos($key['id'],'_')+1,strlen($key['id']));

        $data[$file][$i]['source'] = (string)$item->source;
        $data[$file][$i]['target'] = (string)$item->target;
        $i++;
    }

    foreach ($data as $langFile=>$fileData) {
        $outputFilename = $xliffDirectory.DIRECTORY_SEPARATOR.$langFile.'.user.'.$language.'.xml';
        if (preg_match('/Backend$/', $langFile)) {
            $outputFilename = sfConfig::get('sf_root_dir').'/apps/backend/i18n/'.preg_replace('/Backend/', '', $langFile).'.user.'.$language.'.xml';
        }

        $fh = fopen($outputFilename, 'w');
        fwrite($fh, sprintf(HEADER, $attr['orginal'], $attr['source-language'], $attr['target-language'], date("Y-m-d\Th:i:s\Z")));

        foreach ($fileData as $key=>$value) {
            fwrite($fh, sprintf(BODY, $key, $value['source'], $value['target']));
        }

        fwrite($fh,sprintf(FOOTER));
        fclose($fh);
    }
}

/**
 * Usuwanie plików definicji językowych.
 *
 * @param $task
 * @param $args
 */
function run_xliff_delete_user_files($task, $args)
{
    if (!$args[1])
    {
        throw new Exception('example: ./symfony xliff-delete-user-files frontend en');
    }

    $application = $args[0];
    $language = $args[1];

    $xliffDirectory = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.$application.DIRECTORY_SEPARATOR.'i18n';
    $files = stFinder::type('file')->name('*.user.'.$language.'.xml')->discard('.svn')->in($xliffDirectory);

    foreach ($files as $file)
    {
        unlink($file);
    }
}