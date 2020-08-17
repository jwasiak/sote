<?php if($language->getSystem()):?>
    <div class="row">
        <label>
            <?php echo __('Plik do edycji');?>
            <a class="help" href="#" title="<?php echo __('Plik zawiera frazy bez tłumaczeń.');?>"></a>
        </label>
        <div class="field">
            <?php echo link_to(__('Pobierz'), 'language/download?id='.$language->getId().'&type=edit');?>
            <div class="clr"></div>
        </div>
    </div>
    <?php if($language->getIsTranslate()):?>
        <div class="row">
            <label>
                <?php echo __('Plik oryginalny');?>
                <a class="help" href="#" title="<?php echo __('Plik zawiera frazy wraz z oryginalnymi tłumaczeniami.');?>"></a>
            </label>
            <div class="field">
                <?php echo link_to(__('Pobierz'), 'language/download?id='.$language->getId().'&type=shop');?>
                <div class="clr"></div>
            </div>
        </div>
    <?php endif;?>
<?php endif;?>

<?php if($hasTranslations):?>
    <div class="row">
        <label>
            <?php echo __('Plik ze zmianami');?>
            <a class="help" href="#" title="<?php echo __('Plik zawiera frazy wraz z tłumaczeniami (zmienionymi przez administratora lub oryginalnymi).');?>"></a>
        </label>
        <div class="field">
            <?php echo link_to(__('Pobierz'), 'language/download?id='.$language->getId().'&type=user');?>
            <div class="clr"></div>
        </div>
    </div>
<?php endif;?>

<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {     
            $('.row_translations_export').css('padding-left', '0px');
            <?php if (!$language->getSystem() && !$hasTranslations):?>
                $('#sf_fieldset_eksport').hide();
            <?php endif;?>
        });
    });
</script>
