<?php

class stCashBillSoapClient extends SoapClient {

    public function __doRequest($request, $location, $action, $version, $oneWay = 0) {

        $stCashBill = new stCashBill();

        $sec = <<<EOS
        <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
            <wsse:UsernameToken wsu:Id="UsernameToken-1">
                <wsse:Username>{$stCashBill->getShopId()}</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">{$stCashBill->getSecretKey()}</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
EOS;

        $xml = new DOMDocument();
        $xml->loadXML($request);
        $header = $xml->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'Header');
        $node = $xml->createDocumentFragment();
        $node->appendXML($sec);
        $header->appendChild($node);
        $xml->firstChild->insertBefore($header, $xml->firstChild->firstChild);
        $request = $xml->saveXML();
        return parent::__doRequest($request, $location, $action, $version, $oneWay);
    }
}