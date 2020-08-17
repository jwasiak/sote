<?php
class stFixCode {

	public $msg = '';

	public $title = "Aktualizacja kodów";

	public function fixCode($step) {
		$c = new Criteria();
		$c->setOffset($step);
		$product = ProductPeer::doSelectOne($c);
		if ($product) {
			$this->msg = sprintf("Zmieniamy kod produktu z %s na %s", $product->getCode(),$this->updateCode($product->getCode()) );

			$product->setCode($this->updateCode($product->getCode()));
			$product->save();
		}

		return ($step+1);
	}

	private function updateCode($code) {
		$code = str_replace(" ","-",$code);
		return preg_replace("/[^a-zA-Z0-9_-]/","_",$code);
	}

	public function getMessage() {

		return $this->msg;
	}

	public function getTitle(){
		return $this->title;
	}

	public static function countProducts() {

		return ProductPeer::doCount(new Criteria());

	}
}
?>