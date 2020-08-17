<?php use_helper('stUrl') ?>
<html><body style="background-color:#fff; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;"><div style="margin: 0px auto; background-color:#fff;"><br><div style="width:700px; margin:0px auto;"><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_top.png?version=1); height:30px"></div><div style="min-height:400px;  padding:0px 25px 0px 25px; text-align:justify; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">

<?php echo $head; ?>
<?php echo $content; ?>
<?php echo $foot; ?>


</div><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_bottom.png?version=1); height:30px"></div></div></div></body></html>