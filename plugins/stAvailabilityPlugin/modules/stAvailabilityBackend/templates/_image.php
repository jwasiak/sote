<?php use_helper('stAvailabilityImage') ?>

<p><?php echo st_availability_image_tag($availability, 'full') ?></p>
<?php echo input_file_tag('availability[image]') ?>
<?php if ($availability->getOptImage()): ?>
   <p><?php echo checkbox_tag('availability[delete_image]', 1, false) ?> <?php echo __('usuń obrazek') ?></p>
<?php endif; ?>
<script type="text/javascript">
   $('availability_delete_image').observe('click', function ()
   {
      var availability_image = $('availability_image');

      availability_image[this.checked ? 'disable' : 'enable']();
   });
</script>
