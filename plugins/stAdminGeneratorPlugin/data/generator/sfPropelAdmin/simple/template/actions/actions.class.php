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
 * @version     $Id: actions.class.php 17502 2012-03-22 15:35:51Z marcin $
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
class <?php echo $this->getGeneratedModuleName() ?>Actions extends stAdminGeneratorActions
{
  public function executeIndex()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', 'list');
  }

<?php foreach ($this->getAllActionsByType('custom') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
  public function execute<?php echo $this->getCustomActionPhpName() ?>Custom()
  {
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.preExecute<?php echo $this->getCustomActionPhpName() ?>Custom', array()));
    <?php if ($this->getParameterValue('custom.forward_parameters')): ?>
        $this->process<?php echo $this->getCustomActionPhpName() ?>CustomForwardParameters();
    <?php endif; ?>
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
    
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.postExecute<?php echo $this->getCustomActionPhpName() ?>Custom', array()));

<?php if (!$this->getParameterValue('custom.build_options.related_id')): ?>
    $this->related_object = null;
<?php else: ?>
    $this->related_object = <?php echo $this->params['model_class'] ?>Peer::retrieveByPk(<?php echo $this->getForwardParameterBy('custom.build_options.related_id', '$this->') ?>); 
<?php endif; ?> 
    
    if (isset($this->retval)) {return $this->retval;}
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>
  
<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php if ($action_name && !in_array($action_name, $this->getAllActionsByType('edit'))): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>Edit()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', 'edit');
  }
<?php endif; ?>
<?php $this->setParameterValuePrefix($action_name) ?>
<?php if ($this->getParameterValue('list.editable') !== null): ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>UpdateList()
  {
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
       stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

       $request = $this->getRequestParameter('<?php echo $this->getSingularName() ?>');

       if (isset($request['selected']))
       {
         unset($request['selected']);
       }
       
       $pks = array_keys($request);

       $<?php echo $this->getSingularName() ?>s = <?php echo $this->getClassName() ?>Peer::retrieveByPKs($pks);

       foreach ($<?php echo $this->getSingularName() ?>s as $<?php echo $this->getSingularName() ?>)
       {
         $this->update<?php echo $this->getCustomActionPhpName() ?>ListItem($<?php echo $this->getSingularName() ?>, $request[$<?php echo $this->getSingularName() ?>->getPrimaryKey()]);
         $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.update<?php echo $this->getCustomActionPhpName() ?>ListItem', array('modelInstance' => $<?php echo $this->getSingularName() ?>)));
         $<?php echo $this->getSingularName() ?>->save();
       }

       $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.post<?php echo $this->getCustomActionPhpName() ?>UpdateList', array('items' => $<?php echo $this->getSingularName() ?>s)));

       $this->setFlash('notice', $this->getContext()->getI18N()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
    }

    $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');

    return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')  ?>?page='.$this->getRequestParameter('page', 1).'<?php echo $this->getForwardParametersForUrl('$', '&', 'list') ?>);
  }

  protected function update<?php echo $this->getCustomActionPhpName() ?>ListItem($<?php echo $this->getSingularName() ?>, $request)
  {
<?php foreach ($this->getColumns('list.display') as $column): if (null === $this->getParameterValue('list.editable.'.$column->getName())) continue; ?>
<?php if ($column->getCreoleType() != CreoleTypes::BOOLEAN): ?>

     if (isset($request['<?php echo $column->getName() ?>']))
     {
         $<?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($request['<?php echo $column->getName() ?>']);
     }
<?php else: ?>
     
     $<?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>(isset($request['<?php echo $column->getName() ?>']));
<?php endif; ?>
<?php endforeach; ?>
  }
<?php endif; ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>List()
  {
<?php if ($this->getParameterValue('list.forward_parameters')): ?>
    $this->process<?php echo $this->getCustomActionPhpName() ?>ListForwardParameters();
<?php endif; ?>  
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
<?php if (!$this->getParameterValue('list.build_options.related_id')): ?>
    $this->related_object = null;
<?php else: 
    $class = $this->getClassName();
    $through_class = $this->getParameterValue('list.build_options.through_class');
    if ($through_class)
    {
        $through_column = $this->getParameterValue('list.build_options.through_column');
        $related_class = stPropelManyToMany::getRelatedClass($class, $through_class, $through_column);
    }
    else
    {
        $related_class = $this->params['model_class'];
    }
?>
    $this->related_object = <?php echo $related_class ?>Peer::retrieveByPk(<?php echo $this->getForwardParameterBy('list.build_options.related_id', '$this->') ?>); 
<?php endif; ?>   
    $this->process<?php echo $this->getCustomActionPhpName() ?>Sort();

    $this->process<?php echo $this->getCustomActionPhpName() ?>Filters();
    
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('soteshop/stAdminGenerator/<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>/filters');

    $max_per_page = $this->getUser()->getAttribute('<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>.max_per_page', array(), 'soteshop/stAdminGenerator/<?php echo $this->getModuleName() ?>/config');

    $this->pager = new stPropelPager('<?php echo $this->getClassName() ?>', $max_per_page ? $max_per_page : <?php echo $this->getParameterValue('list.max_per_page', 20) == 40 ? 20 : $this->getParameterValue('list.max_per_page', 20) ?>);
<?php if ($this->getParameterValue('list.peer_method')): ?>
    $this->pager->setPeerMethod('<?php echo $this->getParameterValue('list.peer_method') ?>');
<?php endif ?>
<?php if ($this->getParameterValue('list.peer_count_method')): ?>
    $this->pager->setPeerCountMethod('<?php echo $this->getParameterValue('list.peer_count_method') ?>');
<?php endif ?>    
    $c = new Criteria();
    $this->add<?php echo $this->getCustomActionPhpName() ?>SortCriteria($c);
    $this->add<?php echo $this->getCustomActionPhpName() ?>FiltersCriteria($c);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->init();

    if (method_exists($this, 'get<?php echo $this->getCustomActionPhpName() ?>Labels'))
    {
      $this->labels = $this->get<?php echo $this->getCustomActionPhpName() ?>Labels();
    }
    else
    {
      $this->labels = array();
    }
    
    $this-><?php echo $this->getSingularName() ?>_action_select_options = $this->get<?php echo $this->getCustomActionPhpName() ?>ActionSelectControlOptions();   
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>Create()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', '<?php echo $this->getCustomActionNameCamelized('', 'Edit', 'edit') ?>');
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  
  
<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>  
  public function execute<?php echo $this->getCustomActionPhpName() ?>Save()
  {    
    return $this->forward('<?php echo $this->getModuleName() ?>', '<?php echo $this->getCustomActionNameCamelized('', 'Edit', 'edit')  ?>');
  } 
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>   

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php if ($action_name && !in_array($action_name, $this->getAllActionsByType('list'))): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>List()
  {  
    return $this->forward('<?php echo $this->getModuleName() ?>', 'list');    
  }
<?php endif; ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>Edit()
  {
  $i18n = sfI18N::getInstance();
<?php if ($this->getParameterValue('edit.forward_parameters')): ?>
    $this->process<?php echo $this->getCustomActionPhpName() ?>EditForwardParameters();
<?php endif; ?>
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');  
  
    $this-><?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>OrCreate();

<?php if ($this->getParameterValue('list.mark_as')): ?>
    if (!$this-><?php echo $this->getSingularName() ?>->getIsMarkedAsRead())
    {
        $this-><?php echo $this->getSingularName() ?>->setIsMarkedAsRead(true);
        <?php echo $this->getPeerClassName() ?>::doUpdate($this-><?php echo $this->getSingularName() ?>);
        DashboardPeer::doRefreshAll();
    }
<?php endif ?>
    
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->update<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>FromRequest();

      $this->save<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>($this-><?php echo $this->getSingularName() ?>);
      if (!$this->hasFlash('notice'))
      {
        $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
      }
      if ($this->getRequestParameter('save_and_add'))
      {
        return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'Create', 'create') ?><?php echo $this->getForwardParametersForUrl('$this->', '?') ?>);
      }
      else if ($this->getRequestParameter('save_and_list'))
      {
        return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?><?php echo $this->getForwardParametersForUrl('$this->', '?') ?>);
      }
      else
      {
        if ($this->hasRequestParameter('culture'))
        {
            return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'Edit', 'edit') ?>?culture='.$this->getRequestParameter('culture', 'pl_PL').'&<?php echo $this->getPrimaryKeyUrlParams('this->') ?><?php echo $this->getForwardParametersForUrl('$this->', '.\'&', 'edit', '') ?>);
        }
        else
        {
            return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'Edit', 'edit') ?>?<?php echo $this->getPrimaryKeyUrlParams('this->') ?><?php echo $this->getForwardParametersForUrl('$this->', '.\'&', 'edit', '') ?>);
        }
      }
    }
    else
    {
      $this->labels = $this->get<?php echo $this->getCustomActionPhpName() ?>Labels();
    }
