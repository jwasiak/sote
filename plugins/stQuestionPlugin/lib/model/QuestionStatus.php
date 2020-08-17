<?php

/**
 * Subclass for representing a row from the 'st_question_status' table.
 *
 * 
 *
 * @package plugins.stQuestionPlugin.lib.model
 */ 
class QuestionStatus extends BaseQuestionStatus
{
    /**
     * Nazwa statusu
     *
     * @return   string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Ustawia rodzaj statusu
     *
     * @param   string      $type               Rodzaj statusu
     */
    public function setQuestionStatusType($type)
    {
        $this->setStatusType($type);
    }

    /**
     * Zwraca rodzaj statusu
     *
     * @return  string      Rodzaj statusu
     */
    public function getQuestionStatusType()
    {
        return $this->setStatusType();
    }

    /**
     * Przeciazenie usuwania statusu
     *
     * @param   mixed       $con                Polaczenie bazy danych
     */
    public function delete($con = null)
    {
        parent::delete($con);

        $system_status = QuestionStatusPeer::retrieveSystemStatusByType($this->getStatusType());

        $select_criteria = new Criteria();

        $select_criteria->add(QuestionsPeer::QUESTION_STATUS_ID, $this->getId());

        $update_criteria = new Criteria();

        $update_criteria->add(QuestionsPeer::QUESTION_STATUS_ID, $system_status->getId());

        if ($con === null)
        {
            $con = Propel::getConnection();
        }

        BasePeer::doUpdate($select_criteria, $update_criteria, $con);
    }

    /**
     * Zwraca czy dany rekord jest rekordem systemowym (nie do usuniecia)
     *
     * @return   bool
     */
    public function getIsSystemDefault()
    {
        return parent::getIsSystemDefault() || $this->getIsDefault();
    }

    /**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());
        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getName();

        if (is_null($v))
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }

    /**
     * Przeciążenie setName
     *
     * @param string $v Nazwa producenta
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setName($v);
    }
    
        public function save($con = null)
    {
        if ($this->getIsDefault() && $this->isColumnModified(QuestionStatusPeer::IS_DEFAULT))
        {
            $question_status = QuestionStatusPeer::retrieveDefaultNewStatus(new Criteria(), $con);

            if ($question_status)
            {
                $question_status->setIsDefault(false);

                $question_status->save($con);
            }
        }

        parent::save($con);
    }
}