<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator', 'Object', 'Validation', 'ObjectAdmin') ?>
<?php use_stylesheet('/css/backend/stInstallerWebPlugin.css?version=1'); ?>
<?php echo st_get_admin_head('stInstallerWebPlugin', __('Uaktualnienia',
array()), __('Uaktualnij aplikacje w sklepie',
array()),NULL) ?>
    <div style="margin:0px 30px;">
        <?php echo get_partial('menu');?>

        <div class="st_head_txt_installer">
        <?php echo __('Raport instalacji');?>
        </div>

        <table cellpadding="0" cellspacing="0" border="0" width="100%">
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
       <?php echo st_get_admin_action('install', __('Instaluj wszystkie'), 'stInstallerWeb/verify', 'post=true') ?>
       <?php echo st_get_admin_actions_foot() ?>


    </div>
<?php echo st_get_admin_foot() ?>