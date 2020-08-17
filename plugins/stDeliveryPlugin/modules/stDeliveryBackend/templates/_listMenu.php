<?php $routing = sfRouting::getInstance(); ?>
<?php $action_name = sfContext::getInstance()->getActionName(); ?>
<?php init_tooltip('.help') ?>
<?php init_tooltip('.float_right_config .tooltip, .header .menu > ul > .expandable a.relatedmodules', array('width' => 'auto', 'position' => 'bottom right')) ?>
<?php use_stylesheet('backend/beta/style.css?v17', 'first') ?>
<div class="application-menu">
    <ul>    
        <?php foreach ($items as $action => $name): $url = url_for($action) ?>
        <?php if (($name == "Terminarz dostaw" || $name =="Delivery schedule") && stTheme::hideOldConfiguration()) continue; ?>
            <li class="<?php echo $selected_item_path == $url ? 'selected' : 'none' ?>"><a href="<?php echo $url ?>"><?php echo $name ?></a></li>
        <?php endforeach; ?>
    </ul>
    <br style="clear: left" />
</div>

<div class="header" style="margin-bottom: 10px;">
  <div class="clr"></div>


</div>