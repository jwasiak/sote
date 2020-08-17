<?php

use_helper('stPrice');

function st_allegro_parameter($name, $parameter, array $values)
{
    $call = 'st_allegro_parameter_' . $parameter->type;

    if  (is_callable($call)) 
    {
       $call($name . '[' . $parameter->type . '][' . $parameter->id . ']', $parameter->name, $parameter, isset($values[$parameter->id]) ? $values[$parameter->id] : null);
    } 
    else
    {
        echo '<div>' . $parameter->name.' : '.$parameter->id.' : '.$parameter->type . '</div>';
    }
}

function st_allegro_parameter_dictionary($name, $label, $parameter, $value = null)
{
    if (!$parameter->restrictions->multipleChoices)
    {
        $options = array();

        foreach ($parameter->dictionary as $dictionary)
        {
            $options[$dictionary->id] = $dictionary->value;
        }

        echo st_admin_get_form_field($name, $label, $options, 'select_tag', array('selected' => $value && $value->valuesIds ? $value->valuesIds[0] : null, 'include_custom' => __("Wybierz"), 'required' => $parameter->required));
    }
    else
    {
        echo st_admin_get_form_field($name, $label, $value ? $value->valuesIds : array(), 'st_allegro_parameter_dictionary_multiple', array('parameter' => $parameter, 'required' => $parameter->required));
    }
}

function st_allegro_parameter_dictionary_multiple($name, array $values = null, array $params = array())
{
    $parameter = $params['parameter'];

    ob_start();

    foreach ($parameter->dictionary as $dictionary)
    {
        echo '<label style="float: none; width: auto; display: block; text-align: left">';
        echo checkbox_tag($name . '[]', $dictionary->id, in_array($dictionary->id, $values)) . ' ' . $dictionary->value;
        echo '</label>';
    }

    return ob_get_clean();
}

function st_allegro_parameter_float($name, $label, $parameter, $value = null)
{
    echo st_admin_get_form_field($name, $label, $value, 'st_allegro_parameter_numeric', array(
        'required' => $parameter->required, 
        'postfix' => $parameter->unit ? '<span style="vertical-align: middle">'.$parameter->unit.'</span>' : '',
        'help' => __("Wartość mininalna: %min%, wartość mayksymalna: %max%", array('%min%' => $parameter->restrictions->min, '%max%' => $parameter->restrictions->max)),
        'parameter' => $parameter,
    ));
}

function st_allegro_parameter_integer($name, $label, $parameter, $value = null)
{
    echo st_admin_get_form_field($name, $label, $value, 'st_allegro_parameter_numeric', array(
        'required' => $parameter->required, 
        'postfix' => $parameter->unit ? '<span style="vertical-align: middle">'.$parameter->unit.'</span>' : '',
        'help' => __("Wartość mininalna: %min%, wartość mayksymalna: %max%", array('%min%' => $parameter->restrictions->min, '%max%' => $parameter->restrictions->max)),
        'parameter' => $parameter,
    ));
}

function st_allegro_parameter_numeric($name, $value, $params)
{
    $parameter = $params['parameter'];

    if (!$parameter->restrictions->range)
    {
        return input_tag($name, $value && $value->values ? $value->values[0] : null, array(
            'class' => 'number-type', 
            'data-min' => $parameter->restrictions->min,
            'data-max' => $parameter->restrictions->max,
            'data-precision' => isset($parameter->restrictions->precision) && $parameter->restrictions->precision ? $parameter->restrictions->precision : 0,
        ));
    }
    else
    {
        return input_tag($name . '[from]', $value && $value->rangeValue ? $value->rangeValue->from : null, array(
            'class' => 'number-type', 
            'data-min' => $parameter->restrictions->min,
            'data-max' => $parameter->restrictions->max,
            'data-precision' => isset($parameter->restrictions->precision) && $parameter->restrictions->precision ? $parameter->restrictions->precision : 0,
        )) . ' - ' . input_tag($name . '[to]', $value && $value->rangeValue ? $value->rangeValue->to : null, array(
            'class' => 'number-type', 
            'data-min' => $parameter->restrictions->min,
            'data-max' => $parameter->restrictions->max,
            'data-precision' => isset($parameter->restrictions->precision) && $parameter->restrictions->precision ? $parameter->restrictions->precision : 0,
        ));
    }
}

function st_allegro_parameter_string($name, $label, $parameter, $value = null)
{
    if ($parameter->restrictions->allowedNumberOfValues == 1)
    {
        echo st_admin_get_form_field($name, $label, $value && $value->values ? $value->values[0] : null, 'input_tag', array('required' => $parameter->required, 'class' => 'string-type', 'maxlength' => $parameter->restrictions->maxLength, 'size' => '40', 'postfix' => $parameter->unit ? '<span style="vertical-align: middle">'.$parameter->unit.'</span>' : ''));
    }
    else
    {
        echo st_admin_get_form_field($name, $label, $value ? $value->values : array(), 'st_allegro_parameter_string_multiple', array('parameter' => $parameter, 'required' => $parameter->required, 'postfix' => $parameter->unit ? '<span style="vertical-align: middle">'.$parameter->unit.'</span>' : ''));
    }
}

function st_allegro_parameter_string_multiple($name, array $value = null, array $params)
{
    $parameter = $params['parameter'];

    ob_start();

    for ($i = 0; $i < $parameter->restrictions->allowedNumberOfValues; $i++)
    {
        echo '<div style="margin-bottom: 5px">';
        echo input_tag($name . '[' . $i . ']', isset($value[$i]) ? $value[$i] : null, array('class' => 'string-type', 'maxlength' => $parameter->restrictions->maxLength, 'size' => '40', 'placeholder' => __('Wartość %no%', array('%no%' => $i + 1))));
        echo '</div>';
    }

    return ob_get_clean();
}

function st_allegro_parameter_javascript_init($container = null)
{
    static $initialized = false;

    if ($initialized) 
    {
        return;
    }

    $initialized = true;
?>
<script>
jQuery(function($) {
    var container = $(<?php echo $container ? "'$container'" : 'document' ?>); 

    container.find('.number-type').change(function() {
        var input = $(this);
        var min = input.data('min');
        var max = input.data('max');
        var precision = input.data('precision');
        var value = input.val();

        value = stPrice.fixNumberFormat(value, precision);

        if (value < min) {
            value = min.toFixed(precision);
        } else if (value > max) {
            value = max.toFixed(precision);
        }

        input.val(value);
    });

    container.find('.string-type').change(function() {
        var input = $(this);
        input.val(input.val().trim());
    });
});
</script>
<?php
}