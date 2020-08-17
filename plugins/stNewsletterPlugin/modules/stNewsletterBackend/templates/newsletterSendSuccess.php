<?php use_helper('stProgressBar', 'stAdminGenerator'); ?>

<?php echo st_get_admin_head('stNewsletterPlugin', null, __('Wysyłanie wiadomości do klientów'), array('stMailPlugin')) ?>

<div id="sf_admin_content">
    
    <div style="width: 302px; margin: 50px auto;">
    <?php echo progress_bar('stNewsletter', 'stNewsletterProgressBar', 'send', $count); ?>
    </div>
</div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>