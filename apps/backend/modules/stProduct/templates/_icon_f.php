<?php echo input_file_tag("trust[icon_f]", ""); ?><br />
<?php if ($trust->getIconF() != "") : ?>
  <img src="/uploads<?php echo $trust->getIconF(); ?>" alt="" style="max-width: 40px; margin-top: 7px;"><br />
  <?php echo link_to(__('Usuń ikone'), 'stTrustBackend/deleteProductImage?image=icon_f&product_id='.$trust->getProductId()) ?>
  <br class="st_clear_all">
<?php endif; ?>
