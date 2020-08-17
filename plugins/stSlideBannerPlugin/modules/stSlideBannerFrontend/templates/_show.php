<?php
if($config->get('banner_version')==2):
    $smarty->display('slide_banner_show_new.html');    
else:
    $smarty->display('slide_banner_show.html');    
endif;        
?>
<?php  if(!stTheme::is_responsive()){ ?>
<?php use_javascript('jquery.nivo.slider.js'); ?>
<script type="text/javascript" language="javascript">
jQuery(function ($)
{
    $(document).ready(function ()
    {
        $('#slider').nivoSlider({
        effect:'<?php echo $config->get('effect'); ?>', // Specify sets like: 'fold,fade,sliceDown'
        slices:15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed:<?php echo $config->get('anim')  ?>, // Slide transition speed
        pauseTime:<?php echo $config->get('pause')  ?>, // How long each slide will show
        startSlide:0, // Set starting Slide (0 index)
        directionNav: <?php echo $smarty->get_template_vars('count') > 1 ? 'true' : 'false' ?>, // Next Prev navigation
        directionNavHide:true, // Only show on hover
        controlNav: <?php echo $smarty->get_template_vars('count') > 1 ? 'true' : 'false' ?>, // 1,2,3... navigation
        controlNavThumbs:false, // Use thumbnails for Control Nav
        controlNavThumbsFromRel:false, // Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', // Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
        keyboardNav:true, // Use left right arrows
        pauseOnHover:true, // Stop animation while hovering
        manualAdvance: <?php echo $smarty->get_template_vars('count') > 1 ? 'false' : 'true' ?>, // Force manual transitions
        captionOpacity:0.6, // Universal caption opacity
        captionBgColor:'<?php echo $config->get('caption_background_color')  ?>',
        captionTextColor:'<?php echo $config->get('caption_text_color')  ?>',
        prevText: 'Prev', // Prev directionNav text
        nextText: 'Next', // Next directionNav text
        beforeChange: function(){}, // Triggers before a slide transition
        afterChange: function(){}, // Triggers after a slide transition
        slideshowEnd: function(){}, // Triggers after all slides have been shown
        lastSlide: function(){}, // Triggers when last slide is shown
        afterLoad: function(){} // Triggers when slider has loaded
    });
    });
});

</script>
<?php } ?>