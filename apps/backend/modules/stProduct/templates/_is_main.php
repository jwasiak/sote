<?php
    $c = new Criteria();
    $c->add(ProductForSfAssetPeer::PRODUCT_ID , $forward_parameters['product_id']);
    $c->add(ProductForSfAssetPeer::SF_ASSET_ID , $sf_asset->getId());
    $asset = ProductForSfAssetPeer::doSelectOne($c);
    if ( $asset ):
        $assigned = $asset->getIsMain();
    else:
        $assigned = false;
    endif;    
?>
<?php echo $assigned ? image_tag(sfConfig::get('sf_admin_web_dir').'/images/tick.png') : '-' ?>