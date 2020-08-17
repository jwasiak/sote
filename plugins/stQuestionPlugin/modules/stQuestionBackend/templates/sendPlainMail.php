<?php echo __("Nazwa produktu:") ?><?php echo $product_name ?>
<?php if ($product_code): ?><?php echo __("Kod produktu:") ?><?php echo $product_code ?><?php endif; ?>
<?php if ($product_producer): ?><?php echo __("Producent:") ?><?php echo $product_producer ?><?php endif; ?>
<?php if ($product_category): ?><?php echo __("Kategoria:") ?><?php echo $product_category ?><?php endif; ?>
<?php echo __('Treść odpowiedzi:')?><?php echo $question->getAnswerText()?>