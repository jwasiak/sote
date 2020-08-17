<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stImageSizeHelper.php 7 2009-08-24 08:59:30Z michal $
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Zwraca html potrzebny do wyświetlenia asseta
 *
 * @param   string      $path               względna ścieżka do asseta (zwykle rozpoczyna się w katalogu media) 
 * @param       integer     $width
 * @param       integer     $height
 * @param          bool        $allow_watermark
 * @param          bool        $centered
 * @return   string
 */
function st_product_photo($path, $width, $height, $link = '', $allow_watermark = false, $centered = false, $popup = false)
{
    $file = "/uploads/products/empty_photo.png";
    if (!empty($path))
    {
        if (file_exists(sfConfig::get('sf_web_dir') .$path))
        {
            $file = $path;
        }
    }
    $full_path = sfConfig::get('sf_web_dir') . $file;
    $dimensions = getimagesize($full_path);
    $dimensions[0] += 20;
    $dimensions[1] += 30;
    if($popup)
    {
        $popup_link = "'onclick'=>'javascript:window.open('".$full_path."','', 'width=".$dimensions[0].",height=".$dimensions[1].",scrollbars=yes')'";
    }
    else 
    {
        $popup_link='';
    }
    
    if (is_file($full_path) && is_readable($full_path))
    {
        $image = st_thumbnail_path($file, $width, $height, 90, $allow_watermark);
        
        $marginTop = 0;
        
        if ($centered)
        {
            $dimensions = getimagesize(sfConfig::get("sf_web_dir").$image);
        
            $marginTop = ($height - $dimensions[1]) / 2;
        }
        if($link!='')
        {
            return content_tag('div', link_to(image_tag($image), $link), array('style'=>'margin: auto;cursor: pointer;width:' . $width . 'px; height:' . $height . 'px;text-align:center', $popup_link));
        }
        else 
        {
            return content_tag('div', image_tag($image, array("style" => "margin-top: $marginTop"."px")), 'style=margin: auto;width:' . $width . 'px; height:' . $height . 'px;text-align:center', $popup_link);
        }
    } 
    else
    {
        $file = "/uploads/products/empty_photo.png";
        
        $empty_file_full_path = sfConfig::get('sf_web_dir') . $file;
        
        if (is_file($empty_file_full_path) && is_readable($empty_file_full_path))
        {
            $image = st_thumbnail_path($file, $width, $height, 90, $allow_watermark);
            
            $marginTop = 0;
        
            if ($centered)
            {
                $dimensions = getimagesize(sfConfig::get("sf_web_dir").$image);
            
                $marginTop = ($height - $dimensions[1]) / 2;
            }
        
            if($link!='')
            {
                return content_tag('div', link_to(image_tag($image), $link), array('style'=>'margin: auto;cursor: pointer;width:' . $width . 'px; height:' . $height . 'px;text-align:center', $popup_link));
            }
            else 
            {
                return content_tag('div', image_tag($image, array("style" => "margin-top: $marginTop"."px")), 'style=margin: auto;width:' . $width . 'px; height:' . $height . 'px;text-align:center', $popup_link);
            }
        }
        else 
        {
            
            return;
        }
    }
}

     
/** 
 *  Zwraca ścieżkę do zdjęcia/obrazka.
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param        string      $source
 * @param       integer     $width
 * @param       integer     $height
 * @param       integer     $quality
 * @param          bool        $allow_watermark
 * @param          bool        $absolute
 * @return  string      ścieżka do zdjęcia/obrazka 
 * @todo   zweryfikować i dodać pełniejszy opis phpdoc
 */
function st_thumbnail_path($source, $width, $height, $quality = 75, $allow_watermark = false, $absolute = false)
{
    static $config = null;
    $thumbnails_dir = sfConfig::get('app_sfThumbnail_thumbnails_dir', 'uploads/thumbnails');
    
    $width = intval($width);
    $height = intval($height);
    
    if (substr($source, 0, 1) == '/')
    {
        $realpath = sfConfig::get('sf_web_dir') . $source;
    } else
    {
        $realpath = sfConfig::get('sf_web_dir') . '/images/' . $source;
    }
    
    $real_dir = dirname($realpath);
    $thumb_dir = '/' . $thumbnails_dir . substr($real_dir, strlen(sfConfig::get('sf_web_dir')));
    $thumb_name = preg_replace('/^(.*?)(\..+)?$/', '$1_' . $width . 'x' . $height . '$2', basename($source));
    
    $img_from = $realpath;
    $thumb = $thumb_dir . '/' . $thumb_name;
    $img_to = sfConfig::get('sf_web_dir') . $thumb;
    
    if (! is_dir(dirname($img_to)))
    {
        if (! mkdir(dirname($img_to), 0777, true))
        {
            throw new Exception('Cannot create directory for thumbnail : ' . $img_to);
        }
    }
    
    if (! is_file($img_to) || filemtime($img_from) > filemtime($img_to) || filemtime(sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'stProduct.yml') > filemtime($img_to))
    {
        $thumbnail = new stThumbnail($width, $height, true, true, $quality);
        if ($allow_watermark)
        {
            if (is_null($config))
            {
                $config = stConfig::getInstance(sfContext::getInstance(), array('watermark_on' => stConfig::BOOL, 'watermark_text' => stConfig::STRING, 'watermark_transparency' => stConfig::STRING), 'stProduct');
                $config->load();
            }
            if ($config->get('watermark_on'))
            {
           
                $thumbnail->setWatermarkText($config->get('watermark_text'), 48, stThumbnail::WATERMARK_DIAGONAL_DOWN, '#eee', $config->get('watermark_transparency'));
            }
        
        }
        $thumbnail->loadFile($img_from);
        $thumbnail->save($img_to);
    }
    
    return image_path($thumb, $absolute);
}
/** 
 * Zwraca html potrzebny do wyświetlenia asseta z linkiem
 *
 * @param   string      $path               względna ścieżka do asseta (zwykle rozpoczyna się w katalogu media) 
 * @param       integer     $width
 * @param       integer     $height
 * @param        string      $link
 * @param          bool        $allow_watermark
 * @return   string
 */
function st_photo_link_onclick($path, $width, $height, $link_onclick = '', $allow_watermark = false)
{
    if (! empty($path))
    {
        $file = $path;
    }
    else 
    {
        $file = "/uploads/products/empty_photo.png";
    }
    
    $full_path = sfConfig::get('sf_web_dir') . $file;

    if (is_file($full_path) && is_readable($full_path))
    {
        $image = st_thumbnail_path($file, 240, $height, 90, $allow_watermark);
        
        return content_tag('div', image_tag($image), array("onclick" => $link_onclick) );
    } 
    else
    {
       $file = "/uploads/products/empty_photo.png";
        
        $empty_file_full_path = sfConfig::get('sf_web_dir') . $file;
        
        if (is_file($empty_file_full_path) && is_readable($empty_file_full_path))
        {
            $image = st_thumbnail_path($file,240, $height, 90, $allow_watermark);
        
            return content_tag('div', link_to(image_tag($image), $link), 'style=cursor: pointer;margin: auto;width:' . $width . 'px; height:' . $height . 'px;');
        }
        else 
        {
            
            return;
        }
    }
}