[?php

class <?php echo $this->getGeneratedModuleName() ?>ImportExport extends stImportExportPropel
{

    <?php echo 'public $model = "'.(strlen($this->getParameterValue('import_export_model_class'))?$this->getParameterValue('import_export_model_class'):$this->getClassName()).'"'; ?>;
    
    <?php 
       $export = array();
       $import = array();
       $export['fields'] =  $this->getParameterValue('export.fields', array());

       foreach ($export['fields'] as $key => $field)
       {
           if (isset($field['type'])) continue;

           $export['fields'][$key]['type'] = null;
       }

       $import['fields'] =  $this->getParameterValue('import.fields', array());
       
       foreach ($import['fields'] as $key => $field)
       {
           if (isset($field['type'])) continue;

           $import['fields'][$key]['type'] = null;
       }

       $import['primary_key'] =  $this->getParameterValue('import.primary_key');
       $import['default_class'] = $this->getParameterValue('import.default_class');
       $export['primary_key'] =  ($this->getParameterValue('export.primary_key'))?$this->getParameterValue('export.primary_key'):$this->getParameterValue('import.primary_key');
       ?>
    <?php if($this->getParameterValue('export.limit')>0) echo 'protected $export_limit = '.$this->getParameterValue('export.limit').';'  ?>
    <?php if($this->getParameterValue('import.limit')>0) echo 'protected $import_limit = '.$this->getParameterValue('import.limit').';'  ?>

    <?php echo 'public static function getExport()' ?>
    <?php echo '{' ?>
    <?php echo '   return '.var_export($export,true).';' ?>
    <?php echo '}' ?>

    <?php echo 'public static function getImport()' ?>
    <?php echo '{' ?>
    <?php echo '   return '.var_export($import,true).';' ?>
    <?php echo '}' ?>

    public function __construct($method='', $class = '', $file='', $profile = 0)
    {
        $this->import = self::getImport();
        $this->export = self::getExport();
        parent::__construct($method, $class, $file, $profile);
    }
}
?]