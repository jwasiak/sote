<?php if($id != ""): ?>

    <div style="float: left; width: 260px;">
        <h3><?php echo __('Dane bilingowe') ?></h3>
        <?php st_include_partial('user_data', array('user_data' => $user_data_billing)); ?>
    </div>
    <div style="float: left; width: 260px; padding-left: 20px">
        <h3><?php echo __('Dane dostawy') ?></h3>
        <?php st_include_partial('user_data', array('user_data' => $user_data_delivery)); ?>
    </div>
    <br class="st_clear_all" />

<?php endif; ?>