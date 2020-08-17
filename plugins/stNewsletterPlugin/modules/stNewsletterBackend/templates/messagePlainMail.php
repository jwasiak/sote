<?php use_helper('stUrl') ?>

<?php echo stHtml2Text::convert($newsletter->getContent()); ?>

<?php echo __('Jeżeli chcą Państwo zrezygnować z otrzymywania wiadomości proszę kliknąć w poniższy link.') ?>

<?php echo st_url_for('@stNewsletterUnsubscribe', true, 'frontend') ?>