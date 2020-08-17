function send_form(field, tag_id)
{
    if(field.value)
    {
        $('st_basket-add-submit-container').firstChild.disabled = true;

        if(!tag_id)
        {
            tag_id = 'changed_field';
        }

        $(tag_id).value = field.id.replace('Options_', '');
        $(tag_id).click();
    }
}

var default_data = new Array();

function update_site(data)
{
    if(default_data.init == null)
    {
        if($('st_product-show_success_classic_image')
            && $('st_product-show_success_classic_image').firstChild
            && $('st_product-show_success_classic_image').firstChild.nextSibling
            && $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild)
            {
            default_data.link = $('st_product-show_success_classic_image').firstChild.nextSibling.href;
            default_data.photo_title = $('st_product-show_success_classic_image').firstChild.nextSibling.title;
            default_data.src =  $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild.src;
            default_data.init = 1;
        }

        if($('st_product-show_success_classic_image')
            && $('st_product-show_success_classic_image').firstChild
            && $('st_product-show_success_classic_image').firstChild.firstChild)
            {
            default_data.link = $('st_product-show_success_classic_image').firstChild.href;
            default_data.photo_title = $('st_product-show_success_classic_image').firstChild.title;
            default_data.src =  $('st_product-show_success_classic_image').firstChild.firstChild.src;
            default_data.init = 1;
        }

        if($('st_product-show_success_default_image')
            && $('st_product-show_success_default_image').firstChild
            && $('st_product-show_success_default_image').firstChild.nextSibling
            && $('st_product-show_success_default_image').firstChild.nextSibling.firstChild)
            {
            default_data.link = $('st_product-show_success_default_image').firstChild.nextSibling.href;
            default_data.photo_title = $('st_product-show_success_default_image').firstChild.nextSibling.title;
            default_data.src =  $('st_product-show_success_default_image').firstChild.nextSibling.firstChild.src;
            default_data.init = 1;
        }

        if($('st_product-show_success_default_image')
            && $('st_product-show_success_default_image').firstChild
            && $('st_product-show_success_default_image').firstChild.firstChild)
            {
            default_data.link = $('st_product-show_success_default_image').firstChild.href;
            default_data.photo_title = $('st_product-show_success_default_image').firstChild.title;
            default_data.src =  $('st_product-show_success_default_image').firstChild.firstChild.src;
            default_data.init = 1;
        }
    }
    // update basket form
    if(data.options_list)
    {
        $('options_list').value = data.options_list;
    }

    // update photo
    if((data.link) && (data.src))
    {
        if($('st_product-show_success_classic_image')
            && $('st_product-show_success_classic_image').firstChild
            && $('st_product-show_success_classic_image').firstChild.nextSibling
            && $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild)
            {
            $('st_product-show_success_classic_image').firstChild.nextSibling.href = data.link;
            $('st_product-show_success_classic_image').firstChild.nextSibling.title = data.photo_title;
            $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild.src = data.src+"?"+data.src_timestamp;
            $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild.alt = data.photo_title;
        }

        if($('st_product-show_success_classic_image')
            && $('st_product-show_success_classic_image').firstChild
            && $('st_product-show_success_classic_image').firstChild.firstChild)
            {
            $('st_product-show_success_classic_image').firstChild.href = data.link;
            $('st_product-show_success_classic_image').firstChild.title = data.photo_title;
            $('st_product-show_success_classic_image').firstChild.firstChild.src = data.src+"?"+data.src_timestamp;
            $('st_product-show_success_classic_image').firstChild.firstChild.alt = data.photo_title;
        }

        if($('st_product-show_success_default_image')
            && $('st_product-show_success_default_image').firstChild
            && $('st_product-show_success_default_image').firstChild.nextSibling
            && $('st_product-show_success_default_image').firstChild.nextSibling.firstChild)
            {
            $('st_product-show_success_default_image').firstChild.nextSibling.href = data.link;
            $('st_product-show_success_default_image').firstChild.nextSibling.title = data.photo_title;
            $('st_product-show_success_default_image').firstChild.nextSibling.firstChild.src = data.src+"?"+data.src_timestamp;
            $('st_product-show_success_default_image').firstChild.nextSibling.firstChild.alt = data.photo_title;
        }

        if($('st_product-show_success_default_image')
            && $('st_product-show_success_default_image').firstChild
            && $('st_product-show_success_default_image').firstChild.firstChild)
            {
            $('st_product-show_success_default_image').firstChild.href = data.link;
            $('st_product-show_success_default_image').firstChild.title = data.photo_title;
            $('st_product-show_success_default_image').firstChild.firstChild.src = data.src+"?"+data.src_timestamp;
            $('st_product-show_success_default_image').firstChild.firstChild.alt = data.photo_title;
        }
    }
    else
    {
        if(default_data.init == 1)
        {
            if($('st_product-show_success_classic_image')
                && $('st_product-show_success_classic_image').firstChild
                && $('st_product-show_success_classic_image').firstChild.nextSibling
                && $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild)
                {
                $('st_product-show_success_classic_image').firstChild.nextSibling.href = default_data.link;
                $('st_product-show_success_classic_image').firstChild.nextSibling.title = default_data.photo_title;
                $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild.src = default_data.src;
                $('st_product-show_success_classic_image').firstChild.nextSibling.firstChild.alt = default_data.photo_title;
            }

            if($('st_product-show_success_classic_image')
                && $('st_product-show_success_classic_image').firstChild
                && $('st_product-show_success_classic_image').firstChild.firstChild)
                {
                $('st_product-show_success_classic_image').firstChild.href = default_data.link;
                $('st_product-show_success_classic_image').firstChild.title = default_data.photo_title;
                $('st_product-show_success_classic_image').firstChild.firstChild.src = default_data.src;
                $('st_product-show_success_classic_image').firstChild.firstChild.alt = default_data.photo_title;
            }

            if($('st_product-show_success_default_image')
                && $('st_product-show_success_default_image').firstChild
                && $('st_product-show_success_default_image').firstChild.nextSibling
                && $('st_product-show_success_default_image').firstChild.nextSibling.firstChild)
                {
                $('st_product-show_success_default_image').firstChild.nextSibling.href = default_data.link;
                $('st_product-show_success_default_image').firstChild.nextSibling.title = default_data.photo_title;
                $('st_product-show_success_default_image').firstChild.nextSibling.firstChild.src = default_data.src;
                $('st_product-show_success_default_image').firstChild.nextSibling.firstChild.alt = default_data.photo_title;
            }


            if($('st_product-show_success_default_image')
                && $('st_product-show_success_default_image').firstChild
                && $('st_product-show_success_default_image').firstChild.firstChild)
                {
                $('st_product-show_success_default_image').firstChild.href = default_data.link;
                $('st_product-show_success_default_image').firstChild.title = default_data.photo_title;
                $('st_product-show_success_default_image').firstChild.firstChild.src = default_data.src;
                $('st_product-show_success_default_image').firstChild.firstChild.alt = default_data.photo_title;
            }

        // if($$("#st_product-show_success_default_image img"))
        //          {
        //              imgs = $$("#st_product-show_success_default_image img");
        //              imgs[0].src = default_data.src;
        //              imgs[0].parentNode.link = default_data.link;
        //          }
        }
    }

    // update stock
    if((data.stock!=null))
    {
        if($('st_depository_stock_amount'))
        {
            $('st_depository_stock_amount').innerHTML = $('st_depository_stock_amount').innerHTML.replace(/[0-9]+\s/, data.stock + ' ');
        }

        if(data.check_stock == 1 && $('st_basket-add-submit-container'))
        {
            if(data.stock == 0)
            {
                $('st_basket-add-submit-container').firstChild.disabled = true;
                $('st_basket-add-submit-container').firstChild.value = data.basket_disabled;
                if($('quantity'))
                {
                    $('quantity').value = 0;
                    $('quantity').disabled = true;
                }
            }
            else
            {
                $('st_basket-add-submit-container').firstChild.disabled = false;
                $('st_basket-add-submit-container').firstChild.value = data.basket_enabled;
                if($('quantity'))
                {
                    if($('quantity').value == 0)
                    {
                        $('quantity').value = 1;
                    }
                    $('quantity').disabled = false;
                }
            }
        }
        else
        {
            $('st_basket-add-submit-container').firstChild.disabled = false;
            $('st_basket-add-submit-container').firstChild.value = data.basket_enabled;
            if($('quantity'))
            {
                if($('quantity').value == 0)
                {
                    $('quantity').value = 1;
                }
                $('quantity').disabled = false;
            }
        }
    }
    else
    {
        if($('st_basket-add-submit-container'))
        {
            $('st_basket-add-submit-container').firstChild.disabled = false;
            $('st_basket-add-submit-container').firstChild.value = data.basket_enabled;
            if($('quantity'))
            {
                if($('quantity').value == 0)
                {
                    $('quantity').value = 1;
                }
                $('quantity').disabled = false;
            }
        }
    }

    // update avalibility
    if($('st_availability_info') && (data.avalibility!=null))
    {
        $('st_availability_info').innerHTML = $('st_availability_info').innerHTML.replace(/> [^>]+/, '> ' + data.avalibility);
    }

    // update price
    if($('st_product_options-price_net') && (data.price_netto!=null))
    {
        $('st_product_options-price_net').innerHTML = ' ' + data.price_netto;
    }

    if($('st_product_options-price_brutto') && (data.price_brutto!=null))
    {
        $('st_product_options-price_brutto').innerHTML =  ' ' + data.price_brutto;
    }

    // enable basket
    if($('st_basket-add-submit-container') && $('st_basket-add-submit-container').firstChild.value == data.basket_enabled)
    {
        $('st_basket-add-submit-container').firstChild.disabled = false;
    }
}

