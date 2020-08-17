function openLukasUrlWithPost(url) {
    newWindow = window
            .open(
                    url,
                    'lukasWindow',
                    'location=no, scrollbars=yes, resizable=yes, toolbar=no, menubar=no, height=600, width=840');
    window.setTimeout('document.lukasCalculator.submit();', 500);
    if (window.focus) {
        newWindow.focus()
    }
    return false;
}

function openLukasUrl(url) {
    newWindow = window
            .open(
                    url,
                    'lukasWindow',
                    'location=no, scrollbars=yes, resizable=yes, toolbar=no, menubar=no, height=600, width=840');
    if (window.focus) {
        newWindow.focus()
    }
    return false;
}

function lukasUpdatePrice() {
    var basket_total_amount = 0.0;
    
    if (document.getElementById('st_product_options-price_brutto'))
        basket_total_amount = document.getElementById('st_product_options-price_brutto').innerHTML;

    if (document.getElementById('st_product_options-price_brutto_only'))
        basket_total_amount = document.getElementById('st_product_options-price_brutto_only').innerHTML;

    if (document.getElementById('st_product_options-price-brutto'))
        basket_total_amount = document.getElementById('st_product_options-price-brutto').innerHTML;

    var basket_total_amount_fix = '';
    for ( var i = 0; i < basket_total_amount.length; i++) {
        if (basket_total_amount.charAt(i) == "0"
                || basket_total_amount.charAt(i) == "1"
                || basket_total_amount.charAt(i) == "2"
                || basket_total_amount.charAt(i) == "3"
                || basket_total_amount.charAt(i) == "4"
                || basket_total_amount.charAt(i) == "5"
                || basket_total_amount.charAt(i) == "6"
                || basket_total_amount.charAt(i) == "7"
                || basket_total_amount.charAt(i) == "8"
                || basket_total_amount.charAt(i) == "9"
                || basket_total_amount.charAt(i) == ","
                || basket_total_amount.charAt(i) == ".")
            basket_total_amount_fix = basket_total_amount_fix
                    + basket_total_amount.charAt(i);
        if (basket_total_amount.charAt(i) == "/")
            break;
    }
    basket_total_amount = basket_total_amount_fix.replace(',', '.');
    var last_dot = basket_total_amount.lastIndexOf('.');

    var front = basket_total_amount.slice(0, last_dot).replace('.', '');
    basket_total_amount = front + basket_total_amount.slice(last_dot);

    document.getElementById('lukasPrice').value = basket_total_amount;
}
