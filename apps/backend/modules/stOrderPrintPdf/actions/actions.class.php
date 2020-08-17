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
class stOrderPrintPdfActions extends stActions
{
   
    public function executeShow() {
        sfLoader::loadHelpers('Helper');
        sfLoader::loadHelpers('Partial');
        sfLoader::loadHelpers('stPartial');
        
        $order_id = $this->getRequestParameter('id',null);
        $download = $this->getRequestParameter('download',false);
        
        if (!$order_id) 
        {
            return sfView::NONE;
        }     

        $order = OrderPeer::retrieveByPK($order_id);
        
        if (!$order) 
        {
            return sfView::NONE;
        }  
        
        $pdf = new stOrderPrintPdf($order);
        $pdf->forceDownload($download);
        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->setHttpHeader('Content-Type', 'application/pdf');
        $response->setHttpHeader('Content-Disposition', 'attachment;filename="'.$order->getNumber().'.pdf');

        return $this->renderText($pdf->renderOrder());
    }
   
}