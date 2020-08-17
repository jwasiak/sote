<input type="hidden" name="config[availability]" value="" />
<table class="st_record_list st_record_manager" cellspacing="0" style="margin: 7px 0 0 7px; margin-left: 350px;">
    <thead>
        <tr>
            <th><?php echo __('Dostępność w sklepie');?></th>
            <th><?php echo __('Dostępność w Google Shopping');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach(stGoogleShopping::getAvailabilities() as $availability):?>
            <tr>
                <td style="text-align: left;">
                    <?php echo $availability->getAvailabilityName();?>
                </td>
                <td>
                    <?php echo select_tag('config[availability_'.$availability->getId().']', options_for_select(stGoogleShopping::getGoogleShoppingAvailabilities(), $config->get('availability_'.$availability->getId())));?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
