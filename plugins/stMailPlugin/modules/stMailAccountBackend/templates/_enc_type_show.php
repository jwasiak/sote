<?php
    $enc_types = array(
    null  => __('brak'),
    'tls' => 'TLS',
    'ssl' => 'SSL',
    );
?>
<?php echo $enc_types[$mail_smtp_profile->getEncType()] ?>