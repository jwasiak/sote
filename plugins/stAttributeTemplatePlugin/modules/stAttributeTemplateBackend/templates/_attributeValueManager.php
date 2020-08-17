<?php
/**
 * Szablon dla komponentu attributeValueManager
 *
 * @package stTemplateAttributePlugin
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: _attributeValueManager.php 10141 2008-08-28 15:42:52Z marcin $
 */
?>

<?php use_helper('Form', 'Object', 'Javascript', 'stAttributeTemplateBackend'); ?>


    <p>
        <?php echo object_select_tag($attribute_template, 'getId',array('related_class' => 'AttributeTemplate', 'control_name' => 'attribute_template_id', 'onchange' => remote_function(array('url' => 'stAttributeTemplateBackend/attributeList?product_id='.$product_id, 'update' => 'st_attribute_field-list', 'with' => "'template_id=' + this.options[this.selectedIndex].value")), 'include_custom' => 'Brak')) ?>
    </p>
    <div id="st_attribute_field-list">
        <?php foreach ($attribute_fields as $attribute_field): ?>
            <p>
                <?php echo label_for('attribute_field_'.$attribute_field->getId(), $attribute_field->getName().':') ?>
                <?php echo input_tag('attribute_field['.$attribute_field->getId().']',st_get_attribute_value($attributes, $attribute_field->getPrimaryKey())) ?>
            </p>
        <?php endforeach; ?>
    </div>