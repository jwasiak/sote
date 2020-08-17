<?php

class stTrustedShopsCertificateValidator extends sfValidator {

	public function execute(&$value, &$error) {

		$result = stTrustedShopsConnector::checkCertificate($value);

		switch ($result->stateEnum) {
			case 'PRODUCTION':
			case 'TEST':
			case 'INTEGRATION':
			case 'NO_AUDIT':
				return true;
			case 'CANCELLED':
				$error = $this->getParameterHolder()->get('cancelled_error');
				break;
			case 'DISABLED':
				$error = $this->getParameterHolder()->get('disabled_error');
				break;
			case 'INVALID_TS_ID':
				if (stTrustedShopsConnector::updateRating($value, 1) == 'OK')
					return true;
			default:
				$error = $this->getParameterHolder()->get('invalid_error');
				break;
		}

		return false;
	}

	public function initialize($context, $parameters = null) {
		parent::initialize($context);

		$this->getParameterHolder()->set('msg_error', 'Invalid certificate.');
		$this->getParameterHolder()->add($parameters);
		return true;
	}
}
