<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">  
    <?php echo get_partial('menu');?>
    <div id="sf_admin_container">
        <div class="box_content">
            <div class="st_head_txt_installer">
                <?php echo __('Lista zainstalowanych aplikacji:');?> 
            </div>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <?php foreach ($content as $name => $version):?>
                    <tr>
                        <td>
                            <?php if (is_file("images/backend/main/icons/$name.png")): ?>
                                <img width="30" height="30" src="/images/backend/main/icons/<?php echo $name;?>.png"/>
                            <?php else:?>
                                <img width="30" height="30" src="/images/update/installerweb/empty.png"/>
                            <?php endif;?>
                        </td>
                        <td width="20%"><?php echo $name;?></td>
                        <td><?php echo stApplication::getAppName($name);?></td>
                        <td><?php echo $version;?></td>
                    </tr>
                <?php endforeach;?>
            </table>   
        </div>
        <div class="clear"></div>
    </div>
</div>