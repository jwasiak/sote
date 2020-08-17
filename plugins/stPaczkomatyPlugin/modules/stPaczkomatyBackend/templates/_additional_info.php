<?php use_javascript('stPrice.js') ?>
<?php if($paczkomaty_pack->isNew()):?>
    <div class="row">
        <label for="paczkomaty_pack_pack_type">
            <?php echo __('Rozmiar', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo select_tag('paczkomaty_pack[pack_type]', options_for_select(array('A' => 'A (8 x 38 x 64 cm)', 'B' => 'B (19 x 38 x 64 cm)', 'C' => 'C (41 x 38 x 64 cm)'), !$sf_request->hasParameter('paczkomaty_pack[pack_type]') ? $paczkomaty_pack->getPackType() : $sf_request->getParameter('paczkomaty_pack[pack_type]')));?>
        <div class="clr"></div>
    </div>

    <div class="row">
        <label for="paczkomaty_pack_insurance">
            <?php echo __('Kwota ubezpieczenia', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo st_admin_optional_input('paczkomaty_pack[insurance]', $paczkomaty_pack->getInsurance() ? $paczkomaty_pack->getInsurance() : $paczkomaty_pack->getInsurance(true), array('size' => 7, 'disabled' => !$paczkomaty_pack->getInsurance() && !$paczkomaty_pack->hasAllegroInsurance())); ?> PLN
        <div class="clr"></div>
    </div>
    
    <div class="row">
        <label for="paczkomaty_pack_cash_on_delivery">
            <?php echo __('Kwota pobrania', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo st_admin_optional_input('paczkomaty_pack[cash_on_delivery]', $paczkomaty_pack->getCashOnDelivery() ? $paczkomaty_pack->getCashOnDelivery() : $paczkomaty_pack->getCashOnDelivery(true), array('size' => 7, 'disabled' => !$paczkomaty_pack->getCashOnDelivery() && ($sf_request->getMethod() == sfRequest::POST || !$paczkomaty_pack->hasCashOnDelivery()))); ?> PLN
        <div class="clr"></div>
    </div>
    
    <div class="row">
        <label for="paczkomaty_pack_description">
            <?php echo __('Numer referencyjny', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo input_tag('paczkomaty_pack[description]', !$sf_request->hasParameter('paczkomaty_pack[description]') ? $paczkomaty_pack->getDescription() : $sf_request->getParameter('paczkomaty_pack[description]'), array('size' => 80));?>
        <div class="clr"></div>
    </div>

    <script type="text/javascript" language="javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $('#paczkomaty_pack_insurance').change(function() {
                    $(this).val(stPrice.fixNumberFormat($(this).val()));
                });
                $('#paczkomaty_pack_cash_on_delivery').change(function() {
                    $(this).val(stPrice.fixNumberFormat($(this).val()));
                });
            });
        });
    </script>
<?php else:?>
    <div class="row">
        <label for="paczkomaty_pack_pack_type">
            <?php echo __('Rozmiar', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo $paczkomaty_pack->getPackType();?>
        <div class="clr"></div>
    </div>

    <div class="row">
        <label for="paczkomaty_pack_insurance">
            <?php echo __('Kwota ubezpieczenia', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo stPrice::round($paczkomaty_pack->getInsurance()); ?> PLN
        <div class="clr"></div>
    </div>
    
    <div class="row">
        <label for="paczkomaty_pack_cash_on_delivery">
            <?php echo __('Kwota pobrania', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo stPrice::round($paczkomaty_pack->getCashOnDelivery()); ?> PLN
        <div class="clr"></div>
    </div>
    
    <div class="row">
        <label for="paczkomaty_pack_description">
            <?php echo __('Numer referencyjny', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo $paczkomaty_pack->getDescription();?>
        <div class="clr"></div>
    </div>
<?php endif;?>
