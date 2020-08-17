<?php
   use_helper('stBasket','stUrl');
   st_theme_use_stylesheet('stUser.css');
   $smarty->assign('username', $username);
   $smarty->assign('show_basket', $show_basket);
   $smarty->assign('go_to_basket_link', link_to(__('Przejdź do koszyka'), 'stBasket/indexReferer'));
   $go_to_basket_url = st_url_for('stBasket/indexReferer');
   $smarty->assign('go_to_basket_link', link_to(__('Przejdź do koszyka'), $go_to_basket_url));
   //default2
   $smarty->assign('go_to_basket_url', $go_to_basket_url);
   $smarty->assign("button_back",link_to(__('Wróć do zakupów'), '/'));
   $smarty->display('user_userWaitConfirmRemind.html');
?>