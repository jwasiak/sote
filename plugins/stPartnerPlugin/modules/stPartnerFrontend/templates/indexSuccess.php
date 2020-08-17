<?php use_helper('Validation'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<div id="st_application-user-user" class="st_application box roundies">
    
    <?php echo st_get_component('stUserData', 'userPanelMenu'); ?>

    <?php if(!$partnerData): ?>
           
        <div id="st_application-user-user_tab3">        
     
            <div class="st_content">           
                <h5 class="st_title"><?php echo __('Program partnerski') ?></h5>     
                <?php echo st_get_component('stPartnerFrontend', 'partnerTextInfo'); ?>
            </div>
        
        </div>
        
        <div id="st_application-user-user_tab3">        
     
            <div class="st_content">           
                <h5 class="st_title"><?php echo __('Dane partnera') ?></h5>     
                <?php echo __('Uzupełnij formularz poniżej podając dane, które posłużą administratorowi sklepu do rozliczeń programu partnerskiego.') ?>
                <br><br>
              <?php echo st_get_component('stPartnerFrontend', 'partnerDataForm'); ?>
            </div>
        
        </div>
                
    <?php endif; ?>   
    
    <?php if($partnerData): ?>
    
        <?php if(!$partnerData->getIsActive()): ?>
        
                <?php echo st_get_component('stPartnerFrontend', 'partnerNoActive'); ?>
        
        <?php else: ?>
        
            <?php if($partnerData->getIsConfirm()): ?>
                <?php echo st_get_component('stPartnerFrontend', 'partnerDataInfo'); ?>
            <?php else: ?>
                <?php echo st_get_component('stPartnerFrontend', 'partnerWaiting'); ?>
            <?php endif; ?>
            
        <?php endif; ?>
        
    <?php endif; ?>
        
    <br class="st_clear_all" />
    <br/>
</div>