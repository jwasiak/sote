<?php echo checkbox_tag('theme[responsive]', true, $theme->getIsResponsive()) ?>
<?php if ($theme->getVersion() < 7): ?>
<script type="text/javascript">
jQuery(function($) {
    $(".row_responsive").hide();
});
</script>
<?php endif ?>