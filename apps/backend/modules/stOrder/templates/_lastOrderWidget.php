<?php use_helper('stWidgets');?>
<?php echo st_open_widget('Order',__('Zamówienia'));?>

      <div style="float:right;">
         <?php echo __('Ostatnie', null, 'stBackendMain'); ?>:

         <?php if($date_type == "day"): ?>
            <b><?php echo link_to_remote(__('24h', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=day',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('24h', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=day',)) ?>
         <?php endif; ?>

         <?php if($date_type == "week"): ?>
            <b><?php echo link_to_remote(__('7 dni', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=week',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('7 dni', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=week',)) ?>
         <?php endif; ?>

         <?php if($date_type == "month"): ?>
            <b><?php echo link_to_remote(__('miesiąc', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=month',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('miesiąc', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=month',)) ?>
         <?php endif; ?>

         <?php if($date_type == "lastlog"): ?>
            <b><?php echo link_to_remote(__('logowanie', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=lastlog',)) ?></b>
         <?php else: ?>
            <?php echo link_to_remote(__('logowanie', null, 'stBackendMain'), array('update'=>'last-order-widget', 'url'=>'stOrder/lastOrderWidget?date_type=lastlog',)) ?>
         <?php endif; ?>

      </div>

        <b><?php echo st_link_to(__('Wartość'), 'stOrder/'); ?></b> (<?php echo $orderQuantity; ?>)

        <?php if($price == ""): ?>
        <?php $price = 0; ?>
        <?php endif; ?>

        <b><?php echo st_back_price($price, true, true) ?></b>
    
        <table class="st_record_list" cellspacing="0" width="100%;">
            <thead>
            <tr>
                <th width="20px"><?php echo __('nr') ?></th>
                <th width="60px"><?php echo __('złożone') ?></th>
                <th width="20px"><?php echo __('pot.') ?></th>
                <th><?php echo __('klient') ?></th>
                <th width="80px"><?php echo __('kwota') ?></th>
            </tr>
            </thead>

            <tbody>
            <?php $i = 1; ?>
            <?php foreach ($orders as $index => $order): ?>

            <?php if($i <= 20): ?>
            <tr class="<?php
            $date = explode(" ",$order->getCreatedAt());
            if($date[0]== date('Y-m-d')){ echo ' st_row-new';}else{
            echo $index % 2 ? 'st_row-highlight' : 'st_row-no-highlight';
            };
            ?>">
                <td><?php echo st_link_to($order->getNumber(), 'stOrder/edit?id='.$order->getId()); ?></td>

                <td>
                    <?php


                    $createdAt = explode(" ",$order->getCreatedAt());

                    $d = $createdAt[0];
                    $t = $createdAt[1];

                    $d = explode("-",$d);

                    if(date('Y-m-d')==$createdAt[0])
                    {
                        echo $time = $createdAt[1];
                    }
                    else
                    {
                        echo $d[2]."-".$d[1]."-".$d[0];
                    }


                    ?>
                </td>
                <td><?php if($order->getIsConfirmed()==1): echo image_tag('/sf/sf_admin/images/tick.png'); else: echo "-"; endif; ?></td>

                <td>
                    <div style="text-align: left">
                    <?php if ($order->getOrderUserDataBillingId()): ?>

                        <?php if ($order->getsfGuardUserId()): ?>

                        <?php if ($order->getOrderUserDataBilling()->getCompany()): ?>
                            <?php echo st_external_link_to( $order->getOrderUserDataBilling()->getCompany(), 'user/edit?id=' . $order->getsfGuardUserId()) ?>
                        <?php else: ?>
                        <?php if($order->getOrderUserDataBilling()->getName() && $order->getOrderUserDataBilling()->getSurname()): ?>
                            <?php echo st_external_link_to($order->getOrderUserDataBilling()->getName()." ".$order->getOrderUserDataBilling()->getSurname(), 'user/edit?id=' . $order->getsfGuardUserId()) ?>
                        <?php else: ?>
                            <?php echo st_external_link_to(truncate_text($order->getsfGuardUser()->getUsername(), 25), 'user/edit?id=' . $order->getsfGuardUserId()) ?>
                        <?php endif; ?>

                        <?php endif; ?>

                    <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </td>
                <td>
                    <?php echo st_back_price($order->getTotalAmount(true), true, true) ?>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endif; ?>

            <?php endforeach ; ?>
            </tbody>
        </table>
      

        <br/>
        <?php if ($countOrder!=0): ?>
        <?php echo __('Zamówienia o statusie "oczekuje"') ?>: <b><?php echo $countOrder; ?></b> <?php echo st_link_to(__('pokaż'), 'order/list?filters[filter_order_status]=2'); ?>
        <?php else: ?>
        <br>
        <?php endif; ?>
        <br>
        <?php if ($countInvoice!=0): ?>
        <?php echo __('Faktury do wystawienia') ?>: <b><?php echo $countInvoice; ?></b> <?php echo st_link_to(__('pokaż'), 'invoice/requestList'); ?>
        <?php else: ?>
        <br>
        <?php endif; ?>

<?php echo st_close_widget(); ?>