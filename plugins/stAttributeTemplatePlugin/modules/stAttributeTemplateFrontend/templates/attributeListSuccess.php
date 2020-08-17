<?php 
/**
 * Szablon wyswietlajacy listę atrybutów z wartościami dla danego produktu
 *
 * @package stAttributeTemplatePlugin
 * @subpackage stAttributeTemplateFrontend
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @copyright SOTE
 * @license SOTE
 * @version $Id: attributeListSuccess.php 9938 2008-08-26 11:38:52Z omarcin $
 */
?>
<div id="st_application-st_attribute_template_plugin">
    <?php if(count($attributes)!=0): ?>
        <ul class="st_attribute_template-field-values">
            <?php foreach ($attributes as $attribute): ?>
                <?php if ($attribute->getValue()): ?>
                    <li><em><?php echo $attribute->getAttributeField()->getName() ?></em> <?php echo $attribute->getValue() ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>