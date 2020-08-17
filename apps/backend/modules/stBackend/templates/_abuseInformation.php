<?php if(stLicenseAbuse::isBlocked()):?>
    <div id="abuse_information">
        <span>
            <?php echo __('Wystąpił błąd podczas weryfikacji licencji. Proszę o pilny kontakt z SOTE. Sklep może zostać zablokowany.');?>
            <a href="<?php echo __('http://www.sote.pl/page/block');?>" target="_blank">
                <?php echo __('Więcej informacji...');?>
            </a>
        </span>
    </div>
<?php endif;?>

<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {   
            $.post('/update.php/communication/check');
        });
    });
</script>