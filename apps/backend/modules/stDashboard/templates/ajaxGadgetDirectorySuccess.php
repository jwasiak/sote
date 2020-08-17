<div class="close" style="position: absolute; right: -20px; text-align: right; top: -20px; width: 100%;"><a href="#"><img src="/images/frontend/theme/default2/buttons/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></a></div>
<h2><?php echo __('Katalog gadżetów', null, 'stBackend') ?></h2>
<div class="content">
   <ul class="tabs">
<?php foreach ($categories as $category => $gadgets): ?>
      <li><a href="#"><?php echo __($category, null, 'stBackend') ?> (<?php echo count($gadgets) ?>)</a></li>
<?php endforeach; ?>
   </ul>
   <div class="panes">
<?php foreach ($categories as $category => $gadgets): $count = 0; $gadgets_num = count($gadgets) ?>
      <div style="display: none">
         <ul>
<?php foreach ($gadgets as $name => $gadget): 
$count++;
$i18n_catalogue = isset($gadget['i18n']) ? $gadget['i18n'] : 'stBackend';
$description = __($gadget['description'], null, $i18n_catalogue);
 ?>
            <li class="gadget">
               <div class="thumb"><img src="<?php echo isset($gadget['thumb']) ? $gadget['thumb'] : '/images/backend/main/icons/stDefaultApp.png' ?>" /></div>
               <div class="add"><a href="#<?php echo $name ?>"></a></div>
               <div class="content">
                  <h3><?php echo __($gadget['title'], null, $i18n_catalogue) ?></h3>
<?php if (isset($gadget['author']['website'])): ?>
                  <div class="author"><a href="<?php echo __($gadget['author']['website'], null, $i18n_catalogue) ?>" target="_blank"><?php echo __($gadget['author']['name'], null, $i18n_catalogue) ?></a></div>
<?php else: ?>
                  <div class="author"><?php echo __($gadget['author']['name'], null, $i18n_catalogue) ?></div>
<?php endif; ?>
                  <div class="description"><?php echo mb_strlen($description) > 90 ? mb_substr($description, 0, 90).'...' : $description ?></div>
               </div>
            </li>
<?php if ($count % 2 == 0 && $count < $gadgets_num): ?>
         </ul>
         <ul>
<?php endif; ?>
<?php endforeach; ?>
         </ul>
      </div>
<?php endforeach; ?>   
      <div class="clr"></div> 
   </div>
</div>
<div class="footer"></div>