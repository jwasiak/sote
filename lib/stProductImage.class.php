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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductImage.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Klasa stProductImage
 *
 * @package     stProduct
 * @subpackage  libs
 */
class stProductImage
{
    /** 
     * zmienna $photos
     * @var array
     */
    private $photos;
    
    /** 
     * zmienna $main
     * @var string
     */
    private $main;
    
    /** 
     * zmienna $images
     * @var array
     */
    private $images;
    
    /** 
     * zmienna $image
     * @var string
     */
    private $image;
    
    /** 
     * zmienna $product
     * @var object
     */
    private $product;
    
    /** 
     * Zdjęcia produktu
     *
     * @param        object      $product
     * @return   array
     */
    public static function get_product_images($product)
    {
        $dir = $product->getImage();
        return sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$dir);
    }
    
    /** 
     * Główne zdjęcie do produktu
     *
     * @param        object      $product
     * @return   string
     */
    public static function get_main_product_image($product)
    {
        $dir = $product->getImage();
        if (!file_exists('uploads/products/'.$dir.'/.info'))
        {
            $photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$dir);
            if (!$photos)
            {
                return false;
            }
            $file = new stSerialize('uploads/products/'.$dir.'/.info');
            $file->set('main_photo', $photos[0]);
            $file->save();
        }
        $file = new stSerialize('uploads/products/'.$dir.'/.info');
        $main = $file->get('main_photo');
        $photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/products/'.$dir);    
        return $main;
        
    }
    
    /** 
     * Zmiana głównego zdjecia produktu
     *
     * @param        string      $old_image
     * @param        string      $new_image
     * @param        string      $dir
     */
    public static function change_main_image($old_image, $new_image, $dir)
    {
        $dir = 'uploads/products/'.$dir.'/';
        $file = new stSerialize($dir);
        $file->saveFile($old_image);
    }
    
    /** 
     * Usunięcie pliku zdjęcia produktu
     *
     * @param        string      $file
     * @param        string      $dir
     */
    public static function delete_file($file, $dir)
    {
        $photos = sfFinder::type('file')->name('*.jpg')->maxdepth(0)->relative()->in('uploads/thumbnails/uploads/products/'.$dir);    
        foreach ($photos as $photo)
        {
            unlink('uploads/thumbnails/uploads/products/'.$dir.'/'.$photo);
        }
        $dir = 'uploads/products/'.$dir.'/';
        unlink($dir.$file);
    }
}