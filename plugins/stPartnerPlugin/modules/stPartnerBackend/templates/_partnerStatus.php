<?php if($create==false): ?>
        
    <?php echo __('Przejdz do konta partnera') ?> : <?php echo link_to( __($user->getUsername()),'partner/edit/?id='.$partner->getId()) ?><br/>
    
    <?php if($partner->getProvision()!=""): ?>
        <span ><?php echo __('Stawka prowizji procentowej') ?>:&nbsp;<b><?php echo $partner->getProvision(); ?>%</b><br /></span>
     <?php endif; ?>
     
     <?php if($partner->getAmount()!=""): ?>
        <span ><?php echo __('Stawka prowizji kwotowej') ?>:&nbsp;<b><?php echo $partner->getAmount(); ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
     <?php endif; ?>
    
     <?php if($partner->getAmount()=="" && $partner->getProvision()==""): ?>
        <span ><?php echo __('Nie przyznano prowizji od transakcji.') ?></span><br/>
     <?php endif; ?>
     
     <?php if($provisionAll!=""): ?>
        <span ><?php echo __('Całkowita prowizja') ?>:&nbsp;<b><?php echo $provisionAll; ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
     <?php endif; ?>
                 
     <?php if($provisionPayed!=""): ?>
        <span ><?php echo link_to(__('Rozliczona prowizja'),'partner/orderList/?partner_id='.$partner->getId().'&filters[provision_payed]=1') ?>:&nbsp;<b><?php echo $provisionPayed; ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
     <?php endif; ?>
     
     <?php if($provisionNotPayed!=""): ?>
        <span ><?php echo link_to( __('Nierozliczona prowizja'),'partner/orderList/?partner_id='.$partner->getId().'&filters[provision_payed]=0') ?>:&nbsp;<b><?php echo $provisionNotPayed; ?>&nbsp;</b><?php echo __('PLN') ?><br /></span>
     <?php endif; ?>
     
     <?php if($provisionPayed=="" && $provisionNotPayed==""): ?>
        <span ><?php echo __('Brak transakcji do rozliczenia.') ?></span>
     <?php endif; ?>
     
 
<?php endif; ?>
 
<?php if($create==true): ?>
    
    <?php echo link_to(__('Utwórz konto partnera dla tego użytkownika.'),'partner/createAccount/?user_id='.$user->getId()) ?>
        
<?php endif; ?>