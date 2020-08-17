<?php use_helper('I18N') ?>
<?php if($ie):
?>
<div class="form-errors">
    <h2><?php echo __('Korzystasz z przeglądarki Internet Explorer 8.') ?></h2>
    <dl>
        <dd style="text-align: center">
            <?php echo __('Dla poprawnego działania panelu administracyjnego sklepu zalecamy skorzystanie z innej przeglądarki, zgodnej ze standardem W3C. Poniżej lista przeglądarek zalecanych do obsługi panela administracyjnego:') ?><br/>
            <?php echo link_to("FireFox","http://www.mozilla-europe.org/pl/firefox/", "target=>_blank") ?>
            <?php echo link_to("Chrome","http://www.google.com/chrome/index.html?hl=pl&brand=CHMG&utm_source=pl", "target=>_blank") ?>
            <?php echo link_to("Opera","http://operapl.net/", "target=>_blank") ?><br/>
            <?php echo __('Więcej informacji na temat instalacji przeglądarek znajdziecie Państwo') ?> <?php echo link_to(__('tutaj'),"http://www.sote.pl/trac/wiki/doc/webbrowsers", "target=>_blank") ?>.
        </dd>
    </dl>
</div>
<?php endif; ?>