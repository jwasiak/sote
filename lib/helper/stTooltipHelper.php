<?php
/*
* This file is part of the symfony package.
* (c) 2006 Dmitry Parnas <parnas@rock.zp.ua>
* (c) 2006 Dustin Whittle <dustin.whittle@symfony-project.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * @package    stBase
 * @author     Dmitry Parnas <parnas@rock.zp.ua>
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @author	   Dave Dash <dave.dash@spindrop.us> 
 * @author     Marcin Butlak <marcin.butlak@sote.pl>
 * @version    SVN: $Id: stTooltipHelper.php 169 2008-09-29 13:06:12Z bartek $
 */
    
use_helper('Javascript');  

$request = sfContext::getInstance()->getResponse();
$request->addJavascript('/js/tooltip/wz_tooltip.js');

/**
 * Załącza biblioteke obsługującą tooltipa.
 */
function include_tooltip() 
{
    echo '<script type="text/javascript">tt_Init();</script>';
}

/**
 * Wyświetla tooltip.
 */
function get_tooltip($keyword='', $type='1', $width='300') 
{
    $content = htmlspecialchars($keyword);

    $content_edit = sfContext::getInstance()->getI18N()->__('Kliknij dwukrotnie aby podmienić obraz.', null, 'stThemeFrontend');
    
    if($type==1)
    {
        $out="onmouseover=\"Tip('$content', WIDTH, $width, SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 0, OFFSETX, -20, CLICKCLOSE, false)\" ";
    }
    if($type==2)
    {
        $out="onmouseover=\"Tip('$content<br /><u>zamknij</u>', WIDTH, $width, SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, OFFSETX, -20, CLICKCLOSE, true)\"";
    }

    if($type==3)
    {
        $out="onmouseover=\"Tip('$content', WIDTH, $width, SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 0, OFFSETX, -140, OFFSETY, -40, CLICKCLOSE, false)\" ";
    }
    
    if($type==4)
    {
        if (SF_ENVIRONMENT == 'edit')
        { 
        $out="onmouseover=\"Tip('$content_edit', WIDTH, 140, SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 0, OFFSETX, 10, OFFSETY, 20, CLICKCLOSE, false)\" ";
        }
    }
    
    return $out;
}


?>