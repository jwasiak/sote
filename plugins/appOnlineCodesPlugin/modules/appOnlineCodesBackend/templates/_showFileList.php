<?php use_stylesheet('/css/backend/stProductList.css'); ?>
<?php if (count($files)): ?>
<?php if (isset($media_type) && $media_type == 'ST_IMAGES') : ?>
<div id="product_list_backend">
    <?php foreach ($files as $file): ?>
        <div class="item box roundies">
            <div style="position: relative; text-align: right; margin-right: 10px; top: 10px; z-index: 10"><?php echo link_to(image_tag('/images/backend/icons/delete.gif'),'stProduct/onlineDocsDelete?id='.$file->getId()."&product_id=".$file->getProductId()); ?></div>
            <?php echo image_tag(appOnlineCodesListener::getThumbForImage($file), array('class'=>'image', 'style'=>"position: relative; margin-top: 0px;")) ?>
            <div class="name" style="padding-bottom: 10px"><?php echo $file->getName() ?></div>
        </div>
    <?php endforeach; ?>
</div>
<?php else : ?>
<table class="st_record_list record_list" cellspacing="0" cellpadding="0" width="100%">
    <thead>
        <th><?php echo __("Nazwa") ?></th>
        <th><?php echo __("Nazwa pliku") ?></th>
        <th><?php echo __("Rozmiar") ?></th>
        <th><?php echo __("Data dodania") ?></th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach ($files as $file): ?>
            <tr>
            <td><?php echo $file->getName() ?></td>
            <td><?php echo $file->getFilename() ?></td>
            <td><?php echo ceil(filesize(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'online-files'.DIRECTORY_SEPARATOR.$file->getProduct()->getId().DIRECTORY_SEPARATOR.$file->getFilename())/1024) ?> KB</td>
            <td><?php echo $file->getCreatedAt() ?></td>
            <td><?php echo link_to(image_tag('/images/backend/icons/delete.gif'),'stProduct/onlineDocsDelete?id='.$file->getId()."&product_id=".$file->getProductId()); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif ?>
<?php endif ?>
