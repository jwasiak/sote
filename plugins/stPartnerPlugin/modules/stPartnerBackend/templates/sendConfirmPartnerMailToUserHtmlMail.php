<?php use_helper('Number', 'stCurrency', 'Date', 'stUrl') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body style="background-color:#fff; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;"><div style="margin: 0px auto; background-color:#fff;"><br><div style="width:700px; margin:0px auto;"><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_top.png?version=1); height:30px"></div>
    
                <div style="background-color:#fff; padding:0px 25px 0px 25px; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">
                    <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
                        <?php if (isset($head)): ?>
                        <?php echo $head; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
    <div style="min-height:400px;  padding:0px 25px 0px 25px; text-align:justify; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">

        <div style="float:left;font-size:18px;color:#576278;">
            <?php echo __('Potwierdzenie rejestracji w programie partnerskim.'); ?>
        </div>

        <div style="float:right; font-size:12px; color:#576278;">
           <?php echo __('Data założenia konta:') ?><span style="color:#404040;"><?php echo $partnerData->getCreatedAt(); ?><span>
        </div>
    
    <br style="clear:both;"/>

    <div style="margin:10px 0px 7px 0px">

        <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
            <?php if (isset($head_content)): ?>
                <?php echo $head_content; ?>
            <?php endif; ?>
        </div>
               
        <br style="clear:both">
        <div style="float:left; font-size:12px; color:#576278;">
            <span style="font-size:12px; color:#576278;"><?php echo __('Klient:') ?></span>
            <span style="font-size:12px;color:#404040;"><?php echo ' '.$partnerData->getSfGuardUser()->getUsername().' ' ?></span>
            <span style="font-size:12px; color:#576278;"><?php echo __('został poprawnie zweryfikowany.') ?></span>
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
            
            <br style="clear:both;"/>
    
        <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
            <?php if (isset($foot_content)): ?>
                <?php echo $foot_content ?>
            <?php endif; ?>
        </div>
    
    </div>
    </div>
    </div>
                

    <div style="background-color:#ECECEE; padding:0px 25px 0px 25px; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">
        <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
            <?php if (isset($foot)): ?>
                <?php echo $foot ?>
            <?php endif; ?>
        </div>
    </div>
    
<div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_bottom.png?version=1); height:30px"></div></div></div></body></html>