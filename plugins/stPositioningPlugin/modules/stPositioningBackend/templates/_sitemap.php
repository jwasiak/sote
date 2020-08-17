<?php if ($sf_flash->has('notice')):?>
    <div class="save-ok">
        <h2><?php echo __($sf_flash->get('notice'));?></h2>
    </div>
<?php endif;?>
<div id="sf_admin_content_config">
    <?php echo form_tag('stPositioningBackend/sitemapCustom', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
        <fieldset style="padding: 10px;">
            <div class="st_fieldset-none">
                <?php if (!$sf_params->get('save_and_generate',0) || $sf_request->hasErrors()): ?>
                <div class="form-row">
                    <label style="margin-top: 2px;"><?php echo __('Generuj mapę strony dla') ?>:</label>
                    <div class="content<?php if ($sf_request->hasError('sitemap{langs}')): ?> form-error<?php endif; ?>">
                    <?php if ($sf_request->hasError('sitemap{langs}')): ?>
                        <?php echo form_error('sitemap{langs}', array('class' => 'form-error-msg')) ?>
                    <?php endif; ?>
                    <table border="0" cellpadding="3" cellspacing="0">
                            <tr>
                            <td colspan="2"><?php echo __('Wersja językowa'); ?></td>
                            <td><?php echo __('Plik'); ?></td>
                            <td><?php echo __('Data wygenerowania'); ?></td>
                            </tr>
                        <?php foreach ($languages as $language):?> 
 
                           <tr>
                           <td><?php echo checkbox_tag('sitemap[langs]['.$language->getShortcut().']',$language->getOriginalLanguage(),isset($langs[$language->getShortcut()])?$langs[$language->getShortcut()]:'');?></td>
                            <td style="min-width: 110px;"><div style="float: left;"><?php echo image_tag('/'.sfConfig::get('sf_upload_dir_name').'/stLanguagePlugin/'.$language->getActiveImage(),array('style'=>'margin-top: 5px; margin-right: 5px;')) ?></div><div style="margin-top: 5px;"><?php echo $language->getName();?></div><div style="clear:both;"></div>
                            </td>
                            
                            <?php 
                            $file = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR."sitemap_".$language->getShortcut().".xml";
                            if (file_exists($file)): ?>
                            <td style="padding-top: 10px; min-width: 150px; padding-right: 30px;"> <?php echo st_external_link_to("http://".stSitemapGenerator::getDefaultDomainForLang($language->getShortcut())."/sitemap_".$language->getShortcut().".xml", "http://".stSitemapGenerator::getDefaultDomainForLang($language->getShortcut())."/sitemap_".$language->getShortcut().".xml");?></td>
                            <td style="padding-top: 10px;"><?php echo date("d.m.Y H:i:s", filemtime($file));?></td>
                            <?php else: ?>
                                <td style="padding-top: 10px; min-width: 150px; padding-right: 30px;"><?php echo __("Mapa strony nie została wygenerowana") ?></td>
                                <td style="padding-top: 10px;">-</td>
                            <?php endif;?>

                            </li>
                        <?php endforeach; ?>
                        </tr>
                        </table>               
                    </div>                    
                    <br class="st_clear_all" />
                </div>
                <?php else: ?>
                <div class="form-row">
                    <?php st_include_component('stPositioningBackend','generateSitemap',array('config'=>$config))?>
                    <br class="st_clear_all" />
                </div>                    
                <?php endif;?>
            </div>
        </fieldset>
        <?php if (!$sf_params->get('save_and_generate',0) || $sf_request->hasErrors()): ?>
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
            <?php echo st_get_admin_action('file', __('Generuj mapę serwisu'), null, array('name' => 'save_and_generate'));?>
        <?php echo st_get_admin_actions_foot();?>
        <?php endif;?>
    </form>
</div>
