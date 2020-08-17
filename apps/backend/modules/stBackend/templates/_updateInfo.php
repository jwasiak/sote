<span<?php if ($update || !$has_valid_license): ?> class="need-update"<?php endif ?>><?php echo __('Aktualizacja') ?></span>

<?php if ($update): ?>
    <ul>
        <li id="update-info-refresh"><div class="static" style="width: auto;"><a href="<?php echo st_url_for('stBackend/updateInfoRefresh') ?>"><img src="/images/update/red/modules/install.png"></a></div></li>
        <li class="preloader_26x26"></li>
        <li><span class="static"><?php echo __('Twój sklep jest nieaktualny') ?></span></li>
        <li><div class="static update-info"><?php echo get_service_information() ?></div></li>
        <?php if ($has_valid_license): ?>
            <li><a href="/update.php"><img src="/images/backend/main/icons/red/stUpdate.png" alt=""><?php echo __('Przejdź do aktualizacji') ?></a></li>
        <?php endif ?>
    </ul>
<?php else: ?>
    <ul>
        <li id="update-info-refresh"><div class="static" style="width: auto;"><a href="<?php echo st_url_for('stBackend/updateInfoRefresh') ?>"><img src="/images/update/red/modules/install.png"></div></a></li>
        <li class="preloader_26x26"></li>
        <li><div class="static update-info"><?php echo get_service_information() ?></div></li>
        <?php if ($has_valid_license): ?>
            <li><a href="/update.php"><img src="/images/backend/main/icons/red/stUpdate.png" alt=""><?php echo __('Przejdź do aktualizacji') ?></a></li>
        <?php endif ?>
    </ul>
<?php endif ?>
<script>
    jQuery(function($) {
        $(document).ready(function() {
            $('#update-info-refresh a').click(function() {
                var link = $(this);

                $('#update-menu .preloader_26x26').show();

                $.get(link.attr('href'), function(response) {
                    $('#update-menu').html(response);
                    $('#update-menu .preloader_26x26').hide();
                });

                return false;
            });
        });
    });
</script>