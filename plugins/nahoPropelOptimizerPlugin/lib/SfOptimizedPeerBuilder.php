<?php

include_once 'addon/propel/builder/SfPeerBuilder.php';

class SfOptimizedPeerBuilder extends SfPeerBuilder
{

   protected function addDoSelectJoinAll(&$script)
   {
      $tmp = '';

      parent::addDoSelectJoinAll($tmp);

      $hydrator = "
            if (self::\$hydrateMethod)
            {
               return call_user_func(self::\$hydrateMethod, \$rs);
            }
            ";

      $tmp = str_replace('$results = array();', $hydrator.'$results = array();', $tmp);

      $script .= str_replace('$results[] = $obj1;', "\$results[] = self::\$postHydrateMethod ? call_user_func(self::\$postHydrateMethod, \$obj1) : \$obj1;", $tmp);
   }

   protected function addDoSelectWithI18n(&$script)
   {
      $table = $this->getTable();
      $thisTableObjectBuilder = OMBuilder::getNewObjectBuilder($table);
      $className = $table->getPhpName();
      $pks = $table->getPrimaryKey();
      $pk = PeerBuilder::getColumnName($pks[0], $className);

      // get i18n table name and culture column name
      foreach ($table->getReferrers() as $fk)
      {
         $tblFK = $fk->getTable();
         if ($tblFK->getName() == $table->getAttribute('i18nTable'))
         {
            $i18nClassName = $tblFK->getPhpName();
            // FIXME
            $i18nPeerClassName = $i18nClassName.'Peer';

            $i18nTable = $table->getDatabase()->getTable($tblFK->getName());
            $i18nTableObjectBuilder = OMBuilder::getNewObjectBuilder($i18nTable);
            $i18nTablePeerBuilder = OMBuilder::getNewPeerBuilder($i18nTable);
            $i18nPks = $i18nTable->getPrimaryKey();
            $i18nPk = PeerBuilder::getColumnName($i18nPks[0], $i18nClassName);

            $culturePhpName = '';
            $cultureColumnName = '';
            foreach ($tblFK->getColumns() as $col)
            {
               if (("true" === strtolower($col->getAttribute('isCulture'))))
               {
                  $culturePhpName = $col->getPhpName();
                  $cultureColumnName = PeerBuilder::getColumnName($col, $i18nClassName);
               }
            }
         }
      }

      $script .= "

     /**
      * Selects a collection of $className objects pre-filled with their i18n objects.
      *
      * @return array Array of $className objects.
      * @throws PropelException Any exceptions caught during processing will be
      *     rethrown wrapped into a PropelException.
      */
     public static function doSelectWithI18n(Criteria \$c, \$culture = null, \$con = null)
     {
       \$c = clone \$c;

       if (\$culture === null)
       {
         \$culture = sfContext::getInstance()->getUser()->getCulture();
       }

       // Set the correct dbName if it has not been overridden
       if (\$c->getDbName() == Propel::getDefaultDB())
       {
         \$c->setDbName(self::DATABASE_NAME);
       }
      
       if (!\$c->getSelectColumns())
       {
          ".$this->getPeerClassname()."::addSelectColumns(\$c);
          ".$i18nPeerClassName."::addSelectColumns(\$c);
       }

      \$c->addJoin(".$pk.", sprintf('%s AND %s = \'%s\'', ".$i18nPk.", ".$cultureColumnName.", \$culture), Criteria::LEFT_JOIN);

      \$rs = ".$this->getPeerClassname()."::doSelectRs(\$c, \$con);

      if (self::\$hydrateMethod)
      {
         return call_user_func(self::\$hydrateMethod, \$rs);
      }

      \$results = array();

      while(\$rs->next()) {
";
      $script .= "
         \$obj1 = new ".$className."();
         \$startcol = \$obj1->hydrate(\$rs);
         \$obj1->setCulture(\$culture);
";
      $script .= "
         \$obj2 = new ".$i18nClassName."();
         \$obj2->hydrate(\$rs, \$startcol);

         \$obj1->set".$i18nClassName."ForCulture(\$obj2, \$culture);
         \$obj2->set".$className."(\$obj1);

         \$results[] = self::\$postHydrateMethod ? call_user_func(self::\$postHydrateMethod, \$obj1) : \$obj1;
       }
       return \$results;
     }
";
   }

   protected function addDoSelectJoinAllExcept(&$script)
   {
      $tmp = '';

      parent::addDoSelectJoinAllExcept($tmp);

      $hydrator = "
            if (self::\$hydrateMethod)
            {
               return call_user_func(self::\$hydrateMethod, \$rs);
            }
            ";

      $tmp = str_replace('$results = array();', $hydrator.'$results = array();', $tmp);

      $script .= str_replace('$results[] = $obj1;', "\$results[] = self::\$postHydrateMethod ? call_user_func(self::\$postHydrateMethod, \$obj1) : \$obj1;", $tmp);
   }

