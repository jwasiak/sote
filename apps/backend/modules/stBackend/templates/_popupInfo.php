<div id="popup-info">
    <div class="cd-popup" role="alert">
        <div class="cd-popup-container">
            <a href="#0" class="cd-popup-close"></a>
            <img class="open-image-popup" src="/images/backend/icons/open-block.png" />
            <h5 id="popup-info-title"></h5>
            <p id="popup-info-desc"></p>
            <div class="admin_actions" style="float: none;">
                <input id="popup-info-button" type="button" value="" style="background-image: url(/images/backend/icons/open_add_to_cart.png)">
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {
            <?php if($isOpen):?>
                $(document).on("click", "a", function(event) {
                    if($(this).attr('href').match(/.*product\/(import|export)/i)) {
                        event.preventDefault();
                        $('#popup-info-title').text('<?php echo __('Funkcja niedostępna dla wersji Open');?>');
                        $('#popup-info-desc').text('');
                        $('#popup-info-button').attr('onclick', "window.open('<?php echo __('http://www.sote.pl/licencja-soteshop.html');?>')");
                        $('#popup-info-button').attr('value', "<?php echo __('Zamów wersję komercyjną');?>");
                        $('.cd-popup-container').css('width', '450px');
                        $('.cd-popup').addClass('is-visible');
                    }
                });
            <?php endif;?>

            <?php if($showProductAddInfo):?>
                $("input[name='duplicate']").attr('onclick','').unbind('click');
                $(document).on("click", "input[type='button'], input[type='submit']", function(event) {
                    if($(this).attr('name') == 'duplicate'<?php if (!$hasId):?> || $(this).attr('name') == 'save' || $(this).attr('name') == 'save_and_add' <?php endif;?>) {
                        event.preventDefault();
                        $('#popup-info-title').text('<?php echo __('Nie można dodać nowego produktu.');?>');
                        <?php if($isOpen):?>
                            $('#popup-info-desc').html('<?php echo __('Wykorzystano dostępny limit').' '.$sProductsLimit.' '.__('produktów dla wersji Open.<br/>Zamów wersję komercyjną i zwiększ automatycznie limit produktów do 10 000.');?>');
                            $('#popup-info-button').attr('onclick', "window.open('<?php echo __('http://www.sote.pl/licencja-soteshop.html');?>')");
                            $('#popup-info-button').attr('value', "<?php echo __('Zamów wersję komercyjną');?>");
                        <?php elseif($productsLimit == 100):?>
                            $('#popup-info-desc').html('<?php echo __('Wykorzystano dostępny limit').' '.$sProductsLimit.' '.__('produktów.<br/>Zwiększ liczbę produtków do 10 000.');?>');
                            $('#popup-info-button').attr('onclick', "window.open('<?php echo __('http://www.sote.pl/wynajem-aplikacji.html');?>')");
                            $('#popup-info-button').attr('value', "<?php echo __('Zmień wersję wynajmu programu');?>");
                            $('.cd-popup-container').css('width', '450px');
                        <?php else:?>
                            $('#popup-info-desc').html('<?php echo __('Wykorzystano dostępny limit').' '.$sProductsLimit.' '.__('produktów.<br/>Zwiększ liczbę produktów nawet do 30 000.');?>');
                            $('#popup-info-button').attr('onclick', "window.open('<?php echo __('http://www.sote.pl/zwiekszenie-ilosc-produktow.html');?>')");
                            $('#popup-info-button').attr('value', "<?php echo __('Zamów zwiększenie ilości produktów');?>");
                            $('.cd-popup-container').css('width', '450px');
                        <?php endif;?>
                        $('.cd-popup').addClass('is-visible');
                    }
                });
            <?php endif;?>

            $('.cd-popup').on('click', function(event) {
                if($(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup')) {
                    event.preventDefault();
                    $(this).removeClass('is-visible');
                }
            });

            $(document).keyup(function(event) {
                if(event.which == '27') {
                    $('.cd-popup').removeClass('is-visible');
                }
            });
        });
    });
</script>
