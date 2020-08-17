<?php if (($num_products != $num_products_good) && ($culture == "pl_PL")):?>
    <div style="border: 1px solid red; padding: 20px; width: 250px; margin: 0px auto;">
    <?php echo st_get_admin_actions_head('style="margin-top: 10px;"') ?>
    Przed rozpoczęciem pracy w aplikacji <b>Produkty</b> klknij poniższy przycisk: <br /><br />
              <?php echo st_get_admin_action('save', __('Optymalizuj produkty'), 'stProduct/fixProducts', array (
    )) ?>  <?php echo st_get_admin_actions_foot() ?>
    </div>
    <br />
<?php endif;?>