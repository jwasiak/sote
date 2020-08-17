<?php 
use_helper('stAllegro', 'stJQueryTools');

$default = array();
if (is_object($allegro_auction->getAllegroCategory()))
    $default = array(array('id' => $allegro_auction->getAllegroCategory()->getCatId(), 'name' => $allegro_auction->getAllegroCategory()->getPath()));

echo st_tokenizer_input_tag('allegro_auction[allegro_category_id]', st_url_for('@stAllegroGetAjaxCategoryToken?environment='.$allegro_auction->getEnvironment()), $default, array(
    'id' => 'st-allegro-edit-category-input',
    'tokenizer' => array(
       'tokenLimit' => 1,
       'sortable' => true ,
       'minChars' => 3,
       'onAdd' => ' function (item) { 
                        $(document).trigger("preloader", "show");
                        $.get("'.st_url_for('stAllegroBackend/ajaxAttributes').'?auction='.$allegro_auction->getId().'&category=" + item.id + "&environment='.$allegro_auction->getEnvironment().'&product='.$allegro_auction->getProductId().'", function() {
                             $(".allegro-category-container").show();
                             $(document).trigger("preloader", "close");
                        });
                    }',
        'onDelete' => 'function() {  $(".allegro-category-container").hide();  }',
    ))
);
?>

<a id="st-allegro-edit-category-overlay-trigger" href="#" rel="#st-allegro-edit-category-overlay">
    <?php echo __('drzewo kategorii', null, 'stAllegroBackend');?>
</a>

<div id="st-allegro-edit-category-overlay" class="popup_window">
    <div id="st-allegro-edit-category-overlay-close" class="close">
        <img src="/images/frontend/theme/default2/buttons/close.png" alt="" />
    </div>
    <h2>
        <?php echo __('Drzewo kategorii', null, 'stAllegroBackend');?>
    </h2>
    <div class="content preloader_160x24"></div>
    <div id="st-allegro-edit-category-overlay-submit">
        <button class="submit" type="button">
            <?php echo __('Wybierz', null, 'stAllegroBackend');?>
        </button>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        $(document).ready(function() {
            $('#st-allegro-edit-category-overlay .submit').click(function() {
                var api = $('#st-allegro-edit-category-overlay-trigger').data('overlay');
                api.getOverlay().children('.content').addClass('preloader_160x24');

                var jstree = $('#jstree');
                jstree.css({ 'visibility': 'hidden' });

                var categoryId = jstree.find('input:radio:checked').attr('value');

                var tokeninput = $('#st-allegro-edit-category-input');
                tokeninput.tokenInput('clear');

                if (categoryId > 0) {
                    var path = $.jstree._reference(jstree).get_path($('#jstree-' + categoryId));
                    path.splice(0, 1);

                    tokeninput.tokenInput('add', { 'id': categoryId, 'name': path.join(' / ')});
                }

                api.close();     
            });

            $('#st-allegro-edit-category-overlay-trigger').overlay({
                speed: 'fast',
                close: $('#st-allegro-edit-category-overlay > .close img'),
                load: false,
                mask: {
                    color: '#444',
                    loadSpeed: 'fast',
                    opacity: 0.5,
                },
                closeOnClick: false,
                closeOnEsc: false,
                onBeforeLoad: function() {
                    var content = this.getOverlay().children('.content');
                    content.html('');

                    var selected = 0;

                    var value = $('#st-allegro-edit-category-input').val();
                    if (value) {
                        var parsedValue = $.parseJSON($.parseJSON(value));
                        if (parsedValue[0] && parsedValue[0].id > 0) {
                            selected = parsedValue[0].id;
                        }
                    }

                    $.post('<?php echo st_url_for('@stAllegroGetAjaxCategoryTree?environment='.$allegro_auction->getEnvironment());?>', { 'default': selected }, function(html) {                 
                        content.html(html);
                    });
                }
            });
        });
    });
</script>
