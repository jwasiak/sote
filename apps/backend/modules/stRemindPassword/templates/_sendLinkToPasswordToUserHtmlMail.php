<?php use_helper('Date','stApplication') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body style="background-color:#fff; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;"><div style="margin: 0px auto; background-color:#fff;"><br><div style="width:700px; margin:0px auto;"><div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_top.png?version=1); height:30px"></div>

                <div style="background-color:#fff; padding:0px 25px 0px 25px; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">
                    <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
                        <?php echo @$user_head; ?>
                    </div>
                </div>

    <div style="min-height:400px; padding:0px 25px 0px 25px; text-align:justify; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">

        <div style="float:left;font-size:18px;color:#576278;">
            <?php echo __('Link do zmiany hasła dla konta').': '; ?>
        </div>

        <div style="float:right; font-size:12px; color:#576278;">
           <?php echo __('Data wysłania linku').': '; ?> <span style="color:#404040;"><?php echo $date; ?><span>
        </div>

    <br style="clear:both;"/>

    <div style="margin:10px 0px 7px 0px">

    <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
        <?php echo __('Skorzystaj z linku poniżej aby dokonać zmiany hasła.'); ?>
    </div>

    <br style="clear:both">

    <div style="height:20px;font-size:12px;color:#576278;">
        <?php echo link_to(__('Zmień hasło'), '@stChangePassForAdmin?hash_code=' . $hashCode, 'absolute=true'); ?>
    </div>

    </div>

    </div>

    <div style="background-color:#fff; padding:0px 25px 0px 25px; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">
        <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
            <?php echo @$user_foot; ?>
        </div>
    </div>

<div style="background:url(http://<?php echo $sf_request->getHost(); ?>/images/frontend/theme/default/mail/frame_mail_bottom.png?version=1); height:30px"></div></div></div></body></html>