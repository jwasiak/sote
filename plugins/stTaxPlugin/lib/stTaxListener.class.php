<?php

class stTaxListener
{

   public static function reminder(sfEvent $event)
   {
      $action = $event->getSubject();

      $i18n = $action->getContext()->getI18N();

      if (!($action->getModuleName() == 'stTaxBackend' && $action->getActionName() == 'updatePrice'))
      {
         $c = new Criteria();

         $c->add(TaxPeer::UPDATE_RESUME, null, Criteria::ISNOTNULL);

         $tax = TaxPeer::doSelectOne($c);

         sfLoader::loadHelpers(array('Helper', 'stUrl', 'Asset', 'I18N'));

         if ($tax)
         {
            $reminder = __('Wystąpił problem podczas aktualizacji cen dla stawki VAT', null, 'stTaxBackend').' '.$tax->getVat().' %. '.__('Kliknij', null, 'stTaxBackend').' '.st_link_to(__('tutaj', null, 'stTaxBackend'), 'stTaxBackend/updatePrice?id='.$tax->getId()).', '.__('aby dokończyć.', null, 'stTaxBackend');

            stReminder::add('stTaxBackend/updatePrice', $reminder, 'warning');
         }
      }

      if (strtotime('31.01.2011') > time())
      {
         if(sfContext::getInstance()->getUser()->getCulture() == 'pl_PL')
        {
            $docs_link = '<a href="http://www.sote.pl/trac/wiki/new_doc/tax" target="_blank">';
        } else {
            $docs_link = '<a href="http://www.sote.pl/trac/wiki/new_doc/en/tax" target="_blank">';
        }

        $info = $i18n->__('Od 01.01.2011 obowiązują nowe stawki VAT (więcej w', null, 'stTaxBackend').' '.$docs_link.$i18n->__('dokumentacji', null, 'stTaxBackend').'</a>)';

        stReminder::add('stTaxBackend/taxInfo', $info);
      }
   }

}