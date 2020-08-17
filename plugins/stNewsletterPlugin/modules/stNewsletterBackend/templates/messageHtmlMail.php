<?php use_helper('stUrl') ?>
<html><body style="background-color:#fff; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;"><div style="margin: 0px auto; background-color:#fff;"><br><div style="width:700px; margin:0px auto;"><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_top.png?version=1); height:30px"></div><div style="min-height:400px;  padding:0px 25px 0px 25px; text-align:justify; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">
<br/>
<div style="width:500px; margin: 20px auto;">    
    <?php echo $newsletter->getContent(); ?>
</div>
<br/>
<div style="width:500px; margin: 0px auto;">
    <span style="font-size:10px; color:#404040;"><?php echo __('Jeżeli chcą Państwo zrezygnować z otrzymywania wiadomości proszę kliknąć w poniższy link.') ?></span><br/>
    <span style="font-size:10px; color:#fff;"><?php echo st_link_to(__('Wypisz mnie z listy'), '@stNewsletterUnsubscribe', 'absolute=true for_app=frontend'); ?></span>
</div>

</div><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_bottom.png?version=1); height:30px"></div></div></div></body></html>