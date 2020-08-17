<?php

namespace Eservice;

class RequestActionAuth extends RequestAction
{

    protected $_params = [
        "merchantId"          => ["type" => "mandatory"],
        "token"               => ["type" => "mandatory"],
        "specinCreditCardCVV" => [
            "type"      => "conditional",
            "mandatory" => [
                "paymentMethod" => "CreditCard",
                "channel"       => "ECOM"
            ],
        ],
        "freeText"            => ["type" => "optional"],
    ];

}
