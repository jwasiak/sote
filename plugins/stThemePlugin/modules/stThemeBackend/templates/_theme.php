<?php if($type=="list"): ?>
    <?php echo $theme->getTheme() ?>
    <?php if ($theme->getVersion() >= 7): ?>
    <img src="/images/backend/icons/mobile16.png" style="vertical-align: middle; margin-left: 5px">
    <?php endif ?>
<?php else: ?>
    <?php if ($theme->getIsSystemDefault() == 1): ?>
        <input type="text" size="50" value="<?php echo $theme->getTheme() ?>" id="theme_theme" name="theme[theme]" disabled>
        <input type="hidden" size="50" value="<?php echo $theme->getTheme() ?>" id="theme_theme" name="theme[theme]">
    <?php else: ?>
        
        <?php if ($sf_request->hasError('theme{theme}')): ?>
            <?php echo form_error('theme{theme}', array('class' => 'form-error-msg')) ?>
        <?php endif; ?>
        <input type="text" size="50" value="<?php echo $theme->getTheme() ?>" id="theme_theme" name="theme[theme]">
        
    <?php endif; ?>
<?php endif ?>