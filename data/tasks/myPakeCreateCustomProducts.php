<?php
/** 
 * SOTESHOP/stProduct 
 * 
 * Ten plik należy do aplikacji stProduct opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProduct
 * @subpackage  tasks
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: myPakeCreateCustomProducts.php 617 2009-04-09 13:02:31Z michal $
 */

pake_desc('(SOTE) create custom products');
pake_task('create-custom-products', 'project_exists');

/** 
 * Tworzy przykładowe produkty
 *
 * @param      pakeTask    $task
 * @param         array       $args
 */
function run_create_custom_products($task, $args)
{
    if (!empty($args[0]))
    {
        // define constants
        define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
        define('SF_APP',         'backend');
        define('SF_ENVIRONMENT', 'prod');
        define('SF_DEBUG',       true);

        // get configuration
        require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
        
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        
        $product = ProductPeer::doCount(new Criteria());

        for ($i = $product+1; $i < $product+1+$args[0]; $i++)
        {
            $obj = new Product();
            $obj->setCode("generated_product_".$i);
            $obj->setProducerId(1);
            $obj->setName("Produkt numer $i");
            $obj->setPrice(rand(1,30000));
            $obj->setVat(22);
            $obj->setActive(1);
            $obj->setShortDescription("Przykładowy skrócony opis produktu numer $i.");
            $obj->setDescription("<p>Przykładowy opis produktu numer $i.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>");
            $obj->save();
            $productId = $obj->getId();
            
            $obj = new ProductHasCategory();
            $obj->setCategoryId(2);
            $obj->setProductId($productId);
            $obj->save();
        }
    } else {
        throw new Exception('Run: ./symfony create-custom-products 1000');
    }
}










