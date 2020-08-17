<?php if(stPoints::isReleasePointsSystemForUser($user->getId())=="release_on"){     
    echo "<b style='color:green;'>".__('osiągnięty')."</b>";
    echo " (".link_to(__('dezaktywuj'), 'stUser/pointsRelease?on=0&user_id='.$user->getId()).")";
}elseif(stPoints::isReleasePointsSystemForUser($user->getId())=="release_off"){
    echo __('nieokreślony');
}else{
    echo __('do aktywacji brak').": <b style='color:red;'>".stPoints::isReleasePointsSystemForUser($user->getId())." ".$points_shortcut."</b>";
    echo " (".link_to(__('aktywuj'), 'stUser/pointsRelease?on=1&user_id='.$user->getId()).")";
}
?>