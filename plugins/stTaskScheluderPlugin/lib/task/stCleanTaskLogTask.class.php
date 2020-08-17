<?php

/**
 * Undocumented class
 */
class stCleanTaskLogTask extends stTask
{
    const LIMIT = 1000;

    private $criteria = null;

    public function count(): int
    {
        return TaskLogPeer::doCount($this->getCriteria());
    }

    public function execute(int $offset): int
    {
        $criteria = $this->getCriteria();
        $criteria->setLimit(self::LIMIT);

        return $offset + TaskLogPeer::doDelete($criteria);
    }

    public function finished()
    {
        Propel::getConnection()->executeQuery(sprintf('OPTIMIZE TABLE `%s`', TaskLogPeer::TABLE_NAME));
    }

    protected function getCriteria(): Criteria
    {
        if (null === $this->criteria)
        {
            $date = new DateTime();
            
            $this->criteria = new Criteria();
            $this->criteria->add(TaskLogPeer::CREATED_AT, $date->modify('-5 days')->format('Y-m-d H:i:s'), Criteria::LESS_EQUAL);
        }

        return $this->criteria;
    }
}