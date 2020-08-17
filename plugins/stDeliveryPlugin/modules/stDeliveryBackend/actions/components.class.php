<?php
/** 
 * SOTESHOP/stDelivery
 *
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDeliveryPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 14041 2011-07-12 09:00:21Z bartek $
 */

/** 
 * stDelivery components
 *
 * @author Marcin Olejniczak <marcin.olejniczak@sote.pl>
 *
 * @package     stDeliveryPlugin
 * @subpackage  actions
 */
class stDeliveryBackendComponents extends autoStDeliveryBackendComponents
{
    public function executeEditPayment()
    {
        $this->payments = array();

        $this->form_has_errors = false;

        if ($this->getRequest()->hasErrors() && $this->hasRequestParameter('delivery[payments]'))
        {
            $payments = DeliveryPeer::doSelectPaymentsWithDeliveryHasPaymentsByPK($this->delivery->getId());

            $delivery_payments = $this->getRequestParameter('delivery[payments]', array());

            $is_default_payment = $this->getRequestParameter('delivery[is_default_payment]');

            foreach ($delivery_payments as $id => $delivery_payment)
            {
                $tmp = $this->editPaymentHelper($payments, $id);

                if ($tmp == null) continue;

                if (!$tmp->getDeliveryHasPaymentType())
                {
                    $tmp->addExternalObject(new DeliveryHasPaymentType(), 'DeliveryHasPaymentType');

                    $tmp->getDeliveryHasPaymentType()->setDeliveryId($this->delivery->getId());
                }

                $tmp->getDeliveryHasPaymentType()->setPaymentTypeId($id);

                $tmp->getDeliveryHasPaymentType()->setCostNetto($delivery_payment['cost_netto']);

                $tmp->getDeliveryHasPaymentType()->setCostBrutto($delivery_payment['cost_brutto']);

                $tmp->getDeliveryHasPaymentType()->setFreeFrom($delivery_payment['free_from']);

                if ($is_default_payment)
                {
                    $tmp->getDeliveryHasPaymentType()->setIsDefault($is_default_payment == $id);
                }
                
                $tmp->getDeliveryHasPaymentType()->setIsActive(isset($delivery_payment['is_active']));

                $this->payments[] = $tmp;
            }

            foreach ($this->getRequest()->getErrorNames() as $name)
            {
                if (strpos($name, 'delivery{payments}{') === 0)
                {
                    $this->form_has_errors = true;

                    break;
                }
            }
        }
        else
        {
            $this->payments = DeliveryPeer::doSelectPaymentsWithDeliveryHasPaymentsByPK($this->delivery->getId());
        }
    }

    protected function editPaymentHelper($payments, $payment_id)
    {
        foreach($payments as $payment)
        {
            if ($payment->getId() == $payment_id)
            {
                return $payment;
            }
        }

        return null;
    }

    public function executeEditAdditionalCost()
    {
        $this->delivery_sections = array();

        $c = new Criteria();

        $c->addAscendingOrderByColumn(DeliverySectionsPeer::VALUE_FROM);

        if ($this->getRequest()->hasErrors())
        {
            $delivery_sections = $this->getRequestParameter('delivery[sections]', array());

            foreach ($delivery_sections as $id => $delivery_section)
            {
                $this->delivery_sections[$id] = new DeliverySections();

                $this->delivery_sections[$id]->setFrom($delivery_section['from']);

                $this->delivery_sections[$id]->setCostNetto($delivery_section['cost_netto']);

                $this->delivery_sections[$id]->setCostBrutto($delivery_section['cost_brutto']);
            }
        }
        else
        {
            $this->delivery_sections = $this->delivery->getDeliverySectionss($c);
        }

        $this->ascs = DeliverySectionsPeer::getAdditionalSectionCosts();

        $this->options = array('' => $this->getContext()->getI18N()->__('Brak'));

        foreach($this->ascs as $k => $asc)
        {
            $this->options[$k] = $this->getContext()->getI18N()->__($asc);
        }

        $this->selected = $this->delivery->getSectionCostType();
    }

   public function executeConfigContent()
   {
        $this->config = stConfig::getInstance($this->getContext(), 'stDeliveryBackend');
        
   }

}
