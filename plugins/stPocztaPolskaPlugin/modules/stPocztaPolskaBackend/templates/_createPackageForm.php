<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate', 'stPocztaPolska', 'stPrice') ?>

<fieldset>
    <div class="content">
        <?php echo st_admin_get_form_field('bufor[data_nadania]', __('Planowana data nadania'), $bufor->dataNadania, 'input_date_tag', array(
              'rich' => true,
              'withtime' => false,
              'calendar_button_img' => '/sf/sf_admin/images/date.png'
        )) ?>
        <?php echo st_admin_get_form_field('bufor[urzad_nadania]', __('Urząd nadania'), $bufor->urzadNadania, 'st_urzedy_nadania_select') ?>
        <?php if (in_array($package->getServiceName(), array('przesylka_firmowa_polecona_ekonomiczna', 'przesylka_firmowa_polecona_priorytetowa'))): ?>
            <?php echo st_admin_get_form_field('package[gabaryt]', __('Gabaryt'), stPocztaPolskaClient::getGabarytyFirmowa(), 'select_tag', array('selected' => $service->gabaryt, 'style' => 'width: 50%')) ?>
        <?php elseif ($package->getServiceName() == 'przesylka_biznesowa'): ?>
            <?php echo st_admin_get_form_field('package[gabaryt]', __('Gabaryt'), stPocztaPolskaClient::getGabarytyBiznesowa(), 'select_tag', array('selected' => $service->gabaryt)) ?>
        <?php elseif (property_exists($service, 'format')): ?>
            <?php echo st_admin_get_form_field('package[format]', __('Format'), stPocztaPolskaClient::getFormaty(), 'select_tag', array('selected' => $service->format, 'style' => 'width: 50%')) ?>
        <?php elseif (property_exists($service, 'gabaryt')): ?>
            <?php echo st_admin_get_form_field('package[gabaryt]', __('Gabaryt'), stPocztaPolskaClient::getGabaryty(), 'select_tag', array('selected' => $service->gabaryt, 'style' => 'width: 50%')) ?>
        <?php endif ?>
        <?php echo st_admin_get_form_field('package[masa]', __('Masa'), !$service->masa ? "" : stPrice::round($service->masa / 1000), 'input_tag', array('postfix' => 'kg', 'size' => 9, 'class' => 'amount', 'data-allow-empty' => true)) ?>
        <?php if (property_exists($service, 'pobranie') && $service->pobranie->sposobPobrania): ?>
            <?php echo st_admin_get_form_field('package[pobranie][kwota_pobrania]', __('Kwota pobrania'), stPrice::round($service->pobranie->kwotaPobrania / 100), 'input_tag', array('postfix' => 'PLN', 'size' => 9, 'class' => 'amount')) ?>
            <?php echo st_admin_get_form_field('package[pobranie][nrb]', __('Rachunek pobrania'), $service->pobranie->nrb, 'st_poczta_polska_rachunki') ?> 
        <?php endif ?>

        <?php if ($package->getDeliveryPoint()): ?>
        <?php echo st_admin_get_form_field('package[po]', __('Punkt odbioru'), $package->getDeliveryPoint(), 'st_poczta_polska_punkt_odbioru') ?>
        <?php endif ?>
        <?php if (property_exists($service, 'opakowanie')): ?>
        <?php echo st_admin_get_form_field('package[opakowanie]', __('Opakowanie'), stPocztaPolskaClient::getOpakowania($package->getServiceName()), 'select_tag', array('selected' => $service->opakowanie)) ?> 
        <?php endif ?>
        <?php if (in_array($package->getServiceName(), array('przesylka_firmowa_polecona_ekonomiczna', 'przesylka_firmowa_polecona_priorytetowa'))): ?>
            <?php echo st_admin_get_form_field('package[miejscowa]', __('Miejscowa/Zamiejscowa'), array(1 => __('Miejscowa'), 0 => __('Zamiejscowa')), 'select_tag', array('checked' => $service->miejscowa)) ?>
        <?php endif ?>
    </div>
</fieldset>

