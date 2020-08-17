jQuery(function ($)
{
    var stSearch_page = 1;
    $(document).ready(function() {
        $("#st_search_more_button").click( function() {
            var query = $("#query").val();
            $.ajax({
                url: "/stNewSearchFrontend/newSearch",
                cache: false,
                data: "query="+query+"&page="+stSearch_page,
                success: function (html) {
                    $("#product_other").append(html);
                    stSearch_page++;
                    if (html == "") $("#more_button").hide();
                }
            });
        });
    });
});
