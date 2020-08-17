<?php echo input_file_tag("trust[icon_s]", ""); ?><br />
<?php if ($trust->getIconS() != "") : ?>
  <img src="/uploads<?php echo $trust->getIconS(); ?>" alt="" style="max-width: 40px; margin-top: 7px;"><br />
  <?php echo link_to(__('Usuń ikone'), 'stTrustBackend/deleteProductImage?image=icon_s&product_id='.$trust->getProductId()) ?>
  <br class="st_clear_all">
<?php endif; ?>
