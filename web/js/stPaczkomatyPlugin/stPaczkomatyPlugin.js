(function($) {

    $.paczkomatySelectMachine = function(number, messages) {
        $.getJSON('/paczkomaty/getMachine/' + number, function(data) {
            var deliveryId = $('input.st_delivery-default:checked').val();

            $('#paczkomaty_machine_number').val(number);
            var different_delivery = $('#different_delivery');

            $('#st_paczkomaty_delivery-' + deliveryId).html(messages[1]);
            $('#st_paczkomaty_delivery_address-' + deliveryId).html(messages[4] + ' ' + data.number + '<br />' + data.street + ' ' +  data.house + '<br/>' + data.postCode + ' ' + data.city);


            $('#st_paczkomaty_delivery_address-' + deliveryId).show();

            if (!different_delivery.length) {
                $('#order_form_delivery').hide();
                if($('#order_form_billing').hasClass('left')) {
                    $('#order_form_billing').removeClass('left').addClass('right');
                }
            } else if (different_delivery.prop('checked')) {
                different_delivery.get(0).click();
            }

            different_delivery.prop('disabled', true);

            $(".frame").paczkomatyEqualHeight();
            $(".data_frame").paczkomatyEqualHeight();
        });
    }

    $.paczkomatyRestoreBasket = function(messages) {
        var deliveryId = $('input.st_delivery-default:checked').val();
            
        $('#paczkomaty_machine_number').val('');
        var different_delivery = $('#different_delivery');
        different_delivery.prop('disabled', false);

        $('.paczkomaty_active_overlay').html(messages[0]);
        $('.st_paczkomaty_delivery_address').html('');

        $('.st_paczkomaty_delivery_address').hide();

        if (!different_delivery.length) {
            if($('#order_form_billing').hasClass('right')) {
                $('#order_form_billing').removeClass('right').addClass('left');
                $('#order_form_delivery').show();
            }
        }

        $(".frame").paczkomatyEqualHeight();
        $(".data_frame").paczkomatyEqualHeight();
    }

    $.fn.paczkomatyEqualHeight = function() {
        tallest = 0;
        this.each(function() {
            $(this).css("height","auto");
            thisHeight = $(this).height();
            if(thisHeight > tallest) {
                tallest = thisHeight;
            }
        });
        this.height(tallest);
    }


    $.paczkomatySelectMachineResponsive = function(number, messages) {
        $.getJSON('/paczkomaty/getMachine/' + number, function(data) {
            var deliveryId = $('input.delivery-radio:checked').val();

            $('#paczkomaty_machine_number').val(number);
            var different_delivery = $('#different_delivery');

            $('#st_paczkomaty_delivery-' + deliveryId).html(messages[1]);
            $('#st_paczkomaty_delivery_address-' + deliveryId).html(messages[4] + ' ' + data.number + '<br />' + data.street + ' ' +  data.house + '<br/>' + data.postCode + ' ' + data.city);

            $('#st_paczkomaty_delivery_address-' + deliveryId).show();

            if (!$('#order_form_delivery').parent().hasClass('panel')) {
                $('#order_form_delivery').addClass('hidden');
                $('#order_form_billing').parent().addClass('col-sm-offset-6');
            } else if (different_delivery.prop('checked')) {
                different_delivery.get(0).click();
            }

            different_delivery.prop('disabled', true);

            $('body [data-equalizer]').equalizer({ use_tallest: true });
        });
    }

    $.paczkomatyRestoreBasketResponsive = function(messages) {
        var deliveryId = $('input.delivery-radio:checked').val();
            
        $('#paczkomaty_machine_number').val('');
        $('#different_delivery').prop('disabled', false);

        $('.paczkomaty_active_overlay').html(messages[0]);
        $('.st_paczkomaty_delivery_address').html('');

        $('.st_paczkomaty_delivery_address').hide();

        if ($('#order_form_billing').parent().hasClass('col-sm-offset-6')) {
            $('#order_form_billing').parent().removeClass('col-sm-offset-6');
            $('#order_form_delivery').removeClass('hidden');
        }

        $('body [data-equalizer]').equalizer({ use_tallest: true });
    }

}(jQuery));
