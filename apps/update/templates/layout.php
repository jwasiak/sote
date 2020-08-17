<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <?php echo include_http_metas();?>
        <?php echo include_metas();?>
        <?php echo include_title();?>
        <?php $version = 5 ?>
        <?php use_stylesheet('update/sf_admin.css?v'.$version);?>
        <?php use_stylesheet('update/main2.css?v'.$version);?>
        <?php use_stylesheet('update/style2.css?v'.$version);?>
        <?php use_stylesheet('/jQueryTools/prevue/css/font-awesome-eyes.css?v'.$version); ?>
        <?php use_javascript('jquery-1.8.3.min.js?v'.$version, 'first');?>
        <?php use_javascript('jquery-no-conflict.js?v'.$version, 'first');?>
        <?php use_javascript('/jQueryTools/prevue/js/jquery.prevue.js?v'.$version); ?>
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body>
        <div id="container">
            <?php echo $sf_data->getRaw('sf_content');?>
            <div id="st_version">
                <?php if ($sf_user->isAuthenticated()):?>
                    <?php if (stDevelState::isBeta()) echo " (Beta)";?>
                    <?php if (stLicense::isOpen()) echo __('Darmowy sklep internetowy SOTESHOP Open', null, 'stInstallerWeb'); else echo __('Proudly powered by SOTESHOP', null, 'stInstallerWeb'); ?>

                    <span id="soteshop-version">
                        <?php echo get_shop_version();?>
                    </span>
                    <span id="soteshop-version-refresh" style="cursor: pointer;">
                        <img src="/images/update/icons/refresh.png" alt="" style="vertical-align: middle;"/>
                    </span>
                    <?php if (sfContext::getInstance()->getUser()->getCulture() == 'pl_PL'): ?>
                        <a target="sote" href="http://www.sote.pl/licencja-soteshop.html">
                    <?php else: ?>
                        <a target="sote" href="http://www.soteshop.com/soteshop-license.html">
                    <?php endif; ?>
                    <?php if (stLicense::isOpen()) echo __('Zamów wersję komercyjną', null, 'stInstallerWeb'); ?></a>
                <?php endif;?>
            </div>
        </div>

        <script type="text/javascript">
            jQuery(function($) {
                function detectIE() {
                    var ua = window.navigator.userAgent;
                    var msie = ua.indexOf('MSIE ');

                    if (msie > 0) {
                       return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
                    }

                    var trident = ua.indexOf('Trident/');
                    if (trident > 0) {
                       var rv = ua.indexOf('rv:');
                       return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
                    }

                    var edge = ua.indexOf('Edge/');
                    if (edge > 0) {
                       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
                    }

                    return false;
                }

                if (!detectIE()) {
                    $('input[type=password]').prevue();
                }

                $(document).ready(function() {
                    $('#soteshop-version-refresh').click(function() {
                        $('#soteshop-version').html('<img src="/images/update/red/icons/indicator.gif" alt="" style="vertical-align: middle;"/>')
                        $('#status_box').html('<img src="/images/update/red/icons/indicator-big.gif" alt="" style="vertical-align: middle;"/>');
                        $('#soteshop-version-refresh').hide();
                        $.get('/update.php/communication/check_version', function(data) {
                            $('#soteshop-version').html(data);
                            $('#soteshop-version-refresh').show();
                            $.get('/update.php/stInstallerWeb/ajaxHomepageStatus', function(data) {
                                $('#status_box').html(data);
                            });
                        });
                    });
                });
            });
        </script>
    </body>
</html>
