<?php echo $order->getOptAllegroNick() ? $order->getOptAllegroNick() : '-';?>

<?php if (!$order->isAllegroOrder()):?>
    <script type="text/javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $('#sf_fieldset_allegro').hide();
            });
        });
    </script>
<?php endif;?>