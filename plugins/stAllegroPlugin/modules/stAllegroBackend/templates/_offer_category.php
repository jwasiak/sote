<?php 
$default = array();

$api = stAllegroApi::getInstance();
$ids = array();

$product = $params['product'];

if (isset($value->category) && $value->category->id)
{
    $path = $api->getCategoryPath($value->category->id);

    if ($path) 
    {
        $categoryName = array();

        foreach ($path as $category)
        {
            $ids[] = $category->id;
            $categoryName[] = $category->name;
        }

        $default = array(array("id" => $value->category->id, 'name' => implode(' / ', $categoryName) . ' (' . $value->category->id . ')'));
    }
}

use_helper('stAllegro', 'stJQueryTools');

echo st_tokenizer_input_tag($name, st_url_for('@stAllegroGetAjaxCategoryToken'), $default, array(
    'id' => 'st-allegro-edit-category-input',
    'tokenizer' => array(
       'hintText' => __('Podaj Numer Kategorii'),
       'tokenLimit' => 1,
       'sortable' => true,
       'minChars' => 3,
       'onAdd' => ' function (item) { 
                        $(document).trigger("preloader", "show");

                        var options = [];

                        $(".st_product_options_picker select").each(function() {
                            options.push($(this).val());
                        });

                        $.get("'.st_url_for('stAllegroBackend/ajaxUpdateOfferForm').'", { id: ' . $sf_request->getParameter('id', 0) . ', category_id: item.id, product_id: ' . $sf_request->getParameter('product_id', 0) . ', "options": options.join(",") }, function(response) {
                             tinymce.remove();
                             $("#st-allegro-offer-form-container").html(response);
                             $(document).trigger("preloader", "close");
                             
                             if (item.ids) {
                                 $.updateCategoryPath(item.ids);
                             }
                        });
                    }',
        'onDelete' => 'function() {  $(".allegro-category-container").hide();  }',
    ))
);
?>

<a id="st-allegro-edit-category-overlay-trigger" href="#" rel="#st-allegro-edit-category-overlay">
    <?php echo __('Wybierz kategorię', null, 'stAllegroBackend');?>
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
        var path = '<?php echo implode(",", $ids) ?>';


        $.updateCategoryPath = function(current) {
            path = current;
        }


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
                    var treeApi = $.jstree._reference(jstree);
                    var namePath = treeApi.get_path($('#jstree-' + categoryId));
                    namePath.splice(0, 1);

                    var idsPath = treeApi.get_path($('#jstree-' + categoryId), true);
                    idsPath.splice(0, 1);

                    var cids = [];

                    $.each(idsPath, function() {
                        cids.push(this.replace('jstree-', ''));
                    });



                    path = cids.join(',');

                    tokeninput.tokenInput('add', { 'id': categoryId, 'name': namePath.join(' / ') });
                }

                api.close();     
            });

            $('#st-allegro-edit-category-overlay-trigger').overlay({
                speed: 'fast',
                close: $('#st-allegro-edit-category-overlay > .close img'),
                load: false,
                mask: {
                    color: '#444',
                    loadSpeed: 0,
                    closeSpeed: 0,
                    opacity: 0.5,
                },
                closeOnClick: false,
                closeOnEsc: false,
                onBeforeLoad: function() {
                    var content = this.getOverlay().children('.content');
                    content.html('');

                    $.post('<?php echo st_url_for('@stAllegroPlugin?action=ajaxCategoryTree');?>', { 'path': path }, function(html) {                 
                        content.html(html);
                    });
                }
            });
        });
    });
</script>
