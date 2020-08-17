<?php
/**
 * @var Order $order
 */
?>
<table cellspacing="0" width="502">
    <tr>
        <td align="left" width="200">
            <font size="14"><b><?php echo __('Zamówienie nr') ?>: <?php echo $order->getNumber(); ?></b></font><br/>
            <font size="10"><?php echo $order->getCreatedAt(); ?><br/><br/>
            <?php if($order->getIsConfirmed()): ?>
                <font color="Green"><?php echo __('potwierdzone') ?></font>
            <?php else: ?>
                <font color="Red"><?php echo __('niepotwierdzone') ?></font>
            <?php endif; ?><br/>
            <?php echo __('Status') ?>: <?php echo $order->getOrderStatus()->getName(); ?></font><br/>
            <font size="10"><?php echo __('Faktura VAT') ?>: <?php if($invoice=="request"): ?><b><?php echo __('tak') ?></b><?php else: ?><?php echo __('nie') ?><?php endif; ?></font><br/></td>
        <td align="right" width="302" style="font-size: 8px">
            <?php echo $config->get('company'); ?><br/>
            <?php echo $config->get('nip')!="" ?  __('NIP:') : "" ?> <?php echo $config->get('nip'); ?><br/>
            <?php echo $config->get('street'); ?> <?php echo $config->get('house'); ?> <?php echo $config->get('flat'); ?><br/>
            <?php echo $config->get('code'); ?> <?php echo $config->get('town'); ?><br/>
            <?php echo $config->get('phone')!="" ?  __('Telefon:') : "" ?> <?php echo $config->get('phone'); ?><br/>
            <?php echo $config->get('fax')!="" ?  __('Fax:') : "" ?> <?php echo $config->get('fax'); ?><br/>
            <?php echo $config->get('bank')!="" ?  __('Konto:') : "" ?> <?php echo $config->get('bank'); ?><br/>
            <?php echo $config->get('email'); ?><br/>
        </td>
    </tr>
</table>

<table cellspacing="0" width="700">
    <?php if ($order->isAllegroOrder()): ?>
        <tr>
            <td width="120"><?php echo __('Użytkownik Allegro:') ?></td>
            <td><b><?php echo $order->getOptAllegroNick(); ?></b></td>
        </tr>
        <tr>
            <td width="120"><?php echo __('Zamówienie Allegro:') ?></td>
            <td><b><?php echo $order->getOptAllegroCheckoutFormId() ?></b></td>
        </tr>   
    <?php endif; ?>
    <tr>
        <td width="120"><?php echo __('Email klienta:') ?></td>
        <td><b><?php echo $order->getOptClientEmail(); ?></b></td>
    </tr>
    <?php if($order->getSfGuardUser() && $order->getSfGuardUser()->getWholesale()): ?>
    <tr>
        <td width="120"><?php echo __('Grupa hurtowa:') ?></td>
        <td><b><?php echo strtoupper($order->getSfGuardUser()->getWholesale()); ?></b></td>
    </tr>
    <?php endif; ?>
</table>
