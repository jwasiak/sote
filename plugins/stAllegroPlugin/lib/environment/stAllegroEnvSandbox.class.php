<?php

class stAllegroEnvSandbox extends stAllegroEnv {

    protected $wsdlUri = 'https://webapi.allegro.pl.allegrosandbox.pl/service.php?wsdl';

    protected $auctionUri = 'http://allegro.pl.webapisandbox.pl/show_item.php?item=';

    protected $configPrefix = 'sandbox';

    public static $description = array( 'MODULE_NAME' => 'Serwis testowy - Sandbox',
                                        'CREATE_AUCTION' => 'Tryb testowy (zwany również "Sandbox") pozwala na wystawienie testowej i darmowej aukcji. Pojawia się ona w osobnym serwisie i transakcje w nim realizowane są wirtualne.');
}
