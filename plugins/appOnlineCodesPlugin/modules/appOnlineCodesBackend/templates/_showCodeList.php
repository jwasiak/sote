<?php if (count($files)): ?>
<table class="st_record_list record_list" cellspacing="0" cellpadding="0" width="100%">
    <thead>
        <th><?php echo __("Nazwa") ?></th>
        <th><?php echo __("Kod") ?></th>
        <th><?php echo __("Limit użyć") ?></th>
        <th><?php echo __("Użyty") ?></th>
        <th><?php echo __("Data dodania") ?></th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach ($files as $file): ?>
            <tr>
                <td><?php echo $file->getName() ?></td>
                <td><?php echo $file->getCode() ?></td>
                <td><?php echo $file->getUsageLimit() ?></td>
                <td><?php echo $file->getUsed() ?></td>
                <td><?php echo $file->getCreatedAt() ?></td>
                <td>
                    <?php echo link_to(image_tag('/images/backend/icons/edit.gif'),'stProduct/onlineCodesEdit?id='.$file->getId()."&product_id=".$file->getProductId()); ?>
                    <?php echo link_to(image_tag('/images/backend/icons/delete.gif'),'stProduct/onlineCodesDelete?id='.$file->getId()."&product_id=".$file->getProductId()); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif ?>
