<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'ObjectAdmin', 'stDate', 'stProductImage', 'stCurrency') ?>
<?php use_helper('stWidgets', 'stOrder'); ?>
<?php use_stylesheet("backend/stDashboardGadget.css?v1", 'last'); ?>
<?php init_tooltip('#last_orders .tooltip', array('position' => 'center right', 'offset' => array(0, 10), 'width' => 'auto')) ?>

<div id="last_orders">
   <form action="<?php echo gadget_url_for('@stDashboardGadget?action=lastOrders') ?>" method="post"  class="admin_form">

         <div class="list_filters">
            <ul>
               <li>
                  <label for="filters_from_date"><?php echo __('Złożone', null, 'stOrder') ?></label>
                  <?php st_include_partial('stDashboardGadget/date_from_filter', array('filters' => $filters)) ?>
               </li> 
               <li>
                  <label for="filters_filter_order_status"><?php echo __('Status', null, 'stOrder') ?></label>
                  <?php st_include_partial('stOrder/filter_order_status', array('filters' => $filters, 'style' => 'max-width: 80px;')) ?>
               </li>
               <li>
                  <label for="filters_is_confirmed"><?php echo __('Potwierdzone', null, 'stOrder') ?></label>
                  <?php echo checkbox_tag('filters[is_confirmed]', 1, isset($filters['is_confirmed']) ? $filters['is_confirmed'] : null) ?>
               </li>
               <li>
                  <label for="filters_is_paid"><?php echo __('Opłacone', null, 'stOrder') ?></label>
                  <?php echo checkbox_tag('filters[is_paid]', 1, isset($filters['is_paid']) ? $filters['is_paid'] : null) ?>
               </li>   
               <li class="submit">
                  <input type="submit" value="<?php echo __('Filtruj', null, 'stAdminGeneratorPlugin') ?>" style='cursor: pointer; background-repeat: no-repeat; background-position: 5px center; background-color: #fff; line-height: 12px; min-height: 20px; padding: 3px 5px box-sizing: padding-box; -webkit-box-sizing:padding-box; -moz-box-sizing: padding-box; -ms-box-sizing: padding-box; margin-left: 10px; padding-left: 30px; padding-top: 5px; margin-top: 8px; padding-right: 30px; box-shadow: 1px 1px 1px #888888;' />
               </li>                      
            </ul>
            <div class="clr"></div>
         </div>

   </form>

   <?php if ($pager->getNbResults() > 0): ?>
   <div id="record_list_form" width="100%">
      <?php echo st_get_fast_partial('stAdminGenerator/list_pager', array('url' => gadget_url_for('@stDashboardGadget?action=lastOrders'), 'pager' => $pager, 'max_pages' => 5)) ?>
      <table class="st_record_list record_list" cellspacing="0" width="100%" style="border-width: 1px 0 0 0;">
         <colgroup>
            <col width="<?php echo $view == 'detailed' ? 120 : 100 ?>" />
            <col width="<?php echo $view == 'detailed' ? 120 : 100 ?>" style="min-width: 90px" />
            <col />
            <?php if ($view == 'detailed'): ?>
            <col width="100" />
            <?php endif; ?>
            <col width="100" />
            <?php if ($view == 'detailed'): ?>
            <col width="250" />
            <?php endif; ?>
            <col width="110" />
         </colgroup>
         <thead>
         <tr>
            <th style="border-left-width: 1px; border-left-style: solid;"><?php echo __('Numer', null, 'stOrder') ?></th>
            <th><?php echo __('Złożone', null, 'stOrder') ?></th>
            <th><?php echo __('Status', null, 'stOrder') ?></th>
            <?php if ($view == 'detailed'): ?>
            <th><?php echo __('Potwierdzone', null, 'stOrder') ?></th>
            <?php endif ?>
            <th><?php echo __('Opłacone', null, 'stOrder') ?></th>
            <?php if ($view == 'detailed'): ?>
            <th><?php echo __('Klient', null, 'stOrder') ?></th>
            <?php endif; ?>
            <th style="text-align: right; border-right-width: 1px; border-right-style: solid;"><?php echo __('Kwota', null, 'stOrder') ?></th>
         </tr>
         </thead>

         <tbody>
         <?php foreach ($pager->getResults() as $index => $order): ?>
            <tr class="<?php echo $index % 2 ? 'highlight' : '' ?> <?php if (!$order->getIsMarkedAsRead()): ?> marked_as_not_read<?php endif ?>">
               <td style="border-left-width: 1px; border-left-style: solid;">
                  <a href="<?php echo st_url_for('stOrder/edit?id=' . $order->getId()) ?>" target="_parent" <?php if ($view != 'detailed'): ?> class="list_tooltip" title="<?php echo st_order_info_tooltip($order) ?>"<?php endif ?>>
                     <?php echo $order->getNumber() ?>
                  </a>
               </td>
               <td>
                  <?php echo st_format_date($order->getCreatedAt(), 'dd-MM-yyyy H:mm') ?>
               </td>
               <td style="max-width: <?php echo $view != 'detailed' ? 80 : 270 ?>px">
                  <?php echo $order->getOptOrderStatus() ?>
               </td>
               <?php if ($view == 'detailed'): ?>
               <td class="column_boolean">
                  <?php echo $order->getIsConfirmed() ? image_tag('/images/backend/beta/icons/16x16/tick.png') : "&nbsp;" ?>
               </td>
               <?php endif; ?>
               <td class="column_boolean">
                  <?php st_include_partial('stOrder/is_payed', array('order' => $order)) ?>
               </td>
               <?php if ($view == 'detailed'): ?>
               <td style="max-width: 250px">
                     <?php echo st_order_client_name($order, '_parent') ?>
               </td>
               <?php endif; ?>
               <td style="text-align: right; white-space: nowrap; border-right-width: 1px; border-right-style: solid;">
                  <?php echo st_order_price_format($order->getOptTotalAmount(), $order->getOrderCurrency()) ?>
               </td>
            </tr>
         <?php endforeach; ?>
         </tbody>
         <tfoot>
            <tr>
               <td style="text-align: right; padding-right: 0px; border:" colspan="<?php echo $view == 'detailed' ? 6 : 4 ?>"><?php echo __('Łącznie', null, 'stOrder') ?>:</td>
               <td style="text-align: right; font-weight: bold; white-space: nowrap"><?php echo st_back_price($total_amount, true, true) ?></td>
            </tr>
         </tfoot>
      </table>
   </div>
   <?php else: ?>
   <p style="margin-top: 0px; padding-left: 15px;"><?php echo __('Brak zamówień', null, 'stOrder')  ?></p>
   <?php endif; ?>
</div>