<table class="st_record_list" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo __('Płatności sklepu');?></th>
            <th><?php echo __('Płatności Trusted Shops');?></th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($paymentTypes as $id => $name)
    {
    	echo '<tr><td>'.$name.'</td>';
    	echo '<td>'.select_tag('trusted_shops[payment_method]['.$id.']', options_for_select($paymentMethods, $paymentTypesSelected[$id])).'</td></tr>';
    }
    ?>
    </tbody>
</table>