<script type="text/javascript">
jQuery(function ($)
{
       function equalHeight(group)
       {
       tallest = 0;
       group.each(function() {
          $(this).css("height","auto");
          thisHeight = $(this).height();
          if(thisHeight > tallest) {
             tallest = thisHeight;
          }
        });
        group.height(tallest);
        }

        $(window).load(function() {
           equalHeight($("#product_list_backend .name"));
        });
});
</script>


<div id="product_list_backend">
<?php foreach ($pager->getResults() as $product):?>
  <div class="item box roundies">
    <a class="image" href="<?php echo st_url_for('stProduct/edit?id=' . $product->getId()) ?>"><span style="background-image: url('<?php echo st_product_image_path($product, 'large') ?>')"></span></a>
    <div class="name"><?php echo link_to($product->getName(), 'stProduct/edit?id=' . $product->getId())?></div>
    <div style="float: left; text-align: left; padding: 5px;">

         <?php echo link_to(image_tag('backend/beta/icons/16x16/edit.png', array('alt' => __('edit'), 'title' => __('edit'))), 'stProduct/edit?id='.$product->getId()) ?>
        
<?php
echo st_link_to(image_tag('backend/beta/icons/16x16/view_shop.png'), '@stProduct?action=viewProduct&id='.$product->getId(), array('target' => '_blank'));
?> 
         <?php echo link_to(image_tag('backend/icons/delete.gif', array('alt' => __('delete'), 'title' => __('delete'))), 'stProduct/delete?id='.$product->getId(), array (
      'post' => true,
      'confirm' => __('Potwierdź usuniecie produktu?', null, 'stProduct'),
)) ?>

</div>
    <div class="price"><?php echo st_back_price($product->getPriceBrutto(true), true, true);?></div>
    <div style="clear: both;"></div>
  </div>
<?php endforeach;?>
<div style="clear: both;"></div>
</div>
<?php if (!$pager->getNbResults()): ?>
<?php echo __('Brak rekordów - zmień kryteria wyszukiwania', null, 'stAdminGeneratorPlugin') ?>
<?php endif; ?>




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

<?php if ($sf_user->getAttribute('list.mode', null, 'soteshop/stAdminGenerator/stProduct/config') == 'edit'): ?>
   var editables = $$('input.editable');

   editables.each(function(input) {
      input.observe('keypress', function(event){
         if (event.keyCode == Event.KEY_RETURN)
         {
            Event.stop(event);

            var form =  $('st_record_list-form');

            form.action = "<?php echo st_url_for('stProduct/updateList') ?>";

            form.submit();
         }
      });
   });

   $$('input.update-list-form').each(function(input) {
      input.observe('click', function(event) {
         var form = $('st_record_list-form');

         Event.stop(event);

         form.action = "<?php echo st_url_for('stProduct/updateList') ?>";

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