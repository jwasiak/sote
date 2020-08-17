<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $results=array(); ?>

<?php foreach ($panel_navigator->getTabs() as $tab): ?>

    <?php $row['is_tab']=$panel_navigator->isFirst($tab) ?>
    
    <?php if ($panel_navigator->isFirst($tab)): ?>
    
        <?php $row['selected_tab']=$panel_navigator->isSelected($tab) ? ' st_selected' : '' ?>
        <?php $row['link_to_module']=link_to(__($tab->getLabel(), '', $tab->getModuleName()), $tab->getParamsForUrl()); ?>
    
    <?php elseif ($panel_navigator->isFirst($tab)): ?>
    
        <?php $row['selected_tab']=$panel_navigator->isSelected($tab) ? ' st_selected' : '' ?>
        <?php $row['link_to_module']=link_to(__($tab->getLabel(), '', $tab->getModuleName()), $tab->getParamsForUrl()); ?>
    
    <?php else: ?>
    
        <?php $row['selected_tab']=$panel_navigator->isSelected($tab) ? ' st_selected' : '' ?>
        <?php $row['link_to_module']=link_to(__($tab->getLabel(), '', $tab->getModuleName()), $tab->getParamsForUrl()); ?>
    
    <?php endif; ?>
    
    <?php $results[]=$row;?>

<?php endforeach; ?>

<?php $smarty->assign('results',$results); ?>

<?php $smarty->display('userdata_user_panel_menu.html') ?>