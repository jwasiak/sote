var stTabNavigator = {
    selectTab: function (navigator_id, tab_id, selected_class)
    {
        jQuery('div#'+navigator_id+' ul li').removeClass(selected_class);
        jQuery('#'+tab_id).addClass(selected_class);
    }
}