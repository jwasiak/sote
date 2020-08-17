<?php $c = CurrencyPeer::doSelect(new Criteria());?>
<?php $currency = array(0 => __('Domyślna'));?>
<?php foreach ($c as $v):?>
    <?php $currency[$v->getId()] = $v->getName();?>
<?php endforeach;?>
<?php echo select_tag('language[currency_id]', options_for_select($currency, $language->getCurrencyId()));?>