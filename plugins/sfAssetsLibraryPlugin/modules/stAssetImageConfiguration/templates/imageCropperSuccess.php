<?php use_helper('stAsset') ?>
<ul class="tabs">
<?php foreach ($image_types as $type => $params): ?>
    <li><a href="#"><?php echo __($image_labels[$type]) ?></a></li>
<?php endforeach ?>
    <li class="clr"></li>
</ul>
<div class="tools">
    <ul>
        <li><a href="#" class="align_left" title="<?php echo __('Wyrównaj do lewej') ?>"></a></li>
        <li><a href="#" class="align_center" title="<?php echo __('Wycentruj w poziomie') ?>"></a></li>
        <li><a href="#" class="align_right" title="<?php echo __('Wyrównaj do prawej') ?>"></a></li>
        <li><a href="#" class="align_top" title="<?php echo __('Wyrównaj do góry') ?>"></a></li>
        <li><a href="#" class="align_middle" title="<?php echo __('Wycentruj w pionie') ?>"></a></li>
        <li><a href="#" class="align_bottom" title="<?php echo __('Wyrównaj do dołu') ?>"></a></li>
    </ul>
    <br class="clr" />
</div>

<form action="<?php echo st_url_for('@stAssetImageConfiguration?action=imageCropper') ?>">
    <input type="hidden" name="asset_id" value="<?php echo !$asset->isNew() ? $asset->getId() : $asset->getRelativePath() ?>" />
    <input type="hidden" name="for" value="<?php echo $for ?>" />
    <input type="hidden" name="namespace" value="<?php echo $namespace ?>" />
<?php foreach ($image_types as $type => $params): ?>
    <input type="hidden" name="<?php echo $namespace ?>[select][<?php echo $type ?>]" id="<?php echo $namespace ?>_select_<?php echo $type ?>" value="<?php echo json_encode($asset->getCropByImageType($type)) ?>" />
<?php endforeach ?>    
    <div class="panes">
    <?php foreach ($image_types as $type => $params): ?>                
        <div>
            <?php if ($image_info[0] == $params['width'] && $image_info[1] == $params['height']): ?>
                <p style="background: #fff; padding: 5px; margin-bottom: 5px"><?php echo __("Zdjęcie nie wymaga kadrowania, ponieważ nie przekracza rozmiaru %%cw%%x%%ch%%.", array('%%iw%%' => $image_info[0], '%%ih%%' => $image_info[1], '%%cw%%' => $params['width'], '%%ch%%' => $params['height'])) ?></p>
            <?php elseif ($image_info[0] < $params['width'] && $image_info[1] < $params['height']): ?>
                <p style="background: #fff; padding: 5px; margin-bottom: 5px"><?php echo __("Załączone zdjęcie jest za małe, zalecany minimalny rozmiar to %%cw%%x%%ch%%.", array('%%iw%%' => $image_info[0], '%%ih%%' => $image_info[1], '%%cw%%' => $params['width'], '%%ch%%' => $params['height'])) ?></p>
            <?php endif ?>
            <img class="<?php echo $type ?>" src="/stThumbnailPlugin.php?i=<?php echo $asset->getRelativePath() ?>&w=622&h=512" data-width="<?php echo $image_info[0] ?>" data-height="<?php echo $image_info[1] ?>" />
        </div>
    <?php endforeach ?>                
    </div>
    <ul class="admin_actions">
        <li class="action-save"><input type="submit" value="<?php echo __('Zapisz', null, 'stBackend') ?>"></li>
        <li class="clr"></li>
    </ul>
</form>