<fieldset>
    <h2><?php echo __('Adresat') ?></h2>
    <div class="content">
        <?php echo st_admin_get_form_field('package[adres][nazwa]', __('Nazwisko/Imię/Nazwa'), $service->adres->nazwa, 'input_tag', array('size' => 40, 'maxlength' => 60)) ?>
        <?php echo st_admin_get_form_field('package[adres][nazwa2]', __('Nazwisko/Imię/Nazwa cd'), $service->adres->nazwa2, 'input_tag', array('size' => 40, 'maxlength' => 60)) ?>
        <?php echo st_admin_get_form_field('package[adres][ulica]', __('Adres'), $service->adres->ulica, 'input_tag', array('size' => 40, 'maxlength' => 255)) ?>
        <?php echo st_admin_get_form_field('package[adres][kod_pocztowy]', __('Kod pocztowy'), $service->adres->kodPocztowy, 'input_tag') ?>
        <?php echo st_admin_get_form_field('package[adres][miejscowosc]', __('Miejscowość'), $service->adres->miejscowosc, 'input_tag') ?>
        <?php echo st_admin_get_form_field('package[adres][kraj]', __('Kraj'), $service->adres->kraj, 'st_poczta_polska_countries_select_tag') ?>
        <?php echo st_admin_get_form_field('package[adres][mobile]', __('Telefon komórkowy'), $service->adres->mobile, 'input_tag') ?>
        <?php echo st_admin_get_form_field('package[adres][email]', __('Adres e-mail'), $service->adres->email, 'input_tag', array('size' => 40, 'maxlength' => 50)) ?>
        <?php echo st_admin_get_form_field('package[adres][telefon]', __('Telefon'), $service->adres->telefon, 'input_tag') ?>
    </div>
</fieldset>

<fieldset>
    <h2><?php echo __('Usługi dodatkowe') ?></h2>
    <div class="content">
        <?php if (property_exists($service, 'wartosc')): ?>
            <?php echo st_admin_get_form_field('package[wartosc]', __('Wartość'), $service->wartosc ? $service->wartosc / 100 : $package->getOrderAmount() / 100, 'st_poczta_polska_optional_input', array('postfix' => 'PLN', 'class' => 'amount', 'disabled' => $service->wartosc === null, 'size' => 8)) ?>
        <?php endif ?>
        <?php if (property_exists($service, 'ubezpieczenie')): ?>
            <?php echo st_admin_get_form_field('package[ubezpieczenie][kwota]', __('Ubezpieczenie'), $service->ubezpieczenie ? $service->ubezpieczenie->kwota / 100 : $package->getOrderAmount() / 100, 'st_poczta_polska_ubezpieczenie', array('postfix' => 'PLN', 'serviceName' => $package->getServiceName(), 'disabled' => $service->ubezpieczenie === null)) ?>
        <?php endif ?>
        <?php if (property_exists($service, 'ostroznie')): ?>
            <?php echo st_admin_get_form_field('package[ostroznie]', __('Ostrożnie'), 1, 'checkbox_tag', array('checked' => $service->ostroznie)) ?>
        <?php endif ?>
        <?php if (property_exists($service, 'ponadgabaryt')): ?>
            <?php echo st_admin_get_form_field('package[ponadgabaryt]', __('Przesyłka niestandardowa'), 1, 'checkbox_tag', array('checked' => $service->ponadgabaryt)) ?>
        <?php endif ?>
        <?php if (property_exists($service, 'iloscPotwierdzenOdbioru')): ?>
            <?php echo st_admin_get_form_field('package[iloscPotwierdzenOdbioru]', __('Potwierdzenie odbioru'), $service->iloscPotwierdzenOdbioru, 'st_poczta_polska_optional_input', array('postfix' => 'szt', 'disabled' => $service->iloscPotwierdzenOdbioru === null, 'size' => 4)) ?>
        <?php endif ?>
        <?php if (property_exists($service, 'epo')): ?>
            <?php echo st_admin_get_form_field('package[epo]', __('Elektroniczne potwierdzenie odbioru'), 1, 'checkbox_tag', array('checked' => $service->epo !== null)) ?>
        <?php endif ?>
    </div>
</fieldset>

<fieldset>
    <h2><?php echo __('Opis przesyłki') ?></h2>
    <div class="content">
        <?php if (property_exists($service, 'zawartosc')): ?>
            <?php echo st_admin_get_form_field('package[zawartosc]', __('Zawartość'), $service->zawartosc, 'st_poczta_polska_zawartosc') ?>
        <?php endif ?>  
        <?php if (property_exists($service, 'opis')): ?>
            <?php echo st_admin_get_form_field('package[opis]', __('Dodatkowy opis przesyłki'), $service->opis, 'input_tag', array('maxlength' => 40, 'size' => 40, 'help' => __('To pole na wydruku zostanie skrócone do pierwszych 40 znaków'))) ?>
        <?php endif ?>               
    </div>
</fieldset>

