<?php use_helper('stUrl', 'stProductOptionsBackend') ?>

<?php if(!$ajax): ?>
    <?php use_stylesheet('backend/stProductOptionsPicker.css') ?>
    <div class="st_product_options_picker" data-namespace="<?php echo $namespace ?>">
<?php endif ?>
        <ul>
            <?php st_product_options_picker_show($namespace, $options, $selected) ?>
        </ul>
        <?php echo input_hidden_tag($namespace, implode(',', array_values($selected)), array('class' => 'st_product_options_selected')) ?>
<?php if(!$ajax): ?>
    </div>

    <script type="text/javascript">
        jQuery(function($) {
            $(document).ready(function() {
                $('.st_product_options_picker').each(function() {
                    var current = $(this);
                    if (!current.data('initialized')) {
                        current.data('initialized', true);

                        current.on('change', 'select', function() {
                            var select = $(this);
                            var selects = current.find('select');
                            var post = selects.serialize()+'&namespace='+current.data('namespace')+'&changed='+select.data('field');
                            selects.attr('disabled', true);

                            current.trigger('before_options_change');

                            $.post("<?php echo st_url_for('stProductOptionsBackend/ajaxOptionChangeUpdate?product_id='.$product->getId()) ?>", post, function(response) {
                                current.html(response.content);
                                current.trigger('options_change', [ response.price, response.stock, response.man_code, response.options ]);
                            });
                        });
                    }
                });
            });
        }); 
    </script>
<?php endif ?>