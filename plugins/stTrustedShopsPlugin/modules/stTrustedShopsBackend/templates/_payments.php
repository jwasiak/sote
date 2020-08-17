<?php echo __('Sklep korzysta z domyślnych ustawień przypisania metod płatności.');?><br/>
<?php echo __('Jeżeli chcesz je zmienić przejdź do');?> 
<?php echo st_link_to(__('opcji zaawansowanych.'), 'stTrustedShopsBackend/protectionPaymentsEdit?id='.$trusted_shops->getId());?> 