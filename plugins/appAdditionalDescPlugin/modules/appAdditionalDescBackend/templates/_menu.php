<div class="st_horizontal_list">
    <ul>        
        <li>
            <?php if ($sf_request->getParameter('action')=="index" ): ?>
                <b><?php echo link_to(__('Konfiguracja dodatkowego opisu produktu'),'appAdditionalDescBackend/index')?></b>
            <?php else: ?>
            	<?php echo link_to(__('Konfiguracja dodatkowego opisu produktu'),'appAdditionalDescBackend/index')?>
            <?php endif; ?>
        </li>
         
        <li>
            <?php if ($sf_request->getParameter('action')=="info" ): ?>
                <b><?php echo link_to(__('Informacje o module'),'appAdditionalDescBackend/info')?></b>
            <?php else: ?>
                <?php echo link_to(__('Informacje o module'),'appAdditionalDescBackend/info')?>
            <?php endif; ?>
        </li>
    </ul>
</div>