[?php echo $pb->showProgressBar($actual_step); ?]
[?php if ($errors):?]
    [?php echo link_to_remote(__('Wyświetl błędy importu', array(), 'stImportExportBackend'), array('update'=>'import_log', 'url'=>'stProduct/importLog?file='.$logFile))?].
[?php endif; ?]
<div id="import_log"></div>