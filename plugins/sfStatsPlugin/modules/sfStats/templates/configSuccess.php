<?php use_helper('stAdminGenerator', 'I18N', 'Date', 'Validation') ?>
<?php use_stylesheet('backend/style.css'); ?>
<?php use_stylesheet('backend/sfStatsPlugin.css'); ?>
<?php echo st_get_admin_head('stStatsPlugin', __('Konfiguracja raportów'), __('Raporty sklepu'), array("stProduct"=>"stProduct", "stOrder"=>"stOrder", "stUser"=>"stUser")) ?>
    <?php echo form_tag('sfStats/config', array()) ?>
        <div id="sf_admin_header">
            <?php include_partial('menu', array()) ?><br /><br />
        </div>
        <?php if ($sf_flash->has('notice')): ?>
            <div class="save-ok">
                <h2><?php echo $sf_flash->get('notice') ?></h2>
            </div>
        <?php endif; ?>

        <div class="form-row">
            <label id="stats_config_name"><?php echo __('Przedział czasowy raportów:') ?></label>
            <div id="sf_admin_content">
                <?php echo select_tag(
                    'st_stats[from]',
                    options_for_select(array(
                    'day'       => __('Dzień'),
                    'week'      => __('Tydzień'),
                    'month'     => __('Miesiąc'),
                    'quarter'   => __('Kwartał'),
                    'year'      => __('Rok'),
                    ), $config->get('from')
                    )
                ) ?>
            </div>
        <br class="st_clear_all">
        </div>


        <div class="form-row">
            <label id="stats_config_name"><?php echo __('Pokaż graf:') ?></label>
            <div id="sf_admin_content">
                <?php echo checkbox_tag('st_stats[graf]', true, $config->get('graf')) ?>
            </div>
        <br class="st_clear_all">
        </div>

        <div class="form-row">
            <label id="stats_config_name"><?php echo __('Rodzaj wizualizacji grafu:') ?></label>
            <div id="sf_admin_content">
                <?php echo select_tag(
                    'st_stats[graph]',
                    options_for_select(array(
                    'lines'         => __('Liniowy'),
                    'points'        => __('Punktowy'),
                    'bars'          => __('Słupkowy'),
                    ), $config->get('graph')
                    )
                ) ?>
            </div>
        <br class="st_clear_all">
        </div>

        <div class="form-row">
            <label id="stats_config_name"><?php echo __('Pokaż tabele wartości:') ?></label>
            <div id="sf_admin_content">
                <?php echo checkbox_tag('st_stats[statistics]', true, $config->get('statistics')) ?>
            </div>
        <br class="st_clear_all">
        </div>

        <?php echo st_get_admin_actions_head() ?>
            <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, 'name=save') ?>
        <?php echo st_get_admin_actions_foot() ?>
    </form>
<?php echo st_get_admin_foot() ?>