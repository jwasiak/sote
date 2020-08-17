<?php $helper = new stAllegroEditHelper($allegro_auction, $forward_parameters);?>
<?php use_helper('stPrice', 'stProductImage', 'stAllegro');?>
<?php use_javascript('stPrice.js');?>
<?php use_javascript('stAllegroPlugin/stAllegroEdit.js?v2');?>
<?php use_stylesheet('backend/stAllegroPlugin.css?v2');?>

<?php init_tooltip('.st-allegro-tooltip');?>

<?php $hasOptions = ($allegro_auction->getProduct()->getOptHasOptions() > 1);?>
<?php $stAllegro = stAllegro::getInstance($allegro_auction->getEnvironment());?>

<?php echo form_tag('stProduct/allegroSave?product_id='.$forward_parameters['product_id'], array( 'id' => 'st-allegro-edit-form', 'name' => 'st-allegro-edit-form', 'class' => 'admin_form', 'multipart' => true));?>
    <?php echo input_hidden_tag('id', $allegro_auction->getId(), array('id' => 'st-allegro-edit-id'));?>
    <?php echo input_hidden_tag('allegro_auction[environment]', $allegro_auction->getEnvironment());?>
    <?php echo input_hidden_tag('allegro_aucion[product_id]', $allegro_auction->getProductId()); ?>
    <?php echo input_hidden_tag('environment', $allegro_auction->getEnvironment());?>
    <?php echo ($sf_params->get('product_id')) ? input_hidden_tag('product_id', $sf_params->get('product_id')) : '';?>

    <?php if ($sf_flash->has('allegro-validate-message')):?>
        <?php $message = $sf_flash->get('allegro-validate-message');?>
        <div id="st-allegro-notice" class="save-ok">
            <h2><?php echo __('Pozytywny wynik walidacji - komunikat z serwisu aukcyjnego:', null, 'stAllegroBackend');?></h2>
            <dl>
                <?php foreach ($message as $key => $value):?>
                    <?php if ($key == 'itemPrice'):?>
                        <dt><?php echo __('Przewidywany koszt wystawienia:', null, 'stAllegroBackend');?></dt>
                        <dd><?php echo $value;?></dd>
                    <?php endif;?>
                <?php endforeach;?>
            </dl>
        </div>
    <?php endif;?>

    <?php if ($sf_flash->has('allegro-error')):?>
        <div class="form-errors">
            <h2><?php echo __('Popraw dane w formularzu.', null, 'stAllegroBackend');?></h2>
            <dl>
                <dd><?php echo $sf_flash->get('allegro-error');?></dd>
            </dl>
        </div>
    <?php endif;?>

    <?php if ($sf_flash->has('allegro-validate-error')):?>
        <div class="form-errors">
            <h2><?php echo __('Negatywny wynik walidacji - komunikat błędu z serwisu aukcyjnego:', null, 'stAllegroBackend');?></h2>
            <dl>
                <dd><?php echo $sf_flash->get('allegro-validate-error');?></dd>
            </dl>
        </div>
    <?php endif;?>

    <?php if ($sf_flash->has('allegro-create-error')):?>
        <div class="form-errors">
            <h2><?php echo __('Błąd poczas wystawiania aukcji - komunikat błędu z serwisu aukcyjnego:', null, 'stAllegroBackend');?></h2>
            <dl>
                <dd><?php echo $sf_flash->get('allegro-create-error');?></dd>
            </dl>
        </div>
    <?php endif;?>

    <fieldset>
        <h2><?php echo __('Informacje podstawowe', null, 'stAllegroBackend');?></h2>
        <div class="content">

            <?php if ($allegro_auction->getEnvironment() == 'Sandbox'):?>
                <div class="row">
                    <label></label>
                    <div class="field">
                        <?php echo __('Aukcja wystawiana jest w trybie testowym.', null, 'stAllegroBackend');?><br />
                    </div>
                </div>
            <?php endif;?>

            <div class="row row_name">
                <label for="allegro_auction_name">
                    <b><?php echo __('Nazwa', null, 'stAllegroBackend');?></b>
                </label>
                <div class="field<?php if ($sf_request->hasError('allegro_auction{name}')):?> form-error<?php endif;?>">
                    <?php if ($sf_request->hasError('allegro_auction{name}')):?>
                        <?php echo form_error('allegro_auction{name}', array('class' => 'form-error-msg'));?>
                    <?php endif;?>
                    <?php echo object_input_tag($allegro_auction, 'getName', array('size' => 80, 'control_name' => 'allegro_auction[name]', 'maxlength' => 200));?> 
                    <div class="clr"></div>
                </div>
            </div>

            <?php if ($allegro_auction->getProduct()->getOptHasOptions() > 1):?>
                <div id="st-allegro-edit-options-row" class="row">
                    <label>
                        <b><?php echo __('Opcje produktu', null, 'stAllegroBackend');?></b>
                    </label>
                    <div class="field">
                        <?php echo input_hidden_tag('allegro_auction[product_options]', $allegro_auction->getProductOptions(), array('id' => 'st-allegro-edit-hidden-product-options'));?>
                        
                        <div id="st-allegro-edit-options-selected"></div>
                        <a id="st-allegro-edit-options-overlay-trigger-main" class="st-allegro-edit-options-overlay-trigger" href="#" rel="#st-allegro-edit-options-overlay" data-stock-for="0">
                            <?php echo __('Wybierz opcje produktu', null, 'stAllegroBackend');?>
                        </a>
                        <div class="clr"></div>
                    </div>
                </div>
                <div id="st-allegro-edit-options-overlay" class="popup_window">
                    <div id="st-allegro-edit-options-overlay-close" class="close">
                        <img src="/images/frontend/theme/default2/buttons/close.png" alt="" />
                    </div>
                    <h2>
                        <?php echo __('Wybierz opcje produktu', null, 'stAllegroBackend');?>
                    </h2>
                    <div class="content">
                        <div class="preloader_160x24"></div>
                    </div>
                    <div id="st-allegro-edit-options-overlay-submit">
                        <button class="submit" type="button">
                            <?php echo __('Wybierz', null, 'stAllegroBackend');?>
                        </button>
                    </div>
                </div>
            <?php endif;?>

            <div class="row">
                <label>
                    <b><?php echo __('Kategoria', null, 'stAllegroBackend');?></b>
                </label>
                <div class="field<?php if ($sf_request->hasError('allegro_auction{allegro_category_id}')):?> form-error<?php endif;?>">
                    <?php if ($sf_request->hasError('allegro_auction{allegro_category_id}')):?>
                        <?php echo form_error('allegro_auction{allegro_category_id}', array('class' => 'form-error-msg'));?>
                    <?php endif;?>
                    <?php echo st_get_partial('stAllegroBackend/edit_select_category', array('type' => 'edit', 'allegro_auction' => $allegro_auction, 'forward_parameters' => $forward_parameters, 'related_object' => $related_object)); ?> 
                    <div class="clr"></div>
                </div>
            </div>
            <div class="allegro-category-container"<?php if (!$allegro_auction->getAllegroCategory()): ?> style="display: none"<?php endif ?>>
                <div class="row">
                    <label>
                        <b><?php echo __('Typ', null, 'stAllegroBackend');?></b>
                    </label>
                    <div class="field">
                        <ul class="st-allegro-edit-radio-list">
                            <li>
                                <?php echo radiobutton_tag('allegro_auction[auction_type]', 0, ($allegro_auction->getAuctionType() == 0) ? true : false, array('id' => 'st-allegro-edit-auction-type-auction'));?>
                                <label for="st-allegro-edit-auction-type-auction">
                                    <?php echo __('Tylko Kup Teraz! (bez licytacji) lub licytacja', null, 'stAllegroBackend');?>
                                </label>
                            </li>
                            <li>
                                <?php echo radiobutton_tag('allegro_auction[auction_type]', 1, ($allegro_auction->getAuctionType() == 1) ? true : false, array('id' => 'st-allegro-edit-auction-type-shop'));?>
                                <label for="st-allegro-edit-auction-type-shop">
                                    <?php echo __('Sklep (bez licytacji)', null, 'stAllegroBackend');?>
                                </label>
                            </li>
                        </ul>
                        <div class="clr"></div>
                    </div>
                </div>

                <div class="row">
                    <label>
                        <b><?php echo __('Cena', null, 'stAllegroBackend');?></b>
                    </label>
                    <div class="field">
                        <table class="st_record_list" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><b><?php echo __('"Kup teraz !"', null, 'stAllegroBackend');?></b></th>
                                    <th><b><?php echo __('Wywoławcza', null, 'stAllegroBackend');?></b></th>
                                    <th><b><?php echo __('Minimalna', null, 'stAllegroBackend');?></b></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td><?php echo input_tag('allegro_auction[price_buy_now]', st_price_format($allegro_auction->getPriceBuyNow()), array('size' => 8, 'class' => 'st-allegro-edit-price', 'id' => 'st-allegro-edit-price-buy-now'));?></td>
                                    <td><?php echo input_tag('allegro_auction[price_start]', st_price_format($allegro_auction->getPriceStart()), array('size' => 8, 'class' => 'st-allegro-edit-price', 'id' => 'st-allegro-edit-price-start'));?></td>
                                    <td><?php echo input_tag('allegro_auction[price_min]', st_price_format($allegro_auction->getPriceMin()), array('size' => 8, 'class' => 'st-allegro-edit-price', 'id' => 'st-allegro-edit-price-min'));?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clr"></div>
                    </div>
                </div>
                <?php echo st_allegro_edit_row('Liczba', $helper->getStock(), true);?>
                <?php echo st_allegro_edit_row('Zdejmuj z magazynu podczas wystawiania', checkbox_tag('allegro_auction[depository_on_sale]', 1, $allegro_auction->getDepositoryOnSale()));?>
                <?php echo st_allegro_edit_row('Czas trwania', $helper->getDuration());?>
                <?php //echo st_allegro_edit_row('Automatyczne wznowienie oferty w sklepie', $helper->getResumption());?>
            </div>
        </div>
    </fieldset>
    <div class="allegro-category-container" <?php if (!$allegro_auction->getAllegroCategory()): ?> style="display: none"<?php endif ?>>
        <fieldset>
            <h2><?php echo __('Płatność i dostawa', null, 'stAllegroBackend');?></h2>
            <div class="content">
                <?php echo st_allegro_edit_row('Formy płatności', $helper->getPayOptions(), array('row' => 'allegro-pay-options'));?>
                <?php echo st_allegro_edit_row('Dodatkowe informacje o przesyłce i płatności', textarea_tag('allegro_auction[other_text]', $allegro_auction->getOtherText(), array('id' => 'st-allegro-edit-other-text')));?>
                <?php echo st_allegro_edit_row('Wysyłka w ciągu', $helper->getShippingTime());?>
                <?php echo st_allegro_edit_row('Koszty wysyłki pokrywa', select_tag('allegro_auction[who_pay]', options_for_select(array(1 => __('kupujący', null, 'stAllegroBackend'), 0 => __('sprzedający', null, 'stAllegroBackend')), $allegro_auction->getWhoPay())));?>

                <?php if(($allegroDelivery = $helper->getAllegroDelivery()) !== null):?>
                    <div class="row">
                        <label for="st-allegro-edit-allegro-delivery">
                            <?php echo __('Cennik dostawy', null, 'stAllegroBackend');?>
                        </label>
                        <div class="field">
                            <?php echo $allegroDelivery;?>
                            <div class="clr"></div>
                        </div>
                    </div>
                <?php endif;?>

                <div class="row">
                    <label>
                        <?php echo __('Opcje dostawy', null, 'stAllegroBackend');?>
                    </label>
                    <div class="field">
                        <div id="st-allegro-edit-deliveries">
                            <?php if($allegro_auction->isNew() && $sf_request->getMethod() !== sfRequest::POST):?>
                                <img id="st-allegro-edit-deliveries-loading" src="/images/frontend/theme/default2/loading.gif" alt=""/>
                            <?php else:?>
                                <?php echo st_get_component('stAllegroDeliveryBackend', 'deliveries', array('namespace' => 'allegro_auction', 'environment' => $allegro_auction->getEnvironment(), 'auction' => $allegro_auction->getId(), 'id' => -1, 'show' => true));?>
                            <?php endif;?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset id="st-allegro-fieldset-images">
            <h2><?php echo __('Zdjęcia', null, 'stAllegroBackend');?></h2>
            <div class="content">
                <div class="row">
                    <?php echo __('Wybierz zdjęcia, które będą załączone do aukcji i zaznacz domyślne zdjęcie.', null, 'stAllegroBackend');?><br />
                    <?php echo __('Jeśli chcesz wyświetlić zdjęcie w treści opisu, wprowadź jego nazwę w postaci np. {PHOTO:1} lub {PHOTO:2} itd. w miejscu, gdzie ma się ono pojawić.', null, 'stAllegroBackend');?>
                </div>
                <div class="row">
                    <div class="field">
                        <?php echo input_hidden_tag('allegro_auction[images]', '');?>
                        <div id="st-allegro-edit-images">
                            <?php foreach ($helper->getImages() as $k => $image): $number = $allegro_auction->hasNewDescriptionFormat() ? $image->getId() : $k + 1; $allegroAsset = $helper->getImageInformation($image); ?>
                                <div class="st-allegro-edit-image-box">
                                    <div class="st-allegro-edit-image" data-selected="<?php echo intval($allegroAsset['selected']) ?>" data-number="<?php echo $number ?>">
                                        <?php echo st_product_image_tag($image, 'full');?>
                                    </div>
                                    <div class="st-allegro-edit-image-desc">
                                        <?php echo checkbox_tag('allegro_auction[images][selected]['.$image->getId().']', 1, $allegroAsset['selected'], array('title' => __('Eksport zdjęcia', null, 'stAllegroBackend')));?>
                                        <?php echo radiobutton_tag('allegro_auction[images][default]', $image->getId(), $allegroAsset['default'], array('title' => __('Domyślne zdjęcie', null, 'stAllegroBackend')));?>
                                        <?php if (!$allegro_auction->hasNewDescriptionFormat()): ?>
                                            <label for="allegro_auction_default_image_<?php echo $image->getId();?>"><b>{PHOTO:<?php echo $number; ?>}</b></label>  
                                        <?php endif ?>              
                                        <div class="clr"></div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset id="st-allegro-fieldset-description">
            <h2><?php echo __('Opis', null, 'stAllegroBackend');?></h2>
            <div class="content">
                <?php echo st_allegro_edit_row('Skrócony opis', textarea_tag('allegro_auction[short_text]', $allegro_auction->getShortText(), array('tinymce_options' => 'height:300,width:\'100%\','.($allegro_auction->getAuctionId() ? 'readonly:true' : 'theme:\'simple\''), 'rich' => true)));?>
                <?php echo st_get_component('stAllegroBackend', 'description', array('auction' => $allegro_auction)) ?>
            </div>
        </fieldset>

        <fieldset>
            <h2><?php echo __('Dodatkowe opcje i atrybuty', null, 'stAllegroBackend');?></h2>
            <div class="content">
                <?php if (!$allegro_auction->hasNewDescriptionFormat()): ?>
                    <?php echo st_allegro_edit_row('Szablon', $helper->getTemplate());?>
                <?php endif ?>
                <div class="row allegro-options">
                    <label>
                        <?php echo __('Dodatkowe opcje', null, 'stAllegroBackend');?>
                        <a href="#" class="help" title="<?php echo __('Niektóre opcje mogą być dodatkowo płatne. Więcej w cenniku Allegro.', null, 'stAllegroBackend');?>"></a>
                    </label>
                    <div class="field">
                        <div class="field-container"><?php echo $helper->getOptions();?></div>
                        <div class="clr"></div>
                    </div>
                </div>
                <?php echo st_allegro_edit_row('EAN', input_tag('allegro_auction[ean]', $allegro_auction->getEan()));?>
                <div id="st-allegro-edit-attributes">
                    <?php if (is_object($allegro_auction->getAllegroCategory())):?>
                        <?php echo st_get_component('stAllegroBackend', 'getAttributes', array('environment' => $allegro_auction->getEnvironment(), 'category' => $allegro_auction->getAllegroCategory()->getCatId(), 'auction' => $allegro_auction, 'product' => $allegro_auction->getProduct()));?>
                    <?php endif;?>
                </div>
            </div>
        </fieldset>

        <div id="edit_actions">
            <?php st_include_partial('allegro_edit_actions', array('allegro_auction' => $allegro_auction, 'forward_parameters' => $forward_parameters));?>
        </div>
    </div>
