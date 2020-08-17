<?php use_helper('I18N', 'Text', 'stAdminGenerator', 'Object', 'ObjectAdmin', 'stDate', 'stProductImage','stCurrency') ?>
<?php use_helper('stWidgets'); ?>

	<div class="list_filters">
      <div style="float:right;">

         <?php echo __('Ostatnie', null, 'stBackendMain'); ?>:

         <?php if($date_type == "day"): ?>
            <b><?php echo st_link_to(__('24h', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=day'); ?></b>
         <?php else: ?>
            <?php echo st_link_to(__('24h', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=day'); ?>
         <?php endif; ?>

         <?php if($date_type == "week"): ?>
            <b><?php echo st_link_to(__('7 dni', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=week'); ?></b>
         <?php else: ?>
            <?php echo st_link_to(__('7 dni', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=week'); ?>
         <?php endif; ?>

         <?php if($date_type == "month"): ?>
            <b><?php echo st_link_to(__('miesiąc', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=month'); ?></b>
         <?php else: ?>
            <?php echo st_link_to(__('miesiąc', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=month'); ?>
         <?php endif; ?>

         <?php if($date_type == "lastlog"): ?>
            <b><?php echo st_link_to(__('logowanie', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=lastlog'); ?></b>
         <?php else: ?>
            <?php echo st_link_to(__('logowanie', null, 'stBackendMain'),'stUser/registerUserWidget?date_type=lastlog'); ?>
         <?php endif; ?>


      </div>

      <?php echo st_link_to(__('Nowi Klienci'), 'stUser/'); ?> (<?php echo $userQuantity; ?>)

		</div>

         <?php if($userInfo!=""): ?>
     	<div id="sf_admin_container">
      		<table class="st_record_list" cellspacing="0" width="100%">
      		<tbody>

         <?php foreach ($userInfo as $index => $user): ?>
         <tr class="<?php
         $date = explode(" ",$user['created_at']);
         if($date[0]== date('Y-m-d')){ echo ' st_row-new';}else{
         echo $index % 2 ? 'st_row-highlight' : 'st_row-no-highlight';
         };
         ?>">

             <td>
                 <div style="text-align: left">
                 <?php if ($user['id']): ?>

                     <?php if ($user['company']!=""): ?>
                         <?php echo $user['company'] ?>
                     <?php else: ?>
                         <?php echo $user['fullname'] ?>
                     <?php endif; ?>

                 <?php endif; ?>

                 <?php if ($user['id']): ?>
                 <?php echo st_external_link_to(truncate_text($user['username'], 25), 'user/edit?id=' . $user['id']) ?>
                 <?php endif; ?>
                 </div>

             </td>
         </tr>
         
         <?php endforeach ; ?>
         
         </tbody>
      </table>
   </div>

      <?php else: ?>
      	<p style="text-align: center; margin-top: 20px"><?php echo __('Brak klientów') ?></p>
         
      <?php endif; ?>

      