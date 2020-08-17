<?php 
    $message = !$status || $status == "INACTIVE" ? __('Przy wystawieniu oferty') : __('Prz zapisaniu oferty');
?>
<table cellspacing="0" cellpadding="0" class="st_record_list record_list" style="width: 100%">
    <thead>         
        <tr> 
            <th><?php echo __('Opłata') ?></th>
            <th><?php echo __('Data naliczenia opłaty') ?></th>
            <th>&nbsp;</th>
        </tr>    
    </thead>
    <tbody>
        <?php foreach ($fees->quotes as $index => $quote): ?>
            <tr>
                <td><?php echo $quote->name ?></td>
                <td><?php echo $quotes && isset($quotes->quotes[$index]) ? stAllegroApi::formatDate($quotes->quotes[$index]->nextDate) : $message ?></td>
                <td><?php echo $quote->fee->amount ?> <?php echo $quote->fee->currency ?> / <?php echo stAllegroApi::getIntervalToDays($quote->cycleDuration) ?> <?php echo __('dni') ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
