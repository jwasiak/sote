<?php 

if ($delivery->getCountriesArea() && $delivery->getCountriesArea()->getIsActive())
{
  
    if (strlen($delivery->getCountriesArea()->getName()) > 20) {

        echo st_truncate_text($delivery->getCountriesArea()->getName(), '20', '...');

    } else {

        echo $delivery->getCountriesArea()->getName();

    }

}

?>