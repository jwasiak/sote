<?php
st_theme_use_stylesheet('stSearch.css');

if ($search_config->get('search_off')!=1)
{
    use_helper('XssSafe', 'stJQueryTools', 'stUrl', 'stAsset');

    use_javascript('/jQueryTools/jquery/effects.core.js');

    $config = stConfig::getInstance(sfContext::getInstance(), 'stSearchBackend');

    $autocomplete = array(
        'image_width' => st_asset_thumbnail_setting('width', 'icon'),
        'image' => '{image}',
        'name' => '{name}',
        'url' => '{url}',
        'price' => '{price}',
        'price_netto' => '{price_netto}',
        'price_brutto' => '{price_brutto}'
    );

    $smarty->assign('autocomplete', $autocomplete);

    $smarty->assign('form_start', form_tag('stSearchFrontend/search', array('method' => 'get')));
    //$smarty->assign('search', input_tag('st_search[search]', esc_xsssafe($sf_params->get('st_search[search]','')),array('class'=>'roundies_left')));
    if ($search_config->get('autocomplete_enabled'))
    {
       $smarty->assign('search', st_autocompleter_input_tag('st_search[search]', null, array('class' => 'roundies', 'autocompleter' => array(
                       'serviceUrl' => st_url_for('stSearchFrontend/ajaxSearchProduct?st_search[and_search]='.$config->get('simple_and_search')),
                       'deferRequestBy' => 1500, 'minChars' => 3,
                       'resultFormat' => '$.fn.autocomplete.stSearchResultFormat',
                       'buttonNavigation' => false,
                       'indicator' => _st_get_image_path($smarty->getTheme()->getVersion() >= 2 ? 'stSearch/indicator.gif' : 'search_indicator.gif')
                       ))));
    }
    else
    {
       $smarty->assign('search', input_tag('st_search[search]', $sf_params->get('st_search[search]'), array('class' => 'roundies')));
    }

    $smarty->assign('and_search', input_hidden_tag('st_search[and_search]', $config->get('simple_and_search')));
    $smarty->assign('full_search', input_hidden_tag('st_search[detail]', $config->get('simple_full_search')));
    $smarty->assign('top_search_box', stSocketView::openComponents('stTopSearchBox'));

    $smarty->assign('submit_search', submit_tag(__('Szukaj'), array('id' => 'button_search_middle')));
}
$smarty->assign('search_off', $search_config->get('search_off'));
$smarty->display('search_search_box.html');
?>

<?php if ($search_config->get('search_off')!=1){ ?>

    <?php javascript_cdata_section($content) ?>
    <?php if ($search_config->get('autocomplete_enabled')): ?>
       <script type="text/javascript">
       //<![CDATA[   
          jQuery(function($)
          {         
             $.fn.autocomplete.template = '<?php echo preg_replace('/\r\n|\n|\r/', '', addcslashes($smarty->fetch('search_autocomplete_template.html'), "'")) ?>';
             
             $.fn.autocomplete.stSearchResultFormat = function (value, data, currentValue)
             {
                var html = $.fn.autocomplete.template;

                var product_url = '<?php echo st_url_for(array('module' => 'stProduct', 'action' => 'show', 'url' => 'value')) ?>';
                    
                html = html.replace(/{price_netto}/g, data.pn);
                
                html = html.replace(/{price_brutto}/g, data.pb);
                
       <?php if ($product_config->get('price_view_long') == 'gross_net' || $product_config->get('price_view_long') == 'net_gross'): ?>
                   html = html.replace(/{price}/g, data.pn + ' / ' + data.pb);
       <?php elseif ($product_config->get('price_view_long') == 'net_only'): ?>
                   html = html.replace(/{price}/g, data.pn);
       <?php else: ?>
                   html = html.replace(/{price}/g, data.pb);
       <?php endif; ?>
               
                html = html.replace(/{name}/g, data.name);
               
                html = html.replace(/{image}/g, data.image);
               
                return html.replace(/{url}/g, product_url.replace('value', data.url));
             }
          });   
       //]]>
       </script>
    <?php endif; ?>
<?php } ?>
