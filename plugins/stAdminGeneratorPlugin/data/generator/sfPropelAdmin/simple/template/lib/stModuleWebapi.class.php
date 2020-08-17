[?php
/** 
 * SOTESHOP/stWebApiPlugin 
 * 
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stModuleWebapi.class.php 15190 2011-09-22 09:58:05Z piotr $
 * @author      Michał Prochowski <michal.prochowski@sote.pl>,
 */

<?php if(!defined("IS_WEBAPI")) :?>
<?php define( "IS_WEBAPI",  1 ); ?>

<?php global $fieldsInfo,$generator; 
    $webApiFields = $this->getParameterValue('webapi.fields'); 
    $webApiFields['_delete']['type'] = "integer";
    $webApiFields['_offset']['type'] = "integer";
    $webApiFields['_limit']['type'] = "integer";
    $webApiFields['_count']['type'] = "integer";
    $webApiFields['_update']['type'] = "integer";
    $webApiFields['created_at']['type'] = "dateTime";
    $webApiFields['updated_at']['type'] = "dateTime";
    $webApiFields['_modified_from']['type'] = "dateTime";
    $webApiFields['_modified_to']['type'] = "dateTime";
    $webApiFields['_session_hash']['type'] = "string";
    $generator = $this;
    if (is_array($this->getParameterValue('webapi.fields'))) {
        $fieldsInfo= array_merge($webApiFields,$this->getParameterValue('webapi.fields')); 
    } else {
        $fieldsInfo = $webApiFields;
    }?>


<?php function testRequireFields($fields) { 
        foreach ($fields as $key=>$value) :?><?php

            $fieldName = str_replace('=','',$value);
            if ($value[0]=="="): ?>
        if (!isset($object-><?php print $fieldName ?>)) {throw new SoapFault( "3", sprintf( $this->__(WEBAPI_REQUIRE_ERROR), '<?php print $fieldName ?>' ));}
<?php endif; 
      endforeach; 
 } ?>

<?php function validateFields($fields) {
    global $fieldsInfo;
    foreach ($fields as $key=>$value) : 
        $fieldName = str_replace('=','',$value);
     if (isset($fieldsInfo[$fieldName]['type'])):
      switch ($fieldsInfo[$fieldName]['type']) : 
                case 'int': ?>
        if (isset( $object-><?php print $fieldName ?>) && ! is_numeric( $object-><?php print $fieldName ?>) ) { throw new SoapFault( "3", sprintf( $this->__(WEBAPI_VALIDATE_ERROR), '<?php print $fieldName ?>' ) ); }
<?php break; ?>
<?php case 'double': ?>
        if (isset( $object-><?php print $fieldName ?>) &&! is_numeric( $object-><?php print $fieldName ?>) ) { throw new SoapFault( "3", sprintf( $this->__(WEBAPI_VALIDATE_ERROR), '<?php print $fieldName ?>' ) ); }
<?php break; ?>
<?php case 'string': ?>
        if (isset( $object-><?php print $fieldName ?>) &&! is_string( $object-><?php print $fieldName ?>) ) { throw new SoapFault( "3", sprintf( $this->__(WEBAPI_VALIDATE_ERROR), '<?php print $fieldName ?>' ) ); }
<?php break; ?>   
<?php case 'date': ?>             
<?php case 'dateTime': ?>

        if (isset($object-><?php print $fieldName ?>) && $object-><?php print $fieldName ?> && (!strtotime($object-><?php print $fieldName ?>) || is_numeric($object-><?php print $fieldName ?>)))  { 
            throw new SoapFault( "3", sprintf( $this->__(WEBAPI_VALIDATE_ERROR), '<?php print $fieldName ?>' ) ); 
        }
        
        // zmiana daty z soap na mysql
        if (isset($object-><?php print $fieldName ?>)) {
            $object-><?php print $fieldName ?> = $object-><?php print $fieldName ?> ? date_format(date_create($object-><?php print $fieldName ?>),"Y-m-d H:i:s") : null;
        }


<?php break; ?>                
<?php endswitch; ?>
<?php endif; ?>
<?php endforeach; 
} ?>


<?php function setFields($methodName, $fields, $modulename='') { ?>
    public function setFieldsFor<?php echo $methodName ?>( $object, $item ) {    
<?php     global $fieldsInfo; ?>
    	if (method_exists($item,"setCulture")) { $item->setCulture($this->__getCulture());}
<?php foreach ($fields as $key=>$value) : $fieldName = str_replace('=','',$value); ?>
<?php  if (isset($fieldsInfo[$fieldName]['custom'])): ?>
        if( isset( $object-><?php print $fieldName ?>) && is_callable('<?php echo $modulename ?>WebApi::set<?php print sfInflector::camelize($fieldName) ?>')) { <?php echo $modulename ?>WebApi::set<?php print sfInflector::camelize($fieldName) ?>($item, $object-><?php print $fieldName ?>); }
<?php else: ?>
        if( isset( $object-><?php print $fieldName ?>) && ( method_exists( $item, "<?php print "set".sfInflector::camelize($fieldName)?>" ) ) ) { $item-><?php print "set".sfInflector::camelize($fieldName) ?>( $object-><?php print $fieldName ?> ); }
<?php endif; ?>
<?php endforeach; ?>
    } 
<?php } ?>

<?php function follow($methods=array(), $key='', $step=0) { ?> 
    <?php if ($step==0): ?>
    $tmp = $item;
    <?php endif; ?>
    if (method_exists($tmp,'<?php print $methods[$step]; ?>')&&($tmp=$tmp-><?php print $methods[$step] ?>())!=null) {
        <?php if (isset($methods[$step+1])) {follow($methods, $key, $step+1);} else {?>
            $object-><?php print $key ?> = $tmp;
        <?php } ?>
    }
<?php } ?>

<?php function getFields($methodName, $fields, $modulename = '') { ?>
    public function getFieldsFor<?php echo $methodName ?>( $object, $item ) {
<?php global $fieldsInfo, $generator; ?>
<?php if (is_array($generator->getParameterValue('webapi.methods.'.$methodName.'.custom_fields'))): 
    $webApiFields_custom = array_merge($fieldsInfo, $generator->getParameterValue('webapi.methods.'.$methodName.'.custom_fields')); ?>
<?php else: $webApiFields_custom= $fieldsInfo; endif;?>
		if (method_exists($item,"setCulture" )) { $item->setCulture($this->__getCulture());}
<?php foreach ($fields as $key=>$value) : $fieldName = str_replace('=','',$value); ?>
<?php  if (isset($webApiFields_custom[$fieldName]['custom'])): ?>
        if (is_callable('<?php echo $modulename ?>WebApi::get<?php print sfInflector::camelize($fieldName) ?>')) { $object-><?php print $fieldName ?> = stWebApi::formatData(<?php echo $modulename ?>WebApi::get<?php print sfInflector::camelize($fieldName) ?>($item), "<?php print $webApiFields_custom[$value]['type']?>"); }
<?php else: ?>
        if (method_exists($item,"get<?php print sfInflector::camelize($fieldName) ?>" ) ) { $object-><?php print $fieldName ?> = stWebApi::formatData($item->get<?php print sfInflector::camelize($fieldName); ?>(),"<?php print isset($webApiFields_custom[$value]['type'])?$webApiFields_custom[$value]['type']:'string'?>");} 
<?php endif; ?>
<?php endforeach; ?>

}
<?php } ?>

<?php function TestAndValidate($methodName, $inFields) { ?>

    public function TestAndValidate<?php echo $methodName ?>Fields( $object ) {
        // Sprawdzenie wymaganych parametrow, powielamy dla wszystkich parametrow z parametrem required: true
<?php if ($inFields) testRequireFields($inFields); ?>
                
        // Walidacja parametrow
<?php if ($inFields) validateFields($inFields); ?>
    }    
<?php } ?>
<?php endif ?>

/** 
 * Klasa StApiProduct
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class <?php echo $this->getGeneratedModuleName() ?>WebApi extends stWebApiBase
{
    protected $_culture = null;
<?php if ($this->getParameterValue('webapi')): ?>
<?php foreach ($this->getParameterValue('webapi.methods') as $methodName => $method): 
if (isset($method['custom']) && $method['custom']) continue;
$type = $this->getParameterValue('webapi.methods.'.$methodName.'.type');
$inFields =  $this->getParameterValue('webapi.methods.'.$methodName.'.fields.in');
$outFields =  $this->getParameterValue('webapi.methods.'.$methodName.'.fields.out');

if (is_array($inFields)) { 
    TestAndValidate($methodName, $inFields);
}

if (!in_array($type, array('count', 'delete', 'list')) && is_array($inFields)) {
    setFields($methodName, $inFields, $this->getModuleName());
}

if (!in_array($type, array('count', 'delete')) && is_array($outFields)) { 
    getFields($methodName, $outFields, $this->getModuleName());
}

if ($this->getParameterValue('webapi.methods.'.$methodName.'.peer')) {
    $PeerName=$this->getParameterValue('webapi.methods.'.$methodName.'.peer');
}
else  
{
    $PeerName = $this->getParameterValue('model_class');

    $this->changeModelClass($PeerName);
} 
?>
      <?php switch ($type) : 
      
      case 'add': ?>


    /** 
     * Dodawanie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z numer id dodanych danych
     * @throws WEBAPI_ADD_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać waliadacje danych
     */
    public function <?php echo $methodName ?>( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        <?php if ($inFields) : ?>$this->TestAndValidate<?php echo $methodName ?>Fields( $object );<?php endif;?>
		                       
        $item = new <?php print $PeerName; ?>( );
        if ( $item )
        {
            <?php if ($inFields) : ?>$this->setFieldsFor<?php echo $methodName ?>( $object, $item );<?php endif;?>
            
            //Zapisywanie danych do bazy
            try {
                $item->save( );
            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR),$e->getMessage()));
            }
            
            // Zwracanie danych
            $object = new StdClass( );
            <?php if ($outFields) : ?>$this->getFieldsFor<?php echo $methodName ?>( $object, $item );<?php endif;?>
            return $object;

        } else {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_ADD_ERROR), "") );
        }
    }            
          <?php break; ?>
          <?php case 'update': ?>

    /** 
     * Aktualizacja danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_UPDATE_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać walidacje danych
     */
    public function <?php echo $methodName ?>( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        <?php if ($inFields) : ?>$this->TestAndValidate<?php echo $methodName ?>Fields( $object );<?php endif;?>
        
        $item = <?php print $PeerName; ?>Peer::retrieveByPk( $object->id );
        if ( $item )
        {
            <?php if ($inFields) : ?>$this->setFieldsFor<?php echo $methodName ?>( $object, $item );<?php endif;?>
          
            //Zapisywanie danych do bazy
            try {
                $item->save( );
            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR),$e->getMessage()) );
            }
            
            // Zwracanie danych
            $object = new StdClass( );
            $object->_update = 1;
            return $object;
            
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }
          <?php break; ?>
          <?php case 'get': ?>
    
    /** 
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function <?php echo $methodName ?>( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        <?php if ($inFields) : ?>$this->TestAndValidate<?php echo $methodName ?>Fields( $object );<?php endif;?>


        $item = <?php print $PeerName; ?>Peer::retrieveByPk( $object->id );
        if ( $item )
        {
            $object = new StdClass( );
            <?php if ($outFields) : ?>$this->getFieldsFor<?php echo $methodName ?>( $object, $item );<?php endif;?>
        
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }
          
          <?php break; ?>
          <?php case 'delete': ?>
    
    /** 
     * Usuwanie danych
     *
     * @param   object      $object             obiekt z danymi
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_DELETE_ERROR WEBAPI_REQUIRE_ERROR
     */
    public function <?php echo $methodName ?>( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        <?php if ($inFields) : ?>$this->TestAndValidate<?php echo $methodName ?>Fields( $object );<?php endif;?>


        $item = <?php print $PeerName; ?>Peer::retrieveByPk( $object->id );
        if ( $item )
        {
            // Zwracanie danych
          $obj = new StdClass( );
          $item->delete( );
          $obj->_delete = 1;
          return $obj;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }
          <?php break; ?>
          <?php case 'count': ?>

    /** 
     * Zwraca criteria dla metody <?php echo $methodName ?>
     *
     * @return  Criteria
     */
    public function get<?php echo $methodName ?>Criteria( $object )
    {
        $c = new Criteria();

        if (defined('<?php print $PeerName; ?>Peer::UPDATED_AT')) {
            if (isset($object->_modified_from) && isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $criterion->addAnd($c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
                $c->add($criterion);
            } else {
                if (isset($object->_modified_from)) {
                    $criterion = $c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                    $c->add($criterion);
                }
                
                if (isset($object->_modified_to)) {
                    $criterion = $c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                    $c->add($criterion);
                }
            }
        }
        
        return $c;
    }
   
    /** 
     * Licznie ilości rekordów
     *
     * @return  object      okiekt z liczba rekordów 
     * @throws WEBAPI_COUNT_ERROR
     */
    public function <?php echo $methodName ?>( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        <?php if ($inFields) : ?>$this->TestAndValidate<?php echo $methodName ?>Fields( $object );<?php endif;?>
        
        try{
            $c = $this->get<?php echo $methodName ?>Criteria($object);
        
            //Zwracanie danych            
            $obj = new StdClass( );
            $obj->_count = <?php print $PeerName; ?>Peer::doCount($c);
            return $obj;
        } catch ( Exception $e ) {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_COUNT_ERROR),$e->getMessage()) );
        }
    }
          <?php break; ?>
          <?php case 'list': ?>

    /** 
     * Zwraca criteria dla metody <?php echo $methodName ?>
     *
     * @return  Criteria
     */
    public function get<?php echo $methodName ?>Criteria( $object )
    {
        $c = new Criteria();

        if (defined('<?php print $PeerName; ?>Peer::UPDATED_AT')) {
            if (isset($object->_modified_from) && isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $criterion->addAnd($c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
                $c->add($criterion);
            } else {
                if (isset($object->_modified_from)) {
                    $criterion = $c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                    $c->add($criterion);
                }
                
                if (isset($object->_modified_to)) {
                    $criterion = $c->getNewCriterion(<?php print $PeerName; ?>Peer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                    $c->add($criterion);
                }
            }
        }
        
        return $c;
    }

    /** 
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function <?php echo $methodName ?>( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        <?php if ($inFields) : ?>$this->TestAndValidate<?php echo $methodName ?>Fields( $object );<?php endif;?>

        $c = $this->get<?php echo $methodName ?>Criteria($object);

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );
        if (defined('<?php print $PeerName;?>Peer::CREATED_AT')) {
          $c->addAscendingOrderByColumn(<?php print $PeerName;?>Peer::CREATED_AT);
        }
        
        $items = <?php print $PeerName; ?>Peer::doSelect( $c );
        
        if ( $items )
        {
          // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            foreach ( $items as $item )
            {
                $object = new StdClass( );
                <?php if ($outFields) : ?>$this->getFieldsFor<?php echo $methodName ?>( $object, $item );<?php endif;?>
        
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            return array( );
        }
    }   
  
          <?php break; ?>
          <?php endswitch; ?>
    <?php $this->restoreModelClass() ?>
<?php endforeach; ?>
<?php else:  ?>
  // moduł nie posiada skonfigurowanej obsługi WebApi
<?php endif ?>
};
?]