   protected function addConstantsAndAttributes(&$script)
   {
      parent::addConstantsAndAttributes($script);

      $script .="
         protected static \$hydrateMethod = null;

         protected static \$postHydrateMethod = null;

         public static function setHydrateMethod(\$callback)
         {
            self::\$hydrateMethod = \$callback;
         }

         public static function setPostHydrateMethod(\$callback)
         {
            self::\$postHydrateMethod = \$callback;
         }
";
   }

	/**
	 * Adds the addSelectColumns() method.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addAddSelectColumns(&$script)
	{
		$script .= "
	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad=\"true\" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria \$criteria)
	{
";
		foreach ($this->getTable()->getColumns() as $col) {
			if (!$col->isLazyLoad()) {
				$script .= "
		\$criteria->addSelectColumn(".$this->getPeerClassname()."::".$this->getColumnName($col).");
";
			} // if !col->isLazyLoad
		} // foreach
		$script .="

		if (stEventDispatcher::getInstance()->getListeners('".$this->getPeerClassname().".postAddSelectColumns')) {
			stEventDispatcher::getInstance()->notify(new sfEvent(\$criteria, '".$this->getPeerClassname().".postAddSelectColumns'));
		}
	}
";
	} // addAddSelectColumns()   

   protected function addPopulateObjects(&$script)
   {
      $tmp = '';
      parent::addPopulateObjects($tmp);

      $hydrator = "
            if (self::\$hydrateMethod)
            {
               return call_user_func(self::\$hydrateMethod, \$rs);
            }
            ";

      $tmp = str_replace('$results = array();', $hydrator.'$results = array();', $tmp);

      $script .= str_replace('$results[] = $obj;', "\$results[] = self::\$postHydrateMethod ? call_user_func(self::\$postHydrateMethod, \$obj) : \$obj;", $tmp);
   }

	/**
	 * Adds the doSelectRS() method.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addDoSelectRS(&$script)
	{

		$script .= "
	/**
	 * Prepares the Criteria object and uses the parent doSelect()
	 * method to get a ResultSet.
	 *
	 * Use this method directly if you want to just get the resultset
	 * (instead of an array of objects).
	 *
	 * @param      Criteria \$criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection \$con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     ResultSet The resultset object with numerically-indexed fields.
	 * @see        ".$this->basePeerClassname."::doSelect()
	 */
	public static function doSelectRS(Criteria \$criteria, \$con = null)
	{
		if (\$con === null) {
			\$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!\$criteria->getSelectColumns()) {
			\$criteria = clone \$criteria;
			".$this->getPeerClassname()."::addSelectColumns(\$criteria);
		}

		if (stEventDispatcher::getInstance()->getListeners('BasePeer.preDoSelectRs')) {
			stEventDispatcher::getInstance()->notify(new sfEvent(\$criteria, 'BasePeer.preDoSelectRs'));
		}

		// Set the correct dbName
		\$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a Creole ResultSet, set to return
		// rows indexed numerically.
		\$rs =  ".$this->basePeerClassname."::doSelect(\$criteria, \$con);

		if (stEventDispatcher::getInstance()->getListeners('BasePeer.postDoSelectRs')) {
			stEventDispatcher::getInstance()->notify(new sfEvent(\$rs, 'BasePeer.postDoSelectRs'));
		}		

		return \$rs;
	}";
	}   
   
	/**
	 * Adds the doSelectJoin*() methods.
	 * @param      string &$script The script will be modified in this method.
	 */
	protected function addDoSelectJoin(&$script)
	{
		$table = $this->getTable();
		$className = $table->getPhpName();
		$countFK = count($table->getForeignKeys());

		if ($countFK >= 1) {

			foreach ($table->getForeignKeys() as $fk) {

				$joinTable = $table->getDatabase()->getTable($fk->getForeignTableName());

				if (!$joinTable->isForReferenceOnly()) {

					// FIXME - look into removing this next condition; it may not
					// be necessary:
					// --- IT is necessary because there needs to be a system for
					// aliasing the table if it is the same table.
					if ( $fk->getForeignTableName() != $table->getName() ) {

						/*
						REPLACED BY USING THE ObjectBuilder objects below

						// check to see if we need to add something to the method name.
						// For example if there are multiple columns that reference the same
						// table, then we have to have a methd name like doSelectJoinBooksByBookId
						$partJoinName = "";
						foreach ($fk->getLocalColumns() as $columnName ) {
							$column = $table->getColumn($columnName);
								//							this second part is not currently ever true (right?)
							if ($column->isMultipleFK() || $fk->getForeignTableName() == $table->getName()) {
								$partJoinName = $partJoinName . $column->getPhpName();
							}
						}


						$joinClassName = $joinTable->getPhpName();

						if ($joinTable->getInterface()) {
						   $interfaceName = $joinTable->getInterface();
						} else {
							$interfaceName = $joinTable->getPhpName();
						}

						if ($partJoinName == "") {
							$joinColumnId = $joinClassName;
							$joinInterface = $interfaceName;
							$collThisTable = $className . "s";
							$collThisTableMs = $className;
						} else {
							$joinColumnId = $joinClassName . "RelatedBy" . $partJoinName;
							$joinInterface = $interfaceName . "RelatedBy" . $partJoinName;
							$collThisTable = $className . "sRelatedBy" . $partJoinName;
							$collThisTableMs = $className . "RelatedBy" . $partJoinName;
						}
						*/

						$joinClassName = $joinTable->getPhpName();

						$thisTableObjectBuilder = OMBuilder::getNewObjectBuilder($table);
						$joinedTableObjectBuilder = OMBuilder::getNewObjectBuilder($joinTable);
						$joinedTablePeerBuilder = OMBuilder::getNewPeerBuilder($joinTable);

						$script .= "

	/**
	 * Selects a collection of $className objects pre-filled with their $joinClassName objects.
	 *
	 * @return     array Array of $className objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoin".$thisTableObjectBuilder->getFKPhpNameAffix($fk, $plural = false)."(Criteria \$c, \$con = null)
	{
		\$c = clone \$c;

		// Set the correct dbName if it has not been overridden
		if (\$c->getDbName() == Propel::getDefaultDB()) {
			\$c->setDbName(self::DATABASE_NAME);
		}

		".$this->getPeerClassname()."::addSelectColumns(\$c);

		".$joinedTablePeerBuilder->getPeerClassname()."::addSelectColumns(\$c);
";
                $fk_columns = array();
						$lfMap = $fk->getLocalForeignMapping();
						foreach ($fk->getLocalColumns() as $columnName ) {
							$column = $table->getColumn($columnName);
                                                        $fk_columns[] = $column->getPhpName().'()';
							$columnFk = $joinTable->getColumn( $lfMap[$columnName] );
							$script .= "
		\$c->addJoin(".$this->getColumnConstant($column).", ".$joinedTablePeerBuilder->getColumnConstant($columnFk).");"; //CHECKME
						}
						$script .= "
		\$rs = ".$this->getPeerClassname()."::doSelectRs(\$c, \$con);
                   
                if (self::\$hydrateMethod)
                {
                   return call_user_func(self::\$hydrateMethod, \$rs);
                }                   

		\$results = array();

		while(\$rs->next()) {
";
						$script .= "
			\$obj1 = new ".$className."();
			\$startcol = \$obj1->hydrate(\$rs);
                        if (\$obj1->get".implode(' && $obj1->get', $fk_columns).")
                        {
";

						$script .= "
			   \$obj2 = new ".$joinClassName."();
			   \$obj2->hydrate(\$rs, \$startcol);
                           \$obj2->add".$joinedTableObjectBuilder->getRefFKPhpNameAffix($fk, $plural = false)."(\$obj1);
                        }
			\$results[] = self::\$postHydrateMethod ? call_user_func(self::\$postHydrateMethod, \$obj1) : \$obj1;;
		}
		return \$results;
	}
";
					} // if fk table name != this table name
				} // if ! is reference only
			} // foreach column
		} // if count(fk) > 1

	} // addDoSelectJoin()   

   public function build()
   {
      // Get original built code
      $peerCode = parent::build();

      // Remove useless includes
      if (!DataModelBuilder::getBuildProperty('builderAddIncludes'))
      {
         //remove all inline includes:
         //peer class include inline the mapbuilder classes
         $peerCode = preg_replace("/(include|require)_once\s*.*\.php.*\s*/", "", $peerCode);
      }

      // Change implicit joins (all inner) to explicit INNER or LEFT, depending on the fact the key can be null or not
      if (!DataModelBuilder::getBuildProperty('builderImplicitJoins'))
      {
         foreach ($this->getTable()->getColumns() as $column)
         {
            if ($column->isForeignKey())
            {
               $colName = PeerBuilder::getColumnName($column, $this->getTable()->getPhpName());
               $from = '/->addJoin\('.preg_quote($colName, '/').'\s*,\s*([^,]*?)\)/';
               if ($column->isNotNull())
               {
                  $to = '->addJoin('.$colName.', $1)';
               }
               else
               {
                  $to = '->addJoin('.$colName.', $1, Criteria::LEFT_JOIN)';
               }
               $peerCode = preg_replace($from, $to, $peerCode);
            }
         }
      }

      // remove calls to Propel::import(), which prevent to extend plugin's model classes
      if (!DataModelBuilder::getBuildProperty('builderAddPropelImports'))
      {
         $from = '/Propel::import\((.*?)\)/';
         $to = 'substr($1, ($pos=strrpos($1,\'.\'))?$pos+1:0)';
         $peerCode = preg_replace($from, $to, $peerCode);
      }

      return $peerCode;
   }

}
