<?php use_helper('stAdminGenerator', 'Object', 'stAllegro', 'stAllegroParameter', 'stProgressBar');?>
<?php
$product_id = '';

if (isset($product))
{
    $product_id = $product->getId();
    st_include_partial('stProduct/header', array('title' =>  __('Lista ofert', null, 'stAllegroBackend'), 'related_object' => $product, 'route' => null));
    st_include_component('stProduct', 'editMenu', array('related_object' => $product));
} 
else 
{
    st_include_partial('stAllegroBackend/header', array('title' =>  __('Lista ofert', null, 'stAllegroBackend')));
    st_include_component('stAllegroBackend', 'listMenu');
}
?> 

<div id="sf_admin_content">
    <?php if (!$config->get('offers_updated')): ?>
        <div style="margin: 100px auto; display: block; width: 303px; text-align: center"><?php echo progress_bar('stAllegroPluginUpdateProducts', 'stAllegroProductUpdateBar', 'execute', AllegroAuctionPeer::doCount(new Criteria())); ?></div>
    <?php else: ?>
        <?php st_include_partial('stAdminGenerator/message') ?>
        <?php st_include_partial('stAllegroBackend/list_filters', array('filters' => $filters, 'forward_parameters' => array('product_id' => $product_id))) ?>
        <?php if ($pager->getNbResults() > 0): ?> 
            <?php st_include_partial('stAllegroBackend/list_pager', array('pager' => $pager, 'forward_parameters' => array(), 'url' => st_url_for('@stAllegroPlugin?action=list&product_id='.$product_id), 'prefix' => 'head')) ?> 
            <form action="<?php echo url_for('@stAllegroPlugin?action=list&product_id='.$product_id) ?>" id="record_list_form">
                <table cellspacing="0" cellpadding="0" class="st_record_list record_list" style="width: 100%">
                    <thead>         
                        <tr> 
                            <th width="1%">&nbsp;</th>
                            <th style="width: 5%">&nbsp;</th>
                            <th style="width: 40%"><?php echo __('Tytuł') ?></th>
                            <th><?php echo __('Kod produktu') ?></th>
                            <th><?php echo __('Sztuk') ?></th>
                            <th><?php echo __('W magazynie') ?></th>
                            <th><?php echo __('Cena') ?></th>
                            <th><?php echo __('Sprzedano') ?></th>
                            <th><?php echo __('Status') ?></th>
                            <th><?php echo __('Numer') ?></th>
                            <th width="1%">&nbsp;</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php foreach ($offers->offers as $index => $offer): 
                            $editUrl = url_for('@stAllegroPlugin?action=edit&id=' . $offer->id . '&product_id='.$product_id); 
                            $auction = AllegroAuctionPeer::retrieveByAuctionNumber($offer->id);
                        ?>
                        
                            <tr class="<?php echo $index % 2 ? 'highlight' : '' ?>">
                                <td>
                                    <ul class="st_object_actions">
                                        <li><a href="<?php echo $editUrl ?>" data-admin-action="edit"><img src="/images/backend/beta/icons/16x16/edit.png" class="tooltip"></a></li>                          
                                    </ul>
                                </td>
                                <td>
                                    <a href="<?php echo $editUrl ?>" data-admin-action="edit">
                                        <img src="<?php echo $offer->primaryImage && $offer->primaryImage->url ? $offer->primaryImage->url : 'https://assets.allegrostatic.com/metrum/placeholder/placeholder-2447b7d18a.svg' ?>" style="max-width: 100%; min-width: 10px">
                                    </a>
                                </td>
                                <td style="white-space: normal"><a href="<?php echo $editUrl ?>" data-admin-action="edit"><?php echo $offer->name ?></a></td>
                                <td><?php echo st_allegro_product_code($auction) ?></td>
                                <td><?php echo $offer->stock ? $offer->stock->available : '' ?></td>
                                <td><?php 
                                    if ($auction && $auction->getProduct())
                                    {
                                        $auction->getProductOptionsArray();
                                        echo $auction->getProduct()->getStock();
                                        stNewProductOptions::clearCache($auction->getProduct());
                                    }
                                ?></td>
                                <td><?php echo $offer->sellingMode ? stCurrency::formatPrice($offer->sellingMode->price->amount) . ' ' . $offer->sellingMode->price->currency : '' ?></td>
                                <td><?php echo $offer->stock ? $offer->stock->sold : '' ?></td>
                                <td>
                                    <?php echo st_allegro_status_label($offer->publication->status) ?>
                                </td>
                                <td>
                                    <?php if ($offer->publication->status == 'ACTIVE'): ?> 
                                        <a href="<?php echo stAllegroApi::getOfferUrl($offer->id) ?>" target="_blank"><?php echo $offer->id  ?></a>
                                    <?php else: ?>
                                        <?php echo $offer->id  ?>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <ul class="st_object_actions">   
                                        <?php if ($offer->publication->status == 'INACTIVE'): ?>  
                                            <li><a href="<?php echo url_for('@stAllegroPlugin?action=delete&id=' . $offer->id . '&product_id='.$product_id) ?>" data-admin-confirm="Jesteś pewien?" data-admin-action="delete"><img src="/images/backend/beta/icons/16x16/remove.png" title="delete" class="tooltip"></a></li> 
                                        <?php endif ?>
                                        <?php if ($offer->publication->status == 'ACTIVE' || $offer->publication->status == 'ENDED'): ?> 
                                            <li><a href="<?php echo url_for('@stAllegroPlugin?action=duplicate&id=' . $offer->id . '&product_id='.$product_id) ?>"><img src="/images/backend/icons/duplicate.png" title="<?php echo __('Wystaw podobną') ?>" class="list_tooltip"></a></li> 
                                        <?php endif ?>
                                        <?php if ($offer->publication->status == 'ACTIVE'): ?> 
                                            <li><a href="<?php echo stAllegroApi::getOfferUrl($offer->id) ?>" target="_blank"><img src="/images/backend/icons/view.png" title="<?php echo __('Zobacz ofertę') ?>" class="list_tooltip"></a></li> 
                                        <?php endif ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>  
            </form> 
        <?php else: ?>
            <div style="width: 98.2%; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
                <p id="st_record_list-empty"><?php echo __("Brak ofert") ?></p>
            </div>
        <?php endif ?>
        <?php if ($product_id): ?>
            <div id="list_actions">
                <?php echo st_get_admin_actions(array(
                    array('type' => 'add', 'label' => __('Dodaj'), 'action' => '@stAllegroPlugin?action=edit&product_id='.$product_id),
                )); ?>
            </div>
        <?php endif ?>
        <script>
            jQuery(function($) {
                $('#list_actions').stickyBox();
            });
        </script>
    <?php endif ?>
</div>

<?php st_include_partial('stAllegroBackend/footer');?>

<?php st_allegro_parameter_javascript_init() ?>
