[?php echo st_get_admin_foot() ?]

[?php if (!stLicense::hasSupport() && !stLicense::isOpen()): ?]
<style type="text/css">
#support_tooltip {
    padding-left: 25px; 
    background: rgba(255, 255, 255, 0.1); 
    display: none; 
    z-index: 1000;
}

#support_tooltip div {
    border-radius: 50px 0px 0px 50px; 
    min-height: 28px; 
    background: url(/images/backend/premium.png) no-repeat scroll left center rgb(255, 255, 255); 
    padding: 22px 10px 12px 80px; 
    border: 1px solid rgb(204, 204, 204); 
    box-shadow: 0px 0px 5px rgb(204, 204, 204); 
}
</style>
<script type="text/javascript">

jQuery(function($) {
    var support = $('.support');
    support.each(function() {
        var value = '';
        var widget = $(this);
        widget.attr('disabled', 'disabled');

        if (this.type == 'checkbox' && this.checked) 
        {
            widget.after($('<input type="hidden" value="'+widget.val()+'" name="'+widget.attr('name')+'" />'));
        }
        else if (this.type != 'checkbox')
        {
           widget.after($('<input type="hidden" value="'+widget.val()+'" name="'+widget.attr('name')+'" />')); 
        }
        var container = $('<div style="width: '+widget.width()+'px; height: '+widget.height()+'px; display: inline-block; position: absolute; z-index: 1" />');
        widget.before(container);
        container.tooltip({
            tip:  '#support_tooltip',
            "delay": 10,
            "position": "center right",
            "offset":[3, -10],
            predelay: 0,
        });

    });
});

</script>
<div id="support_tooltip">
    <div>
[?php if (stLicense::isOpen()): ?]
        <a target="_blank" href="[?php echo $sf_user->getCulture() == 'pl_PL' ? 'http://www.sote.pl/licencja-soteshop.html' : 'http://www.soteshop.com/soteshop-license.html' ?]">[?php echo __('Zamów wersje komercyjną', null, 'stAdminGeneratorPlugin') ?]</a>
[?php else: ?]
        <a target="_blank" href="[?php echo get_7_link() ?]">[?php echo __('Zamów aktualizację do wersji 7', null, 'stAdminGeneratorPlugin') ?]</a>
[?php endif; ?]
    </div>
</div>
[?php endif ?]