<?php 
use_helper('I18N', 'stProductImage');
use_helper('stWidgets', 'stOrder');
sfLoader::loadHelpers('stProduct', 'stProduct');
use_stylesheet("backend/stDashboardGadget.css?v1", 'last');
use_stylesheet("backend/stProductList.css?v6"); 
?>


<div id="last_ordered_products">
   <form action="<?php echo gadget_url_for('@stDashboardGadget?action=recentlyOrderedProducts') ?>" method="post"  class="admin_form">

         <div class="list_filters">
            <ul>
               <li>
                  <label for="filters_from_date"><?php echo __('Sprzedane', null, 'stBackend') ?></label>
                  <?php st_include_partial('stDashboardGadget/date_from_filter', array('filters' => $filters)) ?>
               </li>
               <li>
                  <label for="filters_filter_order_status"><?php echo __('Status', null, 'stOrder') ?></label>
                  <?php st_include_partial('stOrder/filter_order_status', array('filters' => $filters)) ?>
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
   <div id="record_list_form">
       <?php echo st_get_fast_partial('stAdminGenerator/list_pager', array('url' => gadget_url_for('@stDashboardGadget?action=recentlyOrderedProducts'), 'pager' => $pager, 'max_pages' => 5)) ?>
      <table class="st_record_list record_list" cellspacing="0" width="100%">
         <thead>
         <tr>
            <th width="40"><?php echo __('Zdjęcie', null, 'stProduct') ?></th>
            <th><?php echo __('Nazwa', null, 'stProduct') ?></th>
            <th width="70"><?php echo __('Kod', null, 'stOrder') ?></th>
            <th width="80"><?php echo __('Ilość', null, 'stOrder') ?></th>
         </tr>
         </thead>

         <tbody>
         <?php foreach ($pager->getResults() as $index => $product): ?>

            <tr class="<?php echo $index % 2 ? 'highlight' : '' ?>">
               <td><?php echo list_product_image($product, '_parent') ?></td>

               <td>
                  <a target="_parent" href="<?php echo st_url_for('@stProductEdit?id='.$product->getId()) ?>"><?php echo $product->getName() ?></a>
               </td>
               <td>
                  <?php echo $product->getCode() ?>
               </td>
               <td style="white-space: nowrap">
                  <?php echo $product->_order_quantity ?> <?php echo st_product_uom($product) ?>
               </td>
            </tr>

         <?php endforeach; ?>
         </tbody>
      </table>
   </div>
   <?php else: ?>
   <p style="margin-top: 0px; padding-left: 15px;"><?php echo __('Brak produktów', null, 'stProduct')  ?></p>
   <?php endif; ?>
</div>