<?php
if ($payment->getPaymentTypeId() !== null) { 
    echo $payment->getPaymentType();
} else {
    echo '-';
}