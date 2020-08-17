<?php use_helper('I18N') ?>
<?php if($isNaviBar == 1): ?>
<?php use_stylesheet("backend/ddlevelsfiles/ddlevelsmenu-base.css"); ?>
<?php use_stylesheet("backend/ddlevelsfiles/ddlevelsmenu-topbar.css"); ?>
<?php use_stylesheet("backend/ddlevelsfiles/ddlevelsmenu-sidebar.css"); ?>

<?php use_javascript("backend/ddlevelsfiles/ddlevelsmenu.js"); ?>

<div style="clear:both"></div>
<div id="ddtopmenubar" class="mattblackmenu">
    <ul>
        <li><?php echo st_link_to(__('Home'),"@homepage")?></li>
        <li><?php echo st_link_to(__('Zamówienia', null, 'stOrder'),"order", array('rel' => 'ddsubmenu1'))?></li>
        <li><?php echo st_link_to(__('Produkty', null, 'stProduct'),"product/index" , array('rel' => 'ddsubmenu2'))?></li>
        <li><?php echo st_link_to(__('Klienci', null, 'stUser'),"user/index" , array('rel' => 'ddsubmenu3'))?></li>
        <li><?php echo st_link_to(__('Strony www', null, 'stWebpageBackend'),"webpage/index" , array('rel' => 'ddsubmenu4'))?></li>
        <li><?php echo st_link_to(__('Integracje'),"#" , array('rel' => 'ddsubmenu5'))?></li>
        <li><?php echo st_link_to(__('Konfiguracja'),"configuration/list" , array('rel' => 'ddsubmenu6'))?></li>        
        <li><?php echo st_link_to(__('Aktualizacja'),"../update.php/stInstallerWeb", array('target' => '_blank'))?></li>

        <li style="float:right"><?php echo st_link_to(image_tag('backend/main/icons/info.png'),"stBackendMain/changeBackendView?backend_view=info");?></li>
        <li style="float:right"><?php echo st_link_to(image_tag('backend/main/icons/icons_all.png'),"stBackendMain/changeBackendView?backend_view=icon_all");?></li>
        <li style="float:right"><?php echo st_link_to(image_tag('backend/main/icons/icons.png'),"stBackendMain/changeBackendView?backend_view=icon");?></li>
        <li style="float:right">
            <div id="change-language">
                <?php st_include_partial('stLanguageBackend/changeLanguage');?>
            </div>
        </li>
    </ul>

           
    <div style="clear:both"></div>
</div>
<script type="text/javascript">
    ddlevelsmenu.setup("ddtopmenubar", "topbar") //ddlevelsmenu.setup("mainmenuid", "topbar")
</script>

<ul id="ddsubmenu1" class="ddsubmenustyle">
    <li><?php echo st_link_to(__('Zamówienia', null, 'stOrder'),"order")?>
      <ul>
          <li><?php echo st_link_to(__('Lista zamówień', null, 'stOrder'),"order")?></li>
          <li><?php echo st_link_to(__('Lista statusów', null, 'stOrder'),"order/orderStatusList")?></li>
          <li><?php echo st_link_to(__('Zamówienia Allegro', null, 'stOrder'),"order/allegroList")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"order/config")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Faktury', null, 'stInvoiceBackend'),"invoice")?>
      <ul>
          <li><?php echo st_link_to(__('Faktury wystawione', null, 'stInvoiceBackend'),"invoice")?></li>
          <li><?php echo st_link_to(__('Faktury do wystawienia', null, 'stInvoiceBackend'),"invoice/requestList")?></li>
          <li><?php echo st_link_to(__('Faktury proforma', null, 'stInvoiceBackend'),"invoice/proformaList")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"invoice/configCustom")?></li>
          <?php if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_POLISH): ?>          
            <li><?php echo st_link_to(__('Konfiguracja Ifirma', '', 'stIfirma'),"invoice/ifirmaConfig")?></li>
          <?php endif; ?>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Płatności', null, 'stPayment'),"payment")?>
      <ul>
          <li><?php echo st_link_to(__('Płatności klienta', null, 'stPayment'),"payment")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"payment_type")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Dostawy', null, 'stDeliveryBackend'),"delivery/index")?></li>
