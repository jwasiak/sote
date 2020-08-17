<?php 

function st_product_options_picker_show($namespace, $options, &$selected_ids = array())
{
   $select_options = array();

   $field_id = $options[0]->getProductOptionsField()->getId();

   $selected = $options[0];

   $last_option_id = end($options)->getId();

   foreach ($options as $option)
   {
      $option_id = $option->getId();

      $field = $option->getProductOptionsField();

      $current_field_id = $field->getId();

      $selected_id = isset($selected_ids[$current_field_id]) ? $selected_ids[$current_field_id] : null;

      if ($field_id != $current_field_id)
      {
         echo '<li><label><span>'.$selected->getProductOptionsField()->getName().'</span>'.select_tag($namespace.'['.$selected->getProductOptionsFieldId().']',options_for_select($select_options, $selected->getId()), array('data-field' => $selected->getProductOptionsFieldId())).'</label></li>'; 

         if ($selected->hasChildren())
         {
            st_product_options_picker_show($namespace, $selected->getChildOptions(), $selected_ids);
         }

         $select_options = array();

         $field_id = $current_field_id;
         $selected_ids[$selected->getProductOptionsFieldId()] = $selected->getId();
         $selected = $option;
      }
      elseif ($selected_id && $selected_id == $option_id || null === $selected_id && $option->getOptValue() == $field->getOptDefaultValue())
      {
         $selected = $option;
         $selected_ids[$selected->getProductOptionsFieldId()] = $selected->getId();
      }

      $select_options[$option_id] = $option->getValue();

      if ($last_option_id == $option_id)
      {
         echo '<li><label><span>'.$selected->getProductOptionsField()->getName().'</span>'.select_tag($namespace.'['.$selected->getProductOptionsFieldId().']',options_for_select($select_options, $selected->getId()), array('data-field' => $selected->getProductOptionsFieldId())).'</label></li>';  

         $selected_ids[$selected->getProductOptionsFieldId()] = $selected->getId();

         if ($selected->hasChildren())
         {
            st_product_options_picker_show($namespace, $selected->getChildOptions(), $selected_ids);
         }
      }
   }
}