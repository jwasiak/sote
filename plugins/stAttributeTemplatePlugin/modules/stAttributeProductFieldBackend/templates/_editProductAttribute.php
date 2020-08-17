<?php echo st_get_admin_item_list_head(); ?>
    <?php foreach($attributes as $attribute): ?>        
        <div class="content<?php if ($sf_request->hasError('attributes{'.$attribute->getId().'}')): ?> form-error<?php endif; ?>">
            <?php if ($sf_request->hasError('attributes{'.$attribute->getId().'}')): ?>
                <?php echo form_error('attributes{'.$attribute->getId().'}', array('class' => 'form-error-msg')) ?>
            <?php endif; ?>
        </div>
        
        <?php if(!empty($values[$attribute->getId()])): ?>
            <?php $input = object_input_tag($values[$attribute->getId()], 'getValue', array('size' => 10, 'control_name' => 'attributes['.$attribute->getId().']'))?>
        <?php else: ?>
            <?php $input = input_tag('attributes['.$attribute->getId().']', null, array('size' => 10, 'control_name' => 'attributes['.$attribute->getId().']'))?>
        <?php endif; ?>
        
        <?php //echo st_get_admin_item_list_element($attribute->getName(), $input) ?>
        <?php echo $input ?>
            
    <?php endforeach;?>
<?php echo st_get_admin_item_list_foot(); ?>