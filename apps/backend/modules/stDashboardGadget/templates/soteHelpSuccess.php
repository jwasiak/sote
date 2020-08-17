<?php  
    use_helper('stText', 'stAdminGenerator');
    use_stylesheet("backend/beta/style.css");
?>

<div id="sote_help">
    <div class="item">
        <div class="img">
            <img src="/images/backend/beta/gadgets/add_product.jpg" alt="Soteshop 7"/>
        </div>
        <div class="info">
            <h3 class="post-title"><?php echo __("Jak dodać produkt", null, "stBackend").'?' ?></h3>
            <a class="desc" href="http://www.sote.pl/docs/produkty" target="_blank"><?php echo __("Zobacz jak w prosty sposób dodać nowy produkt do sklepu. W jaki sposób ustawić jego ceny, zdjęcia, opisy. Jak przypisać produkt do kategorii i grup produktów, dodać opcje produktu i atrybuty.", null, "stBackend") ?></a>
            <div style="clear: both; margin-bottom: 24px;"></div>
            <a href="http://www.sote.pl/docs/produkty" class="external-link create_product"><div class="add_product"><img src="/images/backend/icons/add_product.png" alt="Dodaj produkt" /><?php echo __('Dodaj produkt', null, 'stBackend') ?></div></a>
        </div>
    </div>
    <div class="item">
        <div class="img">
            <img src="/images/backend/beta/gadgets/documentation.jpg">
        </div>
        <div class="info">
            <h3 class="post-title"><?php echo __("Dokumentacja", null, "stBackend") ?></h3>
            <a class="desc" href="http://www.sote.pl/docs/dokumentacja" target="_blank"><?php echo __("Zapoznaj się z pełną dokumentacją sklepu. Zobacz opis wszystkich standardowych funkcjonalności oprogramowania. Skorzystaj z pomocy w obsłudze sklepu, poznaniu jego funkcjonalności i sposobu ich wykorzystania w handlu.", null, "stBackend") ?></a>
            <div style="clear: both; margin-bottom: 6px;"></div>
            <a href="http://www.sote.pl/docs/dokumentacja" target="_blank"><div class="documentation"><img src="/images/backend/icons/documentation.png" alt="Dokumentacja" /><?php echo __('Dokumentacja', null, 'stBackend') ?></div></a>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>