<?php use_helper('appOnlineCodes');?>
<?php echo __('Dodatkowe dane do zamówienia numer', null, 'appOnlineCodesMail');?> 

<?php foreach($codes as $code):?>
<?php echo __('Nazwa produktu', null, 'appOnlineCodesMail');?>: <?php echo $code['product'];?> 
<?php echo __('Kod', null, 'appOnlineCodesMail');?>: <?php echo $code['code'];?> 
<?php endforeach;?>
 
<?php foreach($files as $file):?>
<?php echo __('Nazwa produktu', null, 'appOnlineCodesMail');?>: <?php echo $file['product'];?>  
<?php foreach($file['files'] as $f):?>
<?php echo __('Link do pliku', null, 'appOnlineCodesMail');?>: <?php echo online_codes_generate_download_link($order, $f['id']);?> 
<?php endforeach;?> 
<?php endforeach;?>