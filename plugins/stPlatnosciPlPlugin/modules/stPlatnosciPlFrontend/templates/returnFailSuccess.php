<?php
st_theme_use_stylesheet('stPayment.css');

if ($sf_request->getParameter('type') == 'process')
{
	$smarty->display('platnoscipl_show_payment.html');	
}
else
{
	$smarty->display('platnoscipl_return_fail.html');
}