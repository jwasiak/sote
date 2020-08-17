<?php
use_helper('stProduct', 'stUrl');

if ($attachments)
{
   $results = array();

   foreach ($attachments as $index => $attachment)
   {
      $url = $attachment->getPath();
      $results[$index]['instance'] = $attachment;
      $results[$index]['icon'] = st_product_get_attachment_icon($attachment);
      $results[$index]['name'] = $attachment->getFilename();
      $results[$index]['size'] = $attachment->getFilesize(true);
      $results[$index]['description'] = $attachment->getDescription();
      $results[$index]['only_link'] = $url;
      $results[$index]['url'] = $url;
      $results[$index]['link'] = '<a href="'.$url.'" download="' . $attachment->getFilename() . '">'.__('Pobierz').'</a>';

   }

   $smarty->assign('results', $results);

   $smarty->display('product_attachment_list.html');
}