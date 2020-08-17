<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update">                   
        <?php echo get_partial('menu_tools',array('selected'=>'history'));?>
        <div class="box_content">
            <h2 class="title"><?php echo __('Historia aktualizacji', null, 'stInstallerWeb');?></h2>
            <div class="content_update_box">                        
                <h2 class="subhead_txt_module"> 
                    <?php echo __('Historia instalacji/aktualizacji') ?>
                </h2>      
                                                                                   
                <ul>
                <?php foreach ($history_apps as $date=>$apps):?>
                <li> 
                    <li><br /></li>      
                    <li><?php echo $date ?></li>
                    <ul>               
                    <?php foreach ($apps as $data): ?>
                        <li> &nbsp; &nbsp; 
                            <?php echo $data['package'].' '.$data['version'].' ' ?>     
                        </li>                                         
                    <?php endforeach ?>
                    </ul>
                </li>    
                <?php endforeach ?>
                </ul>
            </div>  
    </div>  
    <div class="st_clear_all"></div>  
</div>

