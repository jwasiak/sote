<li>
    <b><?php echo $index ?>.</b>
    <span id="<?php echo 'attribute_field_'.$attribute_field->getId() ?>" class="st_application-st_attribute_template-attribute_row"><?php echo $attribute_field->getName() ?></span>
    <ul class="st_attribute_template-field-menu">
        <li>
            <?php echo link_to(image_tag('backend/category_tree/arrows/arrow_up.png'),'stAttributeFieldBackend/attributeMoveUp?id='.$attribute_field->getId().'&template_id='.$attribute_field->getAttributeTemplateId()) ?>
        </li>
        <li>
            <?php echo link_to(image_tag('backend/category_tree/arrows/arrow_down.png'),'stAttributeFieldBackend/attributeMoveDown?id='.$attribute_field->getId().'&template_id='.$attribute_field->getAttributeTemplateId()) ?>
        </li>    
        <li>
            <?php echo link_to(image_tag('backend/icons/delete.png'),'stAttributeFieldBackend/deleteAttribute?id='.$attribute_field->getId().'&template_id='.$attribute_field->getAttributeTemplateId()) ?>
        </li>
    </ul>
    <br class="st_clear_all" />
    
    <div id="attribute_field_validation_message_ajax<?php echo $attribute_field->getId() ?>" style="color: red;display: none"><?php echo __("Wprowadzono niepoprawne dane. Zmiany cofnięte.") ?></div>
    <script type="text/javascript">
    
        //<![CDATA[
        new Ajax.InPlaceEditor('attribute_field_<?php echo $attribute_field->getId() ?>', '/backend_dev.php/attribute_field/ajaxEditAttribute/id/<?php echo $attribute_field->getId() ?>', {cancelControl:'button',okText:"Ok",cancelText:"<?php echo __("Anuluj") ?>",savingText:"<?php echo __("Zapisywanie...") ?>",clickToEditText:"<?php echo __("Kliknij aby edytować") ?>"});
        //]]>

    </script>  
    
</li>