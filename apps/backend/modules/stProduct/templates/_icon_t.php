<?php echo input_file_tag("trust[icon_t]", ""); ?><br />
<?php if ($trust->getIconT() != "") : ?>
  <img src="/uploads<?php echo $trust->getIconT(); ?>" alt="" style="max-width: 40px; margin-top: 7px;"><br />
  <?php echo link_to(__('Usuń ikone'), 'stTrustBackend/deleteProductImage?image=icon_t&product_id='.$trust->getProductId()) ?>
  <br class="st_clear_all">
<?php endif; ?>
