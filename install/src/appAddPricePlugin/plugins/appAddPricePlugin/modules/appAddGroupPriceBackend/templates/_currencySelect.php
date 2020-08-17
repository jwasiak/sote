<?php
if ($lock_select_currency == 1) {

    echo object_select_tag($add_group_price, 'getCurrencyId', array('related_class' => 'Currency', 'control_name' => 'add_group_price[currency_id]', 'disabled' => 'disabled', ));
    echo input_hidden_tag('add_group_price[currency_id]', $add_group_price->getCurrencyId());
    
} else {

    echo '<select id="add_group_price_currency_id" name="add_group_price[currency_id]">';
       
       foreach ($result as $key => $value) {
           
            echo '<option value="' . $key . '">' . $value . '</option>';
       }

    echo '</select>';

}
?>
