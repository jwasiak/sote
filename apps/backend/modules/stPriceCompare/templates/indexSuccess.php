<?php use_helper('I18N', 'stAdminGenerator') ?>
<?php echo st_get_admin_head('stPriceCompare', __('Dodawanie produktów do porównywarek cen'), __('Zarządzanie produktami w porównywarkach cen, konfiguracja ustawień.'), NULL) ?>  
        <?php include_partial('menu', array()) ?>
        <?php st_include_partial('stAdminGenerator/message') ?>
        <div id="sf_admin_content" style="padding: 10px"> 
            <?php echo form_tag('price_compare/setForAll', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form')) ?>
                <table cellspacing="0" cellpadding="0" class="st_record_list record_list" width="100%">
                    <thead>      
                        <tr>
                            <th style="font-size: 12px; color: rgb(0, 0, 0); text-decoration: none; padding: 6px 10px;"><?php echo __('Nazwa porównywarki cen') ?></th>
                            <th style="font-size: 12px; padding: 6px 10px; border-left: none;"><?php echo __('Ilość dodanych produktów (wszystkich').': '.$productsCount.')' ?></th>
                            <th style="font-size: 12px; padding: 6px 10px; border-left: none;"><?php echo __('Dodaj wszystkie produkty') ?></th>
                        </tr>
                    </thead>
                    <?php $i = 2;?>
                    <?php foreach ($plugins as $key => $plugin):?>
                        <tr<?php if($i%2) echo ' style="background-color: rgb(249, 249, 249);"'?>>
                            <?php if ($plugin['name'] <> 'Skapiec'):  ?>
                                <td style="font-size: 12px; font-size: 12px; color: rgb(0, 0, 0); text-decoration: none; padding: 6px 10px;"><?php echo $plugin['name'];?></td>
                                <td style="font-size: 12px; padding: 6px 10px; border-left: none;"><?php echo $pluginCount[$key];?></td>
                                <td style="font-size: 12px; padding: 6px 10px; border-left: none;"><?php echo checkbox_tag('price_compare['.$plugin['peerName'].']',$plugin['peerName'],$pluginChecked[$key]);?></td> 
                            <?php endif; ?>
                        </tr>
                    <?php $i++;?>
                    <?php endforeach; ?>
                </table>

                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
        </div>    
    <br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>