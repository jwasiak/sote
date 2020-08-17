<?php
/**
 * Ładowanie fixtures
 *
 * @author Michal Prochowski <michal.prochowski@sote.pl>
 */

 
try
{ 
 
if (version_compare($version_old, '1.0.4.46', '='))
{
    touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductUpdate.log');
    touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_CategoryUpdate.log');
    touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_ProductGroupUpdate.log');
    touch(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'stPositioning_WebpageUpdate.log');
}

if (version_compare($version_old, '1.0.4', '<'))
{
    /*
     * Aktualizacja pliku robots.txt
     */
    $lines = file(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt');
    foreach ($lines as $key=>$line) {
        $rule = explode(":",$line,2);
        if (count($rule)<2 || strlen(trim($rule[1]))==0) {
            unset($lines[$key]);
        } else {
            $lines[$key] = str_replace(array("\n","\r"),array("",""), $line);
        }
         
    }
    $lines[] = 'Disallow: /user';
    $lines[] = 'Disallow: /basket';
    $lines[] = 'Disallow: /search';
    $lines[] = 'Disallow: /recommend_shop';
    $lines[] = 'Disallow: /newsletter';
    $lines[] = 'Disallow: /currency';
    $lines[] = 'Disallow: /productsCompare';
    $lines[] = 'Disallow: /product_options';
    $lines[] = 'Disallow: /stNavigationFrontend';
    $lines[] = 'Disallow: /producer';
    $lines[] = 'Disallow: /navigation';
    $lines[] = '';
    $robots = implode("\n",$lines);

    file_put_contents(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt', $robots);

    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stInstallerTaks.onClose', array('stUpdatePositioningPlugin', 'postInstall'));
}

$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

$positioningCount = PositioningPeer::doCount(new Criteria());

if ($positioningCount == 0)
{

    $context = sfContext::getInstance();
    $config = stConfig::getInstance($context, 'stPositioningBackend');
    $config->set('show_payment_table', 0);
    $config->load();

    /**
     * Wartości domyślne
     */
    $object = new Positioning();
    $object->setCulture('pl_PL');
    $object->setName('Wartości domyślne');
    $object->setSystemName('DEFAULT_VALUE');
    $object->setTitle('Sklep internetowy');
    $object->setKeywords('soteshop, sklepy internetowe, sklepinternetowy, oprogramowanie, sklepów internetowych, sklepy oprogramowanie, sklep, sklepy, funkcjonalność sklepu, sklepu internetowego, dokumentacja, sklepu, demo sklepu, sklepów, internetowych');
    $object->setDescription('Program SOTESHOP to profesjonalne oprogramowanie obsługujące sklep internetowy. Najwięcej wdrożeń w Polsce. Bogata funkcjonalność. Indywidualny wygląd. SOTE - sklepy internetowe');

    /**
     * Zaladowanie starych wartosci
     */
    if (strlen($config->get('title'))) $object->setKeywords(substr($config->get('title'),0,255));
    if (strlen($config->get('keywords'))) $object->setKeywords(substr($config->get('keywords'),0,255));
    if (strlen($config->get('description'))) $object->setDescription(substr($config->get('description'),0,255));

    $object->save();
    $object->setCulture('en_US');
    $object->setType(0);
    $object->save();
}

if (version_compare($version_old, '1.0.5.1', '<'))
{
    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stInstallerTaks.onClose', array('stUpdatePositioningPlugin', 'postInstallProducer'));
}


if (version_compare($version_old, '2.0.0.4', '<'))
{
    /*
     * Aktualizacja pliku robots.txt
     */
    $lines = file(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt');
    foreach ($lines as $key=>$line) {
        $rule = explode(":",$line,2);
        if (count($rule)<2 || strlen(trim($rule[1]))==0) {
            unset($lines[$key]);
        } else {
            $lines[$key] = str_replace(array("\n","\r"),array("",""), $line);
        }
         
    }
    $lines[] = 'Disallow: /invoice';
    $lines[] = 'Disallow: /order';
    $lines[] = 'Disallow: /invoicePdf/*';
    $lines[] = 'Disallow: /orderPdf/*';
    
    $lines[] = '';
    $robots = implode("\n",$lines);

    file_put_contents(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt', $robots);

}

if (version_compare($version_old, '2.1.0.7', '<='))
{
    /*
     * Aktualizacja pliku robots.txt
     */
    $lines = file(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt');
    foreach ($lines as $key=>$line) {
        $rule = explode(":",$line,2);
        if (count($rule)<2 || strlen(trim($rule[1]))==0) {
            unset($lines[$key]);
        } else {
            $lines[$key] = str_replace(array("\n","\r"),array("",""), $line);
        }
         
    }
    $lines[] = 'Disallow: /stAvailabilityFrontend/showAddOverlay';
    $lines[] = 'Disallow: /stQuestionFrontend/showAddOverlay';    
    $lines[] = '';
    $robots = implode("\n",$lines);

    file_put_contents(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt', $robots);

}

if (version_compare($version_old, '7.0.0.121', '<='))
{
    /*
     * Aktualizacja pliku robots.txt
     */
    $lines = file(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt');
    foreach ($lines as $key=>$line) {
        $rule = explode(":",$line,2);
        if (count($rule)<2 || strlen(trim($rule[1]))==0) {
            unset($lines[$key]);
        } else {
            $lines[$key] = str_replace(array("\n","\r"),array("",""), $line);
        }
         
    }
    $lines[] = 'Disallow: /*.php$'; 
    $lines[] = '';
    $robots = implode("\n",$lines);

    file_put_contents(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt', $robots);

}

}
catch (Exception $e)
{
   
}

try {
    if (version_compare($version_old, '7.2.0.0', '<=')) {
        $file = sfConfig::get('sf_web_dir').'/robots.orig';
        if (file_exists($file))
            @unlink($file);
    }
} catch (Exception $e) {
    // @todo: log $e->getMessage();
}

try {
    if (version_compare($version_old, '7.2.0.1', '<=')) {
        $lines = file(sfConfig::get('sf_web_dir').'/robots.txt');

        foreach ($lines as $key=>$line) {
            $rule = explode(":",$line,2);
            if (count($rule)<2 || strlen(trim($rule[1]))==0) {
                unset($lines[$key]);
            } else {
                $lines[$key] = str_replace(array("\n","\r"),array("",""), $line);
            }
        }

        $lines[] = 'Disallow: /paypal';
        $lines[] = '';

        file_put_contents(sfConfig::get('sf_web_dir').'/robots.txt', implode("\n", $lines));
    }
} catch (Exception $e) {
    // @todo: log $e->getMessage();
}

try {
if (version_compare($version_old, '7.2.0.6', '<='))
{
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $positioning = PositioningPeer::doSelectDefaultValues();
        if ($positioning)
        {
            $positioning->setTitleProduct("{NAME}");
            $positioning->setTitleCategory("{NAME}");
            $positioning->setTitleManufacteur("{NAME}");
            $positioning->setTitleBlog("{NAME}");
            $positioning->setTitleProductGroup("{NAME}");
            $positioning->setTitleWebpage("{NAME}");
            $positioning->save();
        }
}
} catch (Exception $e) {
    // @todo: log $e->getMessage();
}