</ul>

<ul id="ddsubmenu2" class="ddsubmenustyle">
    <li><?php echo st_link_to(__('Produkty', null, 'stProduct'),"product/index")?>
      <ul>
          <li><?php echo st_link_to(__('Lista produktów', null, 'stProduct'),"product/index")?></li>
          <li><?php echo st_link_to(__('Prezentacja produktu', null, 'stProduct'),"product/presentationConfig")?></li>
          <li><?php echo st_link_to(__('Eksport', null, 'stProduct'),"product/export")?></li>
          <li><?php echo st_link_to(__('Import', null, 'stProduct'),"product/import")?></li>
          <li><?php echo st_link_to(__('Magazyn', null, 'stProduct'),"product/depositoryList")?></li>
          <li><?php echo st_link_to(__('Lista szablonów opcji', null, 'stProduct'),"product/optionsTemplatesList")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"product/config")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Kategorie', null, 'stCategory'),"category/manager")?>
        <ul>
          <li><?php echo st_link_to(__('Menadżer kategorii', null, 'stCategory'),"category/manager")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"category/config")?></li>
        </ul>
    </li>
    <li><?php echo st_link_to(__('Grupy produktow', null, 'stProductGroup'),"product_group/index")?></li>
    <li><?php echo st_link_to(__('Producenci', null, 'stProducer'),"producer/index")?>
        <ul>
          <li><?php echo st_link_to(__('Lista producentów', null, 'stProducer'),"producer/index")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"producer/config")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Grupy rabatowe', null, 'stDiscountBackend'),"discount/index")?>
        <ul>
          <li><?php echo st_link_to(__('Lista rabatów', null, 'stDiscountBackend'),"discount/list")?></li>
          <li><?php echo st_link_to(__('Progi rabatowe', null, 'stDiscountBackend'),"discount/rangeList")?></li>
        </ul>
    </li>
    <li><?php echo st_link_to(__('Recenzje', null, 'stReview'),"review/index")?>
        <ul>
          <li><?php echo st_link_to(__('Lista recenzji produktów', null, 'stReview'),"review/index")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Rekomendacje', null, 'stRecommendSendBackend'),"recommend_send/index")?>
        <ul>
          <li><?php echo st_link_to(__('Polecenia produktów', null, 'stRecommendSendBackend'),"recommend_send")?></li>
          <li><?php echo st_link_to(__('Polecenia sklepu', null, 'stRecommendSendBackend'),"recommend_shop_send")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"recommend_config")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Zapytania', null, 'stQuestionBackend'),"question/index")?>
        <ul>
          <li><?php echo st_link_to(__('Lista zapytań', null, 'stQuestionBackend'),"question/index")?></li>
          <li><?php echo st_link_to(__('Lista statusów', null, 'stQuestionBackend'),"question/questionStatusList")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"question/config")?></li>
      </ul>
    </li>
</ul>

<ul id="ddsubmenu3" class="ddsubmenustyle">
    <li><?php echo st_link_to(__('Klienci', null, 'stUser'),"user/index")?>
      <ul>
          <li><?php echo st_link_to(__('Lista klientów', null, 'stUser'),"user/index")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"user/config")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Partnerzy', null, 'stPartnerBackend'),"partner")?>
      <ul>
          <li><?php echo st_link_to(__('Lista partnerów', null, 'stPartnerBackend'),"partner")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"partner/configCustom")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Newsletter', null, 'stNewsletterBackend'),"newsletter")?>
        <ul>
          <li><?php echo st_link_to(__('Wiadomości', null, 'stNewsletterBackend'),"newsletter")?></li>
          <li><?php echo st_link_to(__('Adresy', null, 'stNewsletterBackend'),"newsletter/newsletterUserList")?></li>
          <li><?php echo st_link_to(__('Grupy', null, 'stNewsletterBackend'),"newsletter/newsletterGroupList")?></li>
          <li><?php echo st_link_to(__('Eksport', null, 'stNewsletterBackend'),"newsletter/export")?></li>
          <li><?php echo st_link_to(__('Import', null, 'stNewsletterBackend'),"newsletter/import")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"newsletter/config")?></li>
        </ul>
    </li>
