<div style="text-align: left">
   <?php if ($theme->getVersion() < 2): ?>
      <?php if ($theme->getActive()): ?>
         <?php echo st_external_link_to(__('edycja wyglądu'), 'http://'.stSoteshop::getServerName().'/frontend_edit.php?lang='.stLanguage::getLayoutLanguage()); ?>
      <?php endif; ?>
   <?php else: ?>
      <a class="st_admin_external_link" target="_blank" href="http://<?php echo $sf_request->getHost() ?>/frontend_theme.php?theme=<?php echo $theme->getName() ?>&lang=<?php echo stLanguage::getLayoutLanguage() ?>"><?php echo __('podgląd') ?></a>
   <?php endif; ?>
</div>