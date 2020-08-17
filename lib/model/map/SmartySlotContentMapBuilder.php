<?php


/**
 * This class adds structure of 'st_smarty_slot_content' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class SmartySlotContentMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'lib.model.map.SmartySlotContentMapBuilder';

    /**
     * The database map.
     */
    private $dbMap;

    /**
     * Tells us if this DatabaseMapBuilder is built so that we
     * don't have to re-build it every time.
     *
     * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
     */
    public function isBuilt()
    {
        return ($this->dbMap !== null);
    }

    /**
     * Gets the databasemap this map builder built.
     *
     * @return     the databasemap
     */
    public function getDatabaseMap()
    {
        return $this->dbMap;
    }

    /**
     * The doBuild() method builds the DatabaseMap
     *
     * @return     void
     * @throws     PropelException
     */
    public function doBuild()
    {
        $this->dbMap = Propel::getDatabaseMap('propel');

        $tMap = $this->dbMap->addTable('st_smarty_slot_content');
        $tMap->setPhpName('SmartySlotContent');

        $tMap->setUseIdGenerator(false);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addForeignPrimaryKey('SLOT_ID', 'SlotId', 'int' , CreoleTypes::INTEGER, 'st_smarty_slot', 'ID', true, null);

        $tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

        $tMap->addColumn('HASH', 'Hash', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('CONTENT', 'Content', 'array', CreoleTypes::LONGVARCHAR, true, null);

    } // doBuild()

} // SmartySlotContentMapBuilder
