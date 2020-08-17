<?php $blog = $blog_has_positioning->getBlog();?>

<?php echo input_tag('blog_has_positioning[blog_url]', $blog->getFriendlyUrl(), array('size' => '40')) ?>

<?php list($culture) = explode('_', $blog->getCulture()); ?>

<p>
    <?php echo st_link_to(null, 'stBlogFrontend/frontendIndex?url=' . $blog->getFriendlyUrl(), array(
            'absolute' => true,
            'for_app' => 'frontend',
            'for_lang' => $culture,
            'no_script_name' => true,
            'class' => 'st_admin_external_link',
            'target' => '_blank')) ?>
</p>