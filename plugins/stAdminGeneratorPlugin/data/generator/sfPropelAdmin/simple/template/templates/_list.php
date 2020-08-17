<?php
$object_actions = $this->getParameterValue('list.object_actions');
?>
<table cellspacing="0" cellpadding="0" class="st_record_list record_list"<?php if ($this->getParameterValue('list.auto_width')): ?> style="width: 100%"<?php endif; ?>>
    <thead>         
        <tr> 
[?php if ($<?php echo $this->getSingularName() ?>_action_select_options): ?]
            <th width="1%">
               [?php echo checkbox_tag('<?php echo $this->getSingularName() ?>[select_control_head]', true, false, array('class' => 'selector_control')) ?]
            </th>
[?php endif; ?]    
<?php if ($object_actions && isset($object_actions['_edit'])): ?>    
            <th width="1%">&nbsp;</th>
<?php endif; ?>        
            [?php st_include_partial('<?php echo $this->getCustomActionName('', '_') ?>list_th_tabular', array('forward_parameters' => $forward_parameters, 'pager' => $pager)) ?]
<?php if ($this->getParameterValue('list.build_options.through_class')): $i18n_catalogue = $this->getParameterValue('list.fields._assigned.i18n', 'stAdminGeneratorPlugin') ?>
            <th width="1%">
               [?php if ($sf_user->getAttribute('sort', null, 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') == 'assigned'): ?]
               [?php echo link_to(__('<?php echo $this->getParameterValue('list.fields._assigned', 'Przypisany') ?>', array(), '<?php echo $i18n_catalogue ?>'), '<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>?sort=assigned&type='.($sf_user->getAttribute('type', 'asc', 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort') == 'asc' ? 'desc' : 'asc')) ?]
               [?php echo  image_tag('/images/backend/icons/'.$sf_user->getAttribute('type', 'asc', 'sf_admin/<?php echo $this->getGeneratedModuleName() ?>/<?php echo $this->getCustomActionName('', '_') ?>sort').'.png',array('align' => 'absmiddle')) ?]
               [?php else: ?]
               [?php echo link_to(__('<?php echo $this->getParameterValue('list.fields._assigned', 'Przypisany') ?>', array(), '<?php echo $i18n_catalogue ?>'), '<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'List', 'list') ?>?sort=assigned&type=asc') ?]
               [?php endif; ?]
            </th>
<?php endif; ?>
<?php if ($this->isObjectActionVisible()): ?>
            <th width="1%">&nbsp;</th>
<?php endif; ?>
        </tr>    
    </thead>
    <tbody>
<?php $mark_as = $this->getParameterValue('list.mark_as') ?>
[?php $i = 1; $k=1; foreach ($pager->getResults() as $<?php echo $this->getSingularName() ?>): $odd = fmod(++$i, 2); ?]   
<?php foreach ($this->getColumns('list.display') as $column): if ($this->getParameterValue('list.editable.'.$column->getName()) === null) continue; ?>
[?php if (form_has_error('<?php echo $this->getSingularName() ?>{'.$<?php echo $this->getSingularName() ?>->getPrimaryKey().'}{<?php echo $column->getName() ?>}')): ?]
        <tr><td colspan="<?php echo $this->getRecordListColSpan() ?>">[?php echo form_error('<?php echo $this->getSingularName() ?>['.$<?php echo $this->getSingularName() ?>->getPrimaryKey().'][<?php echo $column->getName() ?>]', array('class' => 'list_error')); ?]</td></tr>
[?php endif; ?]
<?php endforeach; ?>
        <tr class="[?php if ($odd): ?]highlight[?php endif ?]<?php if ($mark_as): ?>[?php if (!$<?php echo $this->getSingularName() ?>->getIsMarkedAsRead()): ?] marked_as_not_read[?php endif ?]<?php endif ?>">
[?php if ($<?php echo $this->getSingularName() ?>_action_select_options): ?]
        <td>
            [?php echo checkbox_tag('<?php echo $this->getSingularName() ?>[selected][' . <?php echo $this->getPrimaryKeyField() ?> . ']', <?php echo $this->getPrimaryKeyField(':') ?>, false, array('class' => 'selector')) ?]
        </td>
[?php endif; ?]
<?php if ($object_actions && isset($object_actions['_edit'])): ?>
<?php if (($object_actions = $this->getParameterValue('list.object_actions')) && isset($object_actions['_edit'])): ?>
        <td>
          <ul class="st_object_actions">
          <?php foreach ($this->getParameterValue('list.object_actions') as $actionName => $params): ?>   
             <?php if ($actionName=='_edit'):?>
                 <?php if (!isset($params['action'])) $params['action'] = $this->getCustomActionNameCamelized('', 'Edit', 'edit') ?>
                 <?php echo $this->addCredentialCondition($this->getLinkToAction($actionName, $params, true), $params) ?>
             <?php endif ?>
          <?php endforeach; ?>
          </ul>
        </td>
<?php endif; ?>
<?php endif; ?>
        [?php st_include_partial('<?php echo $this->getCustomActionName('', '_') ?>list_td_tabular', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'forward_parameters' => $forward_parameters)) ?]
<?php if ($this->getParameterValue('list.build_options.through_class')): ?>         
        [?php st_include_partial('<?php echo $this->getCustomActionName('', '_') ?>list_td_assigned', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'forward_parameters' => $forward_parameters)) ?]    
<?php endif; ?>
<?php if ($this->isObjectActionVisible()): ?>
        [?php st_include_partial('<?php echo $this->getCustomActionName('', '_') ?>list_td_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'forward_parameters' => $forward_parameters)) ?]
<?php endif; ?>
        </tr>
[?php endforeach; ?]
[?php if (!$pager->getNbResults()): ?]
        <tr><td colspan="<?php echo $this->getRecordListColSpan() ?>">
        [?php echo __('Brak rekordów - zmień kryteria wyszukiwania', null, 'stAdminGeneratorPlugin') ?]
        </td></tr> 
[?php endif; ?]
    </tbody>
</table>
<script type="text/javascript">
  jQuery(function($) {
    var highlighted = false;
    var selectors = null;

    function submitChanges() {
      $('#record_list_form')
        .attr('action', "[?php echo st_url_for('<?php echo $this->getModuleName() ?>/<?php echo $this->getCustomActionNameCamelized('', 'UpdateList', 'updateList') ?>') ?]")
        .submit();
    }

    function submitSelectFormChanges(select, ajax) {
      var form = select.closest('form');
      if (ajax) {
        $(document).trigger('preloader', 'show');
        $.post(select.val(), form.serialize(), function(response) {
          $(document).trigger('preloader', ['update', response]);
        });
      } else {
        form.attr('action', select.val());
        form.submit();
      } 
    }

    $('#update-list-form').click(function() {
      submitChanges();
      return false;
    });

    $('#filter_list_form .is_empty_field input[type=checkbox]').change(function() {
      var input = $(this);
      var inputs = input.closest('.field').find('input, select').not('[type=checkbox]');

      inputs.prop('disabled', input.prop('checked'));
    }).change();

    $('.record_list').each(function() {

      var recordList = $(this);

      [?php if ($sf_user->getAttribute('<?php echo $this->getCustomActionNameCamelized('', 'List', 'list')?>.mode', null, 'soteshop/stAdminGenerator/<?php echo $this->getModuleName() ?>/config') == 'edit'): ?]
        recordList.find('input.editable').keypress(function(e) {
          if (e.which == 13) {
            submitChanges();
            return false;
          }
        });
      [?php endif ?]

      selectors = recordList.find('input.selector').change(function() {
        var input = $(this);
        if (input.prop('checked')) {
          if (highlighted) {
            highlighted = false;
            $('body td.highlight').removeClass('highlight');
          }

          input.closest('tr').addClass('selected');
        } else {
          input.closest('tr').removeClass('selected');
        }
      });

      recordList.find('input.selector_control').change(function() {
        selectors.prop('checked', $(this).prop('checked')).change();
      }); 
    });

    $('.list_select_control select').change(function() {
      var select = $(this);

      if (select.val()) {
        if (selectors.is(':checked')) {
          var option = select.find(':selected');
          var category = option.data('category');
          var ajax = option.data('ajax');
          var confirm_msg = '[?php echo __("Jesteś pewien, że chcesz wykonać operację", null, "stAdminGeneratorPlugin")." \"%action%\" ".__("na wybranych rekordach?", null, "stAdminGeneratorPlugin") ?]';
          var confirm = option.data('confirm');

          if (confirm !== 0) {
            var message = category ? category+': '+option.text() : option.text();
            var confirmed = window.confirm(confirm_msg.replace('%action%', confirm ? confirm : message));

            if (confirmed)
            {
              submitSelectFormChanges(select, ajax);
            }            
          }
          else {
            submitSelectFormChanges(select, ajax);    
          }

          select.val("");
        } else {
          highlighted = true;
          selectors.closest('td').addClass('highlight');
          select.val("");
          window.alert('[?php echo __("Musisz wybrać przynajmniej jeden rekord", null, "stAdminGeneratorPlugin") ?]');
        }
      }
    });

  });

</script>