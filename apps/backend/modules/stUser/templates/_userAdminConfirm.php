<?php if($id != ""): ?>
    <?php if($admin_confirm == 1): ?>
        <span style="color: green;"><?php echo __("Dane zostały zweryfikowane.") ?></span>
        <?php echo input_hidden_tag('partner_data[is_admin_confirm]', 1); ?>
    <?php else: ?>
            <span style="color: red;"><?php echo link_to(__("Oznacz klienta jako zweryfikowanego."),"/user/updateAdminConfirm?id=".$id) ?></span>
            <?php echo input_hidden_tag('partner_data[is_admin_confirm]', 0); ?>
    <?php endif; ?>
<?php endif; ?>