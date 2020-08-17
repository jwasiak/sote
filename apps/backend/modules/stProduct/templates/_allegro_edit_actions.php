<ul class="admin_actions" style="float: left">
    <?php if (!$allegro_auction->isNew()):?>
        <?php if($sf_request->getParameter('list') == 'stAllegroPlugin'):?>
            <?php echo st_get_admin_action('list', __('Lista', null, 'stAdminGeneratorPlugin'), 'stAllegroBackend/list', array('name' => 'list'));?>
        <?php else:?>
            <?php echo st_get_admin_action('list', __('Lista', null, 'stAdminGeneratorPlugin'), 'stProduct/allegroCustom?product_id='.$forward_parameters['product_id'], array('name' => 'list'));?>
        <?php endif;?>
    <?php endif;?>
</ul>
<ul class="admin_actions" style="float: right">
    <?php if (!$allegro_auction->getAuctionId()):?>
        <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
        <?php echo st_get_admin_action('validate_auction', __('Zapisz i waliduj', null, 'stAllegroBackend'), null, array('name' => 'validate_auction'));?>
        <?php echo st_get_admin_action('auction', __('Zapisz i wystaw', null, 'stAllegroBackend'), null, array('name' => 'create_auction'));?>
    <?php endif;?>
    
    <?php if ($allegro_auction->getEnded() && 1==2):?>
        <?php echo st_get_admin_action('refresh', __('Wystaw ponownie', null, 'stAllegroBackend'), null, array('name' => 'resale'));?>
    <?php endif;?>

    <?php if (!$allegro_auction->isNew()):?>
        <?php echo st_get_admin_action('duplicate', __('Utwórz kopie', null, 'stAllegroBackend'), 'stAllegroBackend/duplicate?id='.$allegro_auction->getId(), array('name' => 'duplicate'));?>
    <?php endif;?>
</ul>
<div class="clr"></div>

<?php if ($allegro_auction->getAuctionId()):?>
    <script type="text/javascript" language="javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $('#st-allegro-edit-form :input').prop('disabled', true);
                $('#st-allegro-edit-category-overlay-trigger, .token-input-delete-token-backend').hide();
                $('.st-allegro-edit-options-overlay-trigger').hide();

                $('.admin_actions :input').prop('disabled', false);
            });
        });
    </script>
<?php endif;?>
