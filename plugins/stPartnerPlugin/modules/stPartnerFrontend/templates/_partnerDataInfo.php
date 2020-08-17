<?php use_helper('Validation','Form'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

           
    <div id="st_application-user-user_tab1">        
     
        <div class="st_content">           
            <h5 class="st_title"><?php echo __('Dane partnera') ?></h5>     
                  
                 <?php if($partner_data->getCompany()!=""): ?>
                     <br class="lowspace" />
                     <span class="lowspace"><?php echo $partner_data->getCompany(); ?><br /></span>
                 <?php else: ?>
                     <br class="lowspace" />
                     <br class="lowspace" />
                 <?php endif; ?>       
                 
                 <span class="lowspace"><?php echo $partner_data->getName(); ?> <?php echo $partner_data->getSurname(); ?><br /></span>
                 <span class="lowspace"><?php echo $partner_data->getStreet(); ?> <?php echo $partner_data->getHouse(); ?> 
                 <?php if($partner_data->getFlat()!=""){echo "/";}; ?>
                 <?php echo $partner_data->getFlat(); ?><br /></span>
                 <span class="lowspace"><?php echo $partner_data->getCode(); ?> <?php echo $partner_data->getTown(); ?><br /></span>
                 <span class="lowspace"><?php echo $partner_data->getCountries(); ?><br /></span>
         
                 <?php if($partner_data->getCompany()!=""): ?>
                     <span class="lowspace">NIP&nbsp;<?php echo $partner_data->getVatNumber(); ?><br /></span>
                     <br class="lowspace" />
                 <?php else: ?>
                     <br class="lowspace" />
                     <br class="lowspace" />
                 <?php endif; ?>       
                 
                 <?php if($partner_data->getBankNumber()!=""): ?>
                    <span class="lowspace"><?php echo __('Konto') ?>:&nbsp;<?php echo $partner_data->getBankNumber(); ?><br /></span>
                    <br class="lowspace" />
                 <?php endif; ?>   
                 
                 <?php if($partner_data->getPhone()!=""): ?>
                    <span><?php echo image_tag('/images/frontend/theme/default/icon_phone.png') ?>&nbsp;&nbsp;<?php echo $partner_data->getPhone(); ?><br /></span>
                 <?php else: ?>
                    <br />
                 <?php endif; ?>
                 
                 <br class="lowspace" />
                                  
                 <!--<div class="st_button st_align-right" id="st_button_edit_billing" style="margin-left:2px;">
                    <div class="st_button-left">
                        <?php echo link_to(__('Edytuj'), 'stUserData/editProfile?userDataType=billing&userDataId='.$partner_data->getId().'&showEditProfileForm=true'); ?>
                    </div>
                </div>-->
                                    
                   
            
        </div>
        
    </div>

    <div id="st_application-user-user_tab2">        
     
        <div class="st_content">           
        
             <h5 class="st_title"><?php echo __('Prowizje partnera') ?></h5>     
             <br class="lowspace" />
             <?php if($partner_data->getProvision()!=""): ?>
                <span ><?php echo __('Stawka prowizji procentowej') ?>:&nbsp;<b><?php echo $partner_data->getProvision(); ?>%</b><br /></span>
             <?php endif; ?>
             
             <?php if($partner_data->getAmount()!=""): ?>
                <span ><?php echo __('Stawka prowizji kwotowej') ?>:&nbsp;<b><?php echo $partner_data->getAmount(); ?></b> PLN<br /></span>
             <?php endif; ?>
                       
             <?php if($partner_data->getAmount()=="" && $partner_data->getProvision()==""): ?>
                <span ><?php echo __('Nie przyznano prowizji od transakcji.') ?></span>
             <?php endif; ?>
              <br>      
             <?php if($provisionAll!=""): ?>
                <span ><?php echo __('Całkowita prowizja') ?>:&nbsp;<b><?php echo $provisionAll; ?></b> PLN<br /></span>
             <?php endif; ?>
                         
             <?php if($provisionPayed!=""): ?>
                <span ><?php echo link_to(__('Rozliczona prowizja'),'partner?status=1&data1&data2') ?>:&nbsp;<b><?php echo $provisionPayed; ?></b> PLN<br /></span>
             <?php endif; ?>
             
             <?php if($provisionNotPayed!=""): ?>
                <span ><?php echo link_to( __('Nierozliczona prowizja'),'partner?status=0&data1&data2') ?>:&nbsp;<b><?php echo $provisionNotPayed; ?></b> PLN<br /></span>
             <?php endif; ?>
        </div>
        
    </div>
    
    <div id="st_application-user-user_tab3">        
     
        <div class="st_content">           
            <h5 class="st_title"><?php echo __('Zamówienia z polecenia') ?></h5>     
            <?php echo st_get_component('stPartnerFrontend', 'partnerOrder'); ?>           
        </div>
        
    </div>

    
    
<br class="st_clear_all" />

<div id="st_application-user-user_tab4">        
 
    <div class="st_content">           
        <h5 class="st_title"><?php echo __('Link partnerski') ?></h5>     
        <?php echo st_get_component('stPartnerFrontend', 'partnerHash'); ?>           
        
    </div>
    
</div>