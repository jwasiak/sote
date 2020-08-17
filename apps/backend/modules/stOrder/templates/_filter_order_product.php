<?php 
sfLoader::loadHelpers('stProduct', 'stProduct');

$id = null;
$token = null;

if (isset($filters['order_product']) && $filters['order_product'])
{
    if (is_numeric($filters['order_product']))
    {
        $token = array("id" => $filters['order_product']);
    }
    else
    {
        $tokens = stJQueryToolsHelper::parseTokensFromRequest($filters['order_product']);

        $token = $tokens ? $tokens[0] : null;
    }
}

if ($token && !isset($token['new']))
{
    $c = new Criteria();
    $c->add(ProductPeer::ID, $token['id']);

    $defaults = ProductPeer::doSelectTokens($c);
}
elseif ($token)
{
    $defaults = array($token); 
}
else 
{
    $defaults = array();
}

$results_formatter = _token_input_product_results_formatter();

$token_formatter = _token_input_product_token_formatter();

echo st_tokenizer_input_tag('filters[order_product]', st_url_for('@stProduct?action=ajaxProductsToken'), $defaults, array('tokenizer' => array(
    'preventDuplicates' => true, 
    'resultsFormatter' => $results_formatter, 
    'tokenFormatter' => $token_formatter,
    'hintText' => __('Wpisz kod/nazwę szukanego produktu', null, 'stProduct'), 
    'additionalDataFields' => array('code'),
    'tokenLimit' => 1,
    'sortable' => false, 
    'createNew' => true,
    'addNewText' => __('Szukaj w historii zamówień'),
    'addNewIcon' => '/images/backend/beta/icons/20x20/search.png',
)));
?>