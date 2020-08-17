<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
    <?php echo get_partial('menu');?>
    <div class="box_content">
        <h2 class="title"><?php echo __('Tryb developerski', null, 'stInstallerWeb');?></h2>
        <div class="st_head_txt_installer">
            <?php echo __('Lista aplikacji do aktualizacji:');?>
        </div>
        <br />

        <?php if(is_array($packages)):?>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <?php foreach ($packages as $package):?>   
                    <tr>
                        <td>
                            <?php if (is_file("images/backend/main/icons/".$package['name'].".png")): ?>
                                <img width="30" height="30" src="/images/backend/main/icons/<?php echo $package['name'];?>.png"/>
                            <?php else:?>
                                <img width="30" height="30" src="/images/update/installerweb/empty.png"/>
                            <?php endif;?>                
                        </td>
                        <td width="20%"><?php echo $package['name']; ?></td>
                        <td><?php echo stApplication::getAppName($package['name']);?></td>
                        <td><?php $version = explode(" ", $package['version']); echo $version[0]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif;?>
    </div>
    <div class="clear"></div>
</div>