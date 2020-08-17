<?php

sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

function st_allegro_payment_type($type)
{
    $payments = array(
        'm' =>      'mTransfer - mBank',
        'mtex' =>   'mTransfer mobilny - mBank',
        'w' =>      'BZWBK - Przelew24',
        'o' =>      'Pekao24Przelew - Bank Pekao',
        'i' =>      'Inteligo',
        'p' =>      'iPKO',
        'pkex' =>   'PayU Express Bank Pekao',
        'g' =>      'ING',
        'gbx' =>    'Getin Bank',
        'gbex' =>   'GetIn Bank PayU Express',
        'nlx' =>    'Noble Bank',
        'nlex' =>   'Noble Bank PayU Express',
        'ib' =>     'Paylink Idea - IdeaBank',
        'l' =>      'Credit Agricole',
        'as' =>     'T-mobile Usługi Bankowe dostarczane przez Alior Bank',
        'exas' =>   'PayU Express T-mobile Usługi Bankowe',
        'u' =>      'Eurobank',
        'ab' =>     'Alior Bankiem',
        'exab' =>   'PayU Express z Alior Bankiem',
        'ps' =>     'PBS',
        'wm' =>     'Przelew z Millennium',
        'h' =>      'Przelew z BPH',
        'wd' =>     'Przelew z Deutsche Banku',
        'wc' =>     'Przelew z Citi Handlowego',
        'bo' =>     'BOŚ',
        'bnx' =>    'BNP Paribas',
        'bnex' =>   'BNP Paribas PayU Express',
        'orx' =>    'Orange',
        'orex' =>   'PayU Express Orange',
        'c' =>      'Karta kredytowa',
        'tt' =>     'Karta kredytowa',
        'b' =>      'Przelew tradycyjny',
        'ai' =>     'Raty',
        'blik' =>   'Blik',
        'ap' =>     'Android Pay',
        'neb' =>    'Nest Bank',
        'rap' =>    'Raiffeisen R-Przelew',
        'plb' =>    'Plus Bank',
        'bpo' =>    'e-transfer Pocztowy24',
        'collect_on_delivery' => 'Płacę przy odbiorze',
        'cash_on_delivery' => 'Płacę przy odbiorze',
        'wire_transfer' => 'Zwykły przelew (poza systemem Allegro Finanse)',
        'p24' => 'Przelewy24',
        'payu' => 'PayU'
    );

    if (isset($payments[$type]))
    {
        return $payments[$type];
    }

    return null;
}

function st_allegro_edit_row($title, $content, $options = null) {
    $title = __($title, null, 'stAllegroBackend');
    $labelClass = "";
    $rowClass = "";
    if (is_array($options)) {
        if (isset($options['row'])) {
            $rowClass = " ".$options['row'];
        }
    } elseif ($options) {
        $labelClass = ' class="required"';
    }
    $content = <<<CONTENT
<div class="row{$rowClass}">
    <label{$labelClass}>$title</label>
    <div class="field">
        <div class="field-container">$content</div>
        <div class="clr"></div>
    </div>
</div>
CONTENT;

    return $content;
}

function st_allegro_edit_row_olny_title($title) {
    $title = __($title, null, 'stAllegroBackend');
    $content = <<<CONTENT
<div class="row">
    $title
</div>
CONTENT;

    return $content;
}

function st_allegro_get_tables($quantity, $content) {
    $tables = array();
    $tableElementsQuantity = ceil(count($content['tbody'])/$quantity);

    for ($i = 1; $i <= $quantity; $i++) {
        $data = array('thead' => $content['thead'], 'tbody' => array());
        for ($j = 0; $j < $tableElementsQuantity; $j++)
            if (count($content['tbody']))
                $data['tbody'][] = array_shift($content['tbody']);

        $tables[] = st_allegro_get_table($data);
    }

    return implode('', $tables);
}

function st_allegro_get_table($content) {
    $thead = st_allegro_get_table_row('thead', $content);
    $tbody = st_allegro_get_table_row('tbody', $content);

    $content = <<<CONTENT
<table class="st_record_list st_record_manager st-allegro-edit-table-size" cellspacing="0">
    $thead
    $tbody
</table>
CONTENT;

    return $content;
}

function st_allegro_get_table_row($type, $content) {
    if (isset($content[$type]) && !empty($content[$type])) {
        $result = '<'.$type.'>';
        foreach ($content[$type] as $row) {
            $result .= '<tr>';
            foreach ($row as $record)
                $result .= '<'.($type == 'tbody' ? 'td' : 'th').'>'.$record.'</'.($type == 'tbody' ? 'td' : 'th').'>';
            $result .= '</tr>';
        }
        $result .= '</'.$type.'>';

        return $result;
    }
    return null;
}

