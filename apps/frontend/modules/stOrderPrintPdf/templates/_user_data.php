<table border="1">
   <tr>
      <td style="background-color: #ccc;"><?php echo $user_data instanceof OrderUserDataBilling ? __('Dane billingowe:') : __('Dane dostawy:') ?></td>
   </tr>
   <tr>
      <td>
   <?php if ($user_data->getCompany()): ?>
      <?php echo $user_data->getCompany(); ?>
      <br />
   <?php endif; ?>
   
   <?php if ($user_data->getVatNumber()): ?>
   	  <?php echo __('NIP') ?>: <?php echo $user_data->getVatNumber(); ?>
   	  <br />
   <?php endif; ?>
      
   <?php if ($user_data->getFullName()): ?>
      <?php echo $user_data->getFullName(); ?>
      <br />
   <?php endif; ?>

   <?php echo $user_data->getAddress(); ?>
   <br />
   
   <?php if ($user_data->getAddressMore()): ?>
      <?php echo $user_data->getAddressMore(); ?>
      <br />
   <?php endif; ?>
   
   <?php if ($user_data->getRegion()): ?>
      <?php echo $user_data->getRegion(); ?>
      <br />
   <?php endif; ?>

   <?php echo $user_data->getCode(); ?> <?php echo $user_data->getTown(); ?> <?php echo $user_data->getCountry(); ?><br />
   
   <?php if ($user_data instanceof OrderUserDataBilling): ?>
   <?php if ($user_data->getPesel()): ?>
   <?php echo __('PESEL') ?>: <?php echo $user_data->getPesel(); ?><br />
   <?php endif; ?>
   <?php endif; ?>
   
   <?php if ($user_data->getPhone()): ?>
   <?php echo __('tel') ?>: <?php echo $user_data->getPhone(); ?><br />
   <?php endif; ?>

</td>
</tr>
</table>