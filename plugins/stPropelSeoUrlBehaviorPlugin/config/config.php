<?php
sfPropelBehavior::registerHooks('stPropelSeoUrlBehavior', array(
  ':save:pre'   => array('stPropelSeoUrlBehavior', 'preSave'),
  ':save:post'   => array('stPropelSeoUrlBehavior', 'postSave'),
));

sfPropelBehavior::registerMethods('stPropelSeoUrlBehavior', array (
  array (
    'stPropelSeoUrlBehavior',
    'getFriendlyUrl'
  ),
));
