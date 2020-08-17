(function($) {
    stAllegroEdit = {
        reloadTypeView: function() {
            var type = $('input[name="allegro_auction[auction_type]"]:checked').val()   
            var duration = $('#st-allegro-edit-duration');
            if (type == 1) {

                $('#st-allegro-edit-price-start, #st-allegro-edit-price-min').prop('disabled', true);

                duration.find('option').filter(function(index) {
                    return index >= 5;
                }).removeAttr('disabled').show();

                duration.find('option').filter(function(index) { 
                    return index < 5;
                }).attr('disabled', 'disabled').hide();

                if (duration.find('option:selected').index() < 5) {
                    duration.val(5);
                }
            } else {
                $('#st-allegro-edit-price-start, #st-allegro-edit-price-min').prop('disabled', false);
                    
                duration.find('option').filter(function(index) {
                    return index >= 5;
                }).attr('disabled', 'disabled').hide();

                duration.find('option').filter(function(index) { 
                    return index < 5;
                }).removeAttr('disabled').show();

                if (duration.find('option:selected').index() >= 5) {
                    duration.val(0);
                }
            }
        },

        reloadDelivery: function() {
            var scriptName = window.location.pathname.split('/')[1];

            var id = $('option:selected', $('#st-allegro-edit-allegro-delivery')).val();
            if (id != 0) {
                $('#st-allegro-edit-deliveries').html('<img id="st-allegro-edit-deliveries-loading" src="/images/frontend/theme/default2/loading.gif" alt=""/>');
                $.ajax({
                    url: '/' + scriptName + '/stAllegroDeliveryBackend/ajaxDelivery?namespace=allegro_auction&show=checked&id=' + id + '&auction=' + $('#st-allegro-edit-id').val(),
                    cache: false 
                }).done(function (html) {
                    $('#st-allegro-edit-deliveries').html(html);
                });
            }
        },

        setVariantsActivity: function () {
            function setActivity(item) {
                $('#st-allegro-variant-quantity-' + item.data('fid') + '-' + item.val()).prop('disabled', !item.attr('checked'));
                if (item.attr('checked'))
                    $('#st-allegro-variant-options-img-' + item.data('fid') + '-' + item.val()).show();
                else
                    $('#st-allegro-variant-options-img-' + item.data('fid') + '-' + item.val()).hide();
            }

            $('.st-allegro-variant-checkbox').each(function () {
                setActivity($(this));
            });

            $('.st-allegro-variant-checkbox').click(function () {
                setActivity($(this));
            });
        },

        // updateStock: function (value) {
        //     if (value == 'clear') {
        //         $('#st-allegro-edit-stock').val(0);
        //         return 0;
        //     }

        //     $('#st-allegro-edit-stock').val(parseInt($('#st-allegro-edit-stock').val()) + parseInt(value));
        // },

        // setStockByVariants: function () {
        //     $('.st-allegro-variant-checkbox').each(function () {
        //         var stock = 0;   
        //         if ($(this).attr('checked')) {
        //             if ($('#st-allegro-edit-stock').prop('disabled', false)) {
        //                 $('#st-allegro-edit-stock').prop('disabled', true);
        //                 stAllegroEdit.updateStock('clear');
        //             }

        //             stAllegroEdit.updateStock($('#st-allegro-variant-quantity-' + $(this).data('fid') + '-' + $(this).val()).val());
        //         }
        //     });
        
        processMainProductOptions: function (url, messages) {
            $.get(url, function(json) {
                var data = $.parseJSON(json);

                divOptions = '<div>';
                $.each(data.selected, function (key, value) {
                    divOptions += '<b>' + key + ':</b> ' + value + ', ';
                });
                divOptions += '</div>';
                $('#st-allegro-edit-options-selected').html(divOptions);
                $('#st-allegro-edit-options-overlay-trigger-main').html(messages[0]);
                $('#st-allegro-edit-stock-information').text(data.stock);
            });
        },

        processProductOptions: function (id, url) {
            $.get(url, function(json) {
                var data = $.parseJSON(json);

                $('#st-allegro-variant-options-img-' + id).attr('src', '/images/backend/icons/list.png');

                newTitle = 'Wybrane opcje: ';
                $.each(data.selected, function (key, value) {
                    newTitle += '<b>' + key + ':</b> ' + value + ', ';
                });
                newTitle += '<br/>Kliknij aby zmienić opcje.';
                newTitle += '<br/>Dostępnych sztuk: ' + data.stock;
                
                $('#st-allegro-variant-options-img-' + id).attr('title', newTitle);
                $('#st-allegro-variant-options-img-' + id).data('title', newTitle);
                $('#st-allegro-variant-options-img-' + id).removeAttr("title"); 
            });
        },

        addLoading: function (element) {
            element.html('<img class="st-allegro-loading" src="/images/frontend/theme/default2/loading.gif" alt=""/>');
        }

    }
})(jQuery);
