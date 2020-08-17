<div style="white-space: normal">
    <?php 
    $fields = array();
    foreach ($export_profile->getExportProfileHasExportFieldsJoinExportField() as $field)
    {
        $field_name = explode(":", $field->getExportField()->__toString());
        $fields[] = $field_name[0];  
    }
    echo implode(", ", $fields);
    ?>
</div>