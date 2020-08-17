<?php use_helper('stCurrency') ?> 

<?php if($invoice->getIsProforma() != 1 ): ?>
    <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" width="20"><font size="8"><?php echo __('Lp') ?></font></td>
            
            <?php if ($config->get('show_product_code')): ?>
            
            <td align="center" width="50"><font size="8"><?php echo __('Kod') ?></font></td>
            
            <?php endif; ?>
            
            <td align="center" <?php if ($config->get('show_product_code')): ?> width="145" <?php else: ?> width="170" <?php endif; ?>><font size="8"><?php echo __('Nazwa') ?></font></td>
            
            <td align="center" width="30"><font size="8"><?php echo __('Ilość') ?></font></td>
            
            <td align="center" width="30"><font size="8"><?php echo __('j.m.') ?></font></td>
            
            <td align="center"><font size="8"><?php echo __('Cena jed.') ?><br/><?php echo __('netto') ?></font></td>

            <td align="center"><font size="8"><?php echo __('Cena jed.') ?><br/><?php echo __('brutto') ?></font></td>
            
            <td align="center" width="30"><font size="8"><?php echo __('VAT') ?><br/>[%]</font></td>
            
            <td align="center"><font size="8"><?php echo __('Wartość netto') ?></font></td>
            
            <td align="center"><font size="8"><?php echo __('VAT') ?></font></td>
            
            <td align="center"><font size="8"><?php echo __('Wartość brutto') ?></font></td>
        </tr>
        <?php $i = 0; ?>
        <?php foreach ($invoiceProducts as $product){ ?>
        
        <tr>
            <td  style="text-align:center;" width="20"><font size="8"><?php $i++; ?><?php echo $i; ?></font></td>
            
            <?php if ($config->get('show_product_code')): ?>
            
            <td align="center" width="50"><font size="8"><?php echo $product->getCode() ?></font></td>
            
            <?php endif; ?>
            
            <td align="center" <?php if ($config->get('show_product_code')): ?> width="145" <?php else: ?> width="170" <?php endif; ?>><font size="8"><?php echo $product->getName() ?></font></td>
            
            <td style="text-align:center;" width="30"><font size="8"><?php echo $product->getQuantity() ?></font></td>
            
            <td style="text-align:center;" width="30"><font size="8"><?php echo $product->getMeasureUnit() ?></font></td>
            
            <td style="text-align:right;"><font size="8"><?php echo st_back_price($product->getPriceNetto()) ?></font></td>

            <td style="text-align:right;"><font size="8"><?php echo st_back_price($product->getPriceBrutto()) ?></font></td>
            
            <td style="text-align:center;" width="30"><font size="8"><?php echo $product->getVat()->getVatName() ?></font></td>
            
            <td style="text-align:right;"><font size="8"><?php echo st_back_price($product->getTotalPriceNetto()) ?></font></td>
            
            <td style="text-align:right;"><font size="8"><?php echo st_back_price($product->getVatAmmount()) ?></font></td>
            
            <td style="text-align:right;"><font size="8"><?php echo st_back_price($product->getOptTotalPriceBrutto()) ?></font></td>
        </tr>
        
    <?php } ?>
    
    </table>
    
<?php else: ?>

    <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" width="20"><font size="8"><?php echo __('Lp') ?></font></td>
            
            <?php if ($config->get('show_product_code')): ?>
            
            <td align="center" width="50"><font size="8"><?php echo __('Kod') ?></font></td>
            
            <?php endif; ?>
            
            <td align="center" <?php if ($config->get('show_product_code')): ?> width="318" <?php else: ?> width="348" <?php endif; ?>><font size="8"><?php echo __('Nazwa') ?></font></td>
            
            <td align="center" width="40"><font size="8"><?php echo __('Ilość') ?></font></td>
            
            <td align="center" width="40"><font size="8"><?php echo __('j.m.') ?></font></td>
            
            <td align="center"><font size="8"><?php echo __('Wartość brutto') ?></font></td>
        </tr>
        <?php $i = 0; ?>
        <?php foreach ($invoiceProducts as $product){ ?>
        
        <tr>
            <td  style="text-align:center;" width="20"><font size="8"><?php $i++; ?><?php echo $i; ?></font></td>
            
           <?php if ($config->get('show_product_code')): ?>
            
            <td align="center" width="50"><font size="8"><?php echo $product->getCode() ?></font></td>
            
            <?php endif; ?>
            
            <td align="center" <?php if ($config->get('show_product_code')): ?> width="318" <?php else: ?> width="348" <?php endif; ?>><font size="8"><?php echo $product->getName() ?></font></td>
            
            <td style="text-align:center;" width="40"><font size="8"><?php echo $product->getQuantity() ?></font></td>
            
            <td style="text-align:center;" width="40"><font size="8"><?php echo $product->getMeasureUnit() ?></font></td>
            
            <td style="text-align:right;"><font size="8"><?php echo st_back_price($product->getOptTotalPriceBrutto()) ?></font></td>
        </tr>
        
    <?php } ?>
    
    </table>

<?php endif; ?>