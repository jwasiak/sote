<div class="application-menu">
    <ul>        
        <?php if ($sf_request->getParameter('action')=="index" ): ?>
            <li class="selected"><?php echo link_to(__('Dodawanie produktów do porównywarek cen'),'stPriceCompare/index')?></li>
        <?php else: ?>
            <li class="none"><?php echo link_to(__('Dodawanie produktów do porównywarek cen'),'stPriceCompare/index')?></li>
        <?php endif; ?>
        <?php if ($sf_request->getParameter('action')=="config" ): ?>
            <li class="selected"><?php echo link_to(__('Konfiguracja'),'stPriceCompare/config')?></li>
        <?php else: ?>
            <li class="none"><?php echo link_to(__('Konfiguracja'),'stPriceCompare/config')?></li>
        <?php endif; ?>
        <li class="none"><?php echo link_to(__('Ceneo'),'stCeneoBackend')?></li>
        <li class="none"><?php echo link_to(__('Nokaut'),'stNokautBackend')?></li>
        <li class="none"><?php echo link_to(__('Okazje'),'stOkazjeBackend')?></li>
        <li class="none"><?php echo link_to(__('Radar'),'stRadarBackend')?></li>
        <li class="none"><?php echo link_to(__('Sklepy24'),'stSklepy24Backend')?></li>
        <li class="clear_item"></li>
    </ul>
</div>
<br style="clear: left">