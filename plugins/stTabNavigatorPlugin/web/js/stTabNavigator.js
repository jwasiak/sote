var stTabNavigator = {
    selectTab: function (navigator_id, tab_id, selected_class)
    {
        var lis = $$('div#'+navigator_id+' ul li');

        $A(lis).each(function(li) {
            li.className = li.className.replace(selected_class,'');
        });

        $(tab_id).className = $(tab_id).className + ' ' + selected_class;
    }
}