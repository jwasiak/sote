<table cellspacing="0" cellpadding="0" class="st_record_list record_list" style="width: 100%">
    <thead>         
        <tr> 
            <th><b><?php echo __('Szczegółowe określenie zawartości') ?></b></th>
            <th><?php echo __('Ilość') ?></th>
            <th><?php echo __('Masa netto') ?></th>
            <th><b><?php echo __('Wartość') ?></b></th>
            <th><?php echo __('Numer taryfowy zharmonizowanego systemu') ?></th>
            <th><?php echo __('Kraj pochodzenia towarów') ?></th>
        </tr>
        <tr> 
            <th></th>
            <th></th>
            <th><?php echo __('kg') ?></th>
            <th><?php echo $params['waluta'] ?></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php for ($index = 0; $index < 5; $index++): $szczegoly = isset($value[$index]) ? $value[$index] : null ?>
            <tr>    
                <td><?php echo input_tag($name.'['.$index.'][okreslenie_zawartosci]',  $szczegoly ? $szczegoly->okreslenieZawartosci : null, array('style' => 'width: 100%; min-width: 250px')) ?></td>
                <td><?php echo input_tag($name.'['.$index.'][ilosc]',  $szczegoly ? $szczegoly->ilosc : null, array('class' => 'amount', 'size' => 8)) ?></td>
                <td><?php echo input_tag($name.'['.$index.'][masa_netto]',  $szczegoly ? $szczegoly->masaNetto / 1000 : null, array('class' => 'integer', 'size' => 8)) ?></td>
                <td><?php echo input_tag($name.'['.$index.'][wartosc]',  $szczegoly ? $szczegoly->wartosc / 100 : null, array('class' => 'integer', 'size' => 8)) ?></td>
                <td><?php echo input_tag($name.'['.$index.'][numer_taryfy_hs]',  $szczegoly ? $szczegoly->numerTaryfyHs : null, array('style' => 'width: 100%', 'maxlength' => 6)) ?></td>
                <td><?php echo st_poczta_polska_countries_select_tag($name.'['.$index.'][kraj_pochodzenia_kod_alfa2]',  $szczegoly ? $szczegoly->krajPochodzeniaKodAlfa2 : 'PL', array('iso' => true, 'style' => 'width: 100%')) ?></td>
            </tr>
        <?php endfor ?>
    </tbody>
</table>