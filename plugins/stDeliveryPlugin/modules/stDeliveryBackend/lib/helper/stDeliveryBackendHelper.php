<?php 
use_helper('stPrice');

sfLoader::loadHelpers(array('stProduct'), 'stProduct');

sfLoader::loadHelpers(array('Helper', 'stPocztaPolska'), 'stPocztaPolskaBackend');


function object_poczta_polska_uslugi($object, $method, $options)
{
    $ppo = DeliveryTypePeer::retrieveIdByType('ppo');
    $ppk = DeliveryTypePeer::retrieveIdByType('ppk');
    $js =<<<JS
    <script>
        jQuery(function($) {
            function filter() {
              var ppks = ["paczka_zagraniczna", "paczka_zagraniczna_ue", "przesylka_polecona_ekonomiczna", "przesylka_polecona_priorytetowa", "paczka_pocztowa_ekonomiczna", "paczka_pocztowa_priorytetowa", "zagraniczna_przesylka_zwykla_ekonomiczna", "zagraniczna_przesylka_zwykla_priorytetowa", "zagraniczna_przesylka_polecona"];
              return ppks.indexOf($(this).val()) > -1;
            }
            $('#delivery_type_id').change(function() {
                var select = $(this);

                if (select.val() && (select.val() == $ppo || select.val() == $ppk)) {
                    $("#sf_fieldset_poczta_polska").show().prop('disabled', false);
                } else {
                    $("#sf_fieldset_poczta_polska").hide().prop('disabled', true);
                }

                if (select.val() == $ppo) {
                    $('#delivery_params_usluga').children().filter(filter).hide();
                } else {
                    $('#delivery_params_usluga').children().filter(filter).show();
                }
            }).change();
        });
    </script>
JS;
    return st_poczta_polska_uslugi('delivery[params][usluga]', $object->getParam('usluga')).$js;
}

function object_delivery_dimension($object, $method, $options)
{
   $id = get_id_from_name($options['control_name']);
   $decimals = 0;

   if (isset($options['decimals']))
   {
      $decimals = $options['decimals'];
      unset($options['decimals']);
   }

   if (method_exists($object, 'getPaczkomatyType'))
   {
      $options['disabled'] = $object->getPaczkomatyType() && $object->getPaczkomatyType() != 'NONE';
   }
   
   return input_tag($options['control_name'], $object->$method(), $options).' '.__('cm').st_price_add_format_behavior($id, $decimals, 8);
}

function object_delivery_margin($object, $param, $options)
{
   $id = get_id_from_name($options['control_name']);

   $decimals = 0;

   if (isset($options['decimals']))
   {
      $decimals = $options['decimals'];
      unset($options['decimals']);
   }

   return input_tag($options['control_name'], $object->get($param, 0), $options).' %'.st_price_add_format_behavior($id, $decimals, 8);
}

function object_delivery_type_picker(Delivery $delivery, $method, $options)
{
   $types = DeliveryTypePeer::doSelectArrayNamesCached();
   return select_tag($options['control_name'], options_for_select(array("" => __('Brak'))+$types, $delivery->getTypeId()));
}

function delivery_select_tag($name, $value)
{
    $cache = new stFunctionCache('stDelivery');

    $deliveries = $cache->cacheCall('_object_product_delivery_helper');

    $defaults = array();

    if ($value) 
    {
        foreach ($value as $id)
        {
            if (isset($deliveries[$id]))
            {
                $defaults[] = array(
                    'id' => $id,
                    'name' => $deliveries[$id]['name'],
                );
            }
        }
    }
    
    return st_tokenizer_input_tag($name, array_values($deliveries), $defaults, array('tokenizer' => array('preventDuplicates' => true, 'hintText' => __('Wpisz szukana dostawę', null, 'stProduct'))));
}

function delivery_type_name(Delivery $delivery)
{
   $types = DeliveryTypePeer::doSelectArrayNamesCached();
   return isset($types[$delivery->getTypeId()]) ? $types[$delivery->getTypeId()] : '';
}

function list_delivery_dimension($object, $type, $method)
{
   return $object->$method().' '.__('cm');
}