<?php


/**
 * This class adds structure of 'st_task' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.stTaskPlugin.lib.model.map
 */
class TaskMapBuilder {

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'plugins.stTaskPlugin.lib.model.map.TaskMapBuilder';

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

        $tMap = $this->dbMap->addTable('st_task');
        $tMap->setPhpName('Task');

        $tMap->setUseIdGenerator(true);

        $tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, false, null);

        $tMap->addColumn('TASK_ID', 'TaskId', 'string', CreoleTypes::VARCHAR, false, 64);

        $tMap->addColumn('TASK_PRIORITY', 'TaskPriority', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('STATUS', 'Status', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('TIME_INTERVAL', 'TimeInterval', 'int', CreoleTypes::INTEGER, false, null);

        $tMap->addColumn('EXECUTE_AT', 'ExecuteAt', 'int', CreoleTypes::TIME, false, null);

        $tMap->addColumn('LAST_EXECUTED_AT', 'LastExecutedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('LAST_FINISHED_AT', 'LastFinishedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('LAST_ACTIVE_AT', 'LastActiveAt', 'int', CreoleTypes::TIMESTAMP, false, null);

    } // doBuild()

} // TaskMapBuilder
