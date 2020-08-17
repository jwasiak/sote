<input type="hidden" name="config[availability]" value="" />
<ul class="st_admin-item-list">
    <?php foreach(stCeneo::getAvailabilities() as $availability):?>
        <li style="padding-bottom: 7px;">
            <span style="width: 240px; padding-top: 2px;"><?php echo __('Dostępność w sklepie').': "'.$availability->getAvailabilityName().'"';?></span>
            <?php echo __('Dostępność w Ceneo');?>: <?php echo select_tag('config[availability_'.$availability->getId().']', options_for_select(stCeneo::getCeneoAvailabilities(), $config->get('availability_'.$availability->getId())));?>
        </li>
    <?php endforeach;?>
</ul>