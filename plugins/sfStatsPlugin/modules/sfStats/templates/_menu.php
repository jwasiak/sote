<?php use_stylesheet('backend/style.css'); ?>
<div class="st_horizontal_list">
    <ul>        
        <li>
            <?php if ($sf_request->getParameter('index')): ?>
                <b><?php echo link_to(__('Raporty'),'sfStats')?></b>
            <?php else: ?>
            	<?php echo link_to(__('Raporty'),'sfStats')?>
            <?php endif; ?>
        </li>   
         
        <li>
            <?php if ($sf_request->getParameter('config')): ?>
                <b><?php echo link_to(__('Konfiguracja raportów'),'sfStats/config')?></b>
            <?php else: ?>
                <?php echo link_to(__('Konfiguracja raportów'),'sfStats/config')?>
            <?php endif; ?>
        </li>
    </ul>
</div>