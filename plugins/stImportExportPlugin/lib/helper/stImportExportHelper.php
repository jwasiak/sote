<?php

function _get_propel_object_list_for_import_export($object, $method, $options)
{
  // get the lists of objects
  $through_class = _get_option($options, 'through_class');

  $c = new Criteria();
  $c->add(ExportFieldPeer::MODEL, $object->getModel());
  $c->add(ExportFieldPeer::IS_KEY, 0);
  
  $objects = sfPropelManyToMany::getAllObjects($object, $through_class, $c);

  if (sfContext::getInstance()->getRequest()->hasErrors()) {
      $ids = sfContext::getInstance()->getRequest()->getParameterHolder()->get('associated_field', 0);
      $c = new Criteria();
      $c->add(ExportFieldPeer::ID, $ids, Criteria::IN);
      $objects_associated = ExportFieldPeer::doSelect($c);
  } else {
      $objects_associated = sfPropelManyToMany::getRelatedObjects($object, $through_class, $c);
  }


  $ids = array_map(create_function('$o', 'return $o->getPrimaryKey();'), $objects_associated);

  return array($objects, $objects_associated, $ids);
}