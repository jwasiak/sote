<?php use_helper('stBackend') ?>
<ul<?php if ($inverted): ?> class="inverted"<?php endif ?>>
    <?php foreach ($items as $item => $children): $attribute = get_navbar_attributes($item); if (!$attribute) continue; ?>   
        <?php if ($attribute['route'] == "points/list" && stTheme::hideOldConfiguration()) continue; ?>
        <li<?php if ($children): ?> class="expandable"<?php endif; ?>>
            <?php if ($attribute['route']): ?>
                <a href="<?php echo __(st_url_for($attribute['route'])) ?>"<?php if ($attribute['is_external']): ?> target="_blank"<?php endif ?>>
                    <?php if(isset($attribute['icon']) && $attribute['icon']): ?><img src="<?php echo get_app_icon($attribute['icon']); ?>" alt="" /><?php endif; ?>
                    <?php if(isset($attribute['icon_path'])): ?><img src="<?php echo $attribute['icon_path'] ?>" alt="" /><?php endif; ?>
                    <span><?php if($attribute['label']) echo __($attribute['label'], null, $attribute['i18n']) ?></span>
                </a>      
            <?php else: ?>      
                <span><?php echo __($attribute['label'], null, $attribute['i18n']) ?></span>
            <?php endif; ?>   
            <?php if ($children): ?>
                <?php echo st_get_fast_partial('stBackend/menu', array('items' => $children, 'inverted' => !$inverted), true) ?>
            <?php endif; ?>      
        </li>
    <?php endforeach; ?>
    <?php if (isset($first_call)): ?>        
        
        <li class="expandable update-menu" id="update-menu">
            <?php echo st_get_component('stBackend', 'updateInfo') ?>
        </li>
        
        <li class="expandable help-menu" id="help-menu">
            <?php echo st_get_component('stBackend', 'helpInfo') ?>
        </li>
    <?php endif ?>
    
    
</ul>