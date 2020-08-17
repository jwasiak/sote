<?php
   $c = new Criteria();

   $select_options = array('' => '---');

   foreach (AvailabilityPeer::doSelectWithI18n($c) as $availability)
   {
      $select_options[$availability->getId()] = $availability->getAvailabilityName();
   }

   echo  select_tag('filters[avail]', options_for_select($select_options, isset($filters['avail']) ? $filters['avail'] : null));