<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <?php $i=1;?>
    <tr bgcolor="#f1f1f1">
        <th align="left"><?php echo __('Nr');?></th>
        <th align="left"><?php echo __('Ikonka');?></th>
        <th align="left"><?php echo __('Nazwa');?></th>
        <th align="left"><?php echo __('Opis');?></th>
        <th align="left"><?php echo __('Status');?></th>
    </tr>
    <?php foreach ($apps as $mode => $val):?>
        <?php if ($mode != 'all'):?>
            <?php foreach ($val as $id => $app):?>
                <tr>
                    <td width="50px">
                        <?php echo $i;?>.
                    </td>
                    <td width="50px">
                        <?php $appImage = 'images/backend/main/icons/red/'.$app.'.png';?>    
                        <img width="30" height="30" src="/<?php echo (is_file($appImage) ? $appImage : 'images/update/red/modules/empty.png');?>"/>
                    </td>
                    <td width="30%">
                        <?php echo $app;?>
                    </td>
                    <td>
                        <?php echo stApplication::getAppName($app);?>
                    </td>
                    <td align="right">
                        <?php
                           switch ($mode)
                           {
                               case 'added': echo '<span style="color:#3380cc">'.__('Dodaj')."</span>";
                               break;
                               case 'changed': echo '<span style="color:#009933">'.__('Aktualizuj')."</span>";
                               break;
                               case 'deleted': echo '<span style="color:red">'.__('Usuń').'</span>';
                               break;
                           }
                        ?>
                    </td>
                </tr>
                <?php $i++;?>
            <?php endforeach;?>
        <?php endif;?>
    <?php endforeach;?>
</table> 
