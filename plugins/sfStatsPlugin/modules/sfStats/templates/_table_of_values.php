<?php
    $total = 0;
    foreach($stats as $key) $total += $key;
?>

<legend><h2><?php echo __('Tabela wartości', null, 'sfStats') ?></h2></legend>    
<br />
<table cellspacing="0" class="sf_admin_list">
<thead>
    <tr>
        <th><?php echo __('Data', null, 'sfStats') ?></th>
        <th style="padding: 2px 5px; text-align: right"><?php echo __('Wartość', null, 'sfStats') ?></th>
    </tr>
</thead>
<tbody>
    <?php $my_date=substr(($filters['period']['from']),-5, 2)?>
    <?php foreach ($stats as $key => $value): ?>
        <tr class="sf_admin_row">
            <?php if ($filters['increment'] == 3600): ?>
                <td><?php echo format_date($key).", ".$my_date.":00" ?> </td>
            <?php else: ?>
                <td><?php echo format_date($key) ?></td>
            <?php endif; ?>
            <td style="padding: 3px 5px;" align="right"><?php echo $value ?></td>
        </tr>
        <?php $my_date++;?>
        <?php if ($my_date==24) $my_date=00;?>
    <?php endforeach; ?>
</tbody>
<tfoot>
    <tr>
        <th><?php echo __('Łącznie', null, 'sfStats') ?></th>
        <th style="padding: 2px 5px; text-align: right"><?php echo $total ?></th>
    </tr>
</tfoot>
</table>