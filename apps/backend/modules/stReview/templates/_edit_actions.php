<?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
      <?php echo st_get_admin_action('list', __('Lista', null, 'stAdminGeneratorPlugin'), 'stReview/list?id='.$review->getId(), array (
)) ?>      
    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save')) ?>
<?php echo st_get_admin_actions_foot() ?>