<?php if ($package->getServiceName() == 'paczka_zagraniczna' || $package->getServiceName() == 'paczka_zagraniczna_ue'): ?>
<fieldset>
    <h2><?php echo __('Zwrot') ?></h2>
    <div class="content">
        <?php echo st_admin_get_form_field('package[zwrot][zwrot_po_liczbie_dni]', __('Zwrot po liczbie dni'), $service->zwrot->zwrotPoLiczbieDni, 'input_tag', array('class' => 'integer')) ?>
        <?php echo st_admin_get_form_field('package[zwrot][sposob_zwrotu]', __('Sposób zwrotu'), stPocztaPolskaClient::getSposobZwrotu($package->getServiceName()), 'select_tag', array('selected' => $service->zwrot->sposobZwrotu)) ?> 
    </div>
</fieldset>
<?php endif ?>

<?php if (property_exists($service, 'deklaracjaCelna2') && !stPocztaPolskaClient::isEUCountry($service->adres->kraj)): 
$deklaracjaCelna = $service->deklaracjaCelna2;
$deklaracjaCelnaNamespace =  'package[deklaracja_celna2]';;  
?>
    <fieldset>
        <h2><?php echo __('Deklaracja celna') ?></h2>
        <div class="content">
            <?php echo st_admin_get_form_field('', __('Instrukcja deklaracji celnej'), link_to(__('Pobierz'), stPocztaPolskaClient::getInstrukcjaDeklaracjiCelnejUrl(), array('download' => '')), 'plain') ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[rodzaj]', __('Rodzaj'), $deklaracjaCelna->rodzaj, '_rodzaj_zagraniczna') ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[szczegoly_zawartosci_przesylki]', __('Szczegóły zawartości przesyłki'), $deklaracjaCelna->szczegolyZawartosciPrzesylki, '_deklaracja_celna_szczegoly', array('waluta' => $deklaracjaCelna->walutaKodISO)) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[numer_referencyjny_celny]', __('Numer referencyjny celny'), $deklaracjaCelna->numerReferencyjnyCelny, 'input_tag', array('size' => 36)) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[numer_referencyjny_importera]', __('Numer referencyjny importera'), $deklaracjaCelna->numerReferencyjnyImportera, 'input_tag', array('size' => 36)) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[numer_telefonu_importera]', __('Numer telefonu importera'), $deklaracjaCelna->numerTelefonuImportera, 'input_tag', array('size' => 36)) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[oplaty_pocztowe]', __('Opłaty pocztowe'), $deklaracjaCelna->oplatyPocztowe, 'input_tag', array('size' => 36)) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[uwagi]', __('Uwagi'), $deklaracjaCelna->uwagi, 'textarea_tag', array('style' => 'width: 100%; height: 50px', 'help' => __('Opis dodatkowych informacji dotyczących rodzaju zawartości (np. towary podlegające kwarantannie/kontrolom sanitarnym lub innym ograniczeniom).'))) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[zawartosc_przesylki]', __('Zawartość przesyłki'), $deklaracjaCelna->zawartoscPrzesylki, '_zawartosc_przesylki_zagranicznej') ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[wyjasnienie]', __('Wyjaśnienie'), $deklaracjaCelna->wyjasnienie, 'textarea_tag', array('style' => 'width: 100%; height: 50px', 'help' => __('Dodatkowe wyjaśnienia dotyczące zawartości przesyłki.'))) ?>

            <?php echo st_admin_get_form_field($deklaracjaCelnaNamespace.'[dokumenty_towarzyszace]', __('Dokumenty towarzyszące'), $deklaracjaCelna->dokumentyTowarzyszace, '_dokumenty_towarzyszace') ?>
        </div>
    </fieldset>
<?php endif ?>

<script type="text/javascript">
    jQuery(function($) {
        $('.amount').change(function() {
            var input = $(this);
            var value = input.val();

            if (value === "" && !input.data('allow-empty')) {
                value = "0";
            }

            if (value !== "") {
                value = stPrice.fixNumberFormat(value, 2);
                
                input.val(value);
            }
        }).change();

        $('.integer').change(function() {
            var input = $(this);
            var value = input.val();

            if (value === "" && !input.data('allow-empty')) {
                value = "0";
            }

            if (value !== "") {
                value = stPrice.fixNumberFormat(value, 0);
                
                input.val(value);
            }
        }).change();

        $('#package_adres_kraj').change(function() {
            var select = $(this);
            $(document).trigger('preloader', 'show');
            $.get("<?php echo st_url_for('@stPocztaPolskaBackend?action=ajaxUpdateCreatePackageForm') ?>", { order_id: <?php echo $order->getId() ?>, service: $('#service_name').val(), country: select.val() }, function(content) {
                $('#package-form-container').html(content);
                $(document).trigger('preloader', 'close');
            });
        });
    });
</script>