<?php
class appOnlineCodesFrontendActions extends stActions {

    public function executeDownload() {

        if ($this->getRequest()->hasParameter('file') && $this->getRequest()->hasParameter('hash')) {

            if ($this->getRequest()->hasParameter('id'))
            {
                $order = OrderPeer::retrieveByIdAndHashCode($this->getRequest()->getParameter('id'), $this->getRequest()->getParameter('hash'));
            }
            else 
            {
                $c = new Criteria();
                $c->add(OrderPeer::HASH_CODE, $this->getRequest()->getParameter('hash'));
                $order = OrderPeer::doSelectOne($c);
            }

            if (null !== $order) {
                $productIds = array();
                foreach ($order->getOrderProducts() as $orderProduct) $productIds[] = $orderProduct->getProductID();

                $c = new Criteria();
                $c->add(OnlineFilesPeer::ID, $this->getRequest()->getParameter('file'));
                $c->add(OnlineFilesPeer::PRODUCT_ID, $productIds, Criteria::IN);
                $fileObj = OnlineFilesPeer::doSelectOne($c);

                if(is_object($fileObj)) {                       
                    $file = sfConfig::get('sf_data_dir').'/online-files/'.$fileObj->getProductId().'/'.$fileObj->getFilename();

                    $key = md5(stConfig::getInstance('stRegister')->get('license'));
                    $hash = urlencode(base64_encode(trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $file, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND)))));
                    return $this->redirect('http'.($this->getRequest()->isSecure() ? 's' : '').'://'.$this->getRequest()->getHost().'/scripts/appOnlineCodesPlugin.php?hash='.$hash);
                }
            }
        }
    
        return $this->redirect('@homepage');
    }
}