<?php if (!$this->getParameterValue('edit.build_options.related_id')): ?>
    $this->related_object = $this-><?php echo $this->getSingularName() ?>;
<?php else: ?>
    $this->related_object = <?php echo $this->params['model_class'] ?>Peer::retrieveByPk(<?php echo $this->getForwardParameterBy('edit.build_options.related_id', '$this->') ?>); 
<?php endif; ?>
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType(array('edit', 'list')) as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
<?php $params = $this->getMethodParamsForPrimaryKey() ?>
  protected function process<?php echo $this->getCustomActionPhpName() ?>Delete(<?php echo $params ?>)
  {
    $this-><?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $params ?>);
    $this->forward404Unless($this-><?php echo $this->getSingularName() ?>);
    
    try
    {
      $this->delete<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>($this-><?php echo $this->getSingularName() ?>);
    }
    catch (PropelException $e)
    {
      $this->getRequest()->setError('delete', 'Could not delete the selected <?php echo sfInflector::humanize($this->getSingularName()) ?>. Make sure it does not have any associated items.');
      $this->forward('<?php echo $this->getModuleName() ?>', '<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>');
      return false;
    }

<?php foreach ($this->getColumnCategories('edit.display') as $category): ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column): ?>
<?php $input_type = $this->getParameterValue('edit.fields.'.$column->getName().'.type') ?>
<?php if ($input_type == 'admin_input_file_tag'): ?>
<?php $upload_dir = $this->replaceConstants($this->getParameterValue('edit.fields.'.$column->getName().'.upload_dir')) ?>
      $currentFile = sfConfig::get('sf_upload_dir')."/<?php echo $upload_dir ?>/".$this-><?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>();
      if (is_file($currentFile))
      {
        unlink($currentFile);
      }

<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>  
    return true;
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>     

