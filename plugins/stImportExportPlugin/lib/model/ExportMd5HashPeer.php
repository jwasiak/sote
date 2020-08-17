<?php

/**
 * Subclass for performing query and update operations on the 'st_export_md5_hash' table.
 *
 * 
 *
 * @package plugins.stImportExportPlugin.lib.model
 */ 
class ExportMd5HashPeer extends BaseExportMd5HashPeer
{
    protected static $pool = array();

    protected static $modelHash = array();

    public static function getModelHash($model)
    {
        if(!isset(self::$modelHash[$model]))
        {
            self::$modelHash[$model] = crc32($model);
        }

        return self::$modelHash[$model];
    }

    public static function retrieveByModelId($id, $model)
    {
        $pool = $id.$model;
        
        if (!isset(self::$pool[$pool]))
        {
            $hash = null !== $id ? self::retrieveByPK($id, self::getModelHash($model)) : null;

            if (null === $hash)
            {
                $hash = new ExportMd5Hash();
                $hash->setId($id);
                $hash->setModel($model);
            }

            if (null === $id)
            {
                return $hash;
            }

            self::$pool[$pool] = $hash;
        }

        return self::$pool[$pool];
    }

    public static function clearHash($id, $model, $name)
    {
        $hash = ExportMd5HashPeer::retrieveByModelId($id, 'Product');
        if (null !== $hash)
        {
            $hash->updateMd5Hash($name, null);
            $hash->save();
        }        
    }
}
