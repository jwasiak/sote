<?php

if ($smarty->get_template_vars('show_ask_price') && $smarty->get_template_vars('ask_price_login'))
{
   $smarty->assign('price_question', link_to(__('Zapytaj o cenę'), 'question/ask?type=price&product_id=' . $product->getId()));
}

if ($smarty->get_template_vars('show_ask_depository') && $smarty->get_template_vars('ask_depository_login'))
{
      $smarty->assign('depository_question', link_to(__('Zapytaj o dostępność'), 'question/ask?type=depository&product_id=' . $product->getId()));
}

$smarty->display('question_ask_comp.html');
?>