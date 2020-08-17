<?php use_helper('stUrl') ?>
<div class="smarty_popup_container">
   <div class="close"><a href="#"><img src="/images/backend/beta/gadgets/close.png" alt="" /></a></div>
   <h2><?php echo __('Edycja') ?></h2>
   <div class="content">
      <form id="content_block_form" target="content_block_form_submit" action="<?php echo st_url_for('stSmartyFrontend/contentBlockEdit') ?>?save=true" method="post" enctype="multipart/form-data"> 
         <input type="hidden" value="<?php echo htmlspecialchars($sf_request->getParameter('data')) ?>" name="data" id="content_block_data" />
<?php if ($data['decorator'] == 'box'): ?>
         <div class="form-row">
            <label for="content_block_title"><b><?php echo __('Tytuł') ?>:</b></label><br />
            <input name="content_block[title]" id="content_block_title" type="text" maxlength="60" value="<?php echo $block->getContentByName('title', $data['title']) ?>" />
         </div>      
<?php endif ?>
         <div class="form-row">         
            <label for="content_block_content"><?php echo __('Zawartość') ?>:</label><br />
<?php if ($data['content_type'] == 'image'): ?>

<?php foreach ($block->getImagesContent() as $index => $image): ?>
            <p class="smarty_image">
               <img src="<?php echo $image['path'] ?>" alt="" style="max-height: 64px" />
               <input name="content_block[image][<?php echo $index ?>]" type="file" value="" />
            </p>
<?php endforeach; ?>

<?php else: ?>         
            <?php 
            $editor = new sfRichTextEditorTinyMCE();
            $editor->initialize("content_block[content]", $block->getContentByName('content', $data['content']));
            echo $editor->toHTML();
            ?>
<?php endif; ?>
         </div>
         <ul class="form-row smarty_button">
            <li class="left"><a href="#" class="smarty_submit roundies"><?php echo __('Zapisz') ?></a></li>
<?php if (!$block->isNew()): ?>
            <li class="right"><a href="<?php echo st_url_for('stSmartyFrontend/contentBlockRestore') ?>" class="smarty_restore roundies"><?php echo __('Przywróć domyślne') ?></a></li>
<?php endif; ?>
         </ul>

         <div class="clear"></div>
      </form>
      <iframe style="display: none" name="content_block_form_submit" id="content_block_form_submit"></iframe>
   </div>
</div>
<script type="text/javascript">
jQuery(function($) {
   form = $('#content_block_form');

<?php if ($data['decorator'] == 'box'): ?>
   var title = $('#content_block_title');

   title.keyup(function() {
      if (!title.val()) {
         title.addClass('form_error');
      } else {
         title.removeClass('form_error');
      }
   });
<?php endif ?>   

   form.find('.smarty_submit').click(function() { 
<?php if ($data['decorator'] == 'box'): ?>      
      if (title.val()) {    
         form.submit();
      }
<?php else: ?>
      form.submit();
<?php endif ?>
      return false;
   });  

   form.find('.smarty_restore').click(function() {
      if (confirm('<?php echo __("Jesteś pewien, że chcesz przywroć domyślną zawartość?") ?>'))
      {
         $(this).trigger('restore');
      }

      return false;
   });  
});

</script>