<?php

class stAllegroEnvAllegroPl extends stAllegroEnv {

    protected $wsdlUri = 'https://webapi.allegro.pl/service.php?wsdl';

    protected $auctionUri = 'http://www.allegro.pl/show_item.php?item=';

    protected $configPrefix = 'allegro_pl';

    public static $description = array( 'MODULE_NAME' => 'Allegro.pl',
                                        'CREATE_AUCTION' => 'Wystaw produkt w serwisie "Allegro.pl".');
}
