<?php use_stylesheet('/css/update/stInstallerWebPlugin.css?version=1'); ?>
<?php use_stylesheet('/css/update/setup.css?v2'); ?>
<?php echo get_partial('menu_top');?>
<div id="frame_update">  
    <div id="sf_admin_container"  style="width: auto;">
        
            <div style="padding-bottom: 40px;">
                <?php echo __('Korzystasz z przeglądarki Internet Explorer 7 lub niższej.');?>
                <?php echo __('Do poprawnego działania panelu aktualizacji oraz sklepu zalecamy skorzystanie z nowszej wersji przeglądarki lub innej zgodnej ze standardem W3C.');?>
            </div>
            <div style="padding-bottom: 20px; text-align: center;">
                <?php echo __('Poniżej lista przeglądarek zalecanych do obsługi panelu administracyjnego:') ?>
            </div>
            <div style="overflow: hidden; padding-bottom: 40px; width: 480px; margin: 0px auto;">
                <div style="float: left; width: 120px; text-align: center;">
                    <a href="http://windows.microsoft.com/pl-PL/internet-explorer/products/ie/home" target="_blank">
                        <img src="/images/update/browser/ie.png" alt=""/><br />
                        Internet Explorer 8
                    </a>
                </div>
                <div style="float: left; width: 120px; text-align: center;">
                    <a href="http://www.mozilla-europe.org/pl/firefox/" target="_blank">
                        <img src="/images/update/browser/firefox.png" alt=""/><br />
                        Firefox
                    </a>
                </div>
                <div style="float: left; width: 120px; text-align: center;">
                    <a href="http://www.opera.com/" target="_blank">
                        <img src="/images/update/browser/opera.png" alt="" /><br />
                        Opera
                    </a>
                </div>  
                <div style="float: left; width: 120px; text-align: center;">
                    <img src="/images/update/browser/chrome.png" alt=""/><br />
                    <?php echo link_to("Chrome","http://www.google.com/chrome/index.html?hl=pl&brand=CHMG&utm_source=pl", "target=>_blank") ?>
                </div>  
            </div>
            <div>
                <?php if($sf_user->getCulture() == 'pl_PL'):?>
                    <?php echo __('Więcej informacji na temat instalacji przeglądarek znajdziecie Państwo');?> <a href="http://www.sote.pl/trac/wiki/doc/webbrowsers" target="_blank"><?php echo __('tutaj');?></a>.
                <?php endif;?>   
            </div>
        
    </div>
</div>