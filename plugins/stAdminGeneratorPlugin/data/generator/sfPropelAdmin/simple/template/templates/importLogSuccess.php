<br />
<table class="st_record_list"  cellspacing="0">
    <thead>
        <tr>
            <th>[?php echo __('Identyfikator', null, 'stImportExportBackend') ?]</th>
            <th>[?php echo __('Typ', null, 'stImportExportBackend') ?]</th>
            <th>[?php echo __('Opis', null, 'stImportExportBackend') ?]</th>
        </tr>
    </thead>
    <tbody>
[?php foreach ($logs as $log): ?]
    [?php if (count($log)==3): ?]
        <tr>
            <td>[?php echo $log[0]; ?]</td>
            <td>[?php switch($log[2]) {
                    case stImportExportLog::$FATAL: echo __('Błąd krytyczny', array(), 'stImportExportBackend'); break;
                    case stImportExportLog::$WARNING: echo __('Błąd', array(), 'stImportExportBackend'); break;
                    case stImportExportLog::$NOTICE: echo __('Ostrzeżenie', array(), 'stImportExportBackend'); break;
                    default: echo __('Ostrzeżenie'); break;
                    }
                ?]</td>
            <td>[?php echo $log[1]; ?]</td>
        </tr>
    [?php endif; ?]
[?php endforeach; ?]
    </tbody>
</table>