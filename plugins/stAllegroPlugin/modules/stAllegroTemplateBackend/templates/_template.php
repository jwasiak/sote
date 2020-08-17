 <?php if (null !== $allegro_template->getTheme()): ?>
    <img src="/plugins/stAllegroPlugin/preview/<?php echo $allegro_template->getTheme() ?>.jpg" />
    <?php echo input_hidden_tag('allegro_template[template]', $allegro_template->getTemplate()) ?>
<?php else: ?>
    <?php 
    echo object_textarea_tag($allegro_template, 'getTemplate', array (
      'size' => '80x20',
      'control_name' => 'allegro_template[template]',
    )); 
    ?> 
    <ul>
        <li><?php echo __('{TITLE} - Tytuł aukcji');?></li>
        <li><?php echo __('{PRICE} - Cena produktu - tylko Kup Teraz!');?></li>
        <li><?php echo __('{OLD_PRICE} - Stara cena produktu');?></li>
        <li><?php echo __('{DESC} - Opis produktu');?></li>
        <li><?php echo __('{SHORT_DESC} - Krótki opis produktu');?></li>
        <li><?php echo __('{ADDITIONAL_DESC} - Dodatkowy opis produktu');?></li>
        <li><?php echo __('{CODE} - Kod produktu');?></li>
        <li><?php echo __('{PRODUCER} - Producent');?></li>
        <li><?php echo __('{MAN_CODE} - Kod producenta');?></li>
    </ul>
<?php endif ?>

<?php if ($sf_flash->has('preview')): ?>
    <div id="preview_overlay" class="popup_window" style="width: 1024px; height: 500px">
        <iframe src="<?php echo st_url_for('stAllegroTemplateBackend/preview?id='.$allegro_template->getId()) ?>" style="width: inherit; height: inherit; border: none"></iframe>
    </div>
    <script type="text/javascript">
        jQuery(function($) {
            $('#preview_overlay').overlay({
                top: "5%", 
                speed: 'fast',
                load: true,
                mask: {
                    color: '#444',
                    loadSpeed: 'fast',
                    opacity: 0.5,
                    zIndex: 30000
                }, 
            });
        });
    </script>
<?php endif ?>