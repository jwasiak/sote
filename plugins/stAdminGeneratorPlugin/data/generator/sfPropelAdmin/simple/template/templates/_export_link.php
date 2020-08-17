[?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?]

    [?php echo st_get_admin_actions_head('style="float: left"') ?]
        [?php echo st_get_admin_action('file', __('Pobierz plik', array(), 'stImportExportBackend'), $link , array (  'name' => 'save',)) ?]
    [?php echo st_get_admin_actions_foot() ?]