<div id="st-allegro-delivery-edit-delivery">
    <?php if($allegro_delivery->isNew()):?>
        <img id="st-allegro-delivery-edit-delivery-loading" src="/images/frontend/theme/default2/loading.gif" alt=""/>
    <?php else:?>
        <?php echo st_get_component('stAllegroDeliveryBackend', 'deliveries', array('id' => $allegro_delivery->getId(), 'namespace' => 'allegro_delivery', 'environment' => $allegro_delivery->getEnvironment(), 'show' => !$allegro_delivery->isNew()));?>
    <?php endif;?>
</div>
