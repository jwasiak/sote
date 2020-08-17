<?php $query_div = strpos($url, '?') !== false ? '&' : '?' ?>
<?php if ($pager->haveToPaginate()): ?>
<ul class="pager float_left">
<?php if ($pager->getPage() == 1): ?>
   <li class="first">
      <b>
         <img src="/images/backend/beta/icons/16x16/go_first_arrow.png" alt="<?php echo __('pierwsza', null, 'stAdminGeneratorPlugin') ?>" />
      </b>
   </li>
   <li class="prev">
      <b>
         <img src="/images/backend/beta/icons/16x16/go_prev_arrow.png" alt="<?php echo __('poprzednia', null, 'stAdminGeneratorPlugin') ?>" />
      </b>          
   </li>
<?php else: ?>
   <li class="first">
      <a href="<?php echo $url ?><?php echo $query_div ?>page=1">
         <img src="/images/backend/beta/icons/16x16/go_first_arrow.png" alt="<?php echo __('pierwsza', null, 'stAdminGeneratorPlugin') ?>" />
      </a>
   </li>
   <li class="prev">
      <a href="<?php echo $url ?><?php echo $query_div ?>page=<?php echo $pager->getPreviousPage() ?>">
         <img src="/images/backend/beta/icons/16x16/go_prev_arrow.png" alt="<?php echo __('poprzednia', null, 'stAdminGeneratorPlugin') ?>" />
      </a>          
   </li>
<?php endif ?>  
<?php foreach ($pager->getLinks(isset($max_pages) ? $max_pages : 10) as $page): ?>
   <li class="page">
   <?php if ($page == $pager->getPage()): ?>
      <b><?php echo $page ?></b>
   <?php else: ?>
      <a href="<?php echo $url ?><?php echo $query_div ?>page=<?php echo $page ?>"><?php echo $page ?></a> 
   <?php endif ?>
   </li>
<?php endforeach; ?>
<?php if ($pager->getPage() == $pager->getLastPage()): ?>
   <li class="next">
      <b>
         <img src="/images/backend/beta/icons/16x16/go_next_arrow.png" alt="<?php echo __('następna', null, 'stAdminGeneratorPlugin') ?>" />
      </b>
   </li>
   <li class="last">
      <b>
         <img src="/images/backend/beta/icons/16x16/go_last_arrow.png" alt="<?php echo __('ostatnia', null, 'stAdminGeneratorPlugin') ?>" />
      </b>          
   </li>
<?php else: ?>
   <li class="next">
      <a href="<?php echo $url ?><?php echo $query_div ?>page=<?php echo $pager->getNextPage() ?>">
         <img src="/images/backend/beta/icons/16x16/go_next_arrow.png" alt="<?php echo __('następna', null, 'stAdminGeneratorPlugin') ?>" />
      </a>
   </li>
   <li class="last">
      <a href="<?php echo $url ?><?php echo $query_div ?>page=<?php echo $pager->getLastPage() ?>">
         <img src="/images/backend/beta/icons/16x16/go_last_arrow.png" alt="<?php echo __('ostatnia', null, 'stAdminGeneratorPlugin') ?>" />
      </a>          
   </li>
<?php endif ?>
   <li class="jump_to_page">
      <?php echo input_tag('product_page', $pager->getPage(), array('maxlength' => 4, 'size' => 3)) ?>
      <a href="<?php echo $url ?>">
         <img style="vertical-align: middle" src="/images/backend/beta/icons/16x16/go_next_arrow.png" alt="<?php echo __('przejdź do strony', null, 'stAdminGeneratorPlugin') ?>" />
      </a>
   </li>
</ul>
<?php endif; ?>

<?php if ($pager->getNbResults() > 10): ?>
<ul class="pager_controls float_right">

   <li>
   <?php echo select_tag('max_per_page', options_for_select(array(
      10 => 10,
      20 => 20,
      50 => 50,
      100 => 100,
   ), $pager->getMaxPerPage()));
   ?>
   </li>
 
<?php if ($pager->getNbResults() > 10): ?>
   <li>
      <?php echo __('z %1%', array('%1%' => $pager->getNbResults()), 'stAdminGeneratorPlugin') ?>
   </li>
<?php endif; ?>     
</ul> 
<?php endif; ?> 
<div class="clr"></div>          

<script type="text/javascript">
   jQuery(function($) {
      $(document).ready(function() {
         var jump_to_page = $('ul.pager > .jump_to_page');

         var input = jump_to_page.children('input');

         var link = jump_to_page.children('a');

         link.click(function(event) {
            window.location = this.href+'<?php echo $query_div ?>page='+input.val();
            event.preventDefault();
         });

         input.change(function() {
            this.value = this.value.replace(/[^0-9]/g, '').replace(/$0+/g, '');
         });

         input.keypress(function(event) {
            if (event.keyCode == 13)
            {
               window.location = link.attr('href')+'<?php echo $query_div ?>page='+this.value;
               event.preventDefault();
            }
         });

         $('#max_per_page').change(function() {
            var selected = this.options[this.selectedIndex].value;

            window.location = '<?php echo $url ?><?php echo $query_div ?>max_per_page='+selected;
         });
      });

   });
</script>