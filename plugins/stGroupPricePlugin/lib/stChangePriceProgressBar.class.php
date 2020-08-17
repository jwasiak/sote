<?php

class stChangePriceProgressBar {
    public function init() {
    }

    public function close() {
        $i18n = sfContext::getInstance() -> getI18N();
        $group_price = self::getParam('group_price');

        $this -> setMessage($i18n -> __('Operacja zmiany cen zakończona pomyślnie.', '', 'stGroupPriceBackend') . '<br/><a href="/backend.php/groupPrice/showProducts/id/' . $group_price['id'] . '">' . $i18n -> __('Pokaż produkty', '', 'stGroupPriceBackend') . '</a>');
    }

    public function send($offset) {

        $group_price = self::getParam('group_price');

        $i18n = sfContext::getInstance() -> getI18N();

        $c = new Criteria();
        $c -> setOffset($offset);
        $c -> setLimit(100);
        $c -> add(ProductPeer::GROUP_PRICE_ID, $group_price['id']);
        $products = ProductPeer::doSelect($c);

        $counter = 0;

        foreach ($products as $product) {
            $counter++;

            if ($group_price['set_one_price'] == "false") {

                if ($group_price['currency_id'] == $product -> getCurrencyId() || $product -> getCurrencyId() == "") {
                    $product -> setTaxId($group_price['tax_id']);
                    $product -> setOptVat($group_price['opt_vat']);
                    $product -> setPrice($group_price['price_netto']);
                    $product -> setOptPriceBrutto($group_price['price_brutto']);
                    $product -> setOldPrice($group_price['old_price_netto']);
                    $product -> setOptOldPriceBrutto($group_price['old_price_brutto']);
                    $product -> setWholesaleANetto($group_price['wholesale_a_price_netto']);
                    $product -> setWholesaleABrutto($group_price['wholesale_a_price_brutto']);
                    $product -> setWholesaleBNetto($group_price['wholesale_b_price_netto']);
                    $product -> setWholesaleBBrutto($group_price['wholesale_b_price_brutto']);
                    $product -> setWholesaleCNetto($group_price['wholesale_c_price_netto']);
                    $product -> setWholesaleCBrutto($group_price['wholesale_c_price_brutto']);
                    $product -> save();
                } else {

                    $c = new Criteria();
                    $c -> add(AddPricePeer::ID, $product -> getId());
                    $c -> add(AddPricePeer::CURRENCY_ID, $group_price['currency_id']);
                    $addPrice = AddPricePeer::doSelectOne($c);
                    if (!$addPrice) {
                        $addPrice = new AddPrice();
                        $addPrice -> setId($product -> getId());
                        $addPrice -> setCurrencyId($group_price['currency_id']);
                    }
                    $addPrice -> setTaxId($group_price['tax_id']);
                    $addPrice -> setOptVat($group_price['opt_vat']);
                    $addPrice -> setPriceNetto($group_price['price_netto']);
                    $addPrice -> setPriceBrutto($group_price['price_brutto']);
                    $addPrice -> setOldPriceNetto($group_price['old_price_netto']);
                    $addPrice -> setOldPriceBrutto($group_price['old_price_brutto']);
                    $addPrice -> setWholesaleANetto($group_price['wholesale_a_price_netto']);
                    $addPrice -> setWholesaleABrutto($group_price['wholesale_a_price_brutto']);
                    $addPrice -> setWholesaleBNetto($group_price['wholesale_b_price_netto']);
                    $addPrice -> setWholesaleBBrutto($group_price['wholesale_b_price_brutto']);
                    $addPrice -> setWholesaleCNetto($group_price['wholesale_c_price_netto']);
                    $addPrice -> setWholesaleCBrutto($group_price['wholesale_c_price_brutto']);
                    $addPrice -> save();
                }
            }

            if ($group_price['set_one_price'] == "true") {

                if ($group_price['currency_id'] == $product -> getCurrencyId() || $product -> getCurrencyId() == "") {

                    // zmiana ceny netto
                    if ($group_price['type'] == "netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $product -> getPrice() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $product -> getPrice() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $product -> getPrice() + ($product -> getPrice() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $product -> getPrice() - ($product -> getPrice() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $product -> setPrice($netto);
                        $product -> setOptPriceBrutto($brutto);

                    }

                    // zmiana ceny brutto
                    if ($group_price['type'] == "brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getOptPriceBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getOptPriceBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getOptPriceBrutto() + ($product -> getOptPriceBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getOptPriceBrutto() - ($product -> getOptPriceBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }
                        $product -> setPrice($netto);
                        $product -> setOptPriceBrutto($brutto);

                    }

                    // zmiana ceny old netto
                    if ($group_price['type'] == "old_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $product -> getOldPrice() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $product -> getOldPrice() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $product -> getOldPrice() + ($product -> getOldPrice() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $product -> getOldPrice() - ($product -> getOldPrice() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $product -> setOldPrice($netto);
                        $product -> setOptOldPriceBrutto($brutto);

                    }

                    // zmiana ceny old brutto
                    if ($group_price['type'] == "old_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getOptOldPriceBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getOptOldPriceBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getOptOldPriceBrutto() + ($product -> getOptOldPriceBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getOptOldPriceBrutto() - ($product -> getOptOldPriceBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }
                        $product -> setOldPrice($netto);
                        $product -> setOptOldPriceBrutto($brutto);

                    }

                    // zmiana ceny wholesale_a_netto
                    if ($group_price['type'] == "wholesale_a_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $product -> getWholesaleANetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $product -> getWholesaleANetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $product -> getWholesaleANetto() + ($product -> getWholesaleANetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $product -> getWholesaleANetto() - ($product -> getWholesaleANetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $product -> setWholesaleANetto($netto);
                        $product -> setWholesaleABrutto($brutto);

                    }

                    // zmiana ceny wholesale_a_brutto
                    if ($group_price['type'] == "wholesale_a_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getWholesaleABrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getWholesaleABrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getWholesaleABrutto() + ($product -> getWholesaleABrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getWholesaleABrutto() - ($product -> getWholesaleABrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }

                        $product -> setWholesaleANetto($netto);
                        $product -> setWholesaleABrutto($brutto);

                    }

                    // zmiana ceny wholesale_b_netto
                    if ($group_price['type'] == "wholesale_b_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $product -> getWholesaleBNetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $product -> getWholesaleBNetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $product -> getWholesaleBNetto() + ($product -> getWholesaleBNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $product -> getWholesaleBNetto() - ($product -> getWholesaleBNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $product -> setWholesaleBNetto($netto);
                        $product -> setWholesaleBBrutto($brutto);

                    }

                    // zmiana ceny wholesale_a_brutto
                    if ($group_price['type'] == "wholesale_b_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getWholesaleBBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getWholesaleBBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getWholesaleBBrutto() + ($product -> getWholesaleBBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getWholesaleBBrutto() - ($product -> getWholesaleBBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }

                        $product -> setWholesaleBNetto($netto);
                        $product -> setWholesaleBBrutto($brutto);

                    }

                    // zmiana ceny wholesale_c_netto
                    if ($group_price['type'] == "wholesale_c_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $product -> getWholesaleCNetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $product -> getWholesaleCNetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $product -> getWholesaleCNetto() + ($product -> getWholesaleCNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $product -> getWholesaleCNetto() - ($product -> getWholesaleCNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $product -> setWholesaleCNetto($netto);
                        $product -> setWholesaleCBrutto($brutto);

                    }

                    // zmiana ceny wholesale_c_brutto
                    if ($group_price['type'] == "wholesale_c_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getWholesaleCBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $product -> getWholesaleCBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getWholesaleCBrutto() + ($product -> getWholesaleCBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $product -> getWholesaleCBrutto() - ($product -> getWholesaleCBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }

                        $product -> setWholesaleCNetto($netto);
                        $product -> setWholesaleCBrutto($brutto);

                    }

                    $product -> save();

                } else {

                    $c = new Criteria();
                    $c -> add(AddPricePeer::ID, $product -> getId());
                    $c -> add(AddPricePeer::CURRENCY_ID, $group_price['currency_id']);
                    $addPrice = AddPricePeer::doSelectOne($c);

                    if (!$addPrice && $group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                        $addPrice = new AddPrice();
                        $addPrice -> setId($product -> getId());
                        $addPrice -> setCurrencyId($group_price['currency_id']);
                        $addPrice -> setTaxId($group_price['tax_id']);
                        $addPrice -> setOptVat($group_price['opt_vat']);
                    }

                    if($addPrice){

                    // zmiana ceny netto
                    if ($group_price['type'] == "netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getPriceNetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getPriceNetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getPriceNetto() + ($addPrice -> getPriceNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getPriceNetto() - ($addPrice -> getPriceNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $addPrice -> setPriceNetto($netto);
                        $addPrice -> setPriceBrutto(stPrice::calculate($netto, $group_price['opt_vat']));

                    }

                    // zmiana ceny brutto
                    if ($group_price['type'] == "brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getPriceBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getPriceBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getPriceBrutto() + ($addPrice -> getPriceBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getPriceBrutto() - ($addPrice -> getPriceBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }
                        $addPrice -> setPriceNetto(stPrice::extract($brutto, $group_price['opt_vat']));
                        $addPrice -> setPriceBrutto($brutto);

                    }

                    // zmiana ceny old netto
                    if ($group_price['type'] == "old_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getOldPriceNetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getOldPriceNetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getOldPriceNetto() + ($addPrice -> getOldPriceNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getOldPriceNetto() - ($addPrice -> getOldPriceNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $addPrice -> setOldPriceNetto($netto);
                        $addPrice -> setOldPriceBrutto(stPrice::calculate($netto, $group_price['opt_vat']));

                    }

                    // zmiana ceny old brutto
                    if ($group_price['type'] == "old_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getOldPriceBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getOldPriceBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getOldPriceBrutto() + ($addPrice -> getOldPriceBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getOldPriceBrutto() - ($addPrice -> getOldPriceBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }
                        $addPrice -> setOldPriceNetto(stPrice::extract($brutto, $group_price['opt_vat']));
                        $addPrice -> setOldPriceBrutto($brutto);

                    }

                    // zmiana ceny wholesale_a_netto
                    if ($group_price['type'] == "wholesale_a_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getWholesaleANetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getWholesaleANetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getWholesaleANetto() + ($addPrice -> getWholesaleANetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getWholesaleANetto() - ($addPrice -> getWholesaleANetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $addPrice -> setWholesaleANetto($netto);
                        $addPrice -> setWholesaleABrutto(stPrice::calculate($netto, $group_price['opt_vat']));

                    }

                    // zmiana ceny wholesale_a_brutto
                    if ($group_price['type'] == "wholesale_a_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleABrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleABrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleABrutto() + ($addPrice -> getWholesaleABrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleABrutto() - ($addPrice -> getWholesaleABrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }

                        $addPrice -> setWholesaleANetto(stPrice::extract($brutto, $group_price['opt_vat']));
                        $addPrice -> setWholesaleABrutto($brutto);

                    }

                    // zmiana ceny wholesale_b_netto
                    if ($group_price['type'] == "wholesale_b_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getWholesaleBNetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getWholesaleBNetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getWholesaleBNetto() + ($addPrice -> getWholesaleBNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getWholesaleBNetto() - ($addPrice -> getWholesaleBNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $addPrice -> setWholesaleBNetto(stPrice::calculate($netto, $group_price['opt_vat']));
                        $addPrice -> setWholesaleBBrutto($brutto);

                    }

                    // zmiana ceny wholesale_a_brutto
                    if ($group_price['type'] == "wholesale_b_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleBBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleBBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleBBrutto() + ($addPrice -> getWholesaleBBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleBBrutto() - ($addPrice -> getWholesaleBBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }

                        $addPrice -> setWholesaleBNetto(stPrice::extract($brutto, $group_price['opt_vat']));
                        $addPrice -> setWholesaleBBrutto($brutto);

                    }

                    // zmiana ceny wholesale_c_netto
                    if ($group_price['type'] == "wholesale_c_netto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getWholesaleCNetto() + $group_price['value'];
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = $addPrice -> getWholesaleCNetto() - $group_price['value'];
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getWholesaleCNetto() + ($addPrice -> getWholesaleCNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = $addPrice -> getWholesaleCNetto() - ($addPrice -> getWholesaleCNetto() * ($group_price['value'] / 100));
                            $brutto = null;

                            if ($netto < 0) {
                                $netto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {

                            $netto = $group_price['value'];
                            $brutto = null;

                        }

                        $addPrice -> setWholesaleCNetto($netto);
                        $addPrice -> setWholesaleCBrutto(stPrice::calculate($netto, $group_price['opt_vat']));

                    }

                    // zmiana ceny wholesale_c_brutto
                    if ($group_price['type'] == "wholesale_c_brutto") {

                        if ($group_price['prefix'] == "+" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleCBrutto() + $group_price['value'];

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "false") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleCBrutto() - $group_price['value'];

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "+" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleCBrutto() + ($addPrice -> getWholesaleCBrutto() * ($group_price['value'] / 100));

                        } elseif ($group_price['prefix'] == "-" && $group_price['sufix'] == "true") {

                            $netto = null;
                            $brutto = $addPrice -> getWholesaleCBrutto() - ($addPrice -> getWholesaleCBrutto() * ($group_price['value'] / 100));

                            if ($brutto < 0) {
                                $brutto = 0;
                            }

                        } elseif ($group_price['prefix'] == "false" && $group_price['sufix'] == "false") {
                            $netto = null;
                            $brutto = $group_price['value'];
                        }

                        $addPrice -> setWholesaleCNetto(stPrice::extract($brutto, $group_price['opt_vat']));
                        $addPrice -> setWholesaleCBrutto($brutto);

                    }

                    $addPrice -> save();
                    }
                }

            }

        }

        self::setMessage($i18n -> __('Zmiana cen w toku %current%/%from%', array('%current%' => $offset, '%from%' => self::getAttribute('steps')), 'stNewsletterBackend'));

        sleep(1);

        return $offset + count($products);
    }

    public static function setParam($name, $value) {
        sfContext::getInstance() -> getUser() -> setAttribute($name, $value, 'soteshop/stChangePriceProgressBar');
    }

    public static function getParam($name, $default = null) {
        return sfContext::getInstance() -> getUser() -> getAttribute($name, $default, 'soteshop/stChangePriceProgressBar');
    }

    public static function getAttribute($name) {
        $attributes = sfContext::getInstance() -> getUser() -> getAttribute('smChangePrice', array(), 'soteshop/stProgressBarPlugin');

        return isset($attributes[$name]) ? $attributes[$name] : null;
    }

    public static function setMessage($message) {
        sfContext::getInstance() -> getUser() -> setAttribute('stProgressBar-stChangePrice', $message, 'symfony/flash');
    }

}
