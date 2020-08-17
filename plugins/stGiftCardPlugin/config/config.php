<?php
if (SF_APP == 'backend')
{
   stPluginHelper::addEnableModule('stGiftCardBackend', 'backend');
   stPluginHelper::addRouting('stGiftCardPlugin', '/giftcard/:action/*', 'stGiftCardBackend', 'list', 'backend');
   stPluginHelper::addRouting('stGiftCardPluginDefault', '/giftcard/:action/*', 'stGiftCardBackend', 'list', 'backend'); 
}
elseif (SF_APP == 'frontend')
{
   stPluginHelper::addEnableModule('stGiftCardFrontend', 'frontend');
   stPluginHelper::addRouting('stGiftCardRemove', '/giftcard/remove/:id', 'stGiftCardFrontend', 'remove', 'frontend');
}