</form>

<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {
            $('#edit_actions').stickyBox();

            $('.st-allegro-edit-price').change(function() {
                $(this).val(stPrice.fixNumberFormat($(this).val()));
            });

            $('.st-allegro-edit-price').keypress(function(event) {
                if (event.which == 13) {
                    $(this).val(stPrice.fixNumberFormat($(this).val()));
                    event.preventDefault();
                }
            });

            $('.st-allegro-edit-quantity').change(function() {
                $(this).val(stPrice.fixNumberFormat($(this).val(), 0));
            });

            $('.st-allegro-edit-quantity').keypress(function(event) {
                if (event.which == 13) {
                    $(this).val(stPrice.fixNumberFormat($(this).val(), 0));
                    event.preventDefault();
                }
            });

            stAllegroEdit.reloadTypeView();
            $('input[name="allegro_auction[auction_type]"]').change(function () {
                stAllegroEdit.reloadTypeView();
            });

            <?php if($allegro_auction->isNew() && $sf_request->getMethod() !== sfRequest::POST):?>
                if ($('#st-allegro-edit-allegro-delivery').val() != -1)
                    stAllegroEdit.reloadDelivery();
            <?php endif;?>

            $('#st-allegro-edit-allegro-delivery').change(function() {
                stAllegroEdit.reloadDelivery();
            });

            stAllegroEdit.setVariantsActivity();

            $('.st-allegro-tooltip').removeData('tooltip'); $('.st-allegro-tooltip').tooltip(); 

            <?php if($hasOptions):?>

                if ($('#st-allegro-edit-options-selected').text().length == 0 && $('#st-allegro-edit-hidden-product-options').val().length != 0) {
                    stAllegroEdit.addLoading($('#st-allegro-edit-options-overlay-trigger-main'));
                    stAllegroEdit.processMainProductOptions('<?php echo st_url_for('stAllegroBackend/ajaxProductStock');?>?id=<?php echo $allegro_auction->getProductId();?>&selected=' + $('#st-allegro-edit-hidden-product-options').val(), ["<?php echo __('Zmień wybrane opcje', null, 'stAllegroBackend');?>"]);
                }

                $('.st-allegro-edit-options-overlay-trigger').live('click', function() {
                    console.log('niby dizała');
                    $('#st-allegro-edit-options-overlay').data('stock-for', $(this).data('stock-for'));
                    $('#st-allegro-edit-options-overlay').overlay({
                        speed: 'fast',
                        close: $('#st-allegro-edit-options-overlay > .close img'),
                        load: true,
                        mask: {
                            color: '#444',
                            loadSpeed: 'fast',
                            opacity: 0.5,
                        },
                        closeOnClick: false,
                        closeOnEsc: false,
                        onBeforeLoad: function() {
                            var content = this.getOverlay().children('.content');

                            $.get('<?php echo st_url_for('stAllegroBackend/ajaxProductOptions');?>?id=<?php echo $allegro_auction->getProductId();?>', function(html) {
                                content.html(html);
                            });
                        },
                        onClose: function() {
                            $('#st-allegro-edit-options-overlay').data('overlay', '');
                        }
                    });
                });

                $('.st-allegro-variant-checkbox:checked').each(function() {
                    var id = $(this).data('fid') + '-' + $(this).val();
                    stAllegroEdit.processProductOptions(id, '<?php echo st_url_for('stAllegroBackend/ajaxProductStock');?>?id=<?php echo $allegro_auction->getProductId();?>&selected=' + $('#st-allegro-variant-options-' + id).val());
                });

                $('#st-allegro-edit-options-overlay .submit').live('click', function() {
                    var api = $('#st-allegro-edit-options-overlay').data('overlay');
                    var options = $('#st-allegro-edit-options-overlay #product_options_selected').val();

                    $('#st-allegro-edit-hidden-product-options').val(options);

                    var stockFor = $('#st-allegro-edit-options-overlay').data('stock-for');

                    if (stockFor == 0)
                        stAllegroEdit.processMainProductOptions('<?php echo st_url_for('stAllegroBackend/ajaxProductStock');?>?id=<?php echo $allegro_auction->getProductId();?>&selected=' + options, ["<?php echo __('Zmień wybrane opcje', null, 'stAllegroBackend');?>"]);
                    else {
                        stAllegroEdit.processProductOptions(stockFor, '<?php echo st_url_for('stAllegroBackend/ajaxProductStock');?>?id=<?php echo $allegro_auction->getProductId();?>&selected=' + options);
                        $('#st-allegro-variant-options-' + stockFor).val(options);

                        // $.get('<?php echo st_url_for('stAllegroBackend/ajaxProductStock');?>?id=<?php echo $allegro_auction->getProductId();?>&selected=' + options, function(json) {
                        //     var data = $.parseJSON(json);

                        //     $('#st-allegro-variant-options-img-' + stockFor).attr('src', '/images/backend/icons/list.png');

                        //     newTitle = 'Wybrane opcje: ';
                        //     $.each(data.selected, function (key, value) {
                        //         newTitle += '<b>' + key + ':</b> ' + value + ', ';
                        //     });
                        //     newTitle += '<br/>Kliknij aby zmienić opcje.';
                            
                        //     $('#st-allegro-variant-options-img-' + stockFor).attr('title', newTitle);
                        //     $('#st-allegro-variant-options-img-' + stockFor).data('title', newTitle);
                        //     $('#st-allegro-variant-options-img-' + stockFor).removeAttr("title"); 

                        //     $('#st-allegro-variant-options-' + stockFor).val(options);
                        // });
                    }

                    api.close();
                    $('#st-allegro-edit-options-overlay').data('overlay', '');
                });
            <?php endif;?>
        });
    });
</script>
