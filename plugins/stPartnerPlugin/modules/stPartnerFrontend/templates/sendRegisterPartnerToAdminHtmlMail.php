<?php use_helper('Number', 'stCurrency', 'Date', 'stUrl') ?>
<html><body style="background-color:#fff; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;"><div style="margin: 0px auto; background-color:#fff;"><br><div style="width:700px; margin:0px auto;"><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_top.png?version=1); height:30px"></div>
                <div style="min-height:400px; padding:0px 25px 0px 25px; text-align:justify; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">

        <div style="float:left; font-size:18px;color:#576278;">
            <?php echo __('Prośba o weryfikacje konta partnerskiego.') ?>
        </div>
        <div style="float:right; font-size:12px; color:#576278;">
           <?php echo __('Data złożenia konta: ') ?><span style="color:#404040;"><?php echo $partnerData->getCreatedAt(); ?><span>
        </div>
        <br style="clear:both;"/></br>
        <div style="float:left; font-size:12px; color:#576278;">
            <span style="font-size:12px; color:#576278;"><?php echo __('Klient: ') ?></span>
            <span style="font-size:12px;color:#404040;"><?php echo $partnerData->getSfGuardUser()->getUsername() ?></span>
            <span style="font-size:12px; color:#576278;"><?php echo __(' prosi o udostępnienie konta partnerskiego w sklepie.') ?></span>
        </div>      
        
        <br style="clear:both;"/>
        
        <div style="margin:10px 0px 7px 0px">
                        
            <div style="float:left; width:300px;">
                <span style="font-size:12px; color:#576278;"><?php echo __('Dane partnera:') ?></span>
                <br>
                <?php if($partnerData->getCompany()!=""): ?>
                <span style="font-size:12px;color:#404040;"><?php echo $partnerData->getCompany() ?></span><br>
                <span style="font-size:12px;color:#404040;"><?php echo __('NIP:') ?><?php echo $partnerData->getVatNumber() ?></span><br>
                <?php endif; ?>
                <span style="font-size:14px;color:#404040; font-weight:bold"><?php echo $partnerData->getName().' '.$partnerData->getSurname()?></span><br>
                <span style="font-size:12px;color:#404040"><?php echo $partnerData->getStreet().'  '.$partnerData->getHouse().' '.$partnerData->getFlat().' , '.$partnerData->getCode().'  '.$partnerData->getTown()?></span><br>
                <?php if($partnerData->getBankNumber()!=""): ?>
                <span style="font-size:14px;color:#404040;"><?php echo __('Nr konta:') ?><?php echo $partnerData->getBankNumber() ?></span><br>
                <?php endif; ?>
            </div>
                
            <br style="clear:both">
                <div style="height:20px;font-size:12px;color:#576278;">
                <?php echo st_link_to(__('Przejdz do partnera'), 'stPartnerBackend/edit?id='.$partnerData->getId(), 'absolute=true for_app=backend'); ?>
            </div>    
        </div>     
  
        </br>
   
    
</div><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_bottom.png?version=1); height:30px"></div></div></div></body></html>