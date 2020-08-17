<?php

class stMailListener
{

   public static function reminder(sfEvent $event)
   {
      $action = $event->getSubject();

      $c = new Criteria();

      $c->add(MailAccountPeer::IS_DEFAULT, true);

      if (!MailAccountPeer::doCount($c))
      {
         sfLoader::loadHelpers(array('Helper', 'stUrl', 'I18N'));

         stReminder::add('stMailAccount', __('Główne konto pocztowe sklepu nie zostało zdefiniowane. Kliknij', null, 'stMailAccountBackend').' '.st_link_to(__('tutaj', null, 'stMailAccountBackend'),'stMailAccountBackend/index').', '.__('aby je zdefiniować', null, 'stMailAccountBackend'), 'warning');
      }
   }

}