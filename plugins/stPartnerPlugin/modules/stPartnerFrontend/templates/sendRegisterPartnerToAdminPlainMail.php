<?php 
use_helper('stCurrency');
/**
 * @package    stOrder
 */
?>
        
<?php echo __('Dane partnera:') ?>

<?php echo $partnerData->getCompany() ?>

<?php echo __('NIP:') ?> <?php echo $partnerData->getVatNumber(); ?>

<?php echo $partnerData->getName().' '.$partnerData->getSurname()?>
  
<?php echo $partnerData->getStreet().'  '.$partnerData->getHouse().' '.$partnerData->getFlat().' , '.$partnerData->getCode().'  '.$partnerData->getTown()?>