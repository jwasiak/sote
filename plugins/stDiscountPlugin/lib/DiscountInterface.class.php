<?php

interface DiscountInterface
{
    public function getDiscount();
    public function setDiscount($value);
    public function hasDiscount();
    public function getDiscountNetto($with_currency = false);
    public function getDiscountBrutto($with_currency = false);
    public function getDiscountInPercent();
}