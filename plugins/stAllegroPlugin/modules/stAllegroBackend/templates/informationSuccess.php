<?php use_helper('stAdminGenerator', 'stProgressBar', 'stUrl', 'stAllegro');?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css');?>
<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php st_include_partial('stAllegroBackend/header', array('related_object' => null, 'title' => __('Pobieranie kategorii Allegro'), 'culture' => null, 'route' => 'stAllegroBackend/categoryCustom'));?>
<?php st_include_component('stAllegroBackend', 'listMenu', array('forward_parameters' => null, 'related_object' => null));?>

<?php st_include_partial('stAllegroBackend/list_messages', array('forward_parameters' => null));?>
<div id="sf_admin_content">
   <div class="admin_form">
        <fieldset>
            <h2><?php echo __('Status Aukcji');?></h2>
            <div class="st_fieldset-content">
                <div class="row">
                    <label><?php echo __('Nazwa aukcji');?></label>
                    <div class="field"><?php echo $auction->getName();?></div>
                </div>
                <div class="row">
                    <label><?php echo __('Numer aukcji');?></label>
                    <div class="field"><?php echo st_allegro_get_auction_link($auction);?></div>
                </div>
                <div class="row">
                    <label><?php echo __('Koszt wystawienia');?></label>
                    <div class="field"><?php echo stCurrency::formatPrice($auction->getAuctionCost());?> PLN</div>
                </div>            
            </div>
        </fieldset>
    </div>
</div>
<?php st_include_partial('stAllegroBackend/footer', array('related_object' => null, 'forward_parameters' => null));?>
