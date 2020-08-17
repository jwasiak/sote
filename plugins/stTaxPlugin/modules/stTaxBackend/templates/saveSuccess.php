<?php use_helper('stAdminGenerator') ?>

<?php st_include_partial('stTaxBackend/header', array('related_object' => $tax, 'title' => __('Edycja stawki VAT'), 'route' => 'stTaxBackend/edit?id='.$tax->getId())) ?>

<div id="sf_admin_content">
    <div class="form-errors">
        <h2><?php echo __('Wykryto zmiane stawki VAT z %from%% na %to%%. Wybierz metodę przeliczenia obecnych cen w sklepie', array('%from%' => $tax->getVat(), '%to%' => $sf_request->getParameter('tax[vat]'))) ?></h2>
    </div>
    <form class="admin_form" id="admin_edit_form" action="<?php echo st_url_for('stTaxBackend/edit?id='.$tax->getId()) ?>" method="post">
        <fieldset>
            <div class="content">
<?php foreach ($sf_request->getParameter('tax') as $name => $value): ?>
             <?php echo input_hidden_tag('tax['.$name.']', $value) ?>
<?php endforeach; ?>
             <?php echo st_admin_get_form_field('update_price', __('Przelicz').':', array('brutto' => __('netto na brutto'), 'netto' => __('brutto na netto')), 'select_tag', array(
                 'help' => __('<b>netto na brutto</b> - ceny brutto ulegną zmianie<br/><b>brutto na netto</b> - ceny netto ulegną zmianie')
                 .'<br /><b>'.__('przeliczeniu ulegną').':</b><ul style="list-style: circle inside"><li>'.__('ceny produktów').'</li><li>'.__('koszty dostaw').'</li></ul>')); ?>
            </div>
        </fieldset>
        <?php echo st_get_admin_actions_head(); ?>
            <?php echo st_get_admin_action('reset', __('Anuluj', null, 'stAdminGeneratorPlugin'), 'stTaxBackend/edit?id='.$tax->getId()); ?>
            <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin')); ?>
        <?php echo st_get_admin_actions_foot(); ?>
    </form>
</div>

<?php st_include_partial('stTaxBackend/footer', array('related_object' => $tax)) ?>
