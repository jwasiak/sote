<?php

class stDocBackendComponents extends sfComponents
{
    public function executeShowDocLink() {                                                                             
        
       if($this->getUser()->getCulture()!="pl_PL"){
            return sfView::NONE;
       }                         
         
        $link = explode("/", $_SERVER['REQUEST_URI']);         
        
        $doc = array();
        $doc['product'] = array();
         
        $doc['product']['default']='https://www.sote.pl/docs/produkty';
        $doc['product']['optionsTemplatesList']='https://www.sote.pl/docs/produkty-opcje-produktow';
        $doc['product']['dimensionList']='https://www.sote.pl/docs/konfiguracja-rozmiarow';
        $doc['product']['depositoryList']='https://www.sote.pl/docs/magazyn';
        $doc['product']['config']='https://www.sote.pl/docs/konfiguracja-produktow';
        $doc['product']['presentationConfig']='https://www.sote.pl/docs/prezentacja-produktow';
        $doc['product']['export']='https://www.sote.pl/docs/import-eksport-produktow';
        $doc['product']['import']='https://www.sote.pl/docs/import-eksport-produktow';

        $doc['category']='https://www.sote.pl/docs/kategorie';                        
        $doc['order']='https://www.sote.pl/docs/zamowienia';
        $doc['question']='https://www.sote.pl/docs/zapytania';
        $doc['invoice']='https://www.sote.pl/docs/faktury';
        $doc['payment']='https://www.sote.pl/docs/platnosci#3';
        $doc['gift_group']='https://www.sote.pl/docs/gratisy-w-koszyku';
        $doc['discount']='https://www.sote.pl/docs/rabaty';
        $doc['giftcard']='https://www.sote.pl/docs/bony-zakupowe';
        $doc['delivery']='https://www.sote.pl/docs/dostawy';
        $doc['allegro']='https://www.sote.pl/docs/allegro-integracja';
        $doc['price_compare']='https://www.sote.pl/docs/porownywarki-cen';
        $doc['google_shopping']='https://www.sote.pl/docs/google-shopping-integracja-z-google-merchant';
        $doc['paczkomaty']='https://www.sote.pl/docs/paczkomaty';
        $doc['poczta-polska']='https://www.sote.pl/docs/poczta-polska-integracja';        
        $doc['producer']='https://www.sote.pl/docs/producenci';
        $doc['user']='https://www.sote.pl/docs/klienci';
        $doc['review']='https://www.sote.pl/docs/recenzje';
        $doc['sociallinks']='https://www.sote.pl/docs/linki-spolecznosciowe';
        $doc['slideBanner']='https://www.sote.pl/docs/banery';
        $doc['product_group']='https://www.sote.pl/docs/grupy-produktow';
        $doc['blog']='https://www.sote.pl/docs/blog';
        $doc['webpage']='https://www.sote.pl/docs/strony-informacyjne';
        $doc['box']='https://www.sote.pl/docs/boksy-informacyjne';
        $doc['text']='https://www.sote.pl/docs/teksty';
        $doc['newsletter']='https://www.sote.pl/docs/newsletter';
        $doc['google_analytics']='https://www.sote.pl/docs/google-analytics';
        $doc['facebook_pixel']='https://www.sote.pl/docs/piksel-facebooka';
        $doc['mail_account']='https://www.sote.pl/docs/obsluga-poczty';
        $doc['theme']='https://www.sote.pl/docs/edycja-grafiki';        
        $doc['product-attributes']='https://www.sote.pl/docs/atrybuty-produktow';
        $doc['fastcache']='https://www.sote.pl/docs/fastcache';
        $doc['auth']='https://www.sote.pl/docs/administratorzy-zarzadzanie-sklepem';
        $doc['webapi']='https://www.sote.pl/docs/webapi';
        $doc['security']='https://www.sote.pl/docs/bezpieczenstwo';
        $doc['lock']='https://www.sote.pl/docs/blokowanie-sklepu';
        $doc['htaccess']='https://www.sote.pl/docs/edycja-pliku-htaccess';
        $doc['shop_info']='https://www.sote.pl/docs/informacje-o-sklepie';
        $doc['migration']='https://www.sote.pl/docs/migracja-danych';
        $doc['optimization']='https://www.sote.pl/docs/optymalizacja';
        $doc['additional_desc']='https://www.sote.pl/docs/dodatkowy-opis';
        $doc['availability']='https://www.sote.pl/docs/dostepnosc';
        $doc['wysiwyg']='https://www.sote.pl/docs/edytor-wysiwyg';
        $doc['groupPrice']='https://www.sote.pl/docs/grupy-cenowe';
        $doc['basicPrice']='https://www.sote.pl/docs/jednostki-miar-cen-zadaniczych';
        $doc['image-configuration']='https://www.sote.pl/docs/konfiguracja-zdjec';
        $doc['basket']='https://www.sote.pl/docs/koszyk';
        $doc['countries']='https://www.sote.pl/docs/kraje-i-strefy-dostawy';
        $doc['compatibility']='https://www.sote.pl/docs/modul-zgodnosci';
        $doc['navigation']='https://www.sote.pl/docs/nawigacja';
        $doc['positioning']='https://www.sote.pl/docs/pozycjonowanie';
        $doc['payment-type']='https://www.sote.pl/docs/platnosci';
        $doc['tax']='https://www.sote.pl/docs/stawki-vat';
        $doc['trustedshops']='https://www.sote.pl/docs/trusted-shops-integracja';
        $doc['currency']='https://www.sote.pl/docs/waluty';
        $doc['language']='https://www.sote.pl/docs/wersje-jezykowe';
        $doc['search']='https://www.sote.pl/docs/wyszukiwarka-produktow';
        $doc['bm']='https://www.sote.pl/docs/bluemedia';
        $doc['cashbill']='https://www.sote.pl/docs/cashbill';
        $doc['lukas']='https://www.sote.pl/docs/credit-agicole-raty';
        $doc['dotpay']='https://www.sote.pl/docs/dotpay';
        $doc['ecard']='https://www.sote.pl/docs/ecard';
        $doc['eservice']='https://www.sote.pl/docs/eservice';
        $doc['paybynet']='https://www.sote.pl/docs/paybynet';
        $doc['polcard']='https://www.sote.pl/docs/payeezy';
        $doc['paynow']='https://www.sote.pl/docs/paynow-mbank';
        $doc['paypal']='https://www.sote.pl/docs/paypal';
        $doc['platnoscipl']='https://www.sote.pl/docs/payu';
        $doc['przelewy24']='https://www.sote.pl/docs/przelewy24';
        $doc['inbank']='https://www.sote.pl/docs/inbank';
        $doc['eraty-santander']='https://www.sote.pl/docs/santander-consumer-bank-raty';
        $doc['moneybookers']='https://www.sote.pl/docs/skrill';
        $doc['ceneo']='https://www.sote.pl/docs/ceneo';
        $doc['additionalApplicationsList']='https://www.sote.pl/docs/dodatkowe-aplikacje';    
        $doc['extend-importexport']='https://www.sote.pl/docs/import-eksport-opisow-produktow';        
        $doc['discount']='https://www.sote.pl/docs/kody-rabatowe';                
        $doc['nokaut']='https://www.sote.pl/docs/nokaut-porownywarka-cen';
        $doc['okazje']='https://www.sote.pl/docs/okazje-porownywarka-cen';                          
         
         
         if($link[2]=="product"){
             
              if($link[3]=="optionsTemplatesList"){
                 $doc_link = $doc['product']['optionsTemplatesList'];
              }elseif($link[3]=="dimensionList"){
                 $doc_link = $doc['product']['dimensionList'];
              }elseif($link[3]=="depositoryList"){
                 $doc_link = $doc['product']['depositoryList'];
              }elseif($link[3]=="config"){
                 $doc_link = $doc['product']['config'];
              }elseif($link[3]=="presentationConfig"){
                 $doc_link = $doc['product']['presentationConfig'];
              }elseif($link[3]=="export"){
                 $doc_link = $doc['product']['export'];
              }elseif($link[3]=="import"){
                 $doc_link = $doc['product']['import'];   
              }else{
                 $doc_link = $doc['product']['default'];     
              }             
                                   
                 
         }else{
            @$doc_link = $doc[$link[2]];     
         }
         
         
         
        if($doc_link==""){
             return sfView::NONE;
        }else{
            $this->link_to_doc = $doc_link;    
        }
         
        
    }
    
}