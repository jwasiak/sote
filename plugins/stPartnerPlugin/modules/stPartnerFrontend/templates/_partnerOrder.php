<?php use_helper('Validation', 'Form', 'stOrder', 'Date'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php 
sfContext::getInstance()->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
?>

 <?php echo form_tag('stPartnerFrontend', array('class' => 'st_form', 'name'=>'show')) ?>
 
          <div class="st_row">
            <div style="float:left;">
            <?php echo input_date_tag('data1', $data1, _parse_attributes(array (
                'rich' => true,
                'withtime' => true,
                'calendar_button_img' => '/sf/sf_admin/images/date.png',
                'size' => 17,
             ))) ?>
          
             
             <?php echo input_date_tag('data2', $data2, _parse_attributes(array (
                'rich' => true,
                'withtime' => true,
                'calendar_button_img' => '/sf/sf_admin/images/date.png',
                'size' => 17,
             ))) ?>
             </div>
             
            <div style="margin-left:5px;" class="st_button st_align-left">
                <div class="st_button-left">
                    <?php echo submit_tag(__('Pokaż')) ?>                        
                </div>
            </div>
             
          </div>   
               
<br class="st_clear_all" />               

<?php echo radiobutton_tag('status', 'off', $checked1) ?> <?php echo __('wszystkie') ?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo radiobutton_tag('status', '1', $checked2) ?> <?php echo __('rozliczone') ?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo radiobutton_tag('status', '0', $checked3) ?> <?php echo __('nierozliczone') ?>

</form>

    <?php if (empty($orders)): ?>
    <p><?php echo __('Brak zamówień.') ?></p>
    
    <?php else: ?>
        
    <?php if ($data1==""): ?>
    
    <p><?php echo __('Łączna kwota prowizji') ?>: <b><?php echo $provision ?></b> PLN</p>
    <?php else: ?>
    
    <p><?php echo __('Łączna kwota prowizji za okres od') ?>: <b><?php echo $data1; ?></b> <?php echo __('do') ?>: <b><?php echo $data2; ?></b> <?php echo __('wynosi') ?>: <b><?php echo $provision ?></b> PLN</p>
    <?php endif; ?>
 <?php foreach ($orders as $order): ?>
    <div class="st_order-last_order">
        <div><?php echo __('ID') ?>: <?php echo $order->getId(); ?> | <?php echo $order->getCreatedAt(); ?> | <?php echo __('Kwota zamówienia') ?>: <?php echo st_order_total_amount($order) ?> | <?php echo __('Wartość prowizji') ?>: <?php echo $order->getProvisionValue(); ?></div>
        <ul>
            <?php foreach ($order->getOrderProducts() as $order_product): ?>
            <li> - <?php echo $order_product->getQuantity() ?> x <?php echo $order_product->getName() ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <br />
    <?php endforeach; ?>
    
    <?php endif; ?>