<?php use_helper('Date','stApplication') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body style="background-color:#f7f7f7; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;">
        <div style="background-color:#f7f7f7; padding: 20px 0px;">
            <div style="width:700px; margin: 0px auto; text-align: right; color: #AAAAAA; font-size: 12px;">
                <?php echo $sf_request->getHost() ?>  <?php echo $user; ?> <?php echo $date; ?>
            </div>
            <div style="width:700px; margin:10px auto; background-color:#fff; border: 1px solid #DDDDDD;">
                <div style="background-color:#fff;">
                    <div style="line-height:18px; font-size:10px; color:#576278;">
                        <?php echo @$user_head; ?>
                    </div>
                </div>

                <div style="min-height:300px;padding:25px;">

                    <div style="float:left;font-size:18px;color:#576278;">
                        <?php echo __('Zmiana hasła'); ?>
                    </div>

                    <br style="clear:both;"/>

                    <div style="margin:10px 0px 7px 0px">

                        <div style="font-size:13px; color:#576278; padding-top: 10px;">
                            <?php echo __('Kliknij w poniższy link, żeby zmienić hasło. Zostaniesz przeniesiony na stronę z formularzem do zmiany hasła.'); ?>
                        </div>

                        <br style="clear:both">

                        <div style="height:20px;font-size:12px;color:#576278;">
                            <?php echo link_to(__('Zmień hasło').' > ', '@stChangePassForAdmin?hash_code=' . $hashCode, 'absolute=true'); ?>
                        </div>

                    </div>

                </div>

                <div style="background-color:#fff;">
                    <div style="line-height:18px; font-size:10px; color:#576278;">
                        <?php echo @$user_foot; ?>
                    </div>
                </div>

                <div style="border-bottom: 1px solid #DDDDDD;"></div>
            </div>
        </div>
    </body>
</html>