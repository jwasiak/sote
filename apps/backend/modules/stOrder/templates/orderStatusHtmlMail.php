<!-- http://templates.mailchimp.com/resources/inline-css/ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
<head style="margin: 0;padding: 0;font-family: Arial, sans-serif;">

<meta name="viewport" content="width=device-width" style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
<title style="margin: 0;padding: 0;font-family: Arial, sans-serif;">ZURBemails</title>

<style style="margin: 0;padding: 0;font-family: Arial, sans-serif;">

/* ------------------------------------- 
        GLOBAL 
------------------------------------- */
* { 
    margin:0;
    padding:0;
}
* { font-family: Arial, sans-serif; }

img { 
    max-width: 100%; 
}
.collapse {
    margin:0;
    padding:0;
}
body {
    -webkit-font-smoothing:antialiased; 
    -webkit-text-size-adjust:none; 
    width: 100%!important; 
    height: 100%;
}


/* ------------------------------------- 
        ELEMENTS 
------------------------------------- */
a { color: #<?php echo  $mail_config->get('link_color'); ?>;}

.btn {
    text-decoration:none;
    color: #FFF;
    background-color: #666;
    padding:10px 16px;
    font-weight:bold;
    margin-right:10px;
    text-align:center;
    cursor:pointer;
    display: inline-block;
}

p.callout {
    padding:15px;
    background-color:#ECF8FF;
    margin-bottom: 15px;
}
.callout a {
    font-weight:bold;
    color: #2BA6CB;
}

table.social {

    background-color: #ebebeb;
    
}
.social .soc-btn {
    padding: 3px 7px;
    font-size:12px;
    margin-bottom:10px;
    text-decoration:none;
    color: #FFF;font-weight:bold;
    display:block;
    text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
    display:block;
    width:100%;
}

/* ------------------------------------- 
        HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
        BODY 
------------------------------------- */
table.body-wrap { width: 100%;}


/* ------------------------------------- 
        FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;    clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
    font-size:10px;
    font-weight: bold;
    
}


/* ------------------------------------- 
        TYPOGRAPHY 
------------------------------------- */
h1,h2,h3,h4,h5,h6 {
font-family: Arial, sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

.collapse { margin:0!important;}

p, ul { 
    margin-bottom: 10px; 
    font-weight: normal; 
    font-size:12px; 
    line-height:1.6;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
    margin-left:5px;
    list-style-position: inside;
}

/* ------------------------------------- 
        SIDEBAR 
------------------------------------- */
ul.sidebar {
    background:#ebebeb;
    display:block;
    list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
    text-decoration:none;
    color: #666;
    padding:10px 16px;
/*  font-weight:bold; */
    margin-right:10px;
/*  text-align:center; */
    cursor:pointer;
    border-bottom: 1px solid #777777;
    border-top: 1px solid #FFFFFF;
    display:block;
    margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



/* --------------------------------------------------- 
        RESPONSIVENESS
        Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
    display:block!important;
    max-width:600px!important;
    margin:0 auto!important; /* makes it centered */
    clear:both!important;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
    padding:15px;
    max-width:600px;
    margin:0 auto;
    display:block; 
}

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
    width: 300px;
    float:left;
}
.social .column tr td { padding: 15px; }

.user_data .column tr td { padding-bottom: 15px; }

.column-wrap { 
    padding:0!important; 
    margin:0 auto; 
    max-width:600px!important;
}
.column table { width:100%;}

.social .column {
    width: 280px;
    min-width: 279px;
    float:left;
}

.user_data .column {
    width: 280px;
    min-width: 279px;
    float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
        PHONE
        For clients that support media queries.
        Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {
    
    a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

    div[class="column"] { width: auto!important; float:none!important;}
    
    table.social div[class="column"] {
        width:auto!important;
    }

}

</style>

</head>
 
<body bgcolor="#FFFFFF" style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;height: 100%;width: 100%!important;">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#<?php echo $mail_config->get('bg_header_color'); ?>" style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;width: 100%;">
    <tr style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;">
        <td style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;"></td>
        <td class="header container" style="margin: 0 auto!important;padding: 0;font-family: Arial, sans-serif;font-size: 12px;display: block!important;max-width: 600px!important;clear: both!important;">
                
                <div class="content" style="margin: 0 auto;padding: 15px;font-family: Arial, sans-serif;font-size: 12px;max-width: 600px;display: block;">
                <table bgcolor="#<?php echo $mail_config->get('bg_header_color'); ?>" style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;width: 100%;">
                    <tr style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;">
                        <td style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;"><?php if ($mail_config->get('logo')!=""): ?><img src="http://<?php echo $sf_request->getHost(); ?>/uploads<?php echo $mail_config->get('logo'); ?>?version=1" style="margin: 0;padding: 0;font-family: Arial, sans-serif;font-size: 12px;max-width: 100%; max-height: 50px;"><?php endif; ?></td>
                        <td align="right" style="margin: 0;padding: 0;font-family: Arial, sans-serif;"><h6 class="collapse" style="margin: 0!important;padding: 0;font-family: &quot;helveticaneue-light&quot: ;, &quot: ;helvetica neue light&quot: ;helvetica neue&quot: ;, helvetica, arial, &quot: ;lucida grande&quot: ;, sans-serif: ;line-height: 1.1;margin-bottom: 15px;color: #444;font-weight: 900;font-size: 14px;text-transform: uppercase;"><?php echo date('d-m-Y H:i'); ?></h6></td>
                    </tr>
                </table>
                </div>
                
        </td>
        <td style="margin: 0;padding: 0;font-family: Arial, sans-serif;"></td>
    </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap" cellpadding="0" cellspacing="0" style="margin: 0;padding: 0;font-family: Arial, sans-serif;width: 100%;">
    <tr style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
        <td style="margin: 0;padding: 0;font-family: Arial, sans-serif;"></td>
        <td class="container" bgcolor="#FFFFFF" style="margin: 0 auto!important;padding: 0;font-family: Arial, sans-serif;display: block!important;max-width: 600px!important;clear: both!important;">

            <div class="content" style="margin: 0 auto;padding: 15px;font-family: Arial, sans-serif;max-width: 600px;display: block;">
            <table cellpadding="0" cellspacing="0" style="margin: 0;padding: 0;font-family: Arial, sans-serif;width: 100%;">
                <tr style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
                    <td style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
                        <p style="font-size: 12px;margin: 0;padding: 0;font-family: Arial, sans-serif;margin-bottom: 10px;font-weight: normal;line-height: 1.6;"><?php echo $head; ?></p>
                        
                        <h4 style="margin: 0;padding: 0;font-family: &quot;helveticaneue-light&quot: ;, &quot: ;helvetica neue light&quot: ;helvetica neue&quot: ;, helvetica, arial, &quot: ;lucida grande&quot: ;, sans-serif: ;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 500;font-size: 23px;"><?php echo __('Zamówienie numer:') ?> <?php echo $order->getNumber(); ?></h4>
                        
                        <div style="font-size:12px; color:#576278;">
                            <?php echo __('Data złożenia zamówienia:') ?><span style="color:#404040; padding-left: 5px"><?php echo $order->getCreatedAt(); ?><span>
                        </div>
                        
                        <br />
                            
                        <p style="font-size: 12px;margin: 0;padding: 0;font-family: Arial, sans-serif;margin-bottom: 10px;font-weight: normal;line-height: 1.6;"><?php echo $head_content; ?></p>
                         
                        <div>                
                            
                        <?php if($order->getOrderDelivery()->getNumber()!=""): 
                            $paczka = PocztaPolskaPaczkaPeer::retrieveByOrder($order);
                            $pp = PaczkomatyPackPeer::retrieveByOrder($order);
                        ?>
                            <p style="margin-bottom: 15px;">                        
                                <span style="font-size:12px; color:#576278;">
                                    <?php  echo __('Numer przesyłki:'); ?> 
                                    <?php if ($pp): ?>
                                        <b><a href="<?php echo $pp->getTrackingUrl() ?>"><?php echo $order->getOrderDelivery()->getNumber(); ?></a></b>
                                    <?php elseif ($paczka && $paczka->isSent()): ?>
                                        <b><a href="<?php echo $paczka->getTrackingUrl() ?>"><?php echo $order->getOrderDelivery()->getNumber(); ?></a></b>
                                    <?php else: ?>
                                        <b><?php echo $order->getOrderDelivery()->getNumber(); ?></b>
                                    <?php endif ?>
                                </span>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($order->getOrderStatus()->getHasInvoiceProforma()==1): ?>
                            <p style="margin-bottom: 15px;">                        
                            <span style="font-size:12px; color:#576278;"><?php echo st_link_to(__('Pobierz fakturę proforma'), 'stOrder/downloadInvoice?id='.$order->getId().'&hash_code='.$order->getHashCode().'&proforma=1', array('absolute' => true, 'for_app' => 'frontend', 'for_lang' => $order->getClientCulture())) ?></span>
                            </p>
                        <?php endif; ?>
            
                        <?php if ($order->getOrderStatus()->getHasInvoice()==1 && $send_link == 1): ?>
                            <p style="margin-bottom: 15px;">                        
                            <span style="font-size:12px; color:#576278;"><?php echo st_link_to(__('Pobierz fakturę'), 'stOrder/downloadInvoice?id='.$order->getId().'&hash_code='.$order->getHashCode().'&proforma=0', array('absolute' => true, 'for_app' => 'frontend', 'for_lang' => $order->getClientCulture())) ?></span>
                            </p>
                        <?php endif; ?>
                                                                
                        <?php $color_link = "color:#".$mail_config->get('bg_action_link_color'); ?>
                        <p class="callout" style="text-align: center;margin: 0;padding: 15px;font-family: Arial, sans-serif;font-size: 12px;margin-bottom: 15px;font-weight: normal;line-height: 1.6;background-color: #<?php echo $mail_config->get('bg_action_color'); ?>;">                                                       
                            <span style="font-size:12px;"><?php echo st_link_to(__('Przejdź do zamówienia'), !$order->isAllegroOrder() ? 'stOrder/show?id='.$order->getId().'&hash_code='.$order->getHashCode() : stAllegroApi::getOrderUrl($order->getOptAllegroCheckoutFormId()), array('style' => $color_link, 'absolute' => true, 'for_app' => 'frontend', 'for_lang' => $order->getClientCulture())) ?></span>
                        </p><!-- /Callout Panel -->
                        
                            
                        </div>

       
                        <br />
                       
               
        <div style="margin:10px 0px 7px 0px">

            <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:10px;">
                <?php echo $order->getOrderStatus()->getDescription(); ?>
            </div>


            <?php if ($coupon_code): ?>
            <br/>
                
                <table cellpadding="0" cellspacing="0" width="300" style="margin:0px auto;">
                        <tr>
                            <td colspan="2" bgcolor="#576278" style="color:#fff;" align="center"><b><?php echo __('Kod rabatowy') ?></b></td>
                        </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#F0F4F7">
                            <span style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:12px;"><?php echo __('Kod') ?>:</span>
                        </td>
                        <td width="150" style="padding-left:5px;" bgcolor="#F0F4F7">
                            <b><?php echo $coupon_code->getCode() ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#F0F4F7" align="right" style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:12px;"><?php echo __('Rabat') ?>:</td>
                        <td bgcolor="#F0F4F7" style="padding-left:5px;"><b><?php echo $coupon_code->getDiscount(); ?>%</b></td>
                    </tr>
                    <?php if ($coupon_code->getValidTo()): ?>
                    <tr>
                        <td bgcolor="#F0F4F7" align="right" style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:12px;"><?php echo __('Ważny do') ?>:</td>
                        <td bgcolor="#F0F4F7" style="padding-left:5px; font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:12px;"><b><?php echo $coupon_code->getValidTo('d-m-Y H:i') ?></b></td>
                    </tr>
                    <?php endif; ?>

                    </table>
                
            <?php endif; ?>

            <div style="font-family:Verdana,Arial,Helvetica,sans-serif; line-height:18px; font-size:12px;">
                <?php echo $foot_content; ?>
            </div>

        </div>    
                                                 
                      
                                                
                        <!-- social & contact -->
                        <table class="social" width="100%" style="margin: 0;padding: 0;font-family: Arial, sans-serif;background-color: #<?php echo  $mail_config->get('bg_footer_color'); ?>;width: 100%;">
                            <tr style="margin: 0;padding: 0;font-family: Arial, sans-serif;">
                                <td style="font-size: 12px;margin: 0;padding: 0;font-family: Arial, sans-serif;">                                                                                                    
                                    <?php echo $foot; ?>                                                                                                                                                                                                                         
                                </td>
                            </tr>
                        </table><!-- /social & contact -->
                        
                    </td>
                </tr>
            </table>
            </div><!-- /content -->
                                    
        </td>
        <td style="margin: 0;padding: 0;font-family: Arial, sans-serif;"></td>
    </tr>
</table><!-- /BODY -->

</body>
</html>