</ul>

<ul id="ddsubmenu4" class="ddsubmenustyle">
    <li><?php echo st_link_to(__('Strony www', null, 'stWebpageBackend'),"webpage/index")?>
      <ul>
          <li><?php echo st_link_to(__('Lista stron www', null, 'stWebpageBackend'),"webpage/index")?></li>
          <li><?php echo st_link_to(__('Linki', null, 'stWebpageBackend'),"webpage/webpageGroupMainList")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Boksy informacyjne', null, 'stBoxBackend'),"box/index")?></li>
    <li><?php echo st_link_to(__('Teksty', null, 'stTextBackend'),"text/index")?></li>
    <li><?php echo st_link_to(__('Nowosci', null, 'stNewsBackend'),"news")?>
        <ul>
          <li><?php echo st_link_to(__('News', null, 'stNewsBackend'),"news")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"news/config")?></li>
        </ul>
    </li>
</ul>

<ul id="ddsubmenu5" class="ddsubmenustyle">
   <?php if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_POLISH): ?>
    <li><?php echo st_link_to(__('Porównywarki cen', null, 'stPriceCompare'),"price_compare")?>
      <ul>
          <li><?php echo st_link_to(__('Lista porównywarek cen', null, 'stPriceCompare'),"price_compare")?>
            <ul>
                <li><?php echo st_link_to(__('Ceneo'),"ceneo")?></li>
                <li><?php echo st_link_to(__('Nokaut'),"nokaut")?></li>
                <li><?php echo st_link_to(__('Oferciak'),"oferciak")?></li>
                <li><?php echo st_link_to(__('Okazje'),"okazje")?></li>
                <li><?php echo st_link_to(__('Radar'),"radar")?></li>
                <li><?php echo st_link_to(__('Skąpiec'),"skapiec")?></li>
                <li><?php echo st_link_to(__('Sklepy24'),"sklepy24")?></li>
                <li><?php echo st_link_to(__('Zakupomat'),"zakupomat")?></li>
            </ul>
          </li>
          <li><?php echo st_link_to(__('Dodawanie produktów', null, 'stPriceCompare'),"price_compare")?></li>
          <li><?php echo st_link_to(__('Przypomnienia', null, 'stPriceCompare'),"price_compare/remind")?></li>
      </ul>
    </li>
    <li><?php echo st_link_to(__('Allegro'),"allegro/index")?>
        <ul>
          <li><?php echo st_link_to(__('Lista aukcji', null, 'stAllegroBackend'),"allegro/list")?></li>
          <li><?php echo st_link_to(__('Szablony', null, 'stAllegroBackend'),"allegro_template/list")?></li>
          <li><?php echo st_link_to(__('Import kategorii', null, 'stAllegroBackend'),"allegro/categoryConfig")?></li>
          <li><?php echo st_link_to(__('Import zamówień', null, 'stAllegroBackend'),"allegro/orderCustom")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"allegro/config")?></li>
      </ul>
    </li>
    <?php endif; ?>
    <li><?php echo st_link_to(__('Google Analytics'),"@stGoogleAnalyticsPlugin")?></li>
    <li><?php echo st_link_to(__('Portale spolecznosciowe', null, 'stAddThisBackend'),"addthis/index")?></li>
</ul>

