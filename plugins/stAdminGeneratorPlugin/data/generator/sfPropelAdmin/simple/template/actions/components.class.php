<?php
/** 
 * SOTESHOP/stAdminGeneratorPlugin 
 * 
 * Ten plik należy do aplikacji stAdminGeneratorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 17502 2012-03-22 15:35:51Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
?>
[?php

/** 
 * <?php echo $this->getGeneratedModuleName() ?> actions.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 */
class <?php echo $this->getGeneratedModuleName() ?>Components extends sfComponents
{
<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
    public function execute<?php echo $this->getCustomActionPhpName() ?>EditMenu()
    {
        $this-><?php echo $this->getSingularName() ?> = $this->related_object;

        $i18n = $this->getContext()->getI18n();

<?php if ($this->getParameterValue('edit.menu.display')): ?>        
        $this->items = array('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'Edit', 'edit') ?>?id=' . $this-><?php echo $this->getSingularName() ?>->getPrimaryKey() => $i18n->__('<?php echo $this->getParameterValue('edit.menu.fields._edit.name', '_edit') ?>', null, '<?php echo $this->getParameterValue('edit.menu.fields._edit.i18n_catalogue', $this->getModuleName()) ?>'));
<?php foreach ($this->getParameterValue('edit.menu.display') as $item): ?>
        $this->items["<?php echo $this->replaceConstants($this->getParameterValue('edit.menu.fields.'.$item.'.action')) ?>"] = $i18n->__('<?php echo $this->getParameterValue('edit.menu.fields.'.$item.'.name') ?>', null, '<?php echo $this->getParameterValue('edit.menu.fields.'.$item.'.i18n_catalogue', $this->getModuleName()) ?>');
<?php endforeach; ?> 
<?php else: ?>
        $this->items = array();
<?php endif; ?>
        if (!$this->items)
        {
            return sfView::NONE;
        }
        $this->processMenuItems(); 
        $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
    } 
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

    public function executeListMenu()
    {
        $i18n = $this->getContext()->getI18n();

        $this->items = array();    
<?php foreach ($this->getParameterValue('list.menu.display', array()) as $item): ?>
        $this->items["<?php echo $this->replaceConstants($this->getParameterValue('list.menu.fields.'.$item.'.action')) ?>"] = $i18n->__('<?php echo $this->getParameterValue('list.menu.fields.'.$item.'.name') ?>', null, '<?php echo $this->getParameterValue('list.menu.fields.'.$item.'.i18n_catalogue', $this->getModuleName()) ?>');
<?php endforeach; ?>
        if (!$this->items)
        {
            return sfView::NONE;
        }
        $this->processMenuItems();  
        $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu');
    } 

    public function executeConfigMenu()
    {
        $i18n = $this->getContext()->getI18n();

        $this->items = array();
<?php foreach ($this->getParameterValue('config.menu.display', array()) as $item): ?>
        $this->items["<?php echo $this->replaceConstants($this->getParameterValue('config.menu.fields.'.$item.'.action')) ?>"] = $i18n->__('<?php echo $this->getParameterValue('config.menu.fields.'.$item.'.name') ?>', null, '<?php echo $this->getParameterValue('config.menu.fields.'.$item.'.i18n_catalogue', $this->getModuleName()) ?>');
<?php endforeach; ?>
        if (!$this->items)
        {
            return sfView::NONE;
        }
        $this->processMenuItems(); 
        $this->selected_item_path = $this->getUser()->getAttribute('selected', false, 'soteshop/component/menu'); 
    } 

    public function executeCustomMenu()
    {
        $i18n = $this->getContext()->getI18n();

        $this->items = array();
<?php foreach ($this->getParameterValue('custom.menu.display', array()) as $item): ?>
        $this->items["<?php echo $this->replaceConstants($this->getParameterValue('custom.menu.fields.'.$item.'.action')) ?>"] = $i18n->__('<?php echo $this->getParameterValue('custom.menu.fields.'.$item.'.name') ?>', null, '<?php echo $this->getParameterValue('custom.menu.fields.'.$item.'.i18n_catalogue', $this->getModuleName()) ?>');;
<?php endforeach; ?>  
        $this->processMenuItems();
        $this->selected_item_path = $this->getUser()->getAttribute('selected', null, 'soteshop/component/menu');
    } 
    
    protected function processMenuItems()
    {        
        $internal_uri = sfRouting::getInstance()->getCurrentInternalUri();
        
        $controller = $this->getController();

        $url = $controller->genUrl($internal_uri);

        foreach ($this->items as $route => $name)
        {
            if ($url == $controller->genUrl($route)) 
            {
                $this->getUser()->setAttribute('selected', $url, 'soteshop/component/menu');
            }
        }
    }

    <?php if(is_array($this->getParameterValue('include_component_files'))): ?>    
            <?php foreach ($this->getParameterValue('include_component_files') as $file ): ?><?php 
            if (is_readable(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file)): ?><?php 
                include(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file); ?><?php 
            endif; ?><?php 
        endforeach; ?>
    <?php endif; ?>    
}