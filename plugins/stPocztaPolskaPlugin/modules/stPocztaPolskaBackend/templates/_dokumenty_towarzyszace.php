<table cellspacing="0" cellpadding="0" class="st_record_list record_list" style="width: 100%">
    <thead>         
        <tr> 
            <th><b><?php echo __('Rodzaj') ?></b></th>
            <th><?php echo __('Numer') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php for ($index = 0; $index < 5; $index++): $dokument = isset($value[$index]) ? $value[$index] : null ?>
            <tr>    
                <td><?php echo select_tag($name.'['.$index.'][rodzaj]', options_for_select(stPocztaPolskaClient::getDokumentTowarzyszacyRodzaje(), $dokument ? $dokument->rodzaj : null, array("include_custom" => '---')), array('style' => 'width: 100%')) ?></td>
                <td><?php echo input_tag($name.'['.$index.'][numer]',  $dokument ? $dokument->numer : null, array('style' => 'width: 100%')) ?></td>            </tr>
        <?php endfor ?>
    </tbody>
</table>