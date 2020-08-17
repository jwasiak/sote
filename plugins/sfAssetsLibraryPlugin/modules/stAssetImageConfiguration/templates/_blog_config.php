<?php
use_helper('Validation');
$id = get_id_from_name($name);
$error_name = str_replace(array('[', ']'), array('{', '}'), $name);
?>

<table class="st_record_list" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Szerokość') ?></th>
            <th><?php echo __('Wysokość') ?></th>
            <th><?php echo __('Jakość') ?></th>
        </tr>
    </thead>
    <tbody>
<?php if (form_has_error($error_name.'{width}')): ?>
       <tr>
          <td colspan="5" class="form-error-msg"><?php echo form_error($error_name.'{width}') ?></td>
       </tr>       
<?php endif; ?>
<?php if (form_has_error($error_name.'{height}')): ?>
       <tr>
          <td colspan="5" class="form-error-msg"><?php echo form_error($error_name.'{height}') ?></td>
       </tr>
<?php endif; ?>
       <tr>
         <td<?php if (form_has_error($error_name.'{width}')): ?> class="form-error"<?php endif ?>><?php echo input_tag($name.'[width]', isset($value['width']) ? $value['width'] : null, array('size' => 4)) ?> <?php echo __('px') ?></td>
         <td<?php if (form_has_error($error_name.'{height}')): ?> class="form-error"<?php endif ?>><?php echo input_tag($name.'[height]', isset($value['height']) ? $value['height'] : null, array('size' => 4)) ?> <?php echo __('px') ?></td>
         <td><?php echo select_tag($name.'[quality]', options_for_select(array(75 => __('słaba'), 85 => __('dobra'), 100 => __('najlepsza')),isset($value['quality']) ? $value['quality'] : null)) ?></td>
      </tr>
    </tbody>
</table>
<?php echo input_hidden_tag($name.'[auto_crop]', 1) ?>