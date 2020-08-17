<?php $results = array(); ?>

<?php foreach ($points as $point):
?>

<?php
$created_at = explode(" ", $point -> getCreatedAt());
$date = explode("-", $created_at[0]);
?>

<?php $row['created_at']=$date[2]."-".$date[1]."-".$date[0]." ".$created_at[1]
?>

<?php
$change = $point -> getChangePointsVarchar();
if ($change{0} == "-") {
    $row['change_points'] = "<span style='color:red'>" . $point -> getChangePointsVarchar() . "</span>";
} else {
    $row['change_points'] = "<span style='color:green'>" . $point -> getChangePointsVarchar() . "</span>";
}
?>

<?php $row['points'] = $point -> getPoints(); ?>

<?php
if ($point -> getAdminId()) {
    $row['change'] = __('administrator');
}

if ($point -> getOrderId()) {
    $row['change'] = link_to(__("Zam") . ": " . $point -> getOrderNumber(), "@stOrderListShowForUser?id=" . $point -> getOrderId() . '&hash_code=' . $point -> getOrderHash());
}
?>

<?php $row['description'] = __($point -> getDescription()); ?>

<?php $results[] = $row; ?>

<?php endforeach; ?>

<?php
$config_points = stConfig::getInstance('stPointsBackend');
$config_points -> setCulture(sfContext::getInstance() -> getUser() -> getCulture());

?>

<?php $smarty -> assign('user_points', stPoints::getLoginStatusPoints()); ?>

<?php $smarty -> assign('release_points', stPoints::isReleasePointsSystemForUser()); ?>

<?php $smarty -> assign('points_shortcut', $config_points -> get('points_shortcut', null, true)); ?>

<?php $smarty -> assign('points_release_value', $config_points -> get('points_release_value')); ?>

<?php $smarty -> assign('results', $results); ?>

<?php $smarty->display('points_points_list.html')
?>