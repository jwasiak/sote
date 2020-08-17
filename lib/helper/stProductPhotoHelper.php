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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductPhotoHelper.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Głowne zdjęcie produktu
 *
 * @param        string      $dir
 * @return   string
 */
function get_main_image($dir)
{
    if (!file_exists('uploads/products/'.$dir.'/.info'))
    {
        $photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$dir);
        if ($photos)
        {
            return $photos[0];
        }
        return false;
    }
    $file = new stSerialize('uploads/products/'.$dir.'/.info');
    $main = $file->get('main_photo');
    $photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$dir);    
    return $main;
}

/** 
 * Zdjęcia produktu
 *
 * @param        object      $product
 * @return   string
 */
function get_image($product)
{
    $image = stProductImage::get_main_product_image($product);
    if ($image)
    {
        return '/uploads/products/'.$product->getImage().'/'.$image;
    }
    
}