<div>
<?php if ($paczka && $paczka->isSent()): ?>
    <a href="<?php echo $paczka->getTrackingUrl() ?>" target="_blank" style="display: inline-block; height: 30px; padding-right: 15px; background: #444; color: #fafafa; text-decoration: none"><img src="/plugins/stPocztaPolskaPlugin/images/poczta-polska.png" style="height: 30px; line-height: 0; vertical-align: middle; padding-right: 15px"; /><span style="vertical-align: middle;"><?php echo __('Śledź przesyłkę') ?></span></a>
<?php elseif ($paczka): ?>
     <a href="<?php echo url_for('@stPocztaPolskaBackend?action=packagesList&bufor_id='.$paczka->getBuforId()) ?>" style="display: inline-block; height: 30px; padding-right: 15px; background: #444; color: #fafafa; text-decoration: none"><img src="/plugins/stPocztaPolskaPlugin/images/poczta-polska.png" style="height: 30px; line-height: 0; vertical-align: middle; padding-right: 15px"; /><span style="vertical-align: middle;"><?php echo __('Wyślij przesyłkę') ?></span></a>   
<?php else: ?>
    <a href="<?php echo url_for('@stPocztaPolskaBackend?action=createPackage&id='.$order->getId()) ?>" style="display: inline-block; height: 30px; padding-right: 15px; background: #444; color: #fafafa; text-decoration: none"><img src="/plugins/stPocztaPolskaPlugin/images/poczta-polska.png" style="height: 30px; line-height: 0; vertical-align: middle; padding-right: 15px"; /><span style="vertical-align: middle;"><?php echo __('Spakuj') ?></span></a>
<?php endif ?>
</div>