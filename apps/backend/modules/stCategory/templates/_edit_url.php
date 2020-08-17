<?php echo input_tag('category[edit_url]', $category->getUrl(), array('disabled' => $category->getAutoGenerateUrl(), 'size' => '64')) ?>

    <?php echo checkbox_tag('category[auto_generate_url]', true, $category->getAutoGenerateUrl(), array('onchange' => "$('category_edit_url').disabled = this.checked")) ?>
    <?php echo label_for('category_auto_generate_url', __('Generuj automatycznie'), array('style' => 'float: none; display: inline; padding: 0px')) ?>
