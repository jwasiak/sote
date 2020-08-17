jQuery(function($)
{
    $(document).ready(function() {

        var trigger = $('.zoom_image_trigger');

        var links = $('.gallery a');     
     
        links.add(trigger).lightBox();

        links.unbind('click');

        trigger.jqzoom({
        zoomType: 'innerzoom',
        lens:true,
        preloadImages: false,
        showEffect : 'fadein',
        hideEffect: 'fadeout',
        title: false
        });
  
    });

});