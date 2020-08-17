<?php
st_theme_use_stylesheet('stPayment.css');
use_helper('stTooltip');

$smarty->assign("hasPaymentType",$hasPaymentType);
$results=array();

if ($hasPaymentType)
{
    foreach ($paymentTypes as $paymentType)
    {
        $row['radio'] = radiobutton_tag('payment_type', $paymentType->getId(), $paymentType->getId() == $checked, array("onclick" => remote_function(array('url' => 'stPayment/ajaxPaymentTypeUpdate', 'with' => "'id=' + this.value", 'script' => true))));
        $row['name'] = $paymentType->getName();
        $row['description'] = $paymentType->getDescription();
        $row['moduleName'] = $paymentType->getModuleName();
        $row['paymentTypeSocket'] = stSocketView::openComponents('stPayment_show_'.$paymentType->getModuleName().'_info');
        $results[]=$row;
    }
    $smarty->assign('results',$results);
}
$smarty->display("payment_select_type.html");
?>