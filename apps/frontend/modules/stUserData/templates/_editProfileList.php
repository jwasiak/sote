<?php st_theme_use_stylesheet('stUser.css') ?>

<?php 
if($userDatas){
 $results=array();   
} 

?>
<?php foreach ($userDatas as $userData):?>
       
    <?php if($userData->getAddress()!=""): ?>

        
    <?php $row['style']=$style='' ?>
       
    <?php $row['default']=$userData->getIsDefault() ?>
    
    <?php if($userData->getIsDefault()==1): ?>
        <?php $row['is_default']="true"; ?>
    <?php else: ?>        
        <?php $row['is_default']="false"; ?>
    <?php endif; ?>

    <?php if($userDataId==$userData->getId()): ?>
        <?php $row['style']=$style='default' ?>
    <?php endif; ?>
    
    <?php if(!stTheme::is_responsive()): ?>
        <?php if($userData->getIsDefault()==1): ?>
            <?php $row['remove_tooltip']=__('Domyślne dane nie mogą być usunięte'); ?>
            <?php $row['remove_image']=""; ?>
        <?php else: ?>
            <?php $row['remove_tooltip']=__('Usuń dane') ?>
            <?php $row['remove_image']=link_to(image_tag('/images/frontend/theme/default2/delete_user.png', array('title' => __('Usuń dane'))), 'stUserData/deleteProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId()) ?>
        <?php endif; ?>
                    
        <?php $row['edit_tooltip']=__('Edytuj dane'); ?>
        <?php $row['edit_image']=link_to(image_tag('/images/frontend/theme/default/icon_edit.png'), 'stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId().'&showEditProfileForm=true') ?>
    <?php else: ?>    
        
        <?php if($userData->getIsDefault()==1): ?>
            <?php $row['remove_url']=""; ?>
        <?php else: ?>  
            <?php $row['remove_url']= '/stUserData/deleteProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId(); ?>
        <?php endif; ?>
                   
        <?php $row['edit_url']='/stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId().'&showEditProfileForm=true'; ?>
        
    <?php endif; ?>
    
    <?php $row['full_name']=$userData->getFullName() ?>
    <?php $row['address']=$userData->getAddress() ?>
    <?php $row['address_more']=$userData->getAddressMore() ?>
    <?php $row['region']=$userData->getRegion() ?>
    <?php $row['pesel']=$userData->getPesel() ?>
    <?php $row['code']=$userData->getCode() ?> 
    <?php $row['town']=$userData->getTown() ?>
    
    
        <?php if($userData->getStreet()!="" || $userData->getHouse()!=""  || $userData->getCode()!=""  || $userData->getTown()!=""): ?>
            <?php $row['make_it_deafult_data']='stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId(); ?>
        <?php endif; ?>
    
    
    <?php $row['has_vat']=$userData->getIsBilling() ?>
       
    <?php $row['company']=$userData->getCompany() ?>
        
    <?php $row['vat']=$userData->getVatNumber() ?>
    
    <?php $row['flat']=$userData->getFlat() ?>
    
    <?php $row['country']=$userData->getCountries() ?>

    <?php $row['phone_image']=image_tag('/images/frontend/theme/default/icon_phone.png') ?>
    
    <?php $row['phone']=$userData->getPhone() ?>
             
    <?php $results[]=$row;?>
    
    <?php endif; ?>
    
<?php endforeach; ?>
<?php $smarty->assign('results',$results); ?>
<?php $smarty->assign('user_data_type', $userDataType) ?>
<?php $smarty->display('userdata_edit_profile_list.html') ?>