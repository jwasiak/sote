<?php
use_helper('Validation');
st_theme_use_stylesheet('stUser.css');
st_theme_use_stylesheet('stNewsletterPlugin.css');
use_javascript('jquery.infieldlabel.js', 'last');


$smarty->assign('my_account', link_to(__('Moje konto', array(), 'stUser'), 'stUserData/userPanel'));
$smarty->assign('user_panel_menu',  st_get_component('stUserData', 'userPanelMenu'));

$smarty->assign("form_start", form_tag('stNewsletterFrontend/addLoginUserToNewsletter', array('class' => 'st_form_ver6')));


$smarty->assign("error_email", form_error('newsletter[email', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign("label_email", label_for('email',__('E-mail')));
$smarty->assign("input_email", input_tag('newsletter[email]', $newsletterUserEmail, array('id'=>'email','class'=>form_has_error('newsletter{email}') ? 'st_form-error' : '')));

$smarty->assign('checkbox_privacy', checkbox_tag('newsletter[privacy]', 1, $sf_params->get('newsletter[privacy]'), array('id'=>'st_form-user-privacy','class'=>form_has_error('newsletter{privacy}') ? 'st_form-error checkobox' : 'checkobox')));

$smarty->assignPartial('link_to_privacy', 'stUser', 'privacy');

$smarty->assign('error_privacy', $sf_request->getError('error_privacy'));

$smarty->assign("newsletterGroup", $newsletterGroup);

if ($newsletterGroup)
{
    $results=array();
    foreach ($newsletterGroup as $group)
    {
        $checked = 0;
        if($group->getIsDefault()==1)
        {
            $checked = 1;
        }
        $row['input']=checkbox_tag('newsletter[group]['.$group->getId().']', 1, $checked);
        $row['name']=$group->getName();
        $row['description']=$group->getDescription();
        $row['input_name'] = 'newsletter[group]['.$group->getId().']';
        $row['input_checked'] = $checked;
        $results[]=$row;
    }
    $smarty->assign('results',$results);
}

$smarty->assign('new_user', $newUser);
$smarty->assign('update', $update);

$smarty->assign('hidden_new_user', input_hidden_tag('newsletter[new_user]', $newUser));

if($newUser==1)
{
    $smarty->assign("newsletter_user_accept", __('Zapisz mnie na newsletter'));
}
else
{
    $smarty->assign('newsletter_user', link_to(__('Usuń mnie z listy'), '@stNewsletterRemove?id=' . $newsletterUser->getId() . '&hash_code=' . $newsletterUser->getHash(), array('class'=>'regular roundies', 'absolute'=>'true')));
    if(stTheme::is_responsive()):
        $smarty->assign('newsletter_user', link_to(__('Usuń mnie z listy'), '@stNewsletterRemove?id=' . $newsletterUser->getId() . '&hash_code=' . $newsletterUser->getHash(), array('class'=>'btn btn-default pull-left', 'absolute'=>'true')));
    endif;    
    
    $smarty->assign("newsletter_user_accept", __('Aktualizuj'));
}

if(stTheme::is_responsive()):
    $smarty->assign('input_email', input_tag('newsletter[email]', $newsletterUserEmail, array('id'=>'email', 'placeholder'=>"* ".__('E-mail (login)'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('error_email', $sf_request->getError('newsletter{email}'));
endif;

$smarty->display('newsletter_list.html')
?>