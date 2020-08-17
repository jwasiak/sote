<?php use_helper('Url') ?>
<h1><?php echo __('Moduł naprawy') ?></h1>
<ul>
    <li><?php echo link_to(__('Naprawa katalogu zdjęć'),'stRepairKit/repairAssetFolders') ?></li>

    <li><?php echo link_to(__('Naprawa zagnieżdzeń kategorii'),'stRepairKit/repairCategories') ?></li>
</ul>