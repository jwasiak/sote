<?php

/**
 * SOTESHOP/stPointsPlugin
 *
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPointsPlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPointsHelper.php 13690 2011-06-20 06:58:55Z marcin $
 */

function st_points_info_tooltip(Order $order) {
    $tooltip = '';

    $client_name = trim($order -> getOptClientName());

    if ($client_name) {
        $tooltip .= '<p>' . $client_name . '</p>';
    }

    if ($order -> getOptClientCompany()) {
        $tooltip .= '<p>' . $order -> getOptClientCompany() . '</p>';
    }

    return htmlspecialchars($tooltip . '<p>' . $order -> getOptClientEmail() . '</p>');
}

function st_points_client_name(UserPoints $userPoints, $target = '_self', $with_tooltip = true) {

    $c = new Criteria();
    $c -> add(sfGuardUserPeer::ID, $userPoints -> getSfGuardUserId());
    $user = sfGuardUserPeer::doSelectOne($c);
    
    if($user){
    $tooltip = '<p>' . $user -> getUsername() . '</p>';
    
    $name = '<a class="list_tooltip" target="'.$target.'" href="'.st_url_for('stUser/pointsInfoEdit?id='.$userPoints->getsfGuardUserId()).'" title="'.$tooltip.'"><img src="/images/backend/beta/icons/16x16/account.png" style="vertical-align: middle" /></a> '.$user -> getUsername();
    }else{
        $name = __("Usunięto");   
    }

    return $name;
}

function st_points_change(UserPoints $userPoints) {

    if($userPoints->getAdminId()){
        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $userPoints -> getAdminId());
        $user = sfGuardUserPeer::doSelectOne($c);
        
        $change = link_to($user->getUsername(),"sfGuardUser/edit?id=".$user -> getId());
    }
    
    if($userPoints->getOrderId()){
        
        $change =  link_to(__("Zam".": ".$userPoints ->getOrderNumber()),"/order/edit?id=".$userPoints ->getOrderId());
    }
  
    return $change;
}