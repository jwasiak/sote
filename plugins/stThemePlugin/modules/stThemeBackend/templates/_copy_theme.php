<?php
    $c = new Criteria();
    $c->add(ThemePeer::IS_SYSTEM_DEFAULT, true);
    $c->add(ThemePeer::IS_HIDDEN, false);
    $c->addAscendingOrderByColumn(ThemePeer::THEME);
    $options = array();

    $default = null;
    
    foreach (ThemePeer::doSelect($c) as $current)
    {
        if ($current->getVersion() < 3 || $current->getTheme() == 'default2') continue;
        $options[$current->getId()] = $current->getTheme();
        if ($current->getTheme() == 'argentorwd')
        {
            $default = $current->getId();
        }
    }
?>
<?php if ($theme->isNew()): 
    $c = new Criteria();
    $c->add(ThemePeer::IS_SYSTEM_DEFAULT, true);
    $c->add(ThemePeer::IS_HIDDEN, false);
    $c->addAscendingOrderByColumn(ThemePeer::THEME);
    $options = array();

    $default = null;
    
    foreach (ThemePeer::doSelect($c) as $current)
    {
        if ($current->getVersion() < 3 || $current->getTheme() == 'default2') continue;
        $options[$current->getId()] = $current->getTheme();
        if ($current->getTheme() == 'argentorwd')
        {
            $default = $current->getId();
        }
    }
?>

    <label for="theme_theme">
        <?php echo __('Utwórz temat na podstawie', null, 'stThemeBackend');?>
    </label>
    <div class="field<?php if ($sf_request->hasError('theme{copy_theme}')):?> form-error<?php endif;?>">
        <?php if ($sf_request->hasError('theme{copy_theme}')):?>
            <?php echo form_error('theme{copy_theme}', array('class' => 'form-error-msg'));?>
        <?php endif;?>
        <?php echo select_tag('theme[copy_theme]', options_for_select($options, $default));?>
        <div class="clr"></div>
    </div>

<?php elseif ($theme->hasBaseTheme()): ?>
    <label>
        <?php echo __('Temat bazowy', null, 'stThemeBackend'); ?>
    </label>
    <div class="field">
        <?php echo implode(' / ', $theme->getBaseThemes()) ?>
    </div>
<?php endif ?>