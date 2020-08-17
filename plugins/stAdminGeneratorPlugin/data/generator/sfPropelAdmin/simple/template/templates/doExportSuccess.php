[?php echo $pb->showProgressBar($actual_step); ?]
[?php if ($errors):?]
    [?php echo link_to_remote(__('Wyświetl błędy eksportu', array(), 'stImportExportBackend'), array('update'=>'export_log', 'url'=>'stProduct/exportLog?file='.$logFile))?].
[?php endif; ?]
<div id="export_log"></div>