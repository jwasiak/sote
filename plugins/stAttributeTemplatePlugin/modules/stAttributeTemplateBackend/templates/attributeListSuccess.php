<?php
/**
 * Szablon dla akcji attributeList
 *
 * @package stTemplateAttributePlugin
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: attributeListSuccess.php 8286 2008-08-01 16:10:01Z michal $
 */
?>
<?php use_helper('stAttributeTemplateBackend') ?>
<?php foreach ($attribute_fields as $attribute_field): ?>
    <p>
        <?php echo label_for('attribute_field_'.$attribute_field->getId(), $attribute_field->getName(),':') ?>
        <?php echo input_tag('attribute_field['.$attribute_field->getId().']', st_get_attribute_value($attributes, $attribute_field->getPrimaryKey())) ?>
    </p>
<?php endforeach; ?>