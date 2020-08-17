<?php use_helper('I18N', 'stAdminGenerator', 'stTrustedShops');?>
<?php use_stylesheet('backend/stTrustedShopsPlugin.css'); ?>
<?php st_include_partial('stTrustedShopsBackend/header', array('title' => __('Integracja z serwisem Trusted Shops.', 
array(), 'stTrustedShopsBackend'), 'route' => 'stTrustedShopsBackend/information')) ?>
<?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items, 'trusted_shops' => null)) ?>
<div id="sf_admin_content">
    <?php if ($sf_user->getCulture() == 'pl_PL'):?>
    <div class="trust_header">
        <div class="trust_title"><b><?php echo __('Zyskaj bezpieczny regulamin i zaufanie kupujących!');?></b></div>
        <div class="img_txt_trusted">
            <img width="190" src="/images/backend/stTrustedShopsPlugin/e_trusted_shops-rgb.png" alt=" "/>    
        </div>
        <div class="desc_trusted">
            <?php echo __('W pakiecie naszego partnera, firmy Trusted Shops znajdziesz nie tylko bezpieczny i dopasowany do Twoich indywidualnych potrzeb regulamin sklepu internetowego, ale i rozwiązania, które przekonają potencjalnych klientów do zakupów w Twoim sklepie:');?>
        </div>
    </div>
    <div class="st_clear_all"></div>
    <div class="left logo_trusted">
        <div class="">
            <?php if ($sf_user->getCulture() == 'pl_PL'):?>
                <img src="/images/backend/stTrustedShopsPlugin/trusted.png" alt=" "/>  
            <?php else: ?>
                <img src="/images/backend/stTrustedShopsPlugin/seal_rating_en.jpg" alt=" "/>  
            <?php endif; ?>  
        </div>
        <div class="st_clear_all"></div>
        <?php if($hasCertificate):?>
            <div class="sote_integration">
                <div>
                    Sote
                    <br />
                    <?php echo __('już zintegrował produkty Trusted Shops w panelu');?>!
                </div>
            </div>
        <?php endif;?>
    </div>
    <div class="left info_trusted">
        <div class="">
            <ul>
                <li>
                    <b><?php echo __('Regulamin e-sklepu');?></b>    
                    <?php echo __('dopasowane do Twoich indywidualnych potrzeb regulamin i polityka prywatności z aktualizacjami w przypadku zmian prawa lub orzecznictwa');?>
                </li>
                <li>
                    <b><?php echo __('Znak jakości');?></b>
                    <?php echo __('dowód wysokiego standardu obsługi klienta w Twoim sklepie');?>            
                </li>
                <li>
                    <b><?php echo __('Gwarancja zwrotu pieniędzy');?></b>
                    <?php echo __('która przekona potencjalnych klientów o bezpieczeństwie zakupów w Twoim sklepie i pomoże obniżyć wskaźnik porzuceń strony');?>            
                </li>
                 <li>
                    <b><?php echo __('System opinii');?></b>
                    <?php echo __('dzięki któremu łatwo zbierzesz i zaprezentujesz na stronie niezbędne do zwiększenia sprzedaży w sieci rekomendacje klientów');?>            
                </li>
            </ul>
            <div class="st_clear_all"></div>
            <div class="trusted-button">
                <a href="<?php echo backend_buyer_protection_register_url();?>" target="_blank"><?php echo __('Zarejestruj się teraz!');?></a>
            </div>
            <div class="st_clear_all"></div>
        </div>
    </div>  
     <?php else: ?>
         <div class="en-info">
            <a href="https://www.trustedshops.eu/merchants/order.html?audit=0" target="_blank"><img src="/images/backend/stTrustedShopsPlugin/infografik_en.jpg" alt=" "/></a>
         </div>     
    <?php endif; ?>  
</div>
<div class="st_clear_all"></div>
<?php st_include_partial('stTrustedShopsBackend/footer', array()) ?>