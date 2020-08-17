<?php

function show_paczkomaty_dropdown_list($name, $selected = '', $params = array()) {
    static $machines = null;

    $list = stPaczkomatyMachines::getListOfMachinesByParam(isset($params['paczkomaty']) ? $params['paczkomaty'] : array());

    $machines = array();
   
    foreach ($list as $m)
    {
        $machines[$m['number']] = array(
            'id' => $m['number'],
            'name' => $m['number'].': '.$m['street'].' '.$m['house'].', '.$m['postCode'].' '.$m['city']
        );
    }    

    if ($selected && $selected != 'NONE' && isset($machines[$selected]))
    {
        $defaults = array(
            $machines[$selected],
        );
    }
    else
    {
        $defaults = array();
    }

    echo st_tokenizer_input_tag($name, array_values($machines), $defaults, array('tokenizer' => array('preventDuplicates' => true, 'hintText' => __('Wpisz szukany paczkomat'), 'tokenLimit' => 1)));
}
