<?php
if ($lock_select_currency == 1) {

    echo object_select_tag($add_price, 'getCurrencyId', array('related_class' => 'Currency', 'control_name' => 'add_price[currency_id]', 'disabled' => 'disabled', ));
} else {

    echo '<select id="add_price_currency_id" name="add_price[currency_id]">';
       
       foreach ($result as $key => $value) {
           
            echo '<option value="' . $key . '">' . $value . '</option>';
       }

    echo '</select>';

}
?>
