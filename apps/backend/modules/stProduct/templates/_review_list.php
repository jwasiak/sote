<div style="border: 1px solid #ccc; margin-bottom: 10px; padding: 5px 10px; background-color: #f1f1f1;">
    <?php st_include_component("stReview", "linkToAddReview", array('product_id' => $forward_parameters['product_id'])); ?>
    
</div>

<table cellspacing="0" cellpadding="0" class="st_record_list record_list">
    <thead>         
        <tr> 
<?php if ($review_action_select_options): ?>
            <th width="1%">
               <?php echo checkbox_tag('review[select_control_head]', true, false, array('class' => 'selector_control')) ?>
            </th>
<?php endif; ?>    
    
            <th width="1%">&nbsp;</th>
        
            <?php st_include_partial('review_list_th_tabular', array('forward_parameters' => $forward_parameters, 'pager' => $pager)) ?>
            <th width="1%">&nbsp;</th>
        </tr>    
    </thead>
    <tbody>
<?php $i = 1; $k=1; foreach ($pager->getResults() as $review): $odd = fmod(++$i, 2) ?>   
<?php if ($odd): ?>
        <tr class="highlight">
<?php else: ?>
        <tr>
<?php endif; ?>
<?php if ($review_action_select_options): ?>
        <td>
            <?php echo checkbox_tag('review[selected][' . $review->getId() . ']', $review->getId(), false, array('class' => 'selector')) ?>
        </td>
<?php endif; ?>
        <td>
          <ul class="st_object_actions">
             
                                               <li><a href="<?php echo url_for('stProduct/reviewEdit?id='.$review->getId()) ?>"><img src="/images/backend/beta/icons/16x16/edit.png" title="<?php echo __('edit') ?>" class="tooltip" /></a></li>                          
                                 </ul>
        </td>
        <?php st_include_partial('review_list_td_tabular', array('review' => $review, 'forward_parameters' => $forward_parameters)) ?>
        <?php st_include_partial('review_list_td_actions', array('review' => $review, 'forward_parameters' => $forward_parameters)) ?>
        </tr>
<?php endforeach; ?>
<?php if (!$pager->getNbResults()): ?>
        <tr><td colspan="9">
        <?php echo __('Brak rekordów - zmień kryteria wyszukiwania', null, 'stAdminGeneratorPlugin') ?>
        </td></tr> 
<?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">
document.observe("dom:loaded", function() {   
   $$('#additional-filter-fields .is_empty_field input[type=checkbox]').each(function(input) {
      var id_part = input.id.replace(/_is_empty$/, '');

      if ($(id_part))
      {
         $(id_part).writeAttribute('disabled', input.checked);
      }
      else
      {
         $(id_part+'_from').writeAttribute('disabled', input.checked);
         $(id_part+'_to').writeAttribute('disabled', input.checked);
      }

      input.observe('click', function() {
         if ($(id_part))
         {
            $(id_part).writeAttribute('disabled', this.checked);
         }
         else
         {
            $(id_part+'_from').writeAttribute('disabled', this.checked);
            $(id_part+'_to').writeAttribute('disabled', this.checked);
         }
      });
   });

<?php if ($sf_user->getAttribute('reviewList.mode', null, 'soteshop/stAdminGenerator/stProduct/config') == 'edit'): ?>
   var editables = $$('input.editable');

   editables.each(function(input) {
      input.observe('keypress', function(event){
         if (event.keyCode == Event.KEY_RETURN)
         {
            Event.stop(event);

            var form =  $('record_list_form');

            form.action = "<?php echo st_url_for('stProduct/reviewUpdateList') ?>";

            form.submit();
         }
      });
   });

   $$('input.update-list-form').each(function(input) {
      input.observe('click', function(event) {
         var form = $('record_list_form');

         Event.stop(event);

         form.action = "<?php echo st_url_for('stProduct/reviewUpdateList') ?>";

         form.submit();
      });
   });
<?php endif; ?>
   var controls = $$('input.selector_control');

   var selectors = $$('input.selector');

   controls.each(function(control) {
      control.observe('click', function() {
         selectors.each(function(selector) {
            selector.up().removeClassName('highlight');

            if (control.checked)
            {
               selector.up(1).addClassName('selected');

               selector.checked = true;
            }
            else
            {
               selector.up(1).removeClassName('selected');

               selector.checked = false;
            }
         });

         controls.each(function(c) {
            c.checked = control.checked;
         })
      });
   });

   selectors.each(function(selector) {
      selector.observe('click', function() {
         selectors.each(function(s) {
            s.up().removeClassName('highlight');
         })

         if (this.checked)
         {
            this.up(1).addClassName('selected');
         }
         else
         {
            this.up(1).removeClassName('selected');
         }
      });
   });

 $$('.list_select_control select').each(function(select) {
    $A(select.options).each(function(option) {

       if (option.title)
       {
         option.writeAttribute('confirm', option.title);

         option.title = '';
       }
    });
    select.observe('change', function()
    {
      if (this.selectedIndex > 0)
      {
         var checked = selectors.any(function(selector) {
            return selector.checked;
         });

         if (checked)
         {
            var option = $(this.options[this.selectedIndex]);

            var confirm_msg = '<?php echo __("Jesteś pewien, że chcesz wykonać operację", null, "stAdminGeneratorPlugin")." \"%action%\" ".__("na wybranych rekordach?", null, "stAdminGeneratorPlugin") ?>';

            var confirm = option.readAttribute('confirm');

            var confirmed = window.confirm(confirm_msg.replace('%action%', confirm ? confirm : option.text));

            if (confirmed)
            {
               this.form.action = option.value;

               this.form.submit();
            }
         }
         else
         {
            window.alert('<?php echo __("Musisz wybrać przynajmniej jeden rekord", null, "stAdminGeneratorPlugin") ?>');

            selectors.each(function(selector) {
               selector.up().addClassName('highlight');
            });
         }

         this.selectedIndex = 0;
      }
    });
 });
});
</script>