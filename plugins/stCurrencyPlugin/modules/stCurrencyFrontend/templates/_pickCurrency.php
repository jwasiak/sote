<?php
    st_theme_use_stylesheet('stCurrencyPlugin.css');
    $smarty->assign("form_start", form_tag('currency/addCurrency'));
    $smarty->assign("select_currency", select_tag("currency", options_for_select($currencies, $selected), array('onchange' => 'this.form.submit()')));
    $smarty->assign("save_button");
    $smarty->display("currency_pick.html");
?>