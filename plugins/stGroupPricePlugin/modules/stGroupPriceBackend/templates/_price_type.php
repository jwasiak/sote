<?php 
$group['type'] = "netto";
if($sf_request->getParameter('group[type]')){
$group['type'] = $sf_request->getParameter('group[type]');    
}
?>
<select id="group_type" name="group[type]" style="width: 150px">
    <option <?php if($group['type']=="netto") : ?> selected="selected" <?php endif; ?> value="netto"><?php echo __('Cenę netto') ?></option>
    <option <?php if($group['type']=="brutto") : ?> selected="selected" <?php endif; ?> value="brutto"><?php echo __('Cenę brutto') ?></option>
    <option <?php if($group['type']=="old_netto") : ?> selected="selected" <?php endif; ?> value="old_netto"><?php echo __('Starą cenę netto') ?></option>
    <option <?php if($group['type']=="old_brutto") : ?> selected="selected" <?php endif; ?> value="old_brutto"><?php echo __('Starą cenę brutto') ?></option>
    <option <?php if($group['type']=="wholesale_a_netto") : ?> selected="selected" <?php endif; ?> value="wholesale_a_netto"><?php echo __('Cenę hurtową A netto') ?></option>
    <option <?php if($group['type']=="wholesale_a_brutto") : ?> selected="selected" <?php endif; ?> value="wholesale_a_brutto"><?php echo __('Cenę hurtową A brutto') ?></option>
    <option <?php if($group['type']=="wholesale_b_netto") : ?> selected="selected" <?php endif; ?> value="wholesale_b_netto"><?php echo __('Cenę hurtową B netto') ?></option>
    <option <?php if($group['type']=="wholesale_b_brutto") : ?> selected="selected" <?php endif; ?> value="wholesale_b_brutto"><?php echo __('Cenę hurtową B brutto') ?></option>
    <option <?php if($group['type']=="wholesale_c_netto") : ?> selected="selected" <?php endif; ?> value="wholesale_c_netto"><?php echo __('Cenę hurtową C netto') ?></option>
    <option <?php if($group['type']=="wholesale_c_brutto") : ?> selected="selected" <?php endif; ?> value="wholesale_c_brutto"><?php echo __('Cenę hurtową C brutto') ?></option>          
</select>