<div class="application-menu">
    <ul>  

        <li class="selected">
            <?php echo link_to(__('Piksel Facebooka'),'appFacebookRemarketingBackend/index')?>
        </li>

        <li>
            <?php if (is_dir(sfConfig::get('sf_plugins_dir')."/appMessengerPlugin")): ?> 
                <?php echo link_to(__('Messenger'),'appMessengerBackend/index')?>
            <?php else: ?>
                <?php if (sfContext::getInstance()->getUser()->getCulture() == 'pl_PL'): ?>
                    <a href="http://www.sote.pl/messenger.html" target="_blank"><?php echo __('Messenger'); ?></a>
                <?php else: ?>
                    <a href="https://www.soteshop.com/messenger.html" target="_blank"><?php echo __('Messenger'); ?></a>
                <?php endif; ?>
            <?php endif; ?>
        </li>
         
        
        <li>
            <?php if (is_dir(sfConfig::get('sf_plugins_dir')."/appFacebookPlugin")): ?> 
                <?php echo link_to(__('Facebook'),'appFacebookBackend/config')?>
            <?php else: ?>
                <?php if (sfContext::getInstance()->getUser()->getCulture() == 'pl_PL'): ?>
                    <a href="https://www.sote.pl/facebook.html" target="_blank"><?php echo __('Facebook'); ?></a>
                <?php else: ?>
                    <a href="https://www.soteshop.com/facebook.html" target="_blank"><?php echo __('Facebook'); ?></a>
                <?php endif; ?>
            <?php endif; ?>
        </li>
        
        <li>
            <?php if (is_dir(sfConfig::get('sf_plugins_dir')."/appFbfeedPlugin")): ?> 
                <?php echo link_to(__('Sklep na Facebooku'),'appFbfeedBackend/list')?>
            <?php else: ?>
                <?php if (sfContext::getInstance()->getUser()->getCulture() == 'pl_PL'): ?>
                    <a href="https://www.sote.pl/sklep-na-facebooku.html" target="_blank"><?php echo __('Sklep na Facebooku'); ?></a>
                <?php else: ?>
                    <a href="http://www.soteshop.com/shop-on-facebook.html" target="_blank"><?php echo __('Shop on Facebook'); ?></a>
                <?php endif; ?>
            <?php endif; ?>
        </li>

    </ul>
</div>

<div class="clr"></div>