<?php
echo select_tag($prefix.'_max_per_page_select', options_for_select(array(
    10 => 10,
    20 => 20,
    50 => 50,
    100 => 100,
), $pager->getMaxPerPage()));
?>

<script type="text/javascript">
$('<?php echo $prefix ?>_max_per_page_select').observe('change', function() {
    var selected = this.options[this.selectedIndex].value;

    window.location = '<?php echo st_url_for($module.'/setConfiguration?for_action='.$action.'&params[max_per_page]=') ?>/'+selected;
});
</script>