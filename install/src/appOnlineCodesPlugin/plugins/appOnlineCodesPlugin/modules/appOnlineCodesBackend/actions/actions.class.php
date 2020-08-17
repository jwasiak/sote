<?php
class appOnlineCodesBackendActions extends autoAppOnlineCodesBackendActions {

	/**
	 * Szukanie produktów w edycji kodów i plików.
	 */
	public function executeAjaxSearchProduct() {
		$query = $this->getRequestParameter('query');
		$by = $this->getRequestParameter('by');

		sfLoader::loadHelpers(array('Helper', 'stProductImage'));

		$c = new Criteria();
		$c->setLimit(50);

		switch ($by) {
			case 'code':
				$c->add(ProductPeer::CODE, $query);
				break;
			case 'name':
				$c->add(ProductI18nPeer::NAME, '%' . $query . '%', Criteria::LIKE);
				break;
		}

		$products = ProductPeer::doSelectWithI18n($c);

		$suggestions = array();
		$data = array();

		foreach ($products as $product) {
			$suggestions[] = $product->getCode() . ': ' . $product->getName();

			$data[] = array('id' => $product->getId(), 'ip' => st_product_image_path($product, 'icon'), 'c' => $product->getCode(), 'n' => $product->getName(), 'pn' => $product->getPriceNetto(), 'pb' => $product->getPriceBrutto());
		}

		return $this->renderJSON(array('query' => $query, 'suggestions' => $suggestions, 'data' => $data));
	}

	/**
	 * Przeciążanie aktualizacji kodów. 
	 */
	protected function updateOnlineCodesFromRequest() {
		if ($this->getRequest()->hasParameter('online_codes[product_id]')) $this->online_codes->setProductId($this->getRequestParameter('online_codes[product_id]'));
		parent::updateOnlineCodesFromRequest();
	}

	/**
	 * Przeciążanie filtów na liście kodów.
	 *
	 * @param Criteria $c
	 */
	protected function addFiltersCriteria($c)
	{
		parent::addFiltersCriteria($c);

		if (isset($this->filters['by_product_code']) && $this->filters['by_product_code'] !== '')
		{
			$c->addJoin(OnlineCodesPeer::PRODUCT_ID, ProductPeer::ID);
			$c->add(ProductPeer::CODE, $this->filters['by_product_code'], Criteria::LIKE);
		}

		if (isset($this->filters['by_product_name']) && $this->filters['by_product_name'] !== '')
		{
			$c->addJoin(OnlineCodesPeer::PRODUCT_ID, ProductPeer::ID);
			$c->add(ProductPeer::OPT_NAME, $this->filters['by_product_name'] . '%', Criteria::LIKE);
		}
	}

	/**
	 * Przeciążanie aktualizacji plików. 
	 */
	protected function updateOnlineFilesOnlineFilesFromRequest()
	{
		parent::updateOnlineFilesOnlineFilesFromRequest();

		$online_files = $this->getRequestParameter('online_files');
		$filename = $this->getRequest()->getFileName('online_files[filename]');

		if ($filename)
		{
			$this->online_files->setFilename($filename);

			$path = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$online_files['product_id'].DIRECTORY_SEPARATOR;
			if (!file_exists($path)) mkdir($path);
			$this->getRequest()->moveFile('online_files[filename]', $path.$filename);
		}

		if ($this->getRequest()->hasParameter('online_files[product_id]')) $this->online_files->setProductId($this->getRequestParameter('online_files[product_id]'));
	}

	/**
	 * Przeciązanie filtrów na liście plików.
	 *
	 * @param unknown_type $c
	 */
	protected function addOnlineFilesFiltersCriteria($c)
	{
		parent::addOnlineFilesFiltersCriteria($c);

		if (isset($this->filters['by_product_code']) && $this->filters['by_product_code'] !== '')
		{
			$c->addJoin(OnlineFilesPeer::PRODUCT_ID, ProductPeer::ID);
			$c->add(ProductPeer::CODE, $this->filters['by_product_code'], Criteria::LIKE);
		}

		if (isset($this->filters['by_product_name']) && $this->filters['by_product_name'] !== '')
		{
			$c->addJoin(OnlineFilesPeer::PRODUCT_ID, ProductPeer::ID);
			$c->add(ProductPeer::OPT_NAME, $this->filters['by_product_name'] . '%', Criteria::LIKE);
		}

		if (isset($this->filters['by_filename_list']) && $this->filters['by_filename_list'] !== '')
		{
			$c->add(OnlineFilesPeer::FILENAME, $this->filters['by_filename_list'] . '%', Criteria::LIKE);
		}
	}

	/**
	 * Walidacja zapisy plików.
	 */
	public function validateOnlineFilesEdit() {
		$validate = true;
		$r = $this->getRequest();
		if ($r->getMethod() == sfRequest::POST) {

			$file = $r->getFile('online_files[filename]');

			if (!isset($file['name']) || empty($file['name'])) {
				$r->setError('online_files{filename}', 'Proszę wybrać plik.');
				$validate = false;
			}

			if (!$r->getParameter('online_files[product_code]')) {
				$r->setError('online_files{product_edit_code}', 'Proszę uzupełnić pole.');
				$validate = false;
			}

			if (!$r->getParameter('online_files[product_name]')) {
				$r->setError('online_files{product_edit_name}', 'Proszę uzupełnić pole.');
				$validate = false;
			}

			if ($validate == true && isset($file['name']) && !empty($file['name'])) {
				$c = new Criteria();
				$c->add(OnlineFilesPeer::FILENAME, $file['name']);
				$c->add(OnlineFilesPeer::PRODUCT_ID, $r->getParameter('online_files[product_id]'));
				if (OnlineFilesPeer::doCount($c)) {
					$r->setError('online_files{filename}', 'Podany plik jest już przypisany do produktu.');
					$validate = false;
				}
			}
		}

		return $validate;
	}

	/**
	 * Akcja do pobirania pliku w panelu.
	 */
	public function executeDownload() {
		if ($this->getRequest()->hasParameter('file_id')) {
			$c = new Criteria();
			$c->add(OnlineFilesPeer::ID, $this->getRequest()->getParameter('file_id'));
			$object = OnlineFilesPeer::doSelectOne($c);

			if (is_object($object)) {
				$file = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$object->getProductId().DIRECTORY_SEPARATOR.$object->getFilename();

				$this->setLayout(false);
				$response = $this->getContext()->getResponse();
				$response->setContentType("application/octet-stream");
				$response->setHttpHeader('Content-Disposition', 'attachment; filename="'.$object->getFilename().'"');

				$this->handle = fopen($file, 'r');
			} else {
				$this->redirect('@homepage');
			}
		} else {
			$this->redirect('@homepage');
		}
	}
}
