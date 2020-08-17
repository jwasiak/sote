<?php
class appOnlineCodesListener {

	/**
	 * Ładowanie pliku stProduct.yml 
	 *
	 * @param sfEvent $event
	 */
	public static function generateStProduct(sfEvent $event) {
		$event->getSubject()->attachAdminGeneratorFile('appOnlineCodesPlugin', 'stProduct.yml');
	}

	/**
	 * Metoda savePaymentStatus
	 * Obsługa wysyłania kodów i plików online.
	 *
	 * @param sfEvent $event
	 */
	public static function savePaymentStatus(sfEvent $event) {
		if ($event->getSubject()->getStatus() == true) {
			$order = $event->getSubject()->getOrder();
			if (is_object($order) && !$order->getIsCodesSent() && $order->getUnpaidAmount() == 0) {
				$mailCodes = array();
				foreach ($order->getOrderProducts() as $orderProduct) {
					$product = $orderProduct->getProduct();
                    if (!is_object($product)) continue; 
                    $codes = array();
					for($i = 1; $i <= $orderProduct->getQuantity(); $i++) {

						$c = new Criteria();
						$c->add(OnlineCodesPeer::PRODUCT_ID, $product->getId());
						$c1 = $c->getNewCriterion(OnlineCodesPeer::USED, OnlineCodesPeer::USED."<".OnlineCodesPeer::USAGE_LIMIT, Criteria::CUSTOM);
						$c2 = $c->getNewCriterion(OnlineCodesPeer::USAGE_LIMIT, null, Criteria::ISNULL);
						$c3 = $c->getNewCriterion(OnlineCodesPeer::USAGE_LIMIT, 0);
						$c1->addOr($c2);
						$c1->addOr($c3);
						$c->add($c1);
						$code = OnlineCodesPeer::doSelectOne($c);

						if (is_object($product) && is_object($code)) {
							$code->setUsed($code->getUsed()+1);
							$code->save();

							$codes[] = $code->getCode(); 
							$mailCodes[] = array('product' => $product->getName(), 'code' => $code->getCode());
						}
					}
					
					if (!empty($codes)) {
					    $orderProduct->setOnlineCode(serialize($codes));
					    $orderProduct->save();
					}
				}

				$mailFiles = array();
				foreach ($order->getOrderProducts() as $orderProduct) {
					$product = $orderProduct->getProduct();

                    if (!is_object($product)) continue; 

					$c = new Criteria();
					$c->add(OnlineFilesPeer::PRODUCT_ID, $product->getId());
					$files = OnlineFilesPeer::doSelect($c);

					if (!empty($files)) {
						$filesList = array();
						foreach($files as $file) {
							$filesList[] = array('id' => $file->getId(), 'name' => $file->getFilename());
						}
						$mailFiles[] = array('product' => $product->getName(), 'product_id' => $product->getId(), 'files' => $filesList);
					}
				}

				if (!empty($mailCodes) || !empty($mailFiles)) {
					sfLoader::loadHelpers(array('Helper', 'I18N'));

					$context = sfContext::getInstance();
					$mail = stMailer::getInstance();

					$htmlMailMessage = stMailTemplate::render('appOnlineCodesMail/sendMailHtml', array('order' => $order, 'codes' => $mailCodes, 'files' => $mailFiles));
					$plainMailMessage = stMailTemplate::render('appOnlineCodesMail/sendMailPlain', array('order' => $order, 'codes' => $mailCodes, 'files' => $mailFiles));
					$subject = $context->getRequest()->getHost().' - '.$context->getI18N()->__('dodatkowe dane do zamówienia numer',  null, 'appOnlineCodesMail').': '.$order->getNumber();

					$mail->setSubject($subject)->setHtmlMessage($htmlMailMessage)->setPlainMessage($plainMailMessage)->setTo($order->getSfGuardUser()->getUsername())->send();
				}

				$order->setIsCodesSent(1);
                $order->save();
			}
		}
	}

    public static function updateFromRequestFiles(sfEvent $event) {
        if (sfContext::getInstance()->getRequest()->hasParameter('product_id')) {
            $event['modelInstance']->setProductId(sfContext::getInstance()->getRequest()->getParameter('product_id'));
        }

        

		$online_files = $event->getSubject()->getRequestParameter('online_files');
		$filename = $event->getSubject()->getRequest()->getFileName('online_files[filename]');

		if ($filename)
		{
			$event['modelInstance']->setFilename($filename);

			$path = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.sfContext::getInstance()->getRequest()->getParameter('product_id').DIRECTORY_SEPARATOR;
			if (!file_exists($path)) mkdir($path);
			$event->getSubject()->getRequest()->moveFile('online_files[filename]', $path.$filename);
		}
    }

    public static function getThumbForImage($file) {
        if ($file->getMediaType() == 'ST_IMAGES') {
            $filename = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$file->getProduct()->getId().DIRECTORY_SEPARATOR.$file->getFilename();
            $dest = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$file->getProduct()->getCode().DIRECTORY_SEPARATOR.$file->getFilename();
            if (!is_file($dest) && is_file($filename) && sfAssetsLibraryTools::getType($filename) == 'image') {
                sfAssetsLibraryTools::createThumbnail($filename, $dest, 148, 128, true);
                return '/'.'media'.DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$file->getProduct()->getCode().DIRECTORY_SEPARATOR.$file->getFilename();
            }
            if (is_file($dest)) {
                return '/'.'media'.DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$file->getProduct()->getCode().DIRECTORY_SEPARATOR.$file->getFilename();
            }
        }
        return '/media/shares/thumbnail/large_no_image.png';

    }
}