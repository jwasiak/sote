<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php use_helper('stAllegro');?>
<div id="sf_admin_content">
   <div class="admin_form">
        <?php foreach ($environments as $environment):?>
            <?php if($environment['config']['enabled']):?>
                <fieldset>
                    <h2><?php echo __($environment['name']);?></h2>
                    <div class="content">
                        <div class="row">
                            <?php if (!$environment['config']['api_key'] || !$environment['hasCategories']):?>
                                <div id="st-allegro-list-type-description">
                                    <?php echo __($environment['description'], null, 'stAllegroBackend');?>
                                </div>
                            <?php endif;?>
                            <?php if ($environment['auctions']):?>
                                <div id="record_list_form">
                                    <table cellspacing="0" cellpadding="0" class="st_record_list record_list st-allegro-list-auctions-table">
                                        <thead>
                                            <tr>
                                                <th width="1%">&nbsp;</th>
                                                <th width="50%"><?php echo __('ID');?></th>
                                                <th><?php echo __('Tytuł aukcji');?></th>
                                                <th width="10%"><?php echo __('Numer aukcji');?></th>
                                                <th width="10%"><?php echo __('Status');?></th>
                                                <th width="10%">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; foreach ($environment['auctions'] as $auction):?>
                                                <tr<?php echo ($i%2) ? ' class="highlight"' : '';?>>
                                                    <td>
                                                        <ul class="st_object_actions">
                                                            <?php if($auction->getAuctionId()):?>
                                                                <li><?php echo link_to(image_tag('/images/backend/icons/view.png', array('alt' => __('Podgląd'), 'title' => __('Podgląd'))), 'stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$productId);?></li>
                                                            <?php else:?>
                                                                <li><?php echo link_to(image_tag('/images/backend/icons/edit.png', array('alt' => __('Edycja'), 'title' => __('Edycja'))), 'stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$productId);?></li>
                                                            <?php endif;?>
                                                        </ul>
                                                    </td>
                                                    <td><a href="<?php echo st_url_for('stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$productId);?>"><?php echo $auction->getId();?></a></td>
                                                    <td><?php echo $auction->getName();?></td>
                                                    <td><?php echo st_allegro_get_auction_link($auction);?></td>
                                                    <td><?php echo $auction->getAuctionId() ? ($auction->getEnded() ? __('Zakończona') : __('Wystawiona')) : __('Do wystawienia');?></td>
                                                    <td class="st-allegro-list-auction-table-actions">
                                                        <ul class="st_object_actions">
                                                            <?php if($auction->getAuctionId()):?>
                                                                <li><?php echo link_to(image_tag('/images/backend/icons/view.png', array('alt' => __('Podgląd'), 'title' => __('Podgląd'))), 'stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$productId);?></li>
                                                            <?php else:?>
                                                                <li><?php echo link_to(image_tag('/images/backend/icons/edit.png', array('alt' => __('Edycja'), 'title' => __('Edycja'))), 'stProduct/allegroEdit?id='.$auction->getId().'&product_id='.$productId);?></li>
                                                                <li><?php echo link_to(image_tag('/images/backend/icons/auction.png', array('alt' => __('Wystaw'), 'title' => __('Wystaw'))), 'stAllegroBackend/sale?id='.$auction->getId()) ?></li>
                                                            <?php endif; ?>

                                                            <li><?php echo link_to(image_tag('/images/backend/icons/duplicate.png', array('alt' => __('Kopiuj'), 'title' => __('Kopiuj'))), 'stAllegroBackend/duplicate?id='.$auction->getId()) ?></li>

                                                            <?php if ($auction->getEnded() && 1==2): ?>
                                                                <li><?php echo link_to(image_tag('/images/backend/icons/refresh.png', array('alt' => __('Wystaw ponownie'), 'title' => __('Wystaw ponownie'))), 'allegro/copy?id='.$auction->getId()."&resale=1") ?></li>
                                                            <?php endif; ?>

                                                            <li><?php echo link_to(image_tag('/images/backend/icons/delete.png', array('alt' => __('Usuń'), 'title' => __('Usuń'))), 'stProduct/allegroDelete?id='.$auction->getId().'&product_id='.$productId, array('post' => true, 'confirm' => __('Czy napewno chcesz usunąć?')));?></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php $i++; endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif;?>
                            <?php if ($environment['config']['api_key'] && $environment['hasCategories']):?>
                                <?php if ($environment['categoriesStatus'] == 0):?>
                                    <div id="st-allegro-custom-category-message">
                                        <?php echo st_allegro_show_category_status($environment['stAllegroCategory']);?>
                                    </div>
                                <?php endif;?>
                                <input id="st-allegro-button-create-<?php echo $environment['htmlEnvironment'];?>" class="st-allegro-button-add" type="button" value="<?php echo __('Stwórz aukcje');?>"/>
                                <div class="clr"></div>
                            <?php else:?>
                                <div>
                                    <?php echo __('Przed przystąpieniem do tworzenia aukcji należy', null, 'stAllegroBackend');?> 
                                    <?php if (!$environment['config']['api_key']):?>
                                        <?php echo st_link_to(__('uzupełnić konfigurację'), 'stAllegroBackend/config');?>.
                                    <?php else:?>
                                        <?php echo st_link_to(__('pobrać kategorie'), 'stAllegroBackend/categoryCustom');?>.
                                    <?php endif;?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </fieldset>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>

<script type="text/javascript" language="javascript">
    jQuery(function($) {
        $(document).ready(function() {
            <?php foreach ($environments as $environment):?>
                $('#st-allegro-button-create-<?php echo $environment['htmlEnvironment'];?>').click(function(){
                    window.location.href = '<?php echo st_url_for('product/allegroEdit?product_id='.$productId.'&environment='.$environment['htmlEnvironment']);?>';
                })
            <?php endforeach;?>
        });
    });
</script>
