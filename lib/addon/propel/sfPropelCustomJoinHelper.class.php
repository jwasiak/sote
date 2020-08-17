<?php

class sfPropelCustomJoinHelper
{
  protected
  $mainClassName = '',
  $selectClasses,
  $classOwnership;

  public function __construct($mainClassName)
  {
    $this->mainClassName = $mainClassName;
    $this->selectClasses = array();
    $this->classOwnership = array();
  }

  public function addSelectTables()
  {
    $classes = array();
    if (func_num_args() == 1) {
      $classes = (array)func_get_arg(0);
    } else {
      $classes = func_get_args();
    }
    $this->selectClasses = array_merge($this->selectClasses, $classes);
  }

  public function clearSelectClasses()
  {
    $this->selectClasses = array();
  }

  public function hydrate($rs, $startCol=1)
  {
    $obj = new sfPropelCustomJoinObjectProxy($this->mainClassName);
    $startCol = $obj->hydrate($rs, 1);

    $childObjs = array();

    // Initialize selected objects as children
    foreach ($this->selectClasses as $childClassName)
    {
      $childObj = new sfPropelCustomJoinObjectProxy($childClassName);
      $startCol = $childObj->hydrate($rs, $startCol);
      if ($childObj->isAllPrimaryKeyNull()) {
        $childObjs[$childClassName] = null;
      } else {
        $childObjs[$childClassName] = $childObj;
      }
    }

    // Initialize child object relationships
    foreach ($childObjs as $childClassName => $childObj)
    {
      $obj->addExternalObject($childObj, $childClassName); //main class object always holds all child objects.
      if ($childObj != null && isset($this->classOwnership[$childClassName])) {
        foreach ($this->classOwnership[$childClassName] as $subChild) {
          if (array_key_exists($subChild[0], $childObjs)) {
            $childObj->addExternalObject($childObjs[$subChild[0]], $subChild[1]);
          }
        }
      }
    }

    return $obj;
  }

  public function doCount($c, $con=null)
  {
    return call_user_func_array(array($this->mainClassName.'Peer', 'doCount'), array($c, $con));
  }

  public function doSelect($c, $con=null)
  {
    $rs = $this->doSelectRS($c, $con=null);

    $a = array();
    while ($rs->next()) {
      $a[] = $this->hydrate($rs);
    }
    return $a;
  }

  public function doSelectOne(Criteria $criteria, $con = null)
  {
    $critcopy = clone $criteria;
    $critcopy->setLimit(1);
    $objects = $this->doSelect($critcopy, $con);
    if ($objects) {
      return $objects[0];
    }
    return null;
  }


  /**
   * Return the Propel ResultSet object.
   *
   * This method adds all columns specified with addSelectTables method.
   * @see addSelectTables
   */
  public function doSelectRS($criteria, $con=null)
  {
    $c = clone $criteria;
    $c->clearSelectColumns();

    call_user_func(array($this->mainClassName.'Peer', 'addSelectColumns'), $c);
    foreach ($this->selectClasses as $className) {
      call_user_func(array($className.'Peer', 'addSelectColumns'), $c);
    }
    $rs = call_user_func_array(array($this->mainClassName.'Peer', 'doSelectRS'), array($c, $con));
    return $rs;
  }

  public function setHas($className, $has, $alias = false)
  {
    if (!isset($this->classOwnership[$className])) {
      $this->classOwnership[$className] = array();
    }
    $this->classOwnership[$className][] = array($has, $alias);
  }

  /**
   * Do proxy call to peer method of the main class.
   */
  public function __call($name, $args)
  {
    return call_user_func_array(array($this->mainClassName.'Peer', $name), $args);
  }

  /**
   * Return the main class name. This is to work around when the pager object
   * tries to include the Peer class file.
   */
  public function __toString()
  {
    return $this->mainClassName;
  }
}

class sfPropelCustomJoinObjectProxy
{
  protected
  $className,
  $obj,
  $extObjs;

  public function __construct($className)
  {
    $this->className = $className;
    $this->obj = new $className;
    $this->extObjs = array();
  }

  public function getDataObject()
  {
    return $this->obj;
  }

  public function isAllPrimaryKeyNull()
  {
    $pk = null;
    $pks = $this->obj->getPrimaryKey();
    foreach ((array)$pks as $pk) {
    } if ($pk) {
      return false;
    }
    return true;
  }

  public function __call($name, $args)
  {
    if (preg_match('/^get(.*)$/', $name, $matches))
    {
      if (array_key_exists($matches[1], $this->extObjs)) {
        return $this->extObjs[$matches[1]];
      }
    }
    return call_user_func_array(array($this->obj, $name), $args);
  }

  public function hydrate(ResultSet $rs, $startcol = 1)
  {
    $startcol = $this->obj->hydrate($rs, $startcol);
    return $startcol;
  }

  public function addExternalObject($obj, $alias = false)
  {
    $key = $alias ? $alias: get_class($obj->getDataObject());
    $this->extObjs[$key] = $obj;
  }

  public function __toString()
  {
    return $this->obj->__toString();
  }
}
