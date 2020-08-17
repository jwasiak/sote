<?php
/**
 * SOTESHOP/stInvoicePlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 665 2009-04-16 07:43:27Z michal $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stInvoiceFrontendActions.
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 */
class stInvoicePdfActions extends stActions
{
   
    public function executeShow() {

        sfLoader::loadHelpers('Helper');
        sfLoader::loadHelpers('Partial');
        sfLoader::loadHelpers('stPartial');
        
        $invoice_id = $this->getRequestParameter('id',null);
        $download = $this->getRequestParameter('download',false);
        $hash_code = $this->getRequestParameter('hash_code',false);
        $culture = $this->getRequestParameter('culture',null);
            
        $pdf = new stInvoicePdf($invoice_id);
        $pdf->forceDownload($download);
        $invoice = $pdf->getInvoice();

        if (SF_APP == 'frontend' && $invoice->getOrder()->getHashCode() != $hash_code)
        {
            return $this->forward404();
        }

        $filename = $invoice->getIsProforma() ? 'proforma-'.$invoice->getNumber().'.pdf' : 'invoice-'.$invoice->getNumber().'.pdf';

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->setHttpHeader('Content-Type', 'application/pdf');
        $response->setHttpHeader('Content-Disposition', 'attachment;filename="'.$filename);
        $response->setHttpHeader('X-Robots-Tag', 'noindex');

        return $this->renderText($pdf->renderInvoice($culture,$hash_code));
    }
   
}