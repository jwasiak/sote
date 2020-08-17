<?php
/** 
 * SOTESHOP/stPayment 
 * 
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPayment
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Klasa stPaymentTypeActions
 *
 * @package     stPayment
 * @subpackage  actions
 */
class stPaymentTypeActions extends autostPaymentTypeActions
{
    protected function processDelete($id)
    {
        $this->payment_type = PaymentTypePeer::retrieveByPk($id);
        $this->forward404Unless($this->payment_type);

        if ($this->payment_type->countPayments() > 0)
        {
        	$i18n = $this->getContext()->getI18N();
            $this->getRequest()->setError('delete', $i18n->__('Nie można usunąć płatności "%payment%", ponieważ przypisana jest do przynajmniej jednego zamówienia. Zamiast usunąć odznacz opcje "Aktywna"', array('%payment%' => $this->payment_type->getName())));
            $this->forward('stPaymentType', 'list');
            return false;            
        }

        try
        {
            $this->deletePaymentType($this->payment_type);
        }
        catch (PropelException $e)
        {
            $this->getRequest()->setError('delete', 'Could not delete the selected Payment type. Make sure it does not have any associated items.');
            $this->forward('stPaymentType', 'list');
            return false;
        }

        return true;
    }


}