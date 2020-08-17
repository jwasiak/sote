<?php 
    if ($discount_coupon_code->getUsed() > 0)
    {
        echo st_link_to($discount_coupon_code->getUsed(), '@stOrder?action=list&filters[discount_coupon_code]='.$discount_coupon_code->getCode());
    }
    else 
    {
        echo $discount_coupon_code->getUsed();   
    }
?>