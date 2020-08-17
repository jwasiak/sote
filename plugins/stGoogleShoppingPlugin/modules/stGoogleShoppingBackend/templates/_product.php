<?php
if ($google_shopping->getProductId())
    echo st_external_link_to($google_shopping->getProduct()->getName(), 'product/googleShoppingEdit?product_id='.$google_shopping->getProductId());