<ul id="ddsubmenu6" class="ddsubmenustyle">
    <li><?php echo st_link_to(__('Administracja sklepem', null, 'stConfigurationBackend'),"configuration/list")?>
        <ul>
          <li><?php echo st_link_to(__('Informacje o sklepie', null, 'stShopInfoBackend'),"@stShopInfoPlugin")?></li>
          <li><?php echo st_link_to(__('Administratorzy', null, 'sfGuardUser'),"auth/users/index")?></li>
          <li><?php echo st_link_to(__('Bezpieczenstwo', null, 'stSecurityBackend'),"security/index")?></li>
          <li><?php echo st_link_to(__('Optymalizacja', null, 'stOptimizationBackend'),"optimization/index")?></li>
          <li><?php echo st_link_to(__('Migracja danych', null, 'stMigration'),"migration")?></li>
          <li><?php echo st_link_to(__('Blokowanie sklepu', null, 'stLockBackend'),"lock")?></li>
          <li><?php echo st_link_to(__('API', null, 'stWebApiBackend'),"webapi/index")?></li>
          <li><?php echo st_link_to(__('Uaktualnienia'),"../update.php")?></li>
        </ul>
    </li>
    <li><?php echo st_link_to(__('Konfiguracja modułów', null, 'stConfigurationBackend'),"configuration/list")?>
        <ul>
          <li><?php echo st_link_to(__('Waluty', null, 'stCurrencyBackend'),"currency/index")?></li>
          <li><?php echo st_link_to(__('Wersje jezykowe', null, 'stLanguageBackend'),"@stLanguagePlugin")?></li>
          <li><?php echo st_link_to(__('Stawki Vat', null, 'stTaxBackend'),"tax/index")?></li>
          <li><?php echo st_link_to(__('Obsluga poczty', null, 'stMailAccountBackend'),"mail_account/list")?></li>
          <li><?php echo st_link_to(__('Dostepnosc', null, 'stAvailabilityBackend'),"availability/index")?></li>
          <li><?php echo st_link_to(__('Mapa serwisu', null, 'stSitemapBackend'),"sitemap/index")?></li>
          <li><?php echo st_link_to(__('Nawigacja', null, 'stNavigationBackend'),"navigation")?></li>
          <li><?php echo st_link_to(__('Konfiguracja zdjęć', null, 'stAssetImageConfiguration'),"image-configuration/watermark")?></li>
        </ul>
    </li>
    <li><?php echo st_link_to(__('Płatności', null, 'stConfigurationBackend'),"configuration/list")?>
        <ul>
          <?php if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_POLISH): ?>
          <li><?php echo st_link_to(__('PayU'),"platnoscipl")?></li>
          <li><?php echo st_link_to(__('Dotpay'),"dotpay")?></li>
          <li><?php echo st_link_to(__('Polcard'),"polcard")?></li>
          <li><?php echo st_link_to(__('Przelewy24'),"przelewy24")?></li>
          <li><?php echo st_link_to(__('Żagiel S.A.'),"zagiel")?></li>
          <li><?php echo st_link_to(__('eCard'),"ecard")?></li>
          <li><?php echo st_link_to(__('LUKAS Raty'),"lukas")?></li>
          <?php endif; ?>
          <li><?php echo st_link_to(__('Moneybookers'),"moneybookers")?></li>
          <li><?php echo st_link_to(__('Paypal'),"paypal")?></li>

        </ul>
    </li>
    <li><?php echo st_link_to(__('Edycja grafiki', null, 'stThemeBackend'),"theme/index")?></li>
    <li><?php echo st_link_to(__('Pozycjonowanie', null, 'stPositioningBackend'),"positioning")?></li>
    <li><?php echo st_link_to(__('Wyszukiwarka', null, 'stSearchBackend'),"search/list")?>
        <ul>
          <li><?php echo st_link_to(__('Lista wyszukiwania', null, 'stSearchBackend'),"search/list")?></li>
          <li><?php echo st_link_to(__('Optymalizacja', null, 'stSearchBackend'),"search/optimize")?></li>
          <li><?php echo st_link_to(__('Konfiguracja'),"search/config")?></li>

        </ul>
    </li>
    <li><?php echo st_link_to(__('Koszyk', null, 'stBasket'),"basket")?></li>
    <li><?php echo st_link_to(__('Raporty', null, 'sfStats'),"@stStatsPlugin")?></li>
    <li><?php echo st_link_to(__('Fast Cache'),"fastcache/index")?></li>
</ul>        

<?php endif; ?>
