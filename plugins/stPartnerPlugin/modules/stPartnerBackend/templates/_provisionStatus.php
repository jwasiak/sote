
<?php if($provisionAll!=""): ?>
    <span ><?php echo __('Całkowita prowizja') ?>:&nbsp;<b><?php echo $provisionAll; ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
<?php endif; ?>
         
<?php if($provisionPayed!=""): ?>
    <span ><?php echo link_to(__('Rozliczona prowizja'),'partner/orderList/?partner_id='.$id.'&filters[provision_payed]=1') ?>:&nbsp;<b><?php echo $provisionPayed; ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
<?php endif; ?>

<?php if($provisionNotPayed!=""): ?>
    <span ><?php echo link_to( __('Nierozliczona prowizja'),'partner/orderList/?partner_id='.$id.'&filters[provision_payed]=0') ?>:&nbsp;<b><?php echo $provisionNotPayed; ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
<?php endif; ?>

<?php if($provisionPayed=="" && $provisionNotPayed==""): ?>
    <span ><?php echo __('Brak transakcji do rozliczenia.') ?></span>
<?php endif; ?>