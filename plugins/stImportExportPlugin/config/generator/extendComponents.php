    public function executeExportMenu()
    {
        $this->items = array();
        
<?php foreach ($this->getParameterValue('export.menu.display', array()) as $item): ?>
        $this->items["<?php echo $this->replaceConstants($this->getParameterValue('export.menu.fields.'.$item.'.action')) ?>"] = '<?php echo $this->getParameterValue('export.menu.fields.'.$item.'.name') ?>';
<?php endforeach; ?>  
    } 

    public function executeImportMenu()
    {
        $this->items = array();
        
<?php foreach ($this->getParameterValue('import.menu.display', array()) as $item): ?>
        $this->items["<?php echo $this->replaceConstants($this->getParameterValue('import.menu.fields.'.$item.'.action')) ?>"] = '<?php echo $this->getParameterValue('import.menu.fields.'.$item.'.name') ?>';
<?php endforeach; ?>  
    } 