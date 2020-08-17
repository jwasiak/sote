<?php

function producer_picker_input_tag($name, array $defaults = array())
{
   return st_tokenizer_input_tag($name, st_url_for('@stProducer?action=ajaxSearchToken'), $defaults, array(
      'tokenizer' => array(
         'preventDuplicates' => true, 
         'hintText' => __('Wpisz nazwę szukanego producenta', array(), 'stProducer'),
      )
      )); 
}

function producer_select_tag($name, $producer, $options = array())
{
   static $select_options = null;

   if ($select_options === null)
   {
      $cache = stFunctionCache::getInstance('stProducer');

      $select_options = $cache->cacheCall('_producer_tag_helper');
   }

   return select_tag($name, options_for_select($select_options, is_object($producer) && $producer instanceof Producer ? $producer->getId() : $producer, $options));
}

function _producer_tag_helper()
{
   $producers = array();

   $c = new Criteria();

   $c->addSelectColumn(ProducerPeer::ID);

   $c->addSelectColumn(ProducerPeer::OPT_NAME);

   $c->addAscendingOrderByColumn(ProducerPeer::OPT_NAME);

   $rs = ProducerPeer::doSelectRs($c);

   while($rs->next())
   {
      list($id, $name) = $rs->getRow();

      $producers[$id] = $name;
   }

   return $producers;
}