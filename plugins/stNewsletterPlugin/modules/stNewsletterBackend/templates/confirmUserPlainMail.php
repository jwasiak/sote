<?php use_helper('Date','stUrl') ?>
<?php echo __('Dziękujemy za wykazanie zainteresowania ofertą naszego sklepu.') ?>

<?php echo $user->getEmail(); ?>

<?php echo __('Adres został dodany do listy subscrypcji. Prosimy potwierdzić chęć otrzymywania wiadomości aktywując konto klikając w link znajdujący się poniżej.')?>

<?php echo st_link_to(__('Potwierdź rejestrację'), '@stNewsletterConfirm?id=' . $user->getId() . '&hash_code=' . $hash, 'absolute=true for_app=frontend'); ?>

<?php if($group): ?>

<?php echo __('Po potwierdzeniu rejestracji, będą wysyłane informacje z następujących tematów:') ?>

<?php foreach ($group as $record): ?>
                                   
<?php echo $record->getName(); ?>

<?php echo $record->getDescription(); ?>
                                              
<?php endforeach; ?>
            
<?php endif; ?>

<?php echo __('Jeżeli chcą Państwo zrezygnować z otrzymywania wiadomości proszę kliknąć w poniższy link.') ?>

<?php echo st_link_to(__('Wypisz mnie z listy'), '@stNewsletterRemove?id=' . $user->getId() . '&hash_code=' . $hash, 'absolute=true for_app=frontend'); ?>