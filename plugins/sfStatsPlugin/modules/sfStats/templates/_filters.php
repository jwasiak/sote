<?php echo form_tag('sfStats/index', array('method' => 'get')) ?>
    
    <fieldset>
        <legend><h2><?php echo __('Filtry', null, 'sfStats') ?></h2></legend>
        <div class="form-row">
        <label for="updated_at" style="width: 120px; text-align: right;"><?php echo __('Typ:', null, 'sfStats') ?></label>
            <div class="content" style="margin-left: 150px;">
                <?php echo select_tag(
                    'filters[what]',
                    options_for_select($items, isset($filters['what']) ? $filters['what'] : sfConfig::get('app_sfStats_default_item'))
                ) ?>
            </div>
        </div>
    
        <div class="form-row">
        <label for="updated_at" style="width: 120px; text-align: right;"><?php echo __('Od:', null, 'sfStats') ?></label>
            <div class="content" style="margin-left: 150px;">
                <?php echo input_date_range_tag('filters[period]',
                    isset($filters['period']) ? $filters['period'] : null,
                    array (
                    'rich'                => true,
                    'withtime'            => true,
                    'culture'             => 'pl',
                    'calendar_button_img' => '/sf/sf_admin/images/date.png',
                    'readonly'            => true,
                    'middle'              => '&nbsp;' . __('Do:', null, 'sfStats') . '&nbsp;'
                    )
                ) ?>
            </div>
        </div>
        
        <div class="form-row">
        <label for="filters_increment" style="width: 120px; text-align: right;"><?php echo __('Jednostka czasu:', null, 'sfStats') ?></label>
            <div class="content" style="margin-left: 150px;">
                <?php echo select_tag(
                    'filters[increment]',
                    options_for_select(array(
                    60 * 60                 => __('Godzina', null, 'sfStats'),
                    60 * 60 * 24            => __('Dzień', null, 'sfStats'),
                    60 * 60 * 24 * 7        => __('Tydzień', null, 'sfStats'),
                    60 * 60 * 24 * 30       => __('Miesiąc', null, 'sfStats'),
                    60 * 60 * 24 * 30 * 12  => __('Rok', null, 'sfStats')
                    ), isset($filters['increment']) ? $filters['increment'] : 60 * 60 * 24
                    )
                ) ?>
            </div>
        </div>
        
        <?php foreach ($specialFilters as $filterKey => $filterParams): ?>
            <div class="form-row">
            <label for="filters_special_<?php echo $filterKey ?>"><?php echo $filterParams['name'] ?>:</label>
                <div class="content">
                    <?php echo select_tag(
                        'filters[special]['.$filterKey.']',
                        '<option value=""></option>' . options_for_select($filterParams['values'], isset($filters['special'][$filterKey]) ? $filters['special'][$filterKey] : '')
                    ) ?>
                </div>
            </div>
        <?php endforeach; ?>
    
        <ul class="sf_admin_actions">
            <li><?php echo submit_tag(__('Szukaj', null, 'sfStats'), array('name'=>'filter', 'id'=>'commit', 'style'=>'background-image:url(/images/backend/icons/filter.png); background-position:6px 1px; background-repeat:no-repeat; background-color:transparent; border:none;')) ?></li>
            <li><?php echo button_to(__('Wyczyść filtr', null, 'sfStats'), 'sfStats/index?filter=filter', array('name'=>'filter', 'id'=>'commit', 'style'=>'background-image:url(/images/backend/icons/reset.png); background-position:2px 1px; background-repeat:no-repeat; background-color:transparent; border:none;')) ?></li>
        </ul>
    </fieldset>

</form>