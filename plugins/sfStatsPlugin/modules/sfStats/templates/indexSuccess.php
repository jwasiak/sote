<?php use_helper('stAdminGenerator', 'I18N', 'Date', 'Validation') ?>

<?php use_stylesheet('backend/stStatsPlugin.css'); ?>

<?php if (sfConfig::get('app_sfStats_include_jquery', true)): ?>
    <?php use_javascript('/js/flot/jquery.js') ?>
<?php endif; ?>

<?php use_javascript('/js/flot/jquery.flot.js') ?>

<?php echo st_get_admin_head('stStatsPlugin', __('Generowanie raportów'), __('Raporty sklepu'), array("stProduct"=>"stProduct", "stOrder"=>"stOrder", "stUser"=>"stUser")) ?>
    <div id="sf_admin_header">
        
        <?php include_partial('menu', array()) ?><br /><br />
        
        <?php include_partial('filters', array(
            'filters'        => $filters,
            'items'          => $items,
            'specialFilters' => isset($specialFilters) ? $specialFilters : array()
        )) ?>
    </div>

    <div id="sf_admin_content">
        <?php if (!$statistics && !$graf): ?>
                <?php echo __('Niestety nie jest ustawiona wizualizacja raportów.') ?>
            <?php else: ?>
                <?php if (isset($stats)): ?>
                    <?php if($graf): ?>
                        <?php include_partial('chart', array('stats' => $stats, 'graph' => $graph)) ?>
                    <?php endif; ?>
                    <?php if ($statistics): ?>
                        <?php include_partial('table_of_values', array('stats' => $stats, 'filters' => $filters)) ?>
                    <?php endif; ?>
                <?php elseif (count($item_config)): ?>
                    <?php echo __('Wybierz typ raportów z listy') ?>
                <?php endif; ?>
        <?php endif; ?>
    </div>
    <br class="st_clear_all">
    
    <div id="sf_admin_footer">
    </div>
<?php echo st_get_admin_foot() ?>