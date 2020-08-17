<div class="st-allegro-edit-stock">
    <?php echo input_tag($name . '[available]', $value && $value->available ? $value->available : 1, array('class' => 'number-type update-pricing-fee-preview', 'data-precision' => 0, 'data-min' => 0, 'data-max' => 10000, 'size' => "6")) ?>
    <?php echo select_tag($name . '[unit]', options_for_select(array('UNIT' => __("Sztuk"), "SET" => __('Kompletów'), "PAIR" => __("Par")), $value ? $value->unit : null)) ?>
</div>
<div style="padding-top: 5px;">
    <?php echo __('dostępnych w magazynie: ') ?> <span id="st-allegro-edit-stock-product"><?php echo $params['product']->getStock() ?></span>
</div>