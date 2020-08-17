<?php if (sfContext::getInstance()->getUser()->getCulture()=="pl_PL"): ?>
<span>Pomoc</span>
<ul>
    <li><?php echo st_link_to('Dokumentacja',"https://www.sote.pl/docs/dokumentacja", array('target' => '_blank'))?></li>
    <li><?php echo st_link_to('Wyślij zgłoszenie',"https://serwis.sote.pl", array('target' => '_blank'))?></li>    
</ul>
<?php else: ?>
    <span>Help</span>
<ul>
    <li><?php echo st_link_to('Documentation',"https://www.soteshop.com/docs/documentation", array('target' => '_blank'))?></li>
    <li><?php echo st_link_to('Send an request',"https://serwis.sote.pl", array('target' => '_blank'))?></li>    
</ul>
    
<?php endif; ?>    