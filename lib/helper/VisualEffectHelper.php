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
 * @version     $Id: VisualEffectHelper.php 7 2009-08-24 08:59:30Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

use_helper('Javascript');

/** 
 * Returns HTML for blind control
 *
 * @param   string      $effect             effect name values (blink, slide, fade, shrink)
 * @param   string      $element_id         id of HTML element
 * @param   array       $content            the content of the control to be displayed after hide or show event array('afterHide'=>'content', 'afterShow'=>'content')
 * @return   HTML
 */
function visual_effect_control($effect,$element_id, $content = array()) 
{
    $control_id="control_$element_id";
    
    $content_hide=$content['afterHide'];
    
    $content_show=$content['afterShow'];
    
    $queue="{scope: '$element_id', limit:1}";
    
    if ($effect=='fade') 
    {
       $effect_up_name=$effect;
       $effect_down_name='appear';
    } 
    elseif ($effect=='shrink') 
    {
       $effect_up_name=$effect;
       $effect_down_name='grow';  
    } 
    else
    {
       $effect_up_name=$effect.'_up';
       $effect_down_name=$effect.'_down';   
    }
    
    $effect_up=visual_effect($effect_up_name, $element_id, array('duration'=> '0.2','queue'=>$queue,'afterFinish'=>"function() { \$('$control_id').innerHTML='$content_show'; $('$control_id').blind_down=false }"));
    
    $effect_down=visual_effect($effect_down_name, $element_id, array('duration'=> '0.2','queue'=>$queue,'afterFinish'=>"function() { \$('$control_id').innerHTML='$content_hide'; $('$control_id').blind_down=true }"));
    
    if (isset($content['hidden']) && $content['hidden'])
    {
        $js_script="if (this.blind_down) { $effect_up; } else { $effect_down; }";
        $content_hide = $content_show;
    }
    else
    {
        $js_script="if (this.blind_down) { $effect_down; } else { $effect_up; }";
    }
    
    return link_to_function($content_hide,$js_script,array('id'=>$control_id));
}

?>