function ini_site ()
{
    $$('#st_update_product_options_form select').each(function(input){
        if(Object.isArray($A(input.options)))
        {
            $A(input.options).each(function(option)
            {
                if(option.defaultSelected)
                {
                    input.selectedIndex = option.index;
                }
            });
        }
    });

    if( typeof( ini_data ) != "undefined")
    {
        update_site(ini_data);
    }
}

function updateJSON(request, json)
{
    var responses = json;
    if (!json){
        //if you don't use the json tips then evaluate the renderedText instead
        responses = eval('(' + request.responseText + ')');
    }

    urlpars = window.location.pathname.split('/');
    if(urlpars[1].match('.php'))
    {
        env = urlpars[1];
    }
    else
    {
        env = 'index.php';
    }

    update_site(responses.to_update);
    new Ajax.Updater('st_product_options_form',
        '/' + env + '/product_options/updateProductOptions',
        {
            parameters: 'json=' + request.responseText ,
            asynchronus: true,
            evalScripts: true
        });
}

function st_product_options_disable(disable)
{
    var zagiel = document.getElementById('zagiel_accept');
    var cn = 'st_button st_align-right';
    var els = document.getElementsByTagName("select");
    for (var i = 0; i < els.length; i++ ){
        if (els[i].className=='st_product_options_select'){
            els[i].disabled=disable;
        }
    }
}

function st_product_options_color_filter(option_id, filter_id)
{
    var option_name = 'of_'+filter_id+'_'+option_id;
    var div_id = 'product_option_filter_div_'+option_id;

    if ($(option_name)) {
        $(option_name).checked = !$(option_name).checked;
    }
    if ($(div_id)) {
        if ($(option_name).checked) $(div_id).className = 'product_options-color-filter-selected';
        else $(div_id).className = 'product_options-color-filter';
    }
}

function st_product_options_clear_filters(ids)
{
    for (var index in ids) {
        if ($(ids[index])) $(ids[index]).checked=false;
    }
    $('of_form').submit()
}
