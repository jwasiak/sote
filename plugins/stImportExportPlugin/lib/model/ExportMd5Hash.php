<?php

/**
 * Subclass for representing a row from the 'st_export_md5_hash' table.
 *
 * 
 *
 * @package plugins.stImportExportPlugin.lib.model
 */ 
class ExportMd5Hash extends BaseExportMd5Hash
{
    protected $backup = array();

    public function setModel($model)
    {
        $this->setTypeId(ExportMd5HashPeer::getModelHash($model));
    }

    public function runDataHashCheck($name, $data, $update = false)
    {   
        $data = str_replace(array("\r\n"), array("\n"), trim($data));
        $hash = md5($data);
        $check = isset($this->md5hash[$name]) && $this->md5hash[$name] == $hash;

        if (!$check && $update)
        {
            $this->updateMd5Hash($name, $hash);
        }

        return $check;
    }

    public function updateMd5Hash($name, $hash)
    {
        $md5hash = $this->getMd5Hash();

        if (!isset($this->backup[$name]) && !$this->isNew())
        {
            $this->backup[$name] = $md5hash[$name];
        }

        $md5hash[$name] = $hash;
        $this->setMd5Hash($md5hash);
    }

    public function restoreMd5Hash($name)
    {
        $md5hash = $this->getMd5Hash();
        $md5hash[$name] = $this->isNew() ? null : $this->backup[$name];
        $this->setMd5Hash($md5hash);        
    }
}
