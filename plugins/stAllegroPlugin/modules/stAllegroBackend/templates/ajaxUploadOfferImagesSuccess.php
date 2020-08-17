<?php use_helper('stAsset', 'stAdminGenerator') ?>

<?php echo st_get_partial('stAdminGenerator/message') ?>

<form action="<?php echo url_for('@stAllegroPlugin?action=ajaxUploadOfferImages&product='. $product->getId()) ?>" method="post">
    <div class="images">
        <?php foreach ($product->getImages() as $image): 
            /**
             * Generate thumbnail image workaround
             */
            st_asset_image_path($image, 'allegro', 'product', true);
            $url = st_asset_image_path($image, 'allegro', 'product', false, true);
        ?>
            <label class="image">
                <span style="background-image: url(<?php echo $url ?>)"></span>
                <input name="images[]" type="checkbox" value="<?php echo $url ?>">
            </label>
        <?php endforeach ?>
    </div>

    <div class="submit">
        <?php echo st_get_admin_actions(array(
            array('type' => 'add', 'label' => __('Dodaj'))
        )) ?>
    </div>
</form>

<script>
jQuery(function($){
    var tpl = $('#add-offer-image-tpl').html();

    var addImageOverlay = $('#st-allegro-offer-add-image-overlay');

    addImageOverlay.find('form').submit(function() {   
        var form = $(this);
        var url = form.prop('action');

        // $(document).trigger("preloader", "show");

        var imageContainer = $('#st-allegro-edit-images');

        addImageOverlay.find('.preloader_48x48').show();

        $.post(url, form.serialize(), function(response) {
            if (typeof response === 'object' && response.images) {
                $.each(response.images, function() {
                    var image = $(tpl.replace(/##image##/g, this));

                    imageContainer.find('.add-image').before(image);
                });

                imageContainer.trigger('st-update-input-value');
                var api = addImageOverlay.data('overlay');
                api.getOverlay().find('input[type=checkbox]').prop("checked", false);
                api.close();
            }
            else
            {
                addImageOverlay.find('.content').html(response);
            }

            addImageOverlay.find('.preloader_48x48').hide();
        });

        return false;
    });
});
</script>