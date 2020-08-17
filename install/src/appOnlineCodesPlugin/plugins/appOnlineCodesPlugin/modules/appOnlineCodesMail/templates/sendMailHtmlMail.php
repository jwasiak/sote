<?php use_helper('appOnlineCodes');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body style="background-color:#fff; font-family:Helvetica,Verdana,Arial,sans-serif; line-height:18px; font-size:1em;">
        <div style="margin: 0px auto; padding-top: 20px; background-color:#fff;">
            <div style="width:700px; margin:0px auto;">
                <div style="background:url(http://<?php echo $sf_request->getHost();?>/images/frontend/theme/default/mail/frame_mail_top.png?version=1); height:30px"></div>
                <div style="padding:0px 25px 0px 25px; text-align:justify; border-left:1px solid #d0d2d8; border-right:1px solid #d0d2d8;">
                    <div style="font-size:18px;color:#576278;">
                        <?php echo __('Dodatkowe dane do zamówienia numer', null, 'appOnlineCodesMail');?>: <?php echo $order->getNumber();?>
                    </div>
                    <?php if (!empty($codes)):?>
                        <div style="margin:20px 0px 0px 0px">
                            <table cellpadding="0" cellspacing="0" border="0" width="650">
                                <thead>
                                    <tr style="background:url(http://<?php echo $sf_request->getHost();?>/images/frontend/theme/default/mail/tabular-list-th.gif) top left repeat-x;">
                                        <td style="width: 50%;height:20px;font-size:12px;color:#576278;" align="left">
                                            <?php echo __('Nazwa produktu', null, 'appOnlineCodesMail');?>
                                        </td>
                                        <td style="height:20px;font-size:12px;color:#576278;" align="left">
                                            <?php echo __('Kod', null, 'appOnlineCodesMail');?>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($codes as $code):?>
                                        <tr>
                                            <td style="font-size:12px;color:#404040;padding:12px 0px;border-bottom:1px solid #efefef;" align="left">
                                                <?php echo $code['product']?>
                                            </td>
                                            <td style="font-size:12px;color:#404040;padding:12px 0px;border-bottom:1px solid #efefef;" align="left">
                                                <?php echo $code['code']?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif;?>
                    <?php if (!empty($files)):?>
                        <div style="margin:20px 0px 0px 0px">
                            <table cellpadding="0" cellspacing="0" border="0" width="650">
                                <thead>
                                    <tr style="background:url(http://<?php echo $sf_request->getHost();?>/images/frontend/theme/default/mail/tabular-list-th.gif) top left repeat-x;">
                                        <td style="width: 50%;height:20px;font-size:12px;color:#576278;" align="left">
                                            <?php echo __('Nazwa produktu', null, 'appOnlineCodesMail');?>
                                        </td>
                                        <td style="height:20px;font-size:12px;color:#576278;" align="left">
                                            <?php echo __('Link do pliku', null, 'appOnlineCodesMail');?>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($files as $file):?>
                                        <tr>
                                            <td style="font-size:12px;color:#404040;padding:12px 0px;border-bottom:1px solid #efefef;" align="left">
                                                <?php echo $file['product']?>
                                            </td>
                                            <td style="font-size:12px;color:#404040;padding:12px 0px;border-bottom:1px solid #efefef;" align="left">
                                                <?php foreach($file['files'] as $k => $f):?>
                                                    <?php if($k != 0):?><br /><?php endif;?>
                                                    <a href="<?php echo online_codes_generate_download_link($order, $f['id']);?>"><?php echo $f['name']?></a>
                                                <?php endforeach;?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif;?>
                </div>
                <div style="background:url(http://<?php echo $sf_request->getHost();?>/images/frontend/theme/default/mail/frame_mail_bottom.png?version=1); height:30px"></div>
            </div>
        </div>
    </body>
</html>