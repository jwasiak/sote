<?php use_stylesheet('backend/stAllegroPlugin.css');?>
<?php echo select_tag('allegro_delivery[environment]', options_for_select(stAllegroEnv::getEnvironments(), $allegro_delivery->getEnvironment()), array('id' => 'st-allegro-delivery-edit-environment', 'disabled' => ($allegro_delivery->isNew() ? '' : 'disabled')));?>

<?php if ($allegro_delivery->isNew()):?>
    <script type="text/javascript">
        jQuery(function($) {
            $(document).ready(function() {
                showDelivery();

                $('#st-allegro-delivery-edit-environment').change(function () {
                    showDelivery();
                });

                function showDelivery() {
                    var type = $('#st-allegro-delivery-edit-environment option:selected').val();
                    $('#st-allegro-delivery-edit-delivery').html('<img id="st-allegro-delivery-edit-delivery-loading" src="/images/frontend/theme/default2/loading.gif" alt=""/>');

                    $.ajax({ 
                        url: "<?php echo st_url_for('@stAllegroDelivery?action=ajaxDelivery');?>?<?php if(!$allegro_delivery->isNew()) echo 'id='.$allegro_delivery->getId().'&';?>namespace=allegro_delivery&environment=" + type, 
                        cache: false
                    }).done(function(html) {
                        $('#st-allegro-delivery-edit-delivery').html(html);
                    })
                }
            });
        });
    </script>
<?php endif;?>
