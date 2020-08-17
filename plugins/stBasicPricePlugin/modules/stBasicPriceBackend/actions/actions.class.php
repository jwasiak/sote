<?php

/**
 * SOTESHOP/stBasicPricePlugin
 *
 * Ten plik należy do aplikacji stAdminGeneratorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stAdminGeneratorPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 396 2009-09-09 07:59:20Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * stBasicPriceBackend actions.
 *
 * @author Your name here
 *
 * @package     stBasicPricePlugin
 * @subpackage  actions
 */
class stBasicPriceBackendActions extends autostBasicPriceBackendActions
{
protected function updateBasicPriceUnitMeasureFromRequest()
  {
    $basic_price_unit_measure = $this->getRequestParameter('basic_price_unit_measure');

    if($basic_price_unit_measure['is_default']==1 && $basic_price_unit_measure['is_system']!=1){
    $c = new Criteria();
    $c->add(BasicPriceUnitMeasurePeer::UNIT_GROUP, $basic_price_unit_measure['unit_group']);
    $units = BasicPriceUnitMeasurePeer::doSelect($c);
    
    $setDefault=1;
    
    if($units){
    foreach ($units as $unit){
        if($unit->getIsSystem()!=1){
            $unit->setIsDefault(0);
            $unit->save();
        }else{
            $setDefault=0;
        }
    }
    }
    
    }
    if($setDefault==1){
        $this->basic_price_unit_measure->setIsDefault(isset($basic_price_unit_measure['is_default']) ? $basic_price_unit_measure['is_default'] : 0);
    }
    
    $this->basic_price_unit_measure->setIsSystem(isset($basic_price_unit_measure['is_system']) ? $basic_price_unit_measure['is_system'] : 0);
    if (isset($basic_price_unit_measure['unit_name']))
    {
      $this->basic_price_unit_measure->setUnitName($basic_price_unit_measure['unit_name']);
    }
    if (isset($basic_price_unit_measure['multiplier']))
    {
      $this->basic_price_unit_measure->setMultiplier($basic_price_unit_measure['multiplier']);
    }
    if (isset($basic_price_unit_measure['unit_symbol']))
    {
      $this->basic_price_unit_measure->setUnitSymbol($basic_price_unit_measure['unit_symbol']);
    }
    if (isset($basic_price_unit_measure['unit_group']))
    {
      $this->basic_price_unit_measure->setUnitGroup($basic_price_unit_measure['unit_group']);
    }
    $this->getDispatcher()->notify(new sfEvent($this, 'autoStBasicPriceBackendActions.postUpdateFromRequest', array('modelInstance' => $this->basic_price_unit_measure, 'requestParameters' => $basic_price_unit_measure)));
  }
   
}