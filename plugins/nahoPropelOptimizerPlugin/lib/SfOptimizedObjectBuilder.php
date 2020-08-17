<?php

include_once 'addon/propel/builder/SfObjectBuilder.php';

class SfOptimizedObjectBuilder extends SfObjectBuilder
{
  protected function addAttributes(&$script)
  {
  $script .= "
              protected static \$dispatcher = null;
";
    parent::addAttributes($script);
  }

  protected function addCall(&$script)
  {
  $script .= "

  public function getDispatcher()
  {
      if (null === self::\$dispatcher)
      {
          self::\$dispatcher = stEventDispatcher::getInstance();
      }

      return self::\$dispatcher;
  }
        
  public function __call(\$method, \$arguments)
  {
      \$event = \$this->getDispatcher()->notifyUntil(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.' . \$method, array('arguments' => \$arguments, 'method' => \$method)));

      if (\$event->isProcessed())
      {
          return \$event->getReturnValue();
      }

      if (!\$callable = sfMixer::getCallable('{$this->getClassname()}:'.\$method))
      {
        throw new sfException(sprintf('Call to undefined method {$this->getClassname()}::%s', \$method));
      }

      array_unshift(\$arguments, \$this);

      return call_user_func_array(\$callable, \$arguments);
  }
";
  }

  public function build()
  {
    // Get original built code
    $objectCode = parent::build();

    // Remove useless includes
    if (!DataModelBuilder::getBuildProperty('builderAddIncludes'))
    {
      //remove all inline includes:
      //peer class include inline the mapbuilder classes
      $objectCode = preg_replace("/include_once\s*.*Base.*Peer\.php.*\s*/", "", $objectCode);
    }

    return $objectCode;
  }

  protected function addFKAccessor(&$script, ForeignKey $fk)
  {
    // Make original modifications
    parent::addFKAccessor($script, $fk);

    // With the explicit joins support, the related object returned can be hydrated with all NULL values, in this case we could simply return NULL
    if (!DataModelBuilder::getBuildProperty('builderHydrateNULLs'))
    {
      $varName = $this->getFKVarName($fk);
      $return = 'return $this->' . $varName . ';';
      $check_null_hydrated_script = '
        if (!is_null($this->' . $varName . ') && !$this->' . $varName . '->isNew() && is_null($this->' . $varName . '->getPrimaryKey())) {
          return NULL;
        }
        ' . $return;
      $script = str_replace($return, $check_null_hydrated_script, $script);
    }
  }

  /**
   * Adds setter method for "normal" columns.
   * @param      string &$script The script will be modified in this method.
   * @param      Column $col The current column.
   * @see        parent::addColumnMutators()
   */
  protected function addDefaultMutator(&$script, Column $col)
  {
    $clo = strtolower($col->getName());

    // FIXME: refactor this
    $defaultValue = null;
    if (($val = $col->getPhpDefaultValue()) !== null)
    {
      settype($val, $col->getPhpNative());
      $defaultValue = var_export($val, true);
    }

    $this->addMutatorOpen($script, $col);

    // Perform some smart checking here to handle possible type discrepancies
    // between the passed-in value and the value from the DB

    if ($col->getPhpType() != 'object' && $col->getPhpType() != 'array')
    {
      if ($col->getPhpNative() === "int")
      {
  $script .= "
        if (\$v !== null && !is_int(\$v) && is_numeric(\$v)) {
          \$v = (int) \$v;
        }
";
      } elseif ($col->getPhpNative() === "string")
      {
  $script .= "
        if (\$v !== null && !is_string(\$v)) {
          \$v = (string) \$v;
        }
";
      } elseif ($col->getPhpNative() === "boolean")
      {
  $script .= "
        if (\$v !== null && !is_bool(\$v)) {
          \$v = (bool) \$v;
        }
";
      } 
      elseif ($col->getPhpNative() === "float" || $col->getPhpNative() === "double")
      {
  $script .= "
        if (\$v !== null && !is_float(\$v) && is_numeric(\$v)) {
          \$v = (float) \$v;
        }
";
      }                
    }

    $script .= "
        if (\$this->$clo !== \$v";
    if ($defaultValue !== null)
    {
      $script .= " || \$v === $defaultValue";
    }
  $script .= ") {
          \$this->$clo = \$v;
          \$this->modifiedColumns[] = ".$this->getColumnConstant($col).";
        }
";
    $this->addMutatorClose($script, $col);
  }

    /**
     * Adds a normal (non-temporal) getter method.
     * @param      string &$script The script will be modified in this method.
     * @param      Column $col The current column.
     * @see        parent::addColumnAccessors()
     */
    protected function addGenericAccessor(&$script, $col)
    {
            $cfc=$col->getPhpName();
            $clo=strtolower($col->getName());

            $script .= "
    /**
     * Get the [$clo] column value.
     * ".$col->getDescription()."
     * @return     ".$col->getPhpNative()."
     */
    public function get$cfc(";
            if ($col->isLazyLoad()) $script .= "\$con = null";
            $script .= ")
    {
";
            if ($col->isLazyLoad()) {
                    $script .= "
            if (!\$this->".$clo."_isLoaded && \$this->$clo === null && !\$this->isNew()) {
                    \$this->load$cfc(\$con);
            }
";
            }
            if ($col->getType() == PropelTypes::DECIMAL)
            {
            $script .= "
            return null !== \$this->$clo ? (string)\$this->$clo : null;
    }
";
            }
            else
            {
            $script .= "
            return \$this->$clo;
    }
";
            }
    }

  protected function addDoSave(&$script)
  {
    $tmp = '';

    $pre_script = '';

    $post_script = '';

    foreach($this->getTable()->getColumns() as $col)
    {
      if ($col->getPhpType() != 'array' && $col->getPhpType() != 'object') continue;

      $attr = strtolower($col->getName());
      $const = $this->getColumnConstant($col);
  $pre_script .= "
              \$o_$attr = \$this->$attr;
              if (null !== \$this->$attr && \$this->isColumnModified($const)) {
                  \$this->$attr = serialize(\$this->$attr);
              }
";
  $post_script .= "
             \$this->$attr = \$o_$attr;
";
    }

    parent::addDoSave($tmp);
    // add autosave to i18n object even if the base object is not changed
    $tmp = str_replace('if ($this->isModified()) {', 'if ($this->isModified()) {'.$pre_script, $tmp);

    $tmp = str_replace('$this->resetModified();', '$this->resetModified();'.$post_script, $tmp);

    $script .= $tmp;
  }

  protected function addDelete(&$script)
  {
    $script .= "
  /**
   * Removes this object from datastore and sets delete attribute.
   *
   * @param      Connection \$con
   * @return     void
   * @throws     PropelException
   * @see        BaseObject::setDeleted()
   * @see        BaseObject::isDeleted()
   */
  public function delete(\$con = null)
  {
    if (\$this->isDeleted()) {
      throw new PropelException(\"This object has already been deleted.\");
    }

    if (\$this->getDispatcher()->getListeners('{$this->getStubObjectBuilder()->getClassname()}.preDelete')) {
        \$this->getDispatcher()->notify(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.preDelete', array('con' => \$con)));
    }

    if (sfMixer::hasCallables('{$this->getClassname()}:delete:pre'))
    {
      foreach (sfMixer::getCallables('{$this->getClassname()}:delete:pre') as \$callable)
      {
        \$ret = call_user_func(\$callable, \$this, \$con);
        if (\$ret)
        {
          return;
        }
      }
    }

    if (\$con === null) {
      \$con = Propel::getConnection(".$this->getPeerClassname()."::DATABASE_NAME);
    }

    try {
      \$con->begin();
      ".$this->getPeerClassname()."::doDelete(\$this, \$con);
      \$this->setDeleted(true);
      \$con->commit();
    } catch (PropelException \$e) {
      \$con->rollback();
      throw \$e;
    }

    if (\$this->getDispatcher()->getListeners('{$this->getStubObjectBuilder()->getClassname()}.postDelete')) {
        \$this->getDispatcher()->notify(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.postDelete', array('con' => \$con)));
    }

    if (sfMixer::hasCallables('{$this->getClassname()}:delete:post'))
    {
      foreach (sfMixer::getCallables('{$this->getClassname()}:delete:post') as \$callable)
      {
        call_user_func(\$callable, \$this, \$con);
      }
    }
  }
";
  } // addDelete()

  /**
   * Adds the save() method.
   * @param      string &$script The script will be modified in this method.
   */
  protected function addSave(&$script)
  {
    $updated = false;
    $created = false;
    $date_script = '';
    foreach ($this->getTable()->getColumns() as $col)
    {
      $clo = strtolower($col->getName());

      if (!$updated && in_array($clo, array('updated_at', 'updated_on')))
      {
        $updated = true;
        $date_script .= "
    if (\$this->isModified() && !\$this->isColumnModified(".$this->getColumnConstant($col)."))
    {
      \$this->set".$col->getPhpName()."(time());
    }
";
      }
      else if (!$created && in_array($clo, array('created_at', 'created_on')))
      {
        $created = true;
        $date_script .= "
    if (\$this->isNew() && !\$this->isColumnModified(".$this->getColumnConstant($col)."))
    {
      \$this->set".$col->getPhpName()."(time());
    }
";
      }
    }
    $script .= "
  /**
   * Stores the object in the database.  If the object is new,
   * it inserts it; otherwise an update is performed.  This method
   * wraps the doSave() worker method in a transaction.
   *
   * @param      Connection \$con
   * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
   * @throws     PropelException
   * @see        doSave()
   */
  public function save(\$con = null)
  {
    if (\$this->isDeleted()) {
      throw new PropelException(\"You cannot save an object that has been deleted.\");
    }

    if (!\$this->alreadyInSave) {
      if (\$this->getDispatcher()->getListeners('{$this->getStubObjectBuilder()->getClassname()}.preSave')) {
          \$this->getDispatcher()->notify(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.preSave', array('con' => \$con)));
      }

      foreach (sfMixer::getCallables('{$this->getClassname()}:save:pre') as \$callable)
      {
        \$affectedRows = call_user_func(\$callable, \$this, \$con);
        if (is_int(\$affectedRows))
        {
          return \$affectedRows;
        }
      }
    }

    $date_script

    if (\$con === null) {
      \$con = Propel::getConnection(".$this->getPeerClassname()."::DATABASE_NAME);
    }

    try {
      \$con->begin();
      \$affectedRows = \$this->doSave(\$con);
      \$con->commit();

      if (!\$this->alreadyInSave) {
        if (\$this->getDispatcher()->getListeners('{$this->getStubObjectBuilder()->getClassname()}.postSave')) {
            \$this->getDispatcher()->notify(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.postSave', array('con' => \$con)));
        }
     
        foreach (sfMixer::getCallables('{$this->getClassname()}:save:post') as \$callable)
        {
          call_user_func(\$callable, \$this, \$con, \$affectedRows);
        }
      }

      return \$affectedRows;
    } catch (PropelException \$e) {
      \$con->rollback();
      throw \$e;
    }
  }
";

  }

  /**
   * Adds the hydrate() method, which sets attributes of the object based on a ResultSet.
   */
  protected function addHydrate(&$script)
  {
    $table = $this->getTable();

  $script .= "
  /**
   * Hydrates (populates) the object variables with values from the database resultset.
   *
   * An offset (1-based \"start column\") is specified so that objects can be hydrated
   * with a subset of the columns in the resultset rows.  This is needed, for example,
   * for results of JOIN queries where the resultset row includes columns from two or
   * more tables.
   *
   * @param      ResultSet \$rs The ResultSet class with cursor advanced to desired record pos.
   * @param      int \$startcol 1-based offset column which indicates which restultset column to start with.
   * @return     int next starting column
   * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
   */
  public function hydrate(ResultSet \$rs, \$startcol = 1)
  {
    try {
      if (\$this->getDispatcher()->getListeners('{$this->getStubObjectBuilder()->getClassname()}.preHydrate')) {
          \$event = \$this->getDispatcher()->notify(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.preHydrate', array('resultset' => \$rs, 'startcol' => \$startcol)));
          \$startcol = \$event['startcol'];
      }
";
    $n = 0;
    foreach($table->getColumns() as $col)
    {
      if(!$col->isLazyLoad())
      {
        $affix = CreoleTypes::getAffix(CreoleTypes::getCreoleCode($col->getType()));
        $clo = strtolower($col->getName());
        switch($col->getType())
        {

          case PropelTypes::DATE:
          case PropelTypes::TIME:
          case PropelTypes::TIMESTAMP:
  $script .= "
      \$this->$clo = \$rs->get$affix(\$startcol + $n, null);
";
            break;
          case PropelTypes::DECIMAL:
  $script .= "
      \$this->$clo = \$rs->getString(\$startcol + $n);
      if (null !== \$this->$clo && \$this->$clo == intval(\$this->$clo))
      {
        \$this->$clo = (string)intval(\$this->$clo);
      }
";
          break;
          default:
            if ($col->getPhpType() == 'array' || $col->getPhpType() == 'object')
            {
  $script .= "
      \$this->$clo = \$rs->get$affix(\$startcol + $n) ? unserialize(\$rs->get$affix(\$startcol + $n)) : null;
";
            }
            else
            {
  $script .= "
      \$this->$clo = \$rs->get$affix(\$startcol + $n);
";
            }
        }
        $n++;
      } // if col->isLazyLoad()
    } /* foreach */

    if ($this->getBuildProperty("addSaveMethod"))
    {
  $script .= "
      \$this->resetModified();
";
    }

  $script .= "
      \$this->setNew(false);
      if (\$this->getDispatcher()->getListeners('{$this->getStubObjectBuilder()->getClassname()}.postHydrate')) {
          \$event = \$this->getDispatcher()->notify(new sfEvent(\$this, '{$this->getStubObjectBuilder()->getClassname()}.postHydrate', array('resultset' => \$rs, 'startcol' => \$startcol + $n)));
          return \$event['startcol'];
      }

      // FIXME - using NUM_COLUMNS may be clearer.
      return \$startcol + $n; // $n = ".$this->getPeerClassname()."::NUM_COLUMNS - ".$this->getPeerClassname()."::NUM_LAZY_LOAD_COLUMNS).

    } catch (Exception \$e) {
      throw new PropelException(\"Error populating ".$table->getPhpName()." object\", \$e);
    }
  }
";

  } // addHydrate()

}