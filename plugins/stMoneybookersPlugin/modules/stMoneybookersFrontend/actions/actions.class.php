<?php
/**
 * SOTESHOP/stDotpayPlugin
 *
 * Ten plik należy do aplikacji stDotpayPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stDotpayFrontendActions
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 */
class stMoneybookersFrontendActions extends stActions
{
    /**
     * Pozytywny powrót z płatności
     */
    public function executeReturnSuccess()
    {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    /**
     * Negatywny powrót z płatności
     */
    public function executeReturnFail()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    /**
     * Odbieranie statusu transakcji
     */
    public function executeStatusReport()
    {
        $this->setLayout(false);

        $requestMerchantId = $this->getRequestParameter('merchant_id');
        $requestTransactionId = $this->getRequestParameter('transaction_id');
        $requestMbAmount = $this->getRequestParameter('mb_amount');
        $requestMbCurrency = $this->getRequestParameter('mb_currency');
        $requestStatus = $this->getRequestParameter('status');
        $requestMd5sig = $this->getRequestParameter('md5sig');
        $requestHash = $this->getRequestParameter('hash');

        $stMoneybookers = new stMoneybookers();

        $shopMd5sig = strtoupper(md5($requestMerchantId.$requestTransactionId.strtoupper(md5($stMoneybookers->getSecretWord())).$requestMbAmount.$requestMbCurrency.$requestStatus));

        if ($requestMd5sig == $shopMd5sig)
        {
            $stPayment = new stPayment();

            switch ($requestStatus) {
                case -2: // błędna
                    $stPayment->cancelPayment($requestHash);
                    break;
                case -1: // anulowana
                    $stPayment->cancelPayment($requestHash);
                    break;
                case 0: // nowa
                    break;
                case 2: // zaakceptowana
                    $stPayment->confirmPayment($requestHash);
                    break;
            }
        }
    }
}