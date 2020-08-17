<?php use_helper('Validation'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel')) ?>
<?php $smarty->assign('user_panel_menu', st_get_component('stUserData', 'userPanelMenu', array('action'=>'editAccount'))) ?>
<?php $smarty->assign('edit_profile_list', st_get_component('stUserData', 'editProfileList', array('userDataId'=>$userDataId, 'userDataType'=>$userDataType, 'showEditProfileForm' => $showEditProfileForm))) ?>
<?php $smarty->assign('add_new_address', link_to(__('Dodaj nowy adres'), 'stUserData/createProfile?userDataType='.$userDataType, array('class'=>'roundies'))) ?>

<?php if($showEditProfileForm == true): ?>
    <?php $smarty->assign('show_edit_profile_form', $showEditProfileForm == true) ?>
    <?php $smarty->assign('edit_profile_form', st_get_component('stUserData', 'editProfileForm', array('userDataId'=>$userDataId, 'userDataType'=>$userDataType, 'showEditProfileForm' => $showEditProfileForm , 'showMessage' => $showMessage))) ?>
<?php endif; ?>

<?php if($showMessage == true): ?>
    <?php $smarty->assign('show_message', $showMessage) ?>
<?php endif; ?>

<?php $smarty->assign('user_data_type', $userDataType) ?>

<?php $smarty->display('userdata_edit_profile.html') ?>