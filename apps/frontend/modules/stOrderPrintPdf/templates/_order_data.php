<table cellspacing="0" width="502">
    <tr>
        <td align="left" width="200"><font size="14"><b><?php echo __('Zamówienie nr:') ?><?php echo $order->getNumber(); ?></b></font><br/><font size="10"><?php echo $order->getCreatedAt(); ?><br/><?php echo $_SERVER['HTTP_HOST']; ?></font><br/>&nbsp;</td>
        <td align="right" width="302"><font size="8">
            <?php echo $config->get('company'); ?><br/>
            <?php echo $config->get('nip')!="" ?  __('NIP') : "" ?>: <?php echo $config->get('nip'); ?><br/>
            <?php echo $config->get('street'); ?> <?php echo $config->get('house'); ?> <?php echo $config->get('flat'); ?><br/>
            <?php echo $config->get('code'); ?> <?php echo $config->get('town'); ?><br/>
            <?php echo $config->get('phone')!="" ?  __('Telefon') : "" ?>: <?php echo $config->get('phone'); ?><br/>
            <?php echo $config->get('fax')!="" ?  __('Fax') : "" ?>: <?php echo $config->get('fax'); ?><br/>
            <?php echo $config->get('bank')!="" ?  __('Konto') : "" ?>: <?php echo $config->get('bank'); ?><br/>
            <?php echo $config->get('email'); ?><br/>
            </font></td>
    </tr>
</table>

<table cellspacing="0" width="502">
    <tr>
        <td width="100"><?php echo __('Email klienta:') ?></td>
        <td><b><?php echo $order->getOptClientEmail(); ?></b></td>
    </tr>
    <?php if($order->getSfGuardUser()->getWholesale()): ?>
    <tr>
        <td width="100"><?php echo __('Grupa hurtowa:') ?></td>
        <td><b><?php echo strtoupper($order->getSfGuardUser()->getWholesale()); ?></b></td>
    </tr>
    <?php endif; ?>
</table>