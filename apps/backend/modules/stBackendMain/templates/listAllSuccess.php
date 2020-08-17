<?php use_helper('Javascript','stAdminGenerator', 'stAlert') ?>

<div id="main_nav">
    <div id="qpanel_main">
        <div id="qpanel_list">      
            <?php foreach ($apps as $id => $title): ?>
          
                <div id="img_icons_all">            
                    <?php if (sfRouting::getInstance()->hasRouteName($id)): ?>
                        <?php echo st_link_to(image_tag('backend/main/icons/'.$id, array(
                        'id'    => 'app_'.$id,
                        'class' => 'qpanel_apps'
                        )),"@$id")?>         
                    <?php else: ?>     
                        <?php echo image_tag('backend/main/icons/stDefaultApp') ?>
                    <?php endif ?>
                    <div class="font_normal">
                        <?php echo $title ?>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
