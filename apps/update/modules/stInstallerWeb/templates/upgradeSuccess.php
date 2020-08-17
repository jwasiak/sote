<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>
<?php use_stylesheet('/css/backend/stInstallerWebPlugin.css?version=1'); ?>
<?php echo st_get_admin_head('stInstallerWebPlugin', __('Uaktualnienia',
array()), __('Uaktualnij aplikacje w sklepie',
array()),NULL) ?>
<?php echo get_partial('stInstallerWeb/menu_top');?>
<div id="frame_update"> 
        <?php echo get_partial('menu');?>
        <div class="content">
            <div class="st_head_txt_installer">
            <?php echo __('Raport instalacji');?>
            </div>

            <table cellpadding="0" cellspacing="0" border="0" width="80%">
            <?php foreach ($apps as $app):?>
                <tr>
                    <td>
                        <?php $app=ereg_replace('__DOWNLOAD__',__('Pobieram'),$app);?>
                        <?php echo $app;?>
                    </td>
                </tr>
            <?php endforeach ?>
            </table>

            <?php $result=ereg_replace('__UPDATED__',__('Aplikacje pobrane.'),$result);?>
            <?php $result=ereg_replace('__NOTHING2UPGRADE__',__('Nie ma aplikacji do aktualizacji.'),$result);?>
            <br />
            <?php echo $result;?>

           <?php echo st_get_admin_actions_head() ?>
           <?php echo st_get_admin_action('add', __('Pobierz następną'), 'stInstallerWeb/upgradeList', 'post=true') ?>
           <?php echo st_get_admin_actions_foot() ?>

        </div>
        <div class="clear"></div>
    </div>
<?php echo st_get_admin_foot() ?>