<div id="st-allegro-edit-images">
    <?php foreach ($images as $image): ?><div class="image" data-value="<?php echo $image->url ?>">
            <div class="image-overlay">
                <a href="#" class="delete" data-action="delete"><img src="/jQueryTools/plupload/images/remove.png?v2"></a>
            </div>
            <div class="thumbnail" style="background-image: url(<?php echo $image->url ?>)"></div>
        </div><?php endforeach ?><a href="#" class="add-image" data-action="add"></a>
</div>

<script>
jQuery(function($) {
    function updateInputValue()
    {
        var values = [];
        $('#st-allegro-edit-images > div').each(function() {
            var value = $(this).data('value');

            values.push({ url: value });
        });

        $('#offer_images').val(JSON.stringify(values));
    }

    $('#st-allegro-edit-images').on('st-update-input-value', function() {
        updateInputValue();
    });

    $('#st-allegro-edit-images').on('click', 'a', function() {
        var link = $(this);
        var action = link.data('action');
        switch (action) {
            case 'delete':
                link.closest('.image').remove();
                updateInputValue();
            break;

            case 'add':
                var api = $('#st-allegro-offer-add-image-overlay').data('overlay');
                api.load();
            break;
        }
        return false;
    });

    var imageList = $('#st-allegro-edit-images');
    imageList.sortable({ 
        placeholder: "image-placeholder",
        tolerance: 'pointer',
        items: '> div',
        forcePlaceholderSize: false,
        cursor: 'move', 
        handle: '.image-overlay',
        opacity: 0.5,
        stop: function(event, ui) {
            // update_modified_hidden_input();
            updateInputValue();

        },
        start: function(event, ui) {

        }
    });
    imageList.disableSelection();
});
</script>