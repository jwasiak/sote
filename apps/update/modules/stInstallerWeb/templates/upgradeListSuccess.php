<?php use_helper('I18N', 'Date', 'Text', 'Object', 'Validation', 'ObjectAdmin', 'stUpdate');?>
<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1');?>
<?php use_stylesheet('/css/update/style2.css');?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">
    <?php echo get_partial('menu_home', array('selected' => 'upgradeList'));?>
    <div class="content">
        <div class="content_update_box">
            <h2 class="title">
                <?php echo __('Pobierz', null, 'stInstallerWeb');?>
            </h2>
            <?php if($hasPackages == TRUE):?>
                <p class="subhead_txt_module left">
                    <?php echo __('Dostępne aktualizacje');?>
                </p>
                <?php if($hasInstaller != true):?>
                    <div style="float: right" class="button_top">
                        <?php echo st_get_update_actions_head('style="float:right"');?>
                            <?php echo st_get_update_action('download', __('Pobierz wszystkie'), 'stInstallerWeb/upgradeAllBySteps', 'post=true');?>
                        <?php echo st_get_update_actions_foot();?>
                    </div>
                <?php endif;?>
                <div class="clear"></div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_download">
                    <tr bgcolor="#fafafa">
                        <th align="left"><?php echo __('Nr');?></th>
                        <th align="left"><?php echo __('Ikonka');?></th>
                        <th align="left"><?php echo __('Nazwa');?></th>
                        <th align="left"><?php echo __('Opis');?></th>
                        <th align="right"><?php echo __('Wersja');?></th> 
                    </tr>
                    <?php $i = 1;?>
                    <?php foreach($packages as $name => $version):?>
                        <tr>
                            <td width="50px"><?php echo $i;?>.&nbsp;</td>
                            <td>
                                <?php $fullPath = 'images/backend/main/icons/red/'.$name.'.png';?>
                                <img width="30" height="30" src="/<?php echo (is_file($fullPath) ? $fullPath : 'images/update/red/modules/empty.png');?>"/>
                            </td>
                            <td width="20%">
                                <?php echo $name;?>
                            </td>
                            <td>
                                <?php echo stApplication::getAppName($name);?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo $version;?>
                            </td>
                        </tr>
                        <?php $i++;?>
                    <?php endforeach;?>
                </table>
                <div style="float: right" class="button" style="margin-top: 20px;">
                    <?php echo st_get_update_actions_head('style="float:right"');?>
                        <?php if ($hasInstaller == TRUE):?>
                            <?php echo st_get_update_action('download', __('Pobierz'), 'stInstallerWeb/upgradeBySteps?package=stUpdate&version='.$installerVersion);?>
                        <?php else:?>
                            <?php echo st_get_update_action('download', __('Pobierz wszystkie'), 'stInstallerWeb/upgradeAllBySteps', 'post=true');?>
                        <?php endif;?>
                    <?php echo st_get_update_actions_foot();?>
                </div>
            <?php else:?>
                <h2 class="subhead_txt_module">
                    <?php echo __('Nie ma nowych aktualizacji.');?>
                </h2>
            <?php endif;?>
            <div class="st_clear_all"></div>
        </div>
    </div>
</div>
<div class="st_clear_all"></div>
