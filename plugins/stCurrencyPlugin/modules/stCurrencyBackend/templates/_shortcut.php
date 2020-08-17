<?php echo input_tag('currency[shortcut]', $currency->getShortcut(), array('disabled' => $currency->getIsSystemCurrency() && !$currency->isNew() || !$currency->isNew(), 'size' => 4)) ?>
<?php if (!$currency->isNew()): ?>
<?php echo input_hidden_tag('currency[shortcut]', $currency->getShortcut()) ?>
<?php endif; ?>
