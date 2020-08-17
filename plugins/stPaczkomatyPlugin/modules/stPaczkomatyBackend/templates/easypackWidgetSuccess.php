<!DOCTYPE html>
<html lang="pl" style="height: 100%;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta http-equiv="x-ua-compatible" content="IE=11"/>
        <title>Geowidget v4 - Example - Search Locker Point</title>
        <script src="https://geowidget.easypack24.net/js/sdk-for-javascript.js"></script>
        <script type="text/javascript">
            window.easyPackAsyncInit = function () {
                easyPack.init({
                    instance: 'pl',
                    mapType: 'osm',
                    apiEndpoint: '<?php echo $endpoint ?>',
                    searchType: 'osm',
                    points: {
                        types: ['pop', 'parcel_locker'],
                    },
                    display: {
                        showTypesFilters: false 
                    },
                    map: {
                        useGeolocation: true,
                        initialTypes: ['parcel_locker']
                    }
                });

                var scope = '#<?php echo $scope ?>';

                $ = window.parent.jQuery;

                var selected = $(scope);

                var map = easyPack.mapWidget('easypack-map', function(point) {
                    $(scope + '_label').html(point.name + '<p>' + point.address.line1 + ', ' + point.address.line2 + '</p>');
                    selected.val(point.name);
                    $(scope + '_trigger').data('overlay').close();
                });


                if (selected.val()) {
                    map.searchLockerPoint(selected.val());
                }

                // setTimeout(function() {
                // var modal = window.parent.jQuery('#inpost-easypack-modal');

                // modal.find('iframe').height(window.document.body.scrollHeight);

                // console.log('test');
                // }, 2000);
            }    
        </script>
        <link rel="stylesheet" href="https://geowidget.easypack24.net/css/easypack.css"/>
    </head>      
    <body>  
        <div id="easypack-map"></div>
    </body>
</html>