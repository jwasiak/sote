<?php
use_helper('stAdminGenerator', 'stAllegroParameter');
?>

<div id="st-allegro-parameters-required">
<?php 
foreach ($parameters as $parameter)
{
    if ($parameter->id == 219809 && !isset($values[$parameter->id]))
    {
        $values[$parameter->id] = stAllegroApi::arrayToObject(array(
            'values' => array($product->getCode())
        ));
    }

    if ($parameter->id == 237194 && !isset($values[$parameter->id]) && $product->getProducer())
    {
        $values[$parameter->id] = stAllegroApi::arrayToObject(array(
            'values' => array($product->getProducer()->getName())
        ));       
    }

    if ($parameter->id == 225693 && !isset($values[$parameter->id]) && $product->getManCode())
    {
        $values[$parameter->id] = stAllegroApi::arrayToObject(array(
            'values' => array($product->getManCode())
        ));         
    }

    if ($parameter->required)
    {
        st_allegro_parameter($name, $parameter, $values);
    }
}
?>
</div>

<div id="st-allegro-parameters-more"><?php
foreach ($parameters as $parameter)
{
    if ($parameter->id == 219809 && !isset($values[$parameter->id]))
    {
        $values[$parameter->id] = stAllegroApi::arrayToObject(array(
            'values' => array($product->getCode())
        ));
    }

    if ($parameter->id == 237194 && !isset($values[$parameter->id]) && $product->getProducer())
    {
        $values[$parameter->id] = stAllegroApi::arrayToObject(array(
            'values' => array($product->getProducer()->getName())
        ));       
    }

    if ($parameter->id == 225693 && !isset($values[$parameter->id]) && $product->getManCode())
    {
        $values[$parameter->id] = stAllegroApi::arrayToObject(array(
            'values' => array($product->getManCode())
        ));         
    }
    
    if (!$parameter->required)
    {
        st_allegro_parameter($name, $parameter, $values);
    }
}
?></div>

<?php st_allegro_parameter_javascript_init(); ?>