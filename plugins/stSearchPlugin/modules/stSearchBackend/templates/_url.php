<?php echo input_tag('search_link[url]', $search_link->getUrl(), array('disabled' => false, 'style' => 'width: 500px;')) ?>

<?php if ($search_link->getUrl()): 
    list($culture) = explode('_', $search_link->getCulture()); 
    stPluginHelper::addRouting('stProductSearchUrlLang4', '/product/:lang/search', 'stProduct', 'list', 'backend', array("page"=>1), array('lang' => '[a-z]{2,2}'));
    stPluginHelper::addRouting('stProductSearchLinkUrl4', '/product/search/:query_url', 'stProduct', 'list', 'backend', array('page' => 1, 'query_url' => '[a-z0-9-]+'));
?>

    <p>
        <?php echo st_link_to(null, 'stProduct/list?query_url=' . $search_link->getUrl(), array(
                'absolute' => true,
                'for_app' => 'frontend',
                'for_lang' => $culture,
                'no_script_name' => true,
                'class' => 'st_admin_external_link',
                'target' => '_blank')) ?>
    </p>
<?php endif ?>