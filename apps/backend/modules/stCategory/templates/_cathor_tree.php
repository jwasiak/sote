<?php
  $c = new Criteria();
  $c->add(CategoryPeer::PARENT_ID, NULL);
  $categories =  CategoryPeer::doSelect($c);

  if($categories)
  {
     foreach ($categories as $category)
     {
        $select[$category->getId()] = $category->getOptName();
     }
  }
  else
  {
     $select = 0;
  }
?>
<label><?php echo __('Drzewo kategorii') ?></label>
<div class="content">
          <?php if($select!=0): ?>
             <?php echo select_tag('config[cathor_tree]', options_for_select($select,
                   array($config->get('cathor_tree'))
               )) ?>
          <?php else: ?>
              <?php echo __('Brak drzew kategorii'); ?>
          <?php endif; ?>
        <br class="st_clear_all">
</div>