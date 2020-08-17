<?php 
use_helper('stTrustedShops');
echo '<img src="'.rating_widget_url($trusted_shops->getCertificate()).'" />';