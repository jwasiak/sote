<?php

/**
 * SOTESHOP/stTaxPlugin
 *
 * Ten plik należy do aplikacji stTaxPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stTaxPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id$
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/**
 * stTaxBackend actions.
 *
 * @package     stTaxPlugin
 * @subpackage  actions
 */
class stTaxBackendActions extends autostTaxBackendActions
{

   public function executeChangePriceType()
   {
      $type = $this->getRequestParameter('type');

      $config = stConfig::getInstance(sfContext::getInstance(), 'stProduct');

      $config->set('price_type', $type);

      $config->save();

      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executeSave()
   {
      $tax = TaxPeer::retrieveByPK($this->getRequestParameter('id'));

      if (!$tax || $tax->getVat() == $this->getRequestParameter('tax[vat]'))
      {
         return parent::executeSave();
      }

      $this->tax = $tax;
   }

   public function updateTaxFromRequest()
   {
      if ($this->hasRequestParameter('update_price') && $this->tax->getVat() != $this->getRequestParameter('tax[vat]'))
      {
         $this->tax->setUpdateResume(array('prev_value' => $this->tax->getVat(), 'type' => $this->getRequestParameter('update_price')));
      }

      parent::updateTaxFromRequest();
   }

   public function executeUpdatePrice()
   {
      $tax = TaxPeer::retrieveByPK($this->getRequestParameter('id'));

      if ($params = $tax->getUpdateResume())
      {
         $c = new Criteria();

         $c->add(ProductPeer::TAX_ID, $tax->getId());

         $steps['products'] = ProductPeer::doCount($c);

         $c = new Criteria();

         $c->add(DeliveryPeer::TAX_ID, $tax->getId());

         $steps['deliveries'] = DeliveryPeer::doCount($c);

         $this->steps = $steps['products'] + $steps['deliveries'];

         stTaxProgressBar::setParam('steps', $steps);
      }

      $params['id'] = $tax->getId();

      $params['value'] = $tax->getVat();

      stTaxProgressBar::setParam('tax', $params);

      $this->params = $params;

      $i18n = $this->getContext()->getI18n();

      if (isset($params['type']))
      {
         $this->title = $i18n->__('Przeliczanie cen z %type% dla stawki VAT %tax%%', array(
            '%type%' => $i18n->__($params['type'] == 'netto' ? 'brutto na netto' : 'netto na brutto'), 
            '%tax%' => $params['value']
         ));
      }
      else
      {
         $this->title = $i18n->__('Przeliczanie cen dla stawki VAT %tax%%', array('%tax%' => $params['value']));
      }

      $this->tax = $tax;
   }

   public function validateEdit()
   {
      $tax = $this->getTaxOrCreate();

      if ($resume = $tax->getUpdateResume())
      {
         $warning = __('Wykryto zmiane stawki VAT. Kliknij').' <a style="color: #fff; text-decoration: underline" href="'.$this->getController()->genUrl('stTaxBackend/updatePrice?id='.$tax->getId()).'">'.__('tutaj').'</a>, '.__('aby dokończyć poprzednią aktualizację cen');
         $this->setFlash('warning', $warning);

         return false;
      }

      return true;
   }

   public function validateSave()
   {
      $tax = $this->getTaxOrCreate();

      if ($resume = $tax->getUpdateResume())
      {
         $warning = __('Wykryto zmiane stawki VAT. Kliknij').' <a style="color: #fff; text-decoration: underline" href="'.$this->getController()->genUrl('stTaxBackend/updatePrice?id='.$tax->getId()).'">'.__('tutaj').'</a>, '.__('aby dokończyć poprzednią aktualizację cen');

         $this->setFlash('warning', $warning);

         return false;
      }

      return true;
   }

   public function handleErrorSave()
   {
      $this->handleErrorEdit();

      $this->setTemplate('edit');

      return sfView::SUCCESS;
   }

   public function saveTax($tax)
   {
      $ret = parent::saveTax($tax);

      if ($this->hasRequestParameter('update_price'))
      {
         $con = Propel::getConnection();

         $sql = sprintf('UPDATE %1$s, %2$s SET %3$s = ? WHERE %4$s = %5$s AND %6$s = ?',
                         ProductOptionsValuePeer::TABLE_NAME,
                         ProductPeer::TABLE_NAME,
                         ProductOptionsValuePeer::IS_UPDATED,
                         ProductOptionsValuePeer::PRODUCT_ID,
                         ProductPeer::ID,
                         ProductPeer::TAX_ID);

         $st = $con->prepareStatement($sql);

         $st->setBoolean(1, false);

         $st->setInt(2, $tax->getId());

         $st->executeQuery();

         $this->redirect('stTaxBackend/updatePrice?id='.$tax->getId());
      }

      return $ret;
   }

}