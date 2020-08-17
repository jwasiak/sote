<?php echo radiobutton_tag('mail_smtp_profile[enc_type_select]', null, null == $mail_smtp_profile->getEncType(), array('id' => 'enc_type_select-off', 'class' => 'enc_type_select')) ?>
<?php echo label_for('enc_type_select-off', __('Bez szyfrowania'), array('class' => 'enc_type_select')) ?>
<?php echo radiobutton_tag('mail_smtp_profile[enc_type_select]', 'tls', 'tls' == $mail_smtp_profile->getEncType(), array('id' => 'enc_type_select-tls', 'class' => 'enc_type_select')) ?>
<?php echo label_for('enc_type_select-tls', __('TLS'), array('class' => 'enc_type_select')) ?>
<?php echo radiobutton_tag('mail_smtp_profile[enc_type_select]', 'ssl', 'ssl' == $mail_smtp_profile->getEncType(), array('id' => 'enc_type_select-ssl', 'class' => 'enc_type_select')) ?>
<?php echo label_for('enc_type_select-ssl', __('SSL'), array('class' => 'enc_type_select')) ?>
<br style="clear: right" />
<script type="text/javascript">
    document.observe("dom:loaded", function()
    {
        var enc_types = $A($$('input.enc_type_select'));

        var enc_to_port = [];

        var port_to_enc = [];

<?php foreach (stMail::getDefaultPorts() as $enc_type => $port):  $type = $enc_type ? $enc_type : 'none' ?>
        enc_to_port['<?php echo $type ?>'] = <?php echo $port ?>;
        port_to_enc[<?php echo $port ?>] = '<?php echo $type ?>';
<?php endforeach ?>

        enc_types.each(function(e)
        {
            e.observe('click', function()
            {
                var profile_port = $('mail_smtp_profile_port');

                if (port_to_enc[profile_port.value] != undefined)
                {
                    profile_port.value = enc_to_port[e.value ? e.value : 'none'];
                }
                else
                {
                    var port_label = $('mail_smpt_profile_port-default');

                    port_label.update('<?php echo __('Domyślnie') ?>: ' + enc_to_port[e.value ? e.value : 'none']);
                }
            });
        });
    });
</script>
