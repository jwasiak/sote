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
        
        if (!$order_id || !OrderPeer::retrieveByIdAndHashCode($order_id, $this->getRequestParameter('hash_code'))) {return $this->redirect('stOrderBackend');}     
        
        $order = new stOrderPrintPdf($order_id);

        $response = $this->getResponse();
        $response->clearHttpHeaders();
        $response->setHttpHeader('Content-Type', 'application/pdf');        
        $response->setHttpHeader('X-Robots-Tag', 'noindex');
        
        if ($download)
        {
            $response->setHttpHeader('Content-Disposition', 'attachment;filename="order-'.$order_id.'.pdf');
        }

        $check_order = OrderPeer::retrieveByIdAndHashCode($order_id, $this->getRequestParameter('hash_code'));

        if($check_order->getSessionHash()==session_id()){
            return $this->renderText($order->renderOrder());
        }else{
           return $this->redirect('stOrderBackend'); 
        }        
        
    }
   
}