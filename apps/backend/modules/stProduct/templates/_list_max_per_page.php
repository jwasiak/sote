<?php
echo select_tag($prefix.'_max_per_page_select', options_for_select(array(
    12 => 12,
    24 => 24,
    48 => 48,
    96 => 96,
), $pager->getMaxPerPage()));
?>

<script type="text/javascript">
$('<?php echo $prefix ?>_max_per_page_select').observe('change', function() {
    var selected = this.options[this.selectedIndex].value;

    window.location = '<?php echo st_url_for($module.'/setConfiguration?for_action='.$action.'&params[max_per_page]=') ?>/'+selected;
});
</script>