<?php use_helper('I18N', 'stDate'); ?>
<?php use_stylesheet("backend/stDashboardGadget.css?v1", 'last'); ?>
<div id="last_registered_clients">
   <form action="<?php echo gadget_url_for('@stDashboardGadget?action=lastRegisteredClients') ?>" method="post"  class="admin_form">

         <div class="list_filters">
            <ul>
               <li>
                  <label for="filters_from_date"><?php echo __('Zarejestrowani', null, 'stBackend') ?></label>
                  <?php st_include_partial('stDashboardGadget/date_from_filter', array('filters' => $filters)) ?>
               </li>   
               <li>
                  <label for="filters_is_confirmed"><?php echo __('Potwierdzeni', null, 'stBackend') ?></label>
                  <?php echo checkbox_tag('filters[is_confirmed]', 1, isset($filters['is_confirmed']) ? $filters['is_confirmed'] : null) ?>
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
       <?php echo st_get_fast_partial('stAdminGenerator/list_pager', array('url' => gadget_url_for('@stDashboardGadget?action=lastRegisteredClients'), 'pager' => $pager, 'max_pages' => 5)) ?>
      <table class="st_record_list record_list" cellspacing="0" width="100%">
         <colgroup>
            <col<?php if ($view != 'detailed'): ?> width="150"<?php endif ?> />
            <col<?php if ($view != 'detailed'): ?> width="130"<?php endif ?> />
            <col />
            <col width="120" />
            <?php if ($view == 'detailed'): ?>
            <col width="100" />
            <?php endif ?>
         </colgroup>
         <thead>
         <tr>
            <th><?php echo __('Login', null, 'stUser') ?></th>
            <th><?php echo __('Imię i nazwisko', null, 'stUser') ?></th>
            <th><?php echo __('Firma', null, 'stUser') ?></th>
            <th><?php echo __('Zarejestrowany', null, 'stBackend') ?></th>
            <?php if ($view == 'detailed'): ?>
            <th><?php echo __('Potwierdzony', null, 'stBackend') ?></th>
            <?php endif ?>
         </tr>
         </thead>

         <tbody>
         <?php foreach ($pager->getResults() as $index => $user): $address = isset($user_data[$user->getId()]) ? $user_data[$user->getId()] : null ?>

            <tr class="<?php echo $index % 2 ? 'highlight' : '' ?>">
               <td><a target="_parent" href="<?php echo st_url_for('stUser/edit?id='.$user->getId()) ?>"><?php echo $user->getUsername() ?></a></td>
               <td style="min-width: 120px"><?php echo $address ? $address->getFullname() : '&nbsp;' ?></td>
               <td style="min-width: 120px"><?php echo $address ? $address->getCompany() : '&nbsp;' ?></td>
               <td><?php echo st_format_date($user->getCreatedAt()) ?></td> 
               <?php if ($view == 'detailed'): ?>
               <td style="text-align: center"><?php echo $user->getIsConfirm() ? image_tag('/images/backend/beta/icons/16x16/tick.png') : "&nbsp;" ?></td>
               <?php endif ?>    
            </tr>

         <?php endforeach; ?>
         </tbody>
      </table>
   </div>
   <?php else: ?>
   <p style="margin-top: 0px; padding-left: 15px;"><?php echo __('Brak klientów', null, 'stUser')  ?></p>
   <?php endif; ?>
</div>