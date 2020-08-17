<?php use_helper("I18N"); ?>
<?php if ( $responseApi === 1 ) : ?>
    <?php print __("Operacja zostala wykonana"); ?> 
<?php else: ?> 
    <pre>;
        <?php print_r( $responseApi ); ?>
    </pre>;  
<?php endif; ?>
