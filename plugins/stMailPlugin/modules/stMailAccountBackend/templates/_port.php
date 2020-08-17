<?php echo input_tag('mail_smtp_profile[port]', $mail_smtp_profile->getPort(), array('size' => 4)) ?>
<?php if ($mail_smtp_profile->getPort() != stMail::defaultPort($mail_smtp_profile->getEncType())): ?>
<span id="mail_smpt_profile_port-default"><?php echo __('Domyślnie') ?>: <?php echo stMail::defaultPort($mail_smtp_profile->getEncType()) ?></span>
<?php else: ?>
<span id="mail_smpt_profile_port-default" style="display: none"><?php echo __('Domyślnie') ?>: <?php echo stMail::defaultPort($mail_smtp_profile->getEncType()) ?></span>
<?php endif ?>

<script type="text/javascript">
        var enc_to_port = [];
        
<?php foreach (stMail::getDefaultPorts() as $enc_type => $port): ?>
        enc_to_port['<?php echo $enc_type ? $enc_type : 'none' ?>'] = <?php echo $port ?>;
<?php endforeach ?>

    new Form.Element.Observer('mail_smtp_profile_port', 0.2, function(el, value)
    {
        var enc_types = $$('.enc_type_select');

        enc_types.each(function(e)
        {
            if (e.checked)
            {
                var port_label = $('mail_smpt_profile_port-default');

                current_value = e.value ? e.value : 'none';

                if (enc_to_port[current_value] != value)
                {
                    port_label.update('<?php echo __('Domyślnie') ?>: ' + enc_to_port[current_value]);

                    port_label.show();

                }
                else
                {
                    port_label.hide();
                }
            }
        });
    });
</script>
