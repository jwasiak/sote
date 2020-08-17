<div>
<?php if ($pp): ?>
    <a href="<?php echo $pp->getTrackingUrl() ?>" target="_blank" style="display: inline-block; padding-right: 15px; background: #444; color: #fafafa; text-decoration: none"><img src="/images/backend/icons/inpost-zolte-tlo.png" style="line-height: 0; vertical-align: middle; padding-right: 15px"; /><span style="vertical-align: middle;"><?php echo __('Śledź przesyłkę') ?></span></a>
<?php else: ?>
    <a href="<?php echo url_for('@stPaczkomatyCreatePack?order='.$order->getId());?>" style="display: inline-block; padding-right: 15px; background: #444; color: #fafafa; text-decoration: none"><img src="/images/backend/icons/inpost-zolte-tlo.png" style="line-height: 0; vertical-align: middle; padding-right: 15px"; /><span style="vertical-align: middle;"><?php echo __('Wyślij paczkę') ?></span></a>
<?php endif ?>
</div>