function stDelivery(){};

stDelivery.executeAjaxUpdate = function(trigger, url, params)
{
    var form = jQuery('#st_basket-delivery-form');
    
    if (form.length) {
        var form_elements = jQuery(form.get(0).elements);
    
        trigger.prop('disabled', true);
    
        form_elements.prop('disabled', true);
    }

    if (!params) {
        params = {};
    }

    params.id = trigger.val();

    jQuery(document).trigger('delivery.update.started');

    params.billing_country = jQuery('#user_data_billing_country, #billing-country').val();

    jQuery.get(url, params, function() {
        if (form.length) {
            trigger.prop('disabled', false);
            form_elements.prop('disabled', false); 
        }      

        jQuery(document).trigger('delivery.update.finished'); 
    });
}