function st_allegro_show_category_status(stAllegroCategory $allegroObject) {
    $categoryStatus = $allegroObject->checkStatus();

    if ($categoryStatus === 1)
        $msg = __('Brak nowych kategorii do pobrania.').' '.__('Data ostatniego pobierania').': '.$allegroObject->getDownloadedTime('d.m.Y H:i');
    elseif ($categoryStatus === 0)
        $msg =  __('Dostępne są nowe kategorie do pobrania.').' '.__('Data ostatniego pobierania').': '.$allegroObject->getDownloadedTime('d.m.Y H:i');
    elseif ($categoryStatus === -1)
        $msg =  __('Brak pobranych kategorii, należy pobrać kategorie.');

    return $msg;
}

function st_allegro_get_auction_link(AllegroAuction $auction) {
    if ($link = $auction->getAuctionLink()) {
        return '<a href="'.$link.'" target="_blank">'.$auction->getAuctionId().'</a>';
    } else 
        return '-';
    
}


function st_allegro_status_label($status)
{
    $enum = stAllegroApi::getStatusList();

    return isset($enum[$status]) ? $enum[$status] : '';
}


function st_allegro_implied_warranty_select_tag($name, $value)
{
    $options = array();

    try
    {   
        $api = stAllegroApi::getInstance();
        
        foreach ($api->getImpliedWarranties() as $warranty)
        {
            $options[$warranty->id] = $warranty->name;
        }
    }
    catch(Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            sfLogger::getInstance()->crit('{stAllegro} st_allegro_implied_warranty_select_tag: '. $e->getMessage());
        }
    }

    return select_tag($name, options_for_select($options, $value, array('include_custom' => __('Wybierz'))), array('style' => 'width: 300px'));
}

function st_allegro_warranty_select_tag($name, $value)
{
    $options = array();

    try
    {   
        $api = stAllegroApi::getInstance();

        foreach ($api->getWarranties() as $warranty)
        {
            $options[$warranty->id] = $warranty->name;
        }
    }
    catch(Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            sfLogger::getInstance()->crit('{stAllegro} st_allegro_warranty_select_tag: '. $e->getMessage());
        }
    }

    return select_tag($name, options_for_select($options, $value, array('include_custom' => __('Wybierz'))), array('style' => 'width: 300px'));
}

function st_allegro_return_policy_select_tag($name, $value)
{
    $options = array();

    try
    {
        $api = stAllegroApi::getInstance();
        
        foreach ($api->getReturnPolicies() as $policy)
        {
            $options[$policy->id] = $policy->name;
        }
    }
    catch(Exception $e)
    {
        if (SF_ENVIRONMENT == 'dev')
        {
            sfLogger::getInstance()->crit('{stAllegro} st_allegro_return_policy_select_tag: '. $e->getMessage());
        }
    }

    return select_tag($name, options_for_select($options, $value, array('include_custom' => __('Wybierz'))), array('style' => 'width: 300px'));
}

function st_allegro_product_code(AllegroAuction $auction = null)
{
    $product = null;

    if ($auction)
    {
        $product = $auction->getProduct();
    }

    return $product ? '<a href="'.url_for('@stProduct?action=edit&id=' . $product->getId()).'">' . $product->getCode() . '</a>' : '';
}

function st_allegro_duration_time_select_tag($name, $value, array $params = array())
{
    return select_tag($name, options_for_select(stAllegroApi::getDurationTimes(), $value), $params);
}

function st_allegro_payments_invoice_select_tag($name, $value, array $params = array())
{
    return select_tag($name, options_for_select(stAllegroApi::getPaymentInvoiceList(), $value), $params); 
}

function st_allegro_product_search($name, $value, $options = array())
{
    $results_formatter = _token_input_product_results_formatter();

    $token_formatter = _token_input_product_token_formatter();

    $url = st_url_for('@stProductEdit?action=ajaxProductsToken&id=0');

    $tokenizer = array_merge(array(
        'preventDuplicates' => true, 
        'resultsFormatter' => $results_formatter, 
        'tokenFormatter' => $token_formatter,
        'hintText' => __('Wpisz kod/nazwę szukanego produktu'), 
        'additionalDataFields' => array('code'),
        'tokenLimit' => 1,
        'sortable' => true,
    ), isset($options['tokenizer']) ? $options['tokenizer'] : array());

    return st_tokenizer_input_tag($name, $url, $value, array('tokenizer' => $tokenizer));
}
