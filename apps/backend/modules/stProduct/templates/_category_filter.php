<?php
use_stylesheet('backend/stProduct.css?version=5');
use_javascript('/stCategoryTreePlugin/js/jquery-1.3.2.min.js', 'first');
use_javascript('/stCategoryTreePlugin/js/jquery-no-conflict.js', 'first');

if (isset($parent))
{
    $children = $parent->getChildren();

    $id = $parent->getId();
}
else
{
    $id = 'null';
}
?>

<?php if ($include_container): ?>
<div id="stProduct-category-filter" style="display: none">
<?php endif; ?>
<ul id="cf-<?php echo $id ?>">
<?php if (isset($return_value)): ?>
    <li class="expandable returnable">
        <span id="cf-trigger-<?php echo $return_value['return_id'] ?>" class="trigger">&laquo;</span>
        <?php
        if (!$return_value['id'])
        {
            echo st_link_to($return_value['label'], '#', array('onclick' => 'return false;', 'class' => 'trigger link', 'id' => 'cf-link-trigger-'.$return_value['return_id']));
        }
        else
        {
            echo st_link_to($return_value['label'], '@stProductCategoryFilter?category_filter='.$return_value['id']);
        }
        ?>
    </li>
<?php endif; ?>
<?php foreach ($children as $child): $has_children = $child->hasChildren(); $is_root = $child->isRoot() ?>
    <li<?php if ($has_children): ?> class="expandable"<?php endif; ?>>
        <?php if ($has_children): ?>
        <span id="cf-trigger-<?php echo $child->getId() ?>" class="trigger">&rsaquo;</span>
        <?php endif; ?>
        <?php
        if ($is_root)
        {
            echo st_link_to($child->getName(), '#', array('onclick' => 'return false;', 'class' => 'trigger link', 'id' => 'cf-link-trigger-'.$child->getId()));
        }
        else
        {
            echo st_link_to($child->getName(), '@stProductCategoryFilter?category_filter='.$child->getId());
        }
        ?>
    </li>
<?php endforeach; ?>
</ul>
<br style="clear: left" />
<?php if ($include_container): ?>
</div>
<?php endif; ?>

<script type="text/javascript">
jQuery(function($) {

var items = $('#cf-<?php echo $id ?> li.expandable .trigger');

$.each(items, function() {
    $(this).click(function() {
        var o = $(this);

        var id = this.id;
        
        id = id.replace('cf-trigger-', '');

        id = id.replace('cf-link-trigger-', '');

        if (o.hasClass('link'))
        {
            var obj2 = $('cf-trigger-'+id);
            
            obj2.html('<?php echo image_tag('backend/stProduct/ajax_loader.gif') ?>');

            obj2.addClass('selected');
        }
        else
        {
            o.html('<?php echo image_tag('backend/stProduct/ajax_loader.gif') ?>');
        }

        o.addClass('selected');

        $.each(items, function () { $(this).unbind('click'); });
        
        $.ajax({
            url: '<?php echo st_url_for('stProduct/ajaxFilterCategory'); ?>/id/' + id,
            dataType: 'html',
            success: function (data)
            {
                $('#stProduct-category-filter').html(data);
            }
        });
    });
});
});
</script>
