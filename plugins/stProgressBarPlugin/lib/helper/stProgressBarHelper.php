<?php
/** 
 * SOTESHOP/stProgressBarPlugin 
 * 
 * Ten plik należy do aplikacji stProgressBarPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProgressBarPlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stProgressBarHelper.php 10047 2010-12-29 16:32:36Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Obsługa paska postępu
 *
 * @param   string      $name               nazwa paska postępu 
 * @param   string      $className          nazwa klasy, w której znajduję się metoda do wywołania 
 * @param   string      $methodName         nazwa metody, która ma zostać wywołana z numerem kroku jako parametrem 
 * @param   integer     $steps              ilość kroków 
 *
 * @package     stProgressBarPlugin
 * @subpackage  helpers
 */
function progress_bar($name, $className, $methodName, $steps, $params = array())
{
    if (class_exists($className))
    {
        $class = new $className;

        if (is_callable(array($class, $methodName)))
        {
            if (is_int($steps))
            {
                $parameters = array('name' => $name, 'class' => $className, 'method' => $methodName, 'steps' => $steps, 'step' => '0', 'msg'=>'');
                $pbFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'progressBar_'.$name.'.yml';
                file_put_contents($pbFile,sfYaml::dump($parameters));
                if(!isset($params['msg'])) $params['msg'] = '';
                if (function_exists('st_get_component')) return st_get_component('stProgressBar','initProgressBar', $parameters).progress_bar_update($name, 0, $params);
                else return get_component('stProgressBar','initProgressBar', $parameters).progress_bar_update($name, 0, $params);
            } else {
                throw new Exception("Parameter \$steps ($steps) is not integer.");
            }
        } else {
            throw new Exception("Method $methodName in class $className don't exist.");
        }
    } else {
        throw new Exception("Class $className don't exist.");
    }
} 

function progress_bar_error($title, $text)
{
    $tag = content_tag('div',content_tag('h2',$title).content_tag('p',$text,array('style'=>'padding-left: 10px; padding-right: 10px;')),array('class'=>'form-errors', 'style'=>'margin-top: 10px;'));
    
	return str_replace(array("'","\n"), array("\\'","\\n'\n\t+'"), $tag);
}

function progress_bar_update($name, $step, $params) {
	$fixName = str_replace(array('-'),array(''),trim($name));
    $i18n = sfContext::getInstance()->getI18N();
    sfContext::getInstance()->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
    return '<script type="text/javascript">
    					
            function updatePB(url, loops, item, item_msg, alert_msg) {
            if (loops<3) {
                    new Ajax.Request(url, {
                        evalJS: true,
                        method: \'post\',
                        onSuccess: function(transport) {
                            if (transport.responseText.match(\'stPrograssBar-main-div\')!=null)
                            {
                                $(item).update(transport.responseText);
                                if ($(item_msg)) $(item_msg).update(\'\');
                            } else {
                            	if (loops<2) {
                            		if ($(item_msg)) $(item_msg).update(\''.$i18n->__('Wystąpił problem podczas wykonywania operacji, ponowna próba za', null, 'stProgressBar').' \'+((loops+1)*10)+\' '.$i18n->__('sekund', null, 'stProgressBar').'\');
	                          		setTimeout(\'updatePB( "\'+url+\'", \'+(loops+1)+\',"\'+item+\'", "\'+item_msg+\'", "\'+alert_msg+\'")\', (loops+1)*10000);
                          		} else {
                          			updatePB( url, loops+1, item, item_msg, alert_msg);
                          		}
		                    }
                        },
                        onFailure: function(transport) {
                        	if (loops<2) { 
                            	if ($(item_msg)) $(item_msg).update(\''.$i18n->__('Wystąpił problem podczas wykonywania operacji, ponowna próba za', null, 'stProgressBar').' \'+((loops+1)*10)+\' '.$i18n->__('sekund', null, 'stProgressBar').'\');
	                          	setTimeout(\'updatePB( "\'+url+\'", \'+(loops+1)+\',"\'+item+\'", "\'+item_msg+\'", "\'+alert_msg+\'")\', (loops+1)*10000);
							} else {
                        		updatePB( url, loops+1, item, item_msg, alert_msg);
                        	}
						}
                    });
                } else {
	                if ($(item_msg)) $(item_msg).update(unescape(alert_msg));
	                '.
    					((isset($params['reload_url'])&& isset($params['reload_time']))?
    					'setTimeout(\'window.location="'.$params['reload_url'].'"\','.$params['reload_time'].');'
    					:
    					'')
    				.'
	                
                }
            };
           
            updatePB(\''.url_for('stProgressBar/process?name='.$name.'&step='.$step).'\', 
                     0, 
                     \'stProgressBar-'.$name.'\',
                     \'stProgressBar-'.trim($name).'message\',
                     escape(\''.
    					progress_bar_error($i18n->__('Wystąpił problem podczas wykonywania zadania', null, 'stProgressBar').': <strong>'.$params['msg'].'</strong>', (!(isset($params['fatal_msg']) && strlen($params['fatal_msg'])))?
    					$i18n->__('Nie można połączyć sie z serwerem w celu wykonania procesu. Prosze o kontakt z serwisem oprogramowania www.serwis.sote.pl.', null, 'stProgressBar'):$params['fatal_msg']).'\')
                     );
             
        </script>';    	
}