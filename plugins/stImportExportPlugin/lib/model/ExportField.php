<?php

/**
 * Subclass for representing a row from the 'st_export_field' table.
 *
 * 
 *
 * @package plugins.stImportExportPlugin.lib.model
 */ 
class ExportField extends BaseExportField
{
    public function  __toString() {
        return sfContext::getInstance()->getI18N()->__($this->getName(),array(),$this->getI18nFile())."::".$this->getField();
    }

    public function getI18nFile()
    {
    	if (!empty($this->i18n_file)) return $this->i18n_file;
    	return $this->getModel().'_import_export';
    }

    public function getProfileName()
    {
        return sfContext::getInstance()->getI18N()->__($this->getName(), null, $this->getI18nFile());
    }
}
