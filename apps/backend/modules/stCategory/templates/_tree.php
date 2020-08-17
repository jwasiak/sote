<ul class="st_category_tree_filter">
   <li class="category_row">
      <?php
      $i = 0;
      $w = 5;
      foreach ($roots as $root): 
      ?>
         <ul>
            <li>
               <span class="name-tree"><?php echo $root->getName() ?></span>
               <?php echo st_get_partial('stCategory/categories', array('parent' => $root, 'expanded' => $expanded, 'selected' => $selected, 'url' => $url)) ?>
            </li>
         </ul>

      <?php
      if($i%$w == 4) 
      {
         echo "</li><li class='category_row'>";
      }
      $i++; 
      endforeach; ?>
   </li>
</ul>

<script type="text/javascript">
   jQuery(function($) {
      $('.st_category_tree_filter').on('click', '.expandable', function() {
         var image = $(this);
         var link = image.next();

         if (!link.next('ul').length) {
            var src = image.attr('src');
            image.attr('src', '/images/backend/beta/gadgets/preloader/26x26.gif');
            $.post("<?php echo st_url_for('@stCategory?action=ajaxCategoryFilterChildren') ?>?id="+link.data('id'), { url: "<?php echo $url ?>" }, function(data) {
               link.after(data);
               link.next().addClass('open');
               image.attr('src', src);
            });
         }  else {
            link.next().toggleClass('open');
         }
      });
   });
</script>