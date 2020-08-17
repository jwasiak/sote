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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stProgressBar.class.php 11472 2011-03-07 12:45:47Z pawel $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stProgressBar
 *
 * @package     stProgressBarPlugin
 * @subpackage  libs
 */
class stProgressBar {

    var $action = '';

    var $module = '';

    var $steps = 0;

    var $context = null;

    var $pb_id = '';
    
    var $msg = '';
    
    var $params = array();
    
    public function __construct( $module='', $action = '',$steps = false)
    {
        sfLoader::loadHelpers(array('Partial', 'Javascript', 'Tag'));
        
        $this->action = $action;
        $this->module = $module;
        $this->pb_id = $module.'_'.$action;
        $this->context = sfContext::getInstance();

        $this->retriveParams();
        
        if ($steps===false) { $this->getSteps();}
        else { $this->setSteps($steps); }
    }
    
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
        $this->updateParams();
    }

    public function getParam($param, $default = null)
    {
        return (isset($this->params[$param]))?$this->params[$param]:$default;
    }
    
    private function updateParams()
    {
        $this->context->getUser()->setAttribute($this->pb_id, $this->params ,'soteshop/stProgressBarPlugin');
    }

    private function retriveParams()
    {
        $this->params = $this->context->getUser()->getAttribute($this->pb_id, array() ,'soteshop/stProgressBarPlugin');
    }
    
    private function getSteps()
    {
        $this->steps = ((isset($this->params['steps']))?$this->params['steps']:0);

    }

    private function setSteps($steps = 0)
    {
        $this->steps  = $this->params['steps'] = $steps;
        $this->updateParams();
    }

    public function setMsg($msg = null)
    {
        $this->msg = $msg;
    }
    
    public function showProgressBar($step =0, $init = false)
    {
        $i18n = sfContext::getInstance()->getI18N();
        sfContext::getInstance()->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
    	
        $process = 100.0;
        if ($this->steps>0 && ($step<=$this->steps)) {
            $process = $step*100.0/$this->steps;    
        }
       
        $progress_bar = st_get_partial('stProgressBar/progressBar',array('name'=>$this->pb_id, 'complete'=>number_format($process,2), 'msg'=>$this->msg));
        //        $update_script = '<script type="text/javascript">'.remote_function(array('update'=>'stProgressBar-'.$this->pb_id,'url'=>$this->module.'/'.$this->action.'?step='.$step,'script'=>'true')).'</script>';
        $update_script = '<script type="text/javascript">
            var url = \''.url_for($this->module.'/'.$this->action.'?step='.$step).'\';
            
            function updatePB(url, loops) { 
            var item = $(\'stProgressBar-'.$this->pb_id.'\');
            var item_msg = $(\'stProgressBar-'.$this->pb_id.'-msg\');
            if (loops<3) {
		            new Ajax.Request(url, {
		                method: \'post\',
		                onSuccess: function(transport) {
		                    if (transport.responseText.match(\'stPrograssBar-main-div\')!=null) {
		                        item.update(transport.responseText);
		                        item_msg.update(\'\');
		                    } else {
	            	   			item_msg.update(\''.$i18n->__('Wystąpił problem podczas wykonywania operacji, ponowna próba za', null, 'stProgressBar').' \'+((loops+1)*5)+\' '.$i18n->__('sekund', null, 'stProgressBar').'\');
		                    	setTimeout(\'updatePB("\'+url+\'",\'+(loops+1)+\')\', (loops+1)*5000);
		                    }
		                },
		                onFailure: function(transport) {
		                  item_msg.update(\''.$i18n->__('Wystąpił problem podczas wykonywania operacji, ponowna próba za', null, 'stProgressBar').' \'+((loops+1)*5)+\' '.$i18n->__('sekund', null, 'stProgressBar').'\');
		                  setTimeout(\'updatePB("\'+url+\'",\'+(loops+1)+\')\', (loops+1)*5000);
		                }
		            });
	            } else {
	                   item_msg.update(\''.(!empty($this->msg)?$i18n->__('Nie można połączyć sie z serwerem w celu wykonania procesu. Prosze o kontakt z serwisem oprogramowania www.serwis.sote.pl.'):$i18n->__('Wystąpił problem podczas wykonywania zadania').'<strong>'.$this->msg.'</strong>. '.$this->getParam('fatal_msg','')).'\');
	            }
            }
            
            updatePB(url, 0);
            
        </script>';               
                
        if ($init) {
            $content = content_tag('div',$progress_bar,array('id'=>'stProgressBar-'.$this->pb_id)).content_tag('div','',array('id'=>'stProgressBar-'.$this->pb_id.'-msg')).$update_script;
        } else {
            $content = $progress_bar.$update_script;
        }
        
        if ($step>=$this->steps) {
            return $progress_bar;
        }
        
        return $content;
    }
}