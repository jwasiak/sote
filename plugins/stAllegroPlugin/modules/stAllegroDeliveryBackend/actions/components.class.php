<?php

class stAllegroDeliveryBackendComponents extends autoStAllegroDeliveryBackendComponents {

    public function executeDeliveries() {
        $api = stAllegroApi::getInstance();

        $deliveryGroups = array(
            "Allegro InPost" => array(),
            "Kurier" => array(),
            "Paczka" => array(),
            "List" => array(),
            "Odbiór w punkcie" => array(),
            "Inny sposób dostawy" => array(),
            "Wysyłka za granicę" => array(),
        );

        $methods = $api->getDeliveryMethods();

        usort($methods, function($m1, $m2) {
            $search = array('Ę','Ó', 'Ą', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń', 'ę', 'ó', 'ą', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń');
            $replace = array('E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N', 'e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n');
            return strnatcmp(str_replace($search, $replace, $m1->name), str_replace($search, $replace, $m2->name));
        });

        foreach ($methods as $method)
        {
            if (!$method->shippingRatesConstraints->allowed)
            {
                continue;
            }
            
            if (in_array($method->name, array("Austria","Belgia","Białoruś","Bułgaria","Chorwacja","Cypr","Czechy","Dania","Estonia","Finlandia","Francja","Grecja","Hiszpania","Holandia","Irlandia","Litwa","Luksemburg","Łotwa","Malta","Niemcy","Norwegia","Portugalia","Rosja","Rumunia","Słowacja","Słowenia","Szwecja","Ukraina","Węgry","Wielka Brytania","Włochy")))
            {   
                $deliveryGroups["Wysyłka za granicę"][$method->paymentPolicy][$method->id] = $method; 
            }
            elseif (preg_match('/Allegro miniKurier24|Allegro Kurier24|Allegro Paczkomaty/i', $method->name))
            {
                $deliveryGroups["Allegro InPost"][$method->paymentPolicy][$method->id] = $method;   
            }
            elseif (false !== strpos($method->name, 'Kurier') || preg_match('/Dostawa przez sprzedającego|Przesyłka kurierska/i', $method->name))
            {
                $deliveryGroups["Kurier"][$method->paymentPolicy][$method->id] = $method;   
            }
            elseif (preg_match('/Paczka pocztowa ekonomiczna|Paczka pocztowa priorytetowa|Paczka24|Paczka48/i', $method->name) && false === strpos($method->name, 'Odbiór w Punkcie'))
            {
                $deliveryGroups["Paczka"][$method->paymentPolicy][$method->id] = $method;  
            }
            elseif (false !== strpos($method->name, 'List'))
            {
                $deliveryGroups["List"][$method->paymentPolicy][$method->id] = $method;  
            }
            elseif (preg_match('/Paczka w RUCHU|Paczka 24 odbiór w punkcie|Punkty Poczta, Żabka, Orlen, Ruch|Paczkomaty 24\/7|Odbiór osobisty w punkcie sprzedawcy|Odbiór w punkcie|Punkty Poczta/i', $method->name))
            {
                $deliveryGroups["Odbiór w punkcie"][$method->paymentPolicy][$method->id] = $method;  
            }
            else
            {
                $deliveryGroups["Inny sposób dostawy"][$method->paymentPolicy][$method->id] = $method;  
            }
        }

        $this->deliveryGroups = $deliveryGroups;
    }
}