<?php foreach ($this->getAllActionsByType(array('edit', 'list')) as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
<?php $params = $this->getMethodParamsForPrimaryKey() ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>Delete()
  {
    stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
    $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');

    $selected = $this->getRequestParameter('<?php echo $this->getSingularName() ?>[selected]', array(<?php echo $this->getRetrieveByPkParamsForAction(40, ".':'.") ?>));
  
    foreach($selected as $id)
    {
<?php if (count($this->getPrimaryKey()) > 1): ?>
        list(<?php echo $params ?>) = explode(':', $id);
<?php endif; ?>

        if (!$this->process<?php echo $this->getCustomActionPhpName() ?>Delete(<?php echo $params ?>))
        {
            break;
        } 
    }

    $this->setFlash('notice', $this->getContext()->getI18N()->__('Usuwanie zakończone pomyślnie', null, 'stAdminGeneratorPlugin'));
  
    return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')  ?>?page='.$this->getRequestParameter('page', 1).'<?php echo $this->getForwardParametersForUrl('$', '&', 'list') ?>);
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>    

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php if ($this->getParameterValue('custom_actions.list.' . $action_name)): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  public function execute<?php echo $this->getCustomActionPhpName() ?>List()
  {
    return $this->forward('<?php echo $this->getModuleName() ?>', '<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')  ?>');
  }
<?php endif; ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  public function handleError<?php echo $this->getCustomActionPhpName() ?>Edit()
  {
    $this->preExecute();
<?php if ($this->getParameterValue('edit.forward_parameters')): ?>
    $this->process<?php echo $this->getCustomActionPhpName() ?>EditForwardParameters();
<?php endif; ?>
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');    
    $this-><?php echo $this->getSingularName() ?> = $this->get<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>OrCreate();
    $this->update<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>FromRequest();

    $this->labels = $this->get<?php echo $this->getCustomActionPhpName() ?>Labels();

<?php if (!$this->getParameterValue('edit.build_options.related_id')): ?>
    $this->related_object = $this-><?php echo $this->getSingularName() ?>;
<?php else: ?>
    $this->related_object = <?php echo $this->params['model_class'] ?>Peer::retrieveByPk(<?php echo $this->getForwardParameterBy('edit.build_options.related_id', '$this->') ?>); 
<?php endif; ?>    

    return sfView::SUCCESS;
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  
  
<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>  
  public function handleError<?php echo $this->getCustomActionPhpName() ?>Config()
  {
    $this->preExecute();
<?php if ($this->getParameterValue('config.forward_parameters')): ?>
    $this->process<?php echo $this->getCustomActionPhpName() ?>EditForwardParameters();
<?php endif; ?>
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');    

<?php if (!$this->getParameterValue('config.build_options.related_id')): ?>
    $this->related_object = null;
<?php else: ?>
    $this->related_object = <?php echo $this->params['model_class'] ?>Peer::retrieveByPk(<?php echo $this->getForwardParameterBy('config.build_options.related_id', '$this->') ?>); 
<?php endif; ?> 
    
    $this->config = $this->load<?php echo $this->getCustomActionPhpName() ?>ConfigOrCreate();
  
    $this->labels = $this->get<?php echo $this->getCustomActionPhpName() ?>ConfigLabels();
     
    $this->update<?php echo $this->getCustomActionPhpName() ?>ConfigFromRequest();

    return sfView::SUCCESS;
  }  
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>   

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  protected function save<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>($<?php echo $this->getSingularName() ?>)
  {
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.preSave<?php echo $this->getCustomActionPhpName() ?>', array('modelInstance' => $<?php echo $this->getSingularName() ?>)));
    $<?php echo $this->getSingularName() ?>->save();
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.postSave<?php echo $this->getCustomActionPhpName() ?>', array('modelInstance' => $<?php echo $this->getSingularName() ?>)));

<?php foreach ($this->getColumnCategories('edit.display') as $category): ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column): $type = $column->getCreoleType(); ?>
<?php $name = $column->getName() ?>
<?php if ($column->isPrimaryKey()) continue ?>
<?php $credentials = $this->getParameterValue('edit.fields.'.$column->getName().'.credentials') ?>
<?php $input_type = $this->getParameterValue('edit.fields.'.$column->getName().'.type') ?>
<?php

$user_params = $this->getParameterValue('edit.fields.'.$column->getName().'.params');
$user_params = is_array($user_params) ? $user_params : sfToolkit::stringToArray($user_params);
$through_class = isset($user_params['through_class']) ? $user_params['through_class'] : '';


?>
<?php if ($through_class): ?>
<?php

$class = $this->getClassName();
$related_class = sfPropelManyToMany::getRelatedClass($class, $through_class);
$related_table = constant($related_class.'Peer::TABLE_NAME');
$middle_table = constant($through_class.'Peer::TABLE_NAME');
$this_table = constant($class.'Peer::TABLE_NAME');

$related_column = sfPropelManyToMany::getRelatedColumn($class, $through_class);
$column = sfPropelManyToMany::getColumn($class, $through_class);

?>
<?php if ($input_type == 'admin_double_list' || $input_type == 'admin_check_list' || $input_type == 'admin_select_list'): ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
    if ($this->getUser()->hasCredential(<?php echo $credentials ?>))
    {
<?php endif; ?>
      // Update many-to-many for "<?php echo $name ?>"
      $c = new Criteria();
      $c->add(<?php echo $through_class ?>Peer::<?php echo strtoupper($column->getColumnName()) ?>, $<?php echo $this->getSingularName() ?>->getPrimaryKey());
      <?php echo $through_class ?>Peer::doDelete($c);

      $ids = $this->getRequestParameter('associated_<?php echo $name ?>');
      if (is_array($ids))
      {
        foreach ($ids as $id)
        {
          $<?php echo ucfirst($through_class) ?> = new <?php echo $through_class ?>();
          $<?php echo ucfirst($through_class) ?>->set<?php echo $column->getPhpName() ?>($<?php echo $this->getSingularName() ?>->getPrimaryKey());
          $<?php echo ucfirst($through_class) ?>->set<?php echo $related_column->getPhpName() ?>($id);
          $<?php echo ucfirst($through_class) ?>->save();
        }
      }

<?php if ($credentials): ?>
    }
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType(array('edit', 'list')) as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  protected function delete<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>($<?php echo $this->getSingularName() ?>)
  {
    if (method_exists($<?php echo $this->getSingularName() ?>, 'getIsSystemDefault') == false || (method_exists($<?php echo $this->getSingularName() ?>, 'getIsSystemDefault') &&  !$<?php echo $this->getSingularName() ?>->getIsSystemDefault()))
    {
        $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.preDelete<?php echo $this->getCustomActionPhpName() ?>', array('modelInstance' => $<?php echo $this->getSingularName() ?>)));
        $<?php echo $this->getSingularName() ?>->delete();
    }
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  protected function update<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>FromRequest()
  {
    $<?php echo $this->getSingularName() ?> = $this->getRequestParameter('<?php echo $this->getSingularName() ?>');

<?php foreach ($this->getColumnCategories('edit.display') as $category): 
$category_install_version = $this->getParameterValue("edit.hide_install_version.".$category);
$category_old_config = $this->getParameterValue("edit.old_config.".$category); ?>
<?php if ($category_install_version): ?>
    if (!stSoteshop::checkInstallVersion('<?php echo $category_install_version ?>'))
    {
<?php endif ?>
<?php if ($category_old_config): ?>
    if (!stTheme::hideOldConfiguration())
    {
<?php endif; ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column): 
$type = $column->getCreoleType(); 
$name = $column->getName();
if ($column->isPrimaryKey() && !$column->isForeignKey()) continue;
$credentials = $this->getParameterValue('edit.fields.'.$column->getName().'.credentials');
$input_type = $this->getParameterValue('edit.fields.'.$column->getName().'.type');
$install_version = $this->getParameterValue('edit.fields.'.$column->getName().'.hide_install_version');
$old_config = $this->getParameterValue('edit.fields.'.$column->getName().'.old_config'); ?>
<?php if ($install_version): ?>
    if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>'))
    {
<?php endif ?>
<?php if ($old_config): ?>
    if (!stTheme::hideOldConfiguration())
    {
<?php endif; ?>
<?php if ($credentials): $credentials = str_replace("\n", ' ', var_export($credentials, true)) ?>
    if ($this->getUser()->hasCredential(<?php echo $credentials ?>))
    {
<?php endif; ?>
<?php if ($input_type == 'admin_input_file_tag'): ?>
<?php $upload_dir = $this->replaceConstants($this->getParameterValue('edit.fields.'.$column->getName().'.upload_dir')) ?>
    $currentFile = sfConfig::get('sf_upload_dir')."/<?php echo $upload_dir ?>/".$this-><?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>();
    if (!$this->getRequest()->hasErrors() && isset($<?php echo $this->getSingularName() ?>['<?php echo $name ?>_remove']))
    {
      $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>('');
      if (is_file($currentFile))
      {
        unlink($currentFile);
      }
    }

    if (!$this->getRequest()->hasErrors() && $this->getRequest()->getFileSize('<?php echo $this->getSingularName() ?>[<?php echo $name ?>]'))
    {
<?php elseif ($type != CreoleTypes::BOOLEAN && $input_type != 'checkbox_tag'): ?>
    if (isset($<?php echo $this->getSingularName() ?>['<?php echo $name ?>']))
    {
<?php endif; ?>
<?php if ($input_type == 'admin_input_file_tag'): ?>
<?php if ($this->getParameterValue('edit.fields.'.$column->getName().'.filename')): ?>
      $fileName = "<?php echo str_replace('"', '\\"', $this->replaceConstants($this->getParameterValue('edit.fields.'.$column->getName().'.filename'))) ?>";
<?php else: ?>
      $fileName = md5($this->getRequest()->getFileName('<?php echo $this->getSingularName() ?>[<?php echo $name ?>]').time().rand(0, 99999));
<?php endif ?>
      $ext = $this->getRequest()->getFileExtension('<?php echo $this->getSingularName() ?>[<?php echo $name ?>]');
      if (is_file($currentFile))
      {
        unlink($currentFile);
      }
      $this->getRequest()->moveFile('<?php echo $this->getSingularName() ?>[<?php echo $name ?>]', sfConfig::get('sf_upload_dir')."/<?php echo $upload_dir ?>/".$fileName.$ext);
      $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($fileName.$ext);
<?php elseif ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP): ?>
      if ($<?php echo $this->getSingularName() ?>['<?php echo $name ?>'])
      {
        try
        {
          $dateFormat = new sfDateFormat($this->getUser()->getCulture());
          <?php $inputPattern  = $type == CreoleTypes::DATE ? 'd' : 'g'; ?>
          <?php $outputPattern = $type == CreoleTypes::DATE ? 'i' : 'I'; ?>
          if (!is_array($<?php echo $this->getSingularName() ?>['<?php echo $name ?>']))
          {
            $value = $dateFormat->format($<?php echo $this->getSingularName() ?>['<?php echo $name ?>'], '<?php echo $outputPattern ?>', $dateFormat->getInputPattern('<?php echo $inputPattern ?>'));
          }
          else
          {
            $value_array = $<?php echo $this->getSingularName() ?>['<?php echo $name ?>'];
            $value = $value_array['year'].'-'.$value_array['month'].'-'.$value_array['day'].(isset($value_array['hour']) ? ' '.$value_array['hour'].':'.$value_array['minute'].(isset($value_array['second']) ? ':'.$value_array['second'] : '') : '');
          }
          $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($value);
        }
        catch (sfException $e)
        {
          // not a date
        }
      }
      else
      {
        $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>(null);
      }
<?php elseif ($type == CreoleTypes::BOOLEAN || $input_type == 'checkbox_tag'): ?>
    $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>(isset($<?php echo $this->getSingularName() ?>['<?php echo $name ?>']) ? $<?php echo $this->getSingularName() ?>['<?php echo $name ?>'] : 0);
<?php elseif ($column->isForeignKey()): ?>
    $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($<?php echo $this->getSingularName() ?>['<?php echo $name ?>'] ? $<?php echo $this->getSingularName() ?>['<?php echo $name ?>'] : null);
<?php elseif ($column->isComponent() || $column->isPartial()): ?>
      if (method_exists($this-><?php echo $this->getSingularName() ?>, 'set<?php echo $column->getPhpName() ?>'))
      {
        $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($<?php echo $this->getSingularName() ?>['<?php echo $name ?>']);
      }
<?php else: ?>
      $this-><?php echo $this->getSingularName() ?>->set<?php echo $column->getPhpName() ?>($<?php echo $this->getSingularName() ?>['<?php echo $name ?>']);
<?php endif; ?>
<?php if ($type != CreoleTypes::BOOLEAN && $input_type != 'checkbox_tag'): ?>
    }
<?php endif; ?>
<?php if ($credentials): ?>
      }
<?php endif; ?>
<?php if ($old_config): ?>
      }
<?php endif ?>
<?php if ($install_version): ?>
      }
<?php endif ?>
<?php endforeach; ?>
<?php if ($category_old_config): ?>
      }
<?php endif; ?>
<?php if ($category_install_version): ?>
      }
<?php endif; ?>
<?php endforeach; ?>
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.postUpdate<?php echo $this->getCustomActionPhpName() ?>FromRequest', array('modelInstance' => $this-><?php echo $this->getSingularName() ?>, 'requestParameters' => $<?php echo $this->getSingularName() ?>)));
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  /**
   * Creates new or returns the existing model instance
   * @return <?php echo $this->getClassName() ?>
   */
  protected function get<?php echo $this->getCustomActionPhpName() ?><?php echo $this->getClassName() ?>OrCreate(<?php echo $this->getMethodParamsForGetOrCreate() ?>)
  {
    $event = $this->getDispatcher()->notifyUntil(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.preGet<?php echo $this->getCustomActionPhpName() ?>OrCreate'));
    if (!$event->isProcessed())
    {  
        if (<?php echo $this->getTestPksForGetOrCreate() ?>)
        {
          $this-><?php echo $this->getSingularName() ?> = new <?php echo $this->getClassName() ?>();
        }
        else
        {
          $this-><?php echo $this->getSingularName() ?> = <?php echo $this->getClassName() ?>Peer::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForGetOrCreate() ?>);
    
          $this->forward404Unless($this-><?php echo $this->getSingularName() ?>);
        }
    }
    
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.postGet<?php echo $this->getCustomActionPhpName() ?>OrCreate', array('modelInstance' => $this-><?php echo $this->getSingularName() ?>)));

    if (method_exists($this-><?php echo $this->getSingularName() ?>, 'setCulture'))
    {
        if ($this-><?php echo $this->getSingularName() ?>->getPrimaryKey())
        {
            $language = $this->getRequestParameter('culture', stLanguage::getOptLanguage());
        }
        else
        {
            $language = stLanguage::getOptLanguage();
        }
        
        $this-><?php echo $this->getSingularName() ?>->setCulture($language);
    }

    return $this-><?php echo $this->getSingularName() ?>;
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>    

<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  protected function process<?php echo $this->getCustomActionPhpName() ?>Filters()
  {
    if ($this->hasRequestParameter('filters_clear'))
    {
      $this->clearFilter('<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>');    
    }  
    elseif ($this->hasRequestParameter('filters'))
    {
      $this->clearFilter('<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>'); 

      $filters = $this->getRequestParameter('filters');
<?php foreach ($this->getColumns('list.display') as $column): $type = $column->getCreoleType(); $control_name = $column->getName() ?>
<?php if ($filter_field = $this->getParameterValue('list.filters.' . $column->getName() . '.filter_field')) $column = $this->getAdminColumnFromField($filter_field) ?>
<?php if (!$column->isReal()) continue ?>
<?php if ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP): ?>
      if (isset($filters['<?php echo $control_name ?>']['from']) && $filters['<?php echo $control_name ?>']['from'] !== '')
      {
        $filters['<?php echo $control_name ?>']['from'] = sfI18N::getTimestampForCulture($filters['<?php echo $control_name ?>']['from'], $this->getUser()->getCulture());
      }
      if (isset($filters['<?php echo $control_name ?>']['to']) && $filters['<?php echo $control_name ?>']['to'] !== '')
      {
        $filters['<?php echo $control_name ?>']['to'] = sfI18N::getTimestampForCulture($filters['<?php echo $control_name ?>']['to'], $this->getUser()->getCulture());
      }
<?php endif; ?>
<?php endforeach; ?>
      
      if (is_array($filters))
      {
        $this->getUser()->getAttributeHolder()->add($filters, 'soteshop/stAdminGenerator/<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>/filters');
      }
    }
  }
<?php $this->resetParameterValuePrefix()  ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  protected function process<?php echo $this->getCustomActionPhpName() ?>Sort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort');
    }

    if (!$this->getUser()->getAttribute('sort', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort'))
    {
<?php if ($sort = $this->getParameterValue('list.sort')): ?>
<?php if (is_array($sort)): ?>
      $this->getUser()->setAttribute('sort', '<?php echo $sort[0] ?>', 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort');
      $this->getUser()->setAttribute('type', '<?php echo $sort[1] ?>', 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort');
<?php else: ?>
      $this->getUser()->setAttribute('sort', '<?php echo $sort ?>', 'sf_admin/<?php echo $this->getSingularName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort');
      $this->getUser()->setAttribute('type', 'asc', 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort');
<?php endif; ?>
<?php endif; ?>
    }
    
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>
  protected function add<?php echo $this->getCustomActionPhpName() ?>FiltersCriteria($c)
  {
<?php if ($this->getParameterValue('list.mark_as')): ?>
    if (isset($this->filters['_is_marked_as']) && $this->filters['_is_marked_as'] !== "")
    {
      if ($this->filters['_is_marked_as'] == 'read' || $this->filters['_is_marked_as'] == 'unread')
      {
        $c->add(<?php echo $this->getPeerClassName() ?>::IS_MARKED_AS_READ, $this->filters['_is_marked_as'] == 'read');
      }
    }
<?php endif ?>
<?php foreach (array_merge($this->getColumns('list.display'), $this->getParameterValue('list.additional_filters') ? $this->getColumns('list.additional_filters') : array()) as $column): $control_name = $column->getName(); ?>
<?php if ($filter_field = $this->getParameterValue('list.filters.' . $column->getName() . '.filter_field')) { $column = $this->getAdminColumnFromField($filter_field); $this->changeModelClassFromField($filter_field); }  ?>
<?php if (!$column->isReal()) { $this->restoreModelClass(); continue; } ?>
<?php $type = $column->getCreoleType() ?>
<?php if (($column->isPartial() || $column->isComponent()) && $this->getParameterValue('list.fields.'.$column->getName().'.filter_criteria_disabled')) continue ?>
    if (isset($this->filters['<?php echo $control_name ?>_is_empty']))
    {
      $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, '');
      $criterion->addOr($c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, null, Criteria::ISNULL));
      $c->add($criterion);
    }
<?php if ($column->isForeignKey()): ?>
    else if (isset($this->filters['<?php echo $control_name ?>']) && $this->filters['<?php echo $control_name ?>'] !== '')
    {
        if (method_exists($this, 'filter<?php echo $this->getCustomActionPhpName() ?>CriteriaBy<?php echo $this->getClassName() ?><?php echo $column->getPhpName() ?>'))
        {
            $filter_anyway = !$this->filter<?php echo $this->getCustomActionPhpName() ?>CriteriaBy<?php echo $this->getClassName() ?><?php echo $column->getPhpName() ?>($c, $this->filters['<?php echo $control_name ?>']);
        }   
        else
        {
            $filter_anyway = true;
        } 
        
        if ($filter_anyway)
        {
            $c->add(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $control_name ?>']);  
        }  
    }
<?php else: ?>
<?php if ($type == CreoleTypes::DATE || $type == CreoleTypes::TIMESTAMP || $type == CreoleTypes::INTEGER || $type == CreoleTypes::NUMERIC || $type == CreoleTypes::DOUBLE || $type == CreoleTypes::FLOAT || $type == CreoleTypes::REAL || $type == CreoleTypes::DECIMAL || $type == CreoleTypes::BIGINT || $type == CreoleTypes::SMALLINT || $type == CreoleTypes::TINYINT): ?>
    else if (isset($this->filters['<?php echo $control_name ?>']))
    {
      if (method_exists($this, 'filter<?php echo $this->getCustomActionPhpName() ?>CriteriaBy<?php echo $this->getClassName() ?><?php echo $column->getPhpName() ?>'))
      {
        $filter_anyway = !$this->filter<?php echo $this->getCustomActionPhpName() ?>CriteriaBy<?php echo $this->getClassName() ?><?php echo $column->getPhpName() ?>($c, $this->filters['<?php echo $control_name ?>']);
      }   
      else
      {
        $filter_anyway = true;
      } 
          
      if (isset($this->filters['<?php echo $control_name ?>']['from']) && $this->filters['<?php echo $control_name ?>']['from'] !== '' && $filter_anyway)
      {

<?php if ($type == CreoleTypes::DATE): ?>
        $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, date('Y-m-d', strtotime($this->filters['<?php echo $control_name ?>']['from'])), Criteria::GREATER_EQUAL);
<?php else: ?>
        $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $control_name ?>']['from'], Criteria::GREATER_EQUAL);
<?php endif; ?>
        
      }
      if (isset($this->filters['<?php echo $control_name ?>']['to']) && $this->filters['<?php echo $control_name ?>']['to'] !== '' && $filter_anyway)
      {
   
        if (isset($criterion))
        {
<?php if ($type == CreoleTypes::DATE): ?>
            $criterion->addAnd($c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, date('Y-m-d', strtotime($this->filters['<?php echo $control_name ?>']['to'])), Criteria::LESS_EQUAL));
<?php else: ?>
          $criterion->addAnd($c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $control_name ?>']['to'], Criteria::LESS_EQUAL));
<?php endif; ?>
        }
        else
        {
<?php if ($type == CreoleTypes::DATE): ?>
            $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, date('Y-m-d', strtotime($this->filters['<?php echo $control_name ?>']['to'])), Criteria::LESS_EQUAL);
<?php else: ?>
            $criterion = $c->getNewCriterion(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $control_name ?>']['to'], Criteria::LESS_EQUAL);
<?php endif; ?>
        }
          
      }

      if (isset($criterion))
      {
        $c->add($criterion);
      }
    }
<?php else: ?>
    else if (isset($this->filters['<?php echo $control_name ?>']) && $this->filters['<?php echo $control_name ?>'] !== '')
    {
        if (method_exists($this, 'filter<?php echo $this->getCustomActionPhpName() ?>CriteriaBy<?php echo $this->getClassName() ?><?php echo $column->getPhpName() ?>'))
        {
            $filter_anyway = !$this->filter<?php echo $this->getCustomActionPhpName() ?>CriteriaBy<?php echo $this->getClassName() ?><?php echo $column->getPhpName() ?>($c, $this->filters['<?php echo $control_name ?>']);
        }   
        else
        {
            $filter_anyway = true;
        }  
  
        if ($filter_anyway)
        {
<?php if ($type == CreoleTypes::BOOLEAN): ?>
            $c->add(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $control_name ?>']);    
<?php elseif ($type == CreoleTypes::VARCHAR || $type == CreoleTypes::LONGVARCHAR || $type == CreoleTypes::TEXT || $type == CreoleTypes::MEDIUMTEXT): ?>
            $c->add(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, '%' . $this->filters['<?php echo $control_name ?>'] . '%', Criteria::LIKE);
<?php else: ?>
            $c->add(<?php echo $this->getPeerClassName() ?>::<?php echo strtoupper($column->getName()) ?>, $this->filters['<?php echo $control_name ?>']);
<?php endif; ?>
        }
    }
<?php endif; ?>
<?php endif; ?>
<?php $this->restoreModelClass() ?>
<?php endforeach; ?>
<?php if ($through_class = $this->getParameterValue('list.build_options.through_class')): 
    $class = $this->getClassName();
    $through_column = $this->getParameterValue('list.build_options.through_column');
    $related_class = stPropelManyToMany::getRelatedClass($class, $through_class, $through_column);
    $related_column = stPropelManyToMany::getRelatedColumn($class, $through_class, $through_column);
    $column = stPropelManyToMany::getColumn($class, $through_class, $through_column);
?>
    if (isset($this->filters['assigned']) && $this->filters['assigned'] !== '')
    {
      if ($this->getUser()->getAttribute('sort', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') != 'assigned')
      {
         $c->addJoin(<?php echo $this->getPeerClassName() ?>::<?php $pk_col = stPropelManyToMany::getPrimaryKeyColumn($class); echo $pk_col->getColumnName() ?>, <?php echo $through_class ?>Peer::<?php echo $column->getColumnName() ?>.sprintf(' AND %s = %s', <?php echo $through_class ?>Peer::<?php echo $related_column->getColumnName() ?>, <?php echo $this->getForwardParameterBy('list.build_options.related_id', '$this->') ?>), Criteria::LEFT_JOIN);
      }
      
      $c->add(<?php echo $through_class ?>Peer::<?php echo $column->getColumnName() ?>, null, $this->filters['assigned'] ? Criteria::ISNOTNULL : Criteria::ISNULL);
    }
<?php endif; ?>
    $this->getDispatcher()->notify(new sfEvent($this, '<?php echo $this->getGeneratedModuleName() ?>Actions.add<?php echo $this->getCustomActionPhpName() ?>FiltersCriteria', array('criteria' => $c)));
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>  
  protected function get<?php echo $this->getCustomActionPhpName() ?>Labels()
  {
    $i18n = $this->getContext()->getI18N();

    return array(
      'delete' => $i18n->__('Usuń', null, 'stAdminGeneratorPlugin'),
<?php foreach ($this->getColumnCategories('edit.display') as $category): ?>
<?php foreach ($this->getColumns('edit.display', $category) as $name => $column):
  $i18n_module = $this->getParameterValue('edit.fields.' . $name . '.i18n', $this->getModuleName());
?>
      '<?php echo $this->getSingularName() ?>{<?php echo $column->getName() ?>}' => $i18n->__('<?php echo str_replace("'", "\\'", $this->getParameterValue('edit.fields.'.$column->getName().'.name')); ?>', null, ''),
<?php endforeach; ?>
<?php endforeach; ?>
    );
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>
  
<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>   
  protected function add<?php echo $this->getCustomActionPhpName() ?>SortCriteria($c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort'))
    {
<?php if ($through_class = $this->getParameterValue('list.build_options.through_class')): ?>
<?php $class = $this->getClassName() ?>
<?php $through_column = $this->getParameterValue('list.build_options.through_column') ?>
<?php $related_class = stPropelManyToMany::getRelatedClass($class, $through_class, $through_column) ?>
<?php $related_column = stPropelManyToMany::getRelatedColumn($class, $through_class, $through_column) ?>
<?php $column = stPropelManyToMany::getColumn($class, $through_class, $through_column) ?>
<?php //$this->changeModelClass($class) ?>
       if ($sort_column == 'assigned')
       {
         $c->addJoin(<?php echo $this->getPeerClassName() ?>::<?php $pk_col = stPropelManyToMany::getPrimaryKeyColumn($class); echo $pk_col->getColumnName() ?>, <?php echo $through_class ?>Peer::<?php echo $column->getColumnName() ?>.sprintf(' AND %s = %s', <?php echo $through_class ?>Peer::<?php echo $related_column->getColumnName() ?>, <?php echo $this->getForwardParameterBy('list.build_options.related_id', '$this->') ?>), Criteria::LEFT_JOIN);

         $sort_column = <?php echo $through_class ?>Peer::<?php echo $related_column->getColumnName() ?>; 
       }
       else
       {
         $sort_column=$this->translate<?php echo $this->getCustomActionPhpName() ?>SortColumn($sort_column);
       }
<?php else: ?>
      $sort_column=$this->translate<?php echo $this->getCustomActionPhpName() ?>SortColumn($sort_column);
<?php endif; ?>

      if ($this->getUser()->getAttribute('type', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }


    }
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>   

<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>     
  protected function translate<?php echo $this->getCustomActionPhpName() ?>SortColumn($field) {
    $sort_field=$this->get<?php echo $this->getCustomActionPhpName() ?>SortField();
    if (isset($sort_field[$field])) {
        list($object_name, $column_name) = each($sort_field[$field]);
     
        $sort_column=call_user_func(array($object_name,"translateFieldName"),$column_name, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
    }
    
    return $sort_column;
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>   
  
<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>    
  protected function get<?php echo $this->getCustomActionPhpName() ?>SortField() {
<?php 
$sort_field_arr=array();
foreach ($this->getColumns('list.display') as $column) 
{
  if ($this->getParameterValue('list.fields.'.$column->getName().'.display'))
  {
    $columns = $this->getColumns('list.fields.'.$column->getName().'.display');
  }  
  else
  {
    $columns = array($column);

  }
  foreach ($columns as $column) 
  {
      $sort_field = $this->getParameterValue('list.fields.'.$column->getName().'.sort_field', '');
      
      $peer_class_name = null;
      if (is_array($sort_field)) {
         $peer_class_name = $sort_field[0] . 'Peer';
         $field_name = $sort_field[1];
      } elseif (strpos($sort_field, '.') !== false) {
         list($table_name, $field_name) = explode('.', $sort_field);
         $peer_class_name = sfInflector::camelize($table_name).'Peer';
      } elseif (strpos($sort_field, '::') !== false) {
         list($peer_class_name, $field_name) = explode('::', $sort_field);
         $field_name = strtolower($field_name);
      }

      if ($peer_class_name) {
          if (!class_exists($peer_class_name)) {
              throw new sfConfigurationException(sprintf('The "sort_field" parameter can only take existing table and field name as argument (sort_order: table_name.field_name)', $only_for));
          }
          $sort_field_arr[$column->getName()] = array($peer_class_name => $field_name);
      } elseif ($column->isReal()) {
          $sort_field_arr[$column->getName()] = array($this->getPeerClassName() => $column->getName());
      }
  }
}
?>
    return <?php var_export($sort_field_arr) ?>;
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  
  

<?php if ($this->getParameterValue('config')): ?>  
<?php foreach ($this->getAllActionsByType('config') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>  
  public function execute<?php echo $this->getCustomActionPhpName() ?>Config() 
  {
  $i18n = sfI18N::getInstance();
<?php if ($this->getParameterValue('config.forward_parameters')): ?>
    $this->process<?php echo $this->getCustomActionPhpName() ?>ConfigForwardParameters(); 
<?php endif; ?>    
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');

    <?php if (!$this->getParameterValue('config.build_options.related_id')): ?>
    $this->related_object = null;
<?php else: ?>
    $this->related_object = <?php echo $this->params['model_class'] ?>Peer::retrieveByPk(<?php echo $this->getForwardParameterBy('config.build_options.related_id', '$this->') ?>); 
<?php endif; ?> 
      
    $this->config = $this->load<?php echo $this->getCustomActionPhpName() ?>ConfigOrCreate();
  
    $this->labels = $this->get<?php echo $this->getCustomActionPhpName() ?>ConfigLabels();
    
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {  
        $this->update<?php echo $this->getCustomActionPhpName() ?>ConfigFromRequest();
    
        $this->save<?php echo $this->getCustomActionPhpName() ?>Config();
        
        $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        
        return $this->redirect('<?php echo $this->getModuleName() ?>/config?culture='.$this->config->getCulture());
    } 
  }  
  
  protected function get<?php echo $this->getCustomActionPhpName() ?>ConfigLabels()
  {
    return array(
<?php foreach ($this->getColumnCategories('config.display') as $category): ?>
<?php foreach ($this->getColumns('config.display', $category) as $name => $column): ?>
      'config{<?php echo $column->getName() ?>}' => '<?php $label_name = str_replace("'", "\\'", $this->getParameterValue('config.fields.'.$column->getName().'.name')); echo $label_name ?><?php if ($label_name): ?>:<?php endif ?>',
<?php endforeach; ?>
<?php endforeach; ?>
    );
  }  
  
  protected function update<?php echo $this->getCustomActionPhpName() ?>ConfigFromRequest()
  {
    $config = $this->getRequestParameter('config');
    
<?php foreach ($this->getColumnCategories('config.display') as $category): 
$category_install_version = $this->getParameterValue("config.hide_install_version.".$category);
$category_old_config = $this->getParameterValue("config.old_config.".$category); ?>
<?php if ($category_install_version): ?>
    if (!stSoteshop::checkInstallVersion('<?php echo $category_install_version ?>'))
    {
<?php endif ?>
<?php if ($category_old_config): ?>
    if (!stTheme::hideOldConfiguration())
    {
<?php endif; ?>
<?php foreach ($this->getColumns('config.display', $category) as $column): 
$type = $this->getParameterValue('config.fields.'.$column->getName().'.type');
$i18n_flag = $this->getParameterValue('config.fields.'.$column->getName().'.is_i18n') ? 'true' : 'false'; 
$install_version = $this->getParameterValue('config.fields.'.$column->getName().'.hide_install_version');
$old_config = $this->getParameterValue('config.fields.'.$column->getName().'.old_config'); ?> 
<?php if ($install_version): ?>
    if (!stSoteshop::checkInstallVersion('<?php echo $install_version ?>'))
    {
<?php endif ?>  
<?php if ($old_config): ?>
    if (!stTheme::hideOldConfiguration())
    {
<?php endif ?>
<?php if ($type != 'checkbox'): ?>
    $this->config->set('<?php echo $column->getName() ?>', $config['<?php echo $column->getName() ?>'], <?php echo $i18n_flag ?>);
<?php else: ?>
    $this->config->set('<?php echo $column->getName() ?>', isset($config['<?php echo $column->getName() ?>']) ?  $config['<?php echo $column->getName() ?>'] : false, <?php echo $i18n_flag ?>);
<?php endif; ?>
<?php if ($old_config): ?>
    }
<?php endif ?>
<?php if ($install_version): ?>
    }
<?php endif ?>
<?php endforeach; ?>
<?php if ($category_old_config): ?>
    }
<?php endif; ?>
<?php if ($category_install_version): ?>
    }
<?php endif; ?>
<?php endforeach; ?>     
  }  
  
  protected function save<?php echo $this->getCustomActionPhpName() ?>Config() 
  {      
    $this->config->save();
  }
  
  protected function load<?php echo $this->getCustomActionPhpName() ?>ConfigOrCreate() 
  {    
    $config = stConfig::getInstance('<?php echo $this->getModuleName() ?>', array('culture' => $this->getRequestParameter('culture', stLanguage::getOptLanguage())));
    
    if ($config->isEmpty())
    { 
<?php foreach ($this->getColumnCategories('config.display') as $category): ?>
<?php foreach ($this->getColumns('config.display', $category) as $column): $type = $this->getParameterValue('config.fields.'.$column->getName().'.type') ?>
<?php if ($type=='select' || $type=='radio'): ?>
<?php $selected=$this->getParameterValue('config.fields.'.$column->getName().'.selected') ?>
      $config->set('<?php echo $column->getName() ?>', '<?php echo $this->getParameterValue('config.fields.'.$column->getName().'.options.'.$selected.'.value') ?>');  
<?php elseif ($type=='checkbox'): ?>
      $config->set('<?php echo $column->getName() ?>', '<?php echo $this->getParameterValue('config.fields.'.$column->getName().'.checked') ?>'); 
<?php endif; ?> 
<?php endforeach; ?>
<?php endforeach; ?> 
    } 
    
    return $config;
  }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  
  
<?php endif; ?>
  
<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?>      
   protected function get<?php echo $this->getCustomActionPhpName() ?>ActionSelectControlOptions()
   {
        $controller = $this->getContext()->getController();
        $i18n = sfI18N::getInstance();
        $page = $this->pager->getPage();
        
        $options = array(
<?php if ($action_name && $this->getParameterValue('list.build_options.through_class')): ?>
         'NONE' => array(
            $controller->genUrl('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('','AddGroup') ?>?page='.$page) => $i18n->__('<?php echo $this->getParameterValue('list.select_actions.actions._add_group.name', 'Dodaj do grupy') ?>', null, 'stAdminGeneratorPlugin'),
            $controller->genUrl('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('','RemoveGroup') ?>?page='.$page) => $i18n->__('<?php echo $this->getParameterValue('list.select_actions.actions._remove_group.name', 'Usuń z grupy') ?>', null, 'stAdminGeneratorPlugin'),
            ),
<?php else: ?>
<?php if ($this->getParameterValue('list.select_actions') === null || $this->getParameterValue('list.select_actions.actions._delete') !== null): ?>
         'NONE' => array(
            $controller->genUrl('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('','Delete', 'delete') ?>?page='.$page) => array('name' => $i18n->__('Usuń', null, 'stAdminGeneratorPlugin'), 'confirm' => $i18n->__('Usuń', null, 'stAdminGeneratorPlugin')),
            ),
<?php endif; ?>            
<?php endif; ?>
<?php if ($this->getParameterValue('list.mark_as')): ?>
          $i18n->__('Oznacz jako', null,'stAdminGeneratorPlugin') => array(
            $controller->genUrl('<?php echo $this->getModuleName() ?>/markAs?id=read&page='.$page) => $i18n->__('Przeczytane', null,'stAdminGeneratorPlugin'),
            $controller->genUrl('<?php echo $this->getModuleName() ?>/markAs?id=unread&page='.$page) => $i18n->__('Nieprzeczytane', null,'stAdminGeneratorPlugin')
          )
<?php endif; ?>
        );
           
<?php if ($this->getParameterValue('list.select_actions.display')): ?>    
<?php foreach ($this->getColumnCategories('list.select_actions.display') as $category): ?>
<?php if ($actions = $this->getParameterValue('list.select_actions.display.' . $category . '.actions')):
$action = $this->getParameterValue('list.select_actions.display.' . $category . '.action');
if (!$action) 
{
  throw new Exception('list.select_actions.display.' . $category . '.action is required');
} 
$module_name = $this->getParameterValue('list.select_actions.actions.' . $category . '.module', $this->getModuleName());
$i18n_module = $this->getParameterValue('list.select_actions.display.' . $category . '.i18n', $this->getModuleName());
$ajax = $this->getParameterValue('list.select_actions.actions.' . $category . '.ajax', false);
?>
      foreach (<?php var_export($actions) ?> as $id => $label)
      {
          $options[$i18n->__('<?php echo $category ?>', null, '<?php echo $i18n_module ?>')][$controller->genUrl('<?php echo $module_name ?>/<?php echo $action ?>?id=' . $id .'&page='.$page)] = array("name" => $i18n->__($label, null, '<?php echo $i18n_module ?>'), "ajax" => <?php echo intval($ajax) ?>);
      }
<?php elseif ($callback = $this->getParameterValue('list.select_actions.display.' . $category . '.callback')):  
$action = $this->getParameterValue('list.select_actions.display.' . $category . '.action');
if (!$action) 
{
  throw new Exception('list.select_actions.display.' . $category . '.action is required');
} 
$module_name = $this->getParameterValue('list.select_actions.actions.' . $category . '.module', $this->getModuleName());
$i18n_module = $this->getParameterValue('list.select_actions.display.' . $category . '.i18n', $this->getModuleName());
$ajax = $this->getParameterValue('list.select_actions.actions.' . $category . '.ajax', false);
?> 
      foreach (<?php echo $callback ?>() as $id => $label)
      {
          $options[$i18n->__('<?php echo $category ?>', null, '<?php echo $i18n_module ?>')][$controller->genUrl('<?php echo $module_name ?>/<?php echo $action ?>?id=' . $id .'&page='.$page)] = array("name" => $label, "ajax" => <?php echo intval($ajax) ?>);
      }
<?php elseif ($related_class = $this->getParameterValue('list.select_actions.display.' . $category . '.related_class')):
$related_method = $this->getParameterValue('list.select_actions.display.' . $category . '.related_method', 'getId');
$related_peer_method = $this->getParameterValue('list.select_actions.display.' . $category . '.related_peer_method', 'doSelect');
$action = $this->getParameterValue('list.select_actions.display.' . $category . '.action', $column->getName());
$ajax = $this->getParameterValue('list.select_actions.display.' . $category . '.ajax', false);
?>  
        foreach (<?php echo $related_class ?>Peer::<?php echo $related_peer_method ?>(new Criteria()) as $item)
        {
            $options['<?php echo $category ?>'][$controller->genUrl('<?php echo $this->getParameterValue('list.select_actions.actions.' . $column->getName() . '.module', $this->getModuleName()) ?>/<?php echo $action ?>?id=' . $item-><?php echo $related_method ?>().'&page='.$page)] = array("name" => $item, "ajax" => <?php echo intval($ajax) ?>;
        } 
<?php else: ?>
<?php foreach ($this->getColumns('list.select_actions.display', $category) as $column): $action = $this->getParameterValue('list.select_actions.actions.' . $column->getName() . '.action', $column->getName()); $i18n = $this->getParameterValue('list.select_actions.actions.' . $column->getName().'.i18n', $this->getModuleName()); $confirm = $this->getParameterValue('list.select_actions.actions.' . $column->getName() . '.confirm', ''); $ajax = $this->getParameterValue('list.select_actions.actions.' . $column->getName() . '.ajax', false) ?>
        $options['<?php echo $category ?>'][$controller->genUrl('<?php echo $this->getParameterValue('list.select_actions.actions.' . $column->getName() . '.module', $this->getModuleName()) ?>/<?php echo $action ?>?page='.$page)] = array('name' => $i18n->__('<?php echo $this->getParameterValue('list.select_actions.actions.' . $column->getName() . '.name') ?>', null, '<?php echo $i18n ?>'), 'confirm' => <?php if ($confirm !== false): ?>$i18n->__('<?php echo $confirm ?>', null, '<?php echo $i18n ?>')<?php else: ?>0<?php endif ?>, 'ajax' => <?php echo intval($ajax) ?>);
<?php endforeach; ?>
<?php endif; ?>
                
<?php endforeach; ?>
<?php endif; ?>
        return $options;     
   }
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>    

<?php foreach ($this->getAllActionsByType('edit') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
<?php if ($this->getParameterValue('edit.forward_parameters')): ?>
    protected function process<?php echo $this->getCustomActionPhpName() ?>EditForwardParameters()
    {
        $params = array();
       
<?php foreach ($this->getParameterValue('edit.forward_parameters') as $parameter): ?>
        if ($this->hasRequestParameter('<?php echo $parameter ?>'))
        {
            $params['<?php echo $parameter ?>'] = $this->getRequestParameter('<?php echo $parameter ?>');
        }
<?php endforeach; ?>
        if (!empty($params))
        {
            $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
            $this->getUser()->getAttributeHolder()->add($params, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        }
    }
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>   

<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
<?php if ($this->getParameterValue('list.forward_parameters')): ?>
    protected function process<?php echo $this->getCustomActionPhpName() ?>ListForwardParameters()
    {
        $params = array();
       
<?php foreach ($this->getParameterValue('list.forward_parameters') as $parameter): ?>
        if ($this->hasRequestParameter('<?php echo $parameter ?>'))
        {
            $params['<?php echo $parameter ?>'] = $this->getRequestParameter('<?php echo $parameter ?>');
        }
<?php endforeach; ?>
        if (!empty($params))
        {
            $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
            $this->getUser()->getAttributeHolder()->add($params, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        }
    }
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>  

<?php foreach ($this->getAllActionsByType('config') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
<?php if ($this->getParameterValue('config.forward_parameters')): ?>
    protected function process<?php echo $this->getCustomActionPhpName() ?>ConfigForwardParameters()
    {
        $params = array();
       
<?php foreach ($this->getParameterValue('config.forward_parameters') as $parameter): ?>
        if ($this->hasRequestParameter('<?php echo $parameter ?>'))
        {
            $params['<?php echo $parameter ?>'] = $this->getRequestParameter('<?php echo $parameter ?>');
        }
<?php endforeach; ?>
        if (!empty($params))
        {
            $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
            $this->getUser()->getAttributeHolder()->add($params, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        }
    }
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?> 

<?php foreach ($this->getAllActionsByType('custom') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
<?php if ($this->getParameterValue('custom.forward_parameters')): ?>
    protected function process<?php echo $this->getCustomActionPhpName() ?>CustomForwardParameters()
    {
        $params = array();
       
<?php foreach ($this->getParameterValue('custom.forward_parameters') as $parameter): ?>
        if ($this->hasRequestParameter('<?php echo $parameter ?>'))
        {
            $params['<?php echo $parameter ?>'] = $this->getRequestParameter('<?php echo $parameter ?>');
        }
<?php endforeach; ?>
        if (!empty($params))
        {
            $this->getUser()->getAttributeHolder()->removeNamespace('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
            $this->getUser()->getAttributeHolder()->add($params, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        }
    }
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?> 

<?php foreach ($this->getAllActionsByType('list') as $action_name): ?>
<?php $this->setParameterValuePrefix($action_name) ?> 
<?php if ($this->getParameterValue('list.mark_as')): ?>
    public function execute<?php echo $this->getCustomActionPhpName() ?>MarkAs()
    {  
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $id = $this->getRequestParameter('id');
         $page = $this->getRequestParameter('page');
         $<?php echo $this->getSingularName() ?> = $this->getRequestParameter('<?php echo $this->getSingularName() ?>');


         foreach (<?php echo $this->getPeerClassName() ?>::retrieveByPKs(array_values($order['selected'])) as $<?php echo $this->getSingularName() ?>) 
         {
            if ($id == 'read' || $id == 'unread')
            {
              $<?php echo $this->getSingularName() ?>->setIsMarkedAsRead($id == 'read');
            }
            if ($<?php echo $this->getSingularName() ?>->isModified())
            {
              <?php echo $this->getPeerClassName() ?>::doUpdate($<?php echo $this->getSingularName() ?>);
            }
         }

         DashboardPeer::doRefreshAll();
      }

      return $this->redirect($this->getRequest()->getReferer());      
    }
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType('list') as $action_name): if (empty($action_name)) continue ?>
<?php $this->setParameterValuePrefix($action_name) ?>  
<?php $through_column = $this->getParameterValue('list.build_options.through_column') ?>
<?php if ($through_class = $this->getParameterValue('list.build_options.through_class')): ?>
<?php $class = $this->getClassName() ?>
<?php $related_class = stPropelManyToMany::getRelatedClass($class, $through_class, $through_column) ?>
<?php $related_column = stPropelManyToMany::getRelatedColumn($class, $through_class, $through_column) ?>
<?php $column = stPropelManyToMany::getColumn($class, $through_class, $through_column) ?>
<?php $through_class_var = sfInflector::underscore($through_class); ?>
    public function execute<?php echo $this->getCustomActionPhpName() ?>AddGroup()
    {  
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

        $ids = $this->getRequestParameter('<?php echo $this->getSingularName() ?>[selected]', array($this->getRequestParameter('id')));
        $related_id = $this->getRequestParameter('<?php echo $this->getForwardParameterBy('list.build_options.related_id', '', false) ?>');
        $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        
        foreach ($ids as $id)
        {
            $c = new Criteria();
            $c->add(<?php echo $through_class ?>Peer::<?php echo $related_column->getColumnName() ?>, $related_id);
            $c->add(<?php echo $through_class ?>Peer::<?php echo $column->getColumnName() ?>, $id);
            
            if (!<?php echo $through_class ?>Peer::doCount($c))
            {
                $<?php echo $through_class_var ?> = new <?php echo $through_class ?>();
                $<?php echo $through_class_var ?>->set<?php echo $related_column->getPhpName() ?>($related_id);
                $<?php echo $through_class_var ?>->set<?php echo $column->getPhpName() ?>($id);
                $<?php echo $through_class_var ?>->save();
            }
        }
        
        return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')  ?>?page='.$this->getRequestParameter('page', 1).'<?php echo $this->getForwardParametersForUrl('$', '&', 'list') ?>);
    }
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>

<?php foreach ($this->getAllActionsByType('list') as $action_name): if (empty($action_name)) continue ?>
<?php $this->setParameterValuePrefix($action_name) ?>  
<?php $through_column = $this->getParameterValue('list.build_options.through_column') ?>
<?php if ($through_class = $this->getParameterValue('list.build_options.through_class')): ?>
<?php $class = $this->getClassName() ?>
<?php $related_class = stPropelManyToMany::getRelatedClass($class, $through_class, $through_column) ?>
<?php $related_column = stPropelManyToMany::getRelatedColumn($class, $through_class, $through_column) ?>
<?php $column = stPropelManyToMany::getColumn($class, $through_class, $through_column) ?>
<?php $through_class_var = sfInflector::underscore($through_class); ?>
    public function execute<?php echo $this->getCustomActionPhpName() ?>RemoveGroup()
    {  
        stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

        $ids = $this->getRequestParameter('<?php echo $this->getSingularName() ?>[selected]', array($this->getRequestParameter('id')));
        $related_id = $this->getRequestParameter('<?php echo $this->getForwardParameterBy('list.build_options.related_id', '', false) ?>');
        $forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>forward_parameters');
        
        $c = new Criteria();
        $c->add(<?php echo $through_class ?>Peer::<?php echo $related_column->getColumnName() ?>, $related_id);
        $c->add(<?php echo $through_class ?>Peer::<?php echo $column->getColumnName() ?>, array_values($ids), Criteria::IN);

        foreach (<?php echo $through_class ?>Peer::doSelect($c) as $<?php echo sfInflector::underscore($through_class) ?>)
        {
            $<?php echo sfInflector::underscore($through_class) ?>->delete();
        }        
        
        return $this->redirect('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')  ?>?page='.$this->getRequestParameter('page', 1).'<?php echo $this->getForwardParametersForUrl('$', '&', 'list') ?>);
    } 
<?php endif; ?>
<?php $this->resetParameterValuePrefix() ?>
<?php endforeach; ?>
    <?php if(is_array($this->getParameterValue('include_action_files'))): ?>    
        <?php foreach ($this->getParameterValue('include_action_files') as $file ): ?><?php 
            if (is_readable(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file)): ?><?php 
                include(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$file); ?><?php 
            endif; ?><?php 
        endforeach; ?>
   <?php endif; ?>
}
<?php $this->restoreModelClass() ?>