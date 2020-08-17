<?php
/*
* This file is part of the sfPropelActAsNestedSetBehavior package.
*
* (c) 2006-2007 Tristan Rivoallan <tristan@rivoallan.net>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * This behavior adds necessary logic for a propel model to behave as a nested set.
 *
 * To enable this behavior add this after Propel stub class declaration :
 *
 * <code>
 *   $columns_map = array('left'   => MyClassPeer::TREE_LEFT,
 *                        'right'  => MyClassPeer::TREE_RIGHT,
 *                        'parent' => MyClassPeer::TREE_PARENT,
 *                        'scope'  => MyClassPeer::TOPIC_ID);
 *
 *   sfPropelBehavior::add('MyClass', array('actasnestedset' => array('columns' => $columns_map)));
 * </code>
 *
 * Column map values signification :
 *
 *  - left : Model column holding nested set left value for a row
 *  - right : Model column holding nested set right value for a row
 *  - parent : Model column holding row's parent id
 * (this is necessary because we use adjacency list tree traversal for some methods)
 *  - scope : Model column holding row's scope id. The scope is used to differenciate trees stored in
 * the same table
 *
 * @author   Tristan Rivoallan   <tristan@rivoallan.net>
 * @author   Heltem              (http://propel.phpdb.org/trac/ticket/312)
 * @author   Joe Simms           (http://www.symfony-project.com/forum/index.php/m/20657/)
 *
 * @see      http://www.symfony-project.com/trac/wiki/sfPropelActAsNestedSetBehaviorPlugin
 */

class sfPropelActAsNestedSetBehavior
{
    # -- PROPERTIES
    /**
     * Nested set related columns.
     *
     * @var array
     */
    private static $columns = array();

    /**
     * Holds SQL queries propel objects that need to be processed before a node is saved.
     * It acts as a FIFO stack.
     *
     * @var array
     */
    private $presave_stack = array();

    /**
     * Holds SQL queries propel objects that need to be processed before a node is deleted.
     * It acts as a FIFO stack.
     *
     * @var array
     */
    private $predelete_stack = array();

    # -- HOOKS


    /**
     * Runs necessary queries before node is saved.
     *
     * @param      BaseObject  $node
     */
    public function preSave(BaseObject $node)
    {
        $this->processPreSaveStack();
    }

    /**
     * Runs necessary queries before node is deleted.
     *
     * @param      BaseObject  $node
     */
    public function preDelete(BaseObject $node)
    {
        $this->deleteDescendants($node);
    }

    # -- GETTERS AND SETTERS


    /**
     * Proxy method used to access column holding nested set's left value getter.
     *
     * @param      BaseObject  $node
     */
    public function getLeftValue(BaseObject $node)
    {
        $getter = self::forgeMethodName($node, 'get', 'left');
        return $node->$getter();
    }

    /**
     * Proxy method used to access column holding nested set's left value setter.
     *
     * @param      BaseObject  $node
     * @param      integer     $value
     */
    public function setLeftValue(BaseObject $node, $value)
    {
        $setter = self::forgeMethodName($node, 'set', 'left');
        return $node->$setter($value);
    }

    /**
     * Proxy method used to access column holding nested set's right value setter.
     *
     * @param      BaseObject  $node
     * @param      integer     $value
     */
    public function setRightValue(BaseObject $node, $value)
    {
        $setter = self::forgeMethodName($node, 'set', 'right');
        return $node->$setter($value);
    }

    /**
     * Proxy method used to access column holding nested set's right value getter.
     *
     * @param      BaseObject  $node
     */
    public function getRightValue(BaseObject $node)
    {
        $getter = self::forgeMethodName($node, 'get', 'right');
        return $node->$getter();
    }

    /**
     * Proxy method used to access column holding nested set's scope value setter.
     *
     * @param      BaseObject  $node
     * @param      integer     $value
     */
    public function setScopeIdValue(BaseObject $node, $value)
    {
        $setter = self::forgeMethodName($node, 'set', 'scope');
        return $node->$setter($value);
    }

    /**
     * Proxy method used to access column holding nested set's scope value getter.
     *
     * @param      BaseObject  $node
     */
    public function getScopeIdValue(BaseObject $node)
    {
        $getter = self::forgeMethodName($node, 'get', 'scope');
        return $node->$getter();
    }

    /**
     * Proxy method used to access column holding nested set's depth value getter.
     *
     * @param      BaseObject  $node
     */
    public function getDepthValue(BaseObject $node)
    {
        $getter = self::forgeMethodName($node, 'get', 'depth');
        return $node->$getter();
    }

    /**
     * Proxy method used to access column holding nested set's depth value setter.
     *
     * @param      BaseObject  $node
     * @param      integer     $value
     */
    public function setDepthValue(BaseObject $node, $value)
    {
        $setter = self::forgeMethodName($node, 'set', 'depth');
        return $node->$setter($value);
    }

    /**
     * Proxy method used to access column holding nested set's parent value setter.
     *
     * @param      BaseObject  $node
     * @param      integer     $value
     */
    public function setParentIdValue(BaseObject $node, $value)
    {
        $setter = self::forgeMethodName($node, 'set', 'parent');
        return $node->$setter($value);
    }

    /**
     * Proxy method used to access column holding nested set's parent value getter.
     *
     * @param      BaseObject  $node
     */
    public function getParentIdValue(BaseObject $node)
    {
        $getter = self::forgeMethodName($node, 'get', 'parent');
        return $node->$getter();
    }

    # -- NESTED SETS PUBLIC API


    /**
     * Sets node properties to make it a root node.
     *
     * @param      BaseObject  $node
     * @throws     Exception   When trying to turn an existing non-root node into a root node
     */
    public function makeRoot(BaseObject $node)
    {
        if ((bool)$node->getLeftValue())
        {
            throw new Exception('Cannot turn an existing node into a root node.');
        }

        $node->setDepthValue(0);
        $node->setLeftValue(1);
        $node->setRightValue(2);
    }

    # ---- INSERTION METHODS


    /**
     * Inserts node as first child of given node.
     *
     * @param      BaseObject     $node
     * @param      BaseObject     $dest_node
     */
    public function insertAsFirstChildOf(BaseObject $node, BaseObject $dest_node)
    {
        $node->setLeftValue($dest_node->getLeftValue() + 1);
        $node->setRightValue($dest_node->getLeftValue() + 2);
        $node->setScopeIdValue($dest_node->getScopeIdValue());
        $node->setParentIdValue($dest_node->getPrimaryKey());
        $node->setDepthValue($dest_node->getDepthValue() + 1);
        $this->addPreSaveStackEntries($this->shiftRLValues(get_class($node->getPeer()), $node->getLeftValue(), 2, $dest_node->getScopeIdValue()));

        $dest_node->setRightValue($dest_node->getRightValue() + 2);
        $this->addPreSaveStackEntries(array($dest_node));
    }

    /**
     * Inserts node as last child of given node.
     *
     * @param      BaseObject    $node
     * @param      BaseObject    $dest_node
     */
    public function insertAsLastChildOf(BaseObject $node, BaseObject $dest_node)
    {
        $node->setLeftValue($dest_node->getRightValue());
        $node->setRightValue($dest_node->getRightValue() + 1);
        $node->setScopeIdValue($dest_node->getScopeIdValue());
        $node->setParentIdValue($dest_node->getPrimaryKey());
        $node->setDepthValue($dest_node->getDepthValue() + 1);
        $this->addPreSaveStackEntries($this->shiftRLValues(get_class($node->getPeer()), $node->getLeftValue(), 2, $dest_node->getScopeIdValue()));

        $dest_node->setRightValue($dest_node->getRightValue() + 2);
        $this->addPreSaveStackEntries(array($dest_node));
    }

    /**
     * Inserts node as next sibling of given node.
     *
     * @param      BaseObject  $node
     * @param      BaseObject  $dest_node
     * @throws     Exception   When trying to create a sibling to a root node
     */
    public function insertAsNextSiblingOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->isRoot())
        {
            $msg = 'Root nodes cannot have siblings';
            throw new Exception($msg);
        }

        $node->setLeftValue($dest_node->getRightValue() + 1);
        $node->setRightValue($dest_node->getRightValue() + 2);
        $node->setScopeIdValue($dest_node->getScopeIdValue());
        $node->setParentIdValue($dest_node->getParentIdValue());
        $node->setDepthValue($dest_node->getDepthValue());

        $this->addPreSaveStackEntries($this->shiftRLValues(get_class($node->getPeer()), $node->getLeftValue(), 2, $dest_node->getScopeIdValue()));
    }

    /**
     * Inserts node as previous sibling of given node.
     *
     * @param      BaseObject     $node
     * @param      BaseObject     $dest_node
     * @throws     Exception      When trying to create a sibling to a root node
     */

    public function insertAsPrevSiblingOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->isRoot())
        {
            $msg = 'Root nodes cannot have siblings';
            throw new Exception($msg);
        }

        $node->setLeftValue($dest_node->getLeftValue());
        $node->setRightValue($dest_node->getLeftValue() + 1);
        $node->setScopeIdValue($dest_node->getScopeIdValue());
        $node->setParentIdValue($dest_node->getParentIdValue());
        $node->setDepthValue($dest_node->getDepthValue());

        $this->addPreSaveStackEntries($this->shiftRLValues(get_class($node->getPeer()), $node->getLeftValue(), 2, $dest_node->getScopeIdValue()));

        $dest_node->setLeftValue($dest_node->getLeftValue() + 2);
        $dest_node->setRightValue($dest_node->getRightValue() + 2);
        $this->addPreSaveStackEntries(array($dest_node));
    }

    /**
     * Inserts node as parent of given node.
     *
     * @param      BaseObject     $node
     * @param      BaseObject     $dest_node
     * @throws     Exception      When trying to insert node as parent of a root node
     */
    public function insertAsParentOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->isRoot())
        {
            $msg = 'Impossible to insert a node as parent of a root node';
            throw new Exception($msg);
        }

        $peer_name = get_class($node->getPeer());

        $this->addPreSaveStackEntries(self::shiftRLValues($peer_name, $dest_node->getLeftValue(), 1, $dest_node->getScopeIdValue()));
        $this->addPreSaveStackEntries(self::shiftRLValues($peer_name, $dest_node->getRightValue() + 2, 1, $dest_node->getScopeIdValue()));

        $node->setLeftValue($dest_node->getLeftValue());
        $node->setRightValue($dest_node->getRightValue() + 2);

        $previous_parent = $dest_node->getParentIdValue();
        $node->setParentIdValue($previous_parent);
        $dest_node->setParentIdValue($node->getPrimaryKey());

        $this->addPreSaveStackEntries(array($dest_node));

    }

    # ---- INFORMATIONAL METHODS


    /**
     * Returns true if given node as one or several children.
     *
     * @param      BaseObject  $node
     * @return     bool
     */
    public function hasChildren(BaseObject $node)
    {
        return $node->getRightValue() - $node->getLeftValue() > 1;
    }

    /**
     * Returns true if given node is a root node.
     *
     * @param      BaseObject      $node
     * @return     bool
     */
    public function isRoot(BaseObject $node)
    {
        return $node->getLeftValue() == 1;
    }

    /**
     * Returns true if given node has a parent node.
     *
     * @param      BaseObject      $node
     * @return     bool
     */
    public function hasParent(BaseObject $node)
    {
        return $node->getParentIdValue();
    }

    /**
     * Returns true if given node has a next sibling.
     *
     * @param      BaseObject      $node
     * @return     bool
     */
    public function hasNextSibling(BaseObject $node)
    {
        return (bool)$node->retrieveNextSibling();
    }

    /**
     * Returns true if given node has a previous sibling.
     *
     * @param      BaseObject      $node
     * @return     bool
     */
    public function hasPrevSibling(BaseObject $node)
    {
        return (bool)$node->retrievePrevSibling();
    }

    /**
     * Returns true if given node does not have children.
     *
     * @param      BaseObject      $node
     * @return     bool
     */
    public function isLeaf(BaseObject $node)
    {
        return $node->getRightValue() - $node->getLeftValue() == 1;
    }

    /**
     * Returns true if given node is identical to node.
     *
     * @param      BaseObject      $node
     * @param      BaseObject      $compared_node
     * @return     bool
     */
    public function isEqualTo(BaseObject $node, BaseObject $compared_node)
    {
        return ($node->getLeftValue() === $compared_node->getLeftValue() && $node->getRightValue() === $compared_node->getRightValue() && $node->getScopeIdValue() === $compared_node->getScopeIdValue() && $node->getParentIdValue() === $compared_node->getParentIdValue());
    }

    /**
     * Returns true if given node is parent of node.
     *
     * @param      BaseObject      $node
     * @param      BaseObject      $parent_node
     */
    public function isChildOf(BaseObject $node, BaseObject $parent_node)
    {
        return ($node->getParentIdValue() === $parent_node->getPrimaryKey() && $node->getScopeIdValue() === $parent_node->getScopeIdValue());
    }

    /**
     * Returns true if given node is descendant of node.
     *
     * @param      BaseObject      $descendant_node
     * @param      BaseObject      $node
     */
    public function isDescendantOf(BaseObject $descendant_node, BaseObject $node)
    {
        return ($node->getLeftValue() <= $descendant_node->getLeftValue() && $node->getRightValue() >= $descendant_node->getRightValue() && $node->getScopeIdValue() === $descendant_node->getScopeIdValue());
    }

    /**
     * Returns given node number of direct children.
     *
     * @param      BaseObject  $node
     * @return     integer
     */
    public function getNumberOfChildren(BaseObject $node)
    {
        $peer_name = get_class($node->getPeer());
        $con = Propel::getConnection();
        $scope_sql = '';
        if (!is_null($node->getScopeIdValue()))
        {
            $scope_sql = sprintf(' AND %s = "%s"', self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue());
        }

        $sql = sprintf('SELECT COUNT(*) AS num_children FROM %s WHERE %s = %s %s', constant("$peer_name::TABLE_NAME"), self::getColumnConstant(get_class($node), 'parent'), $node->getPrimaryKey(), $scope_sql);

        $stmt = $con->createStatement();
        $rs = $stmt->executeQuery($sql);
        $rs->next();

        return $rs->getInt('num_children');
    }

    /**
     * Returns given node number of descendants (n level).
     *
     * @param      BaseObject  $node
     * @return     integer
     */
    public function getNumberOfDescendants(BaseObject $node)
    {
        $right = $node->getRightValue();
        $left = $node->getLeftValue();
        $num = ($right - $left - 1) / 2;

        return $num;
    }

    /**
     * Returns given node level.
     *
     * @param      BaseObject     $node
     * @return     integer
     */
    public function getLevel(BaseObject $node)
    {
        return (int)$node->getDepthValue();
    }

    /**
     * Sets node level.
     *
     * @param    BaseObject    $node
     * @param    int           $level
     */
    public function setLevel(BaseObject $node, $level)
    {
        $node->setDepthValue($level);
    }

    # ---- NODE RETRIEVAL METHODS


    /**
     * Returns node's parent.
     *
     * @param    BaseObject   $node
     * @param    string       $peer_method     (optional) Method used for selecting node
     * @return   BaseObject or null if node does not have a parent.
     */
    public function getParent(BaseObject $node, $peer_method = 'retrieveByPk')
    {
        return $node->isRoot() ? null : call_user_func(array($node->getPeer(), $peer_method), $node->getParentIdValue());
    }

    /**
     * Returns given node direct children.
     *
     * @param      BaseObject  $node
     * @param      string      $peer_method     (optional) Method used for selecting nodes
     * @param      Criteria    $c               (optional) Criteria object for restricting lookup
     * @return     array       Node children
     */
    public function getChildren(BaseObject $node, $peer_method = 'doSelect', Criteria $c = null)
    {
        if (!$c)
        {
            $c = new Criteria();
        }
        $c->addAnd(self::getColumnConstant(get_class($node), 'parent'), $node->getPrimaryKey(), Criteria::EQUAL);
        $c->addAnd(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue(), Criteria::EQUAL);
        $c->addAscendingOrderByColumn(self::getColumnConstant(get_class($node), 'left'));

        $children = call_user_func(array(get_class($node->getPeer()), $peer_method), $c);

        /*
     * Set children level depending on node's.
     * This prevents many further queries for getting children levels.
     */
//        if (is_array($children))
//        {
//            $child_level = $node->getLevel() + 1;
//            for($i = 0; $i < count($children); $i++)
//            {
//                $children[$i]->setLevel($child_level);
//            }
//        }
//
        return $children;
    }

    /**
     * Returns given node descendants (n level) in pre-order.
     *
     * @param      BaseObject  $node
     * @param      string      $peer_method     (optional) Method used for selecting nodes
     * @param      Criteria    $c               (optional) Criteria object for restricting lookup
     * @return     array       Node descendants, pre-order
     */
    public function getDescendants(BaseObject $node, $peer_method = 'doSelect', Criteria $c = null)
    {
        $descendants = array();

        if (!$node->isLeaf())
        {
            if (!$c)
            {
                $c = new Criteria();
            }
            $c->addAnd(self::getColumnConstant(get_class($node), 'left'), $node->getLeftValue(), Criteria::GREATER_THAN);
            $c->addAnd(self::getColumnConstant(get_class($node), 'right'), $node->getRightValue(), Criteria::LESS_THAN);
            $c->addAnd(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue(), Criteria::EQUAL);
            $c->addAscendingOrderByColumn(self::getColumnConstant(get_class($node), 'left'));

            $descendants = call_user_func(array(get_class($node->getPeer()), $peer_method), $c);
        }

        /*
     * Set node levels to prevent further queries to database
     */
//        $prev = array($node->getRightValue());
//        $i = 0;
//        if (count($descendants))
//        {
//            $initial_level = $descendants[0]->getLevel() - 1;
//        }
//
//        foreach ($descendants as $cur)
//        {
//            // get back to the parent
//            while($cur->getRightValue() > $prev[$i])
//            {
//                $i--;
//            }
//
//            $cur->setLevel(++$i + $initial_level);
//            $prev[$i] = $cur->getRightValue();
//        }

        return $descendants;
    }

    /**
     * Returns given node next sibling.
     *
     * @param      BaseObject     $node
     * @return     BaseObject
     */
    public function retrieveNextSibling(BaseObject $node)
    {
        $c = new Criteria();
        $c->add(self::getColumnConstant(get_class($node), 'left'), $node->getRightValue() + 1, Criteria::EQUAL);
        $c->add(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue(), Criteria::EQUAL);

        return call_user_func(array(get_class($node->getPeer()), 'doSelectOne'), $c);
    }

    /**
     * Returns given node previous sibling.
     *
     * @param      BaseObject     $node
     * @return     BaseObject
     */
    public function retrievePrevSibling(BaseObject $node)
    {
        $c = new Criteria();
        $c->add(self::getColumnConstant(get_class($node), 'right'), $node->getLeftValue() - 1, Criteria::EQUAL);
        $c->add(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue(), Criteria::EQUAL);

        return call_user_func(array(get_class($node->getPeer()), 'doSelectOne'), $c);
    }

    /**
     * Returns given node first child.
     *
     * @param      BaseObject     $node
     * @return     BaseObject
     */
    public function retrieveFirstChild(BaseObject $node)
    {
        $c = new Criteria();
        $c->add(self::getColumnConstant(get_class($node), 'left'), $node->getLeftValue() + 1, Criteria::EQUAL);
        $c->add(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue(), Criteria::EQUAL);

        return call_user_func(array(get_class($node->getPeer()), 'doSelectOne'), $c);
    }

    /**
     * Returns given node last child.
     *
     * @param      BaseObject     $node
     * @return     BaseObject
     */
    public function retrieveLastChild(BaseObject $node)
    {
        $c = new Criteria();
        $c->add(self::getColumnConstant(get_class($node), 'right'), $node->getRightValue() - 1, Criteria::EQUAL);
        $c->add(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue(), Criteria::EQUAL);

        return call_user_func(array(get_class($node->getPeer()), 'doSelectOne'), $c);
    }

    /**
     * Returns given node parent.
     *
     * @param      BaseObject     $node
     * @return     BaseObject
     */
    public function retrieveParent(BaseObject $node, $peer_method = 'doSelectOne')
    {
        if ($node->isRoot())
        {
            return false;
        }

        // Trick to get proper criteria
        $clone = clone $node;
        $clone->setId($node->getParentIdValue());
        $c = $clone->buildPKeyCriteria();

        return call_user_func(array(get_class($node->getPeer()), $peer_method), $c);
    }

    /**
     * Returns node siblings.
     *
     * @param      BaseObject     $node
     * @param      string         $peer_method    (optional) defaults to "doSelect"
     * @return     array
     */
    public function retrieveSiblings(BaseObject $node, $peer_method = 'doSelect')
    {
        $c = new Criteria();
        $c->add(self::getColumnConstant(get_class($node), 'parent'), $node->getParentIdValue());
        $c->add(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue());

        $results = call_user_func(array($node->getPeer(), $peer_method), $c);
        $final_results = array();

        if (is_array($results) && count($results))
        {
            $level = $results[0]->getLevel();
            foreach ($results as $r)
            {
                if ($node->isEqualTo($r))
                {
                    continue;
                }
                $r->setLevel($level);
                $final_results[] = $r;
            }
        }

        return $final_results;
    }

    /**
     * Returns path to a specific node as an array, useful to create breadcrumbs.
     *
     * @param      BaseObject     $node
     * @return     array
     */
    public function getPath(BaseObject $node, $peer_method = 'doSelect')
    {
        $c = new Criteria();
        $c->add(self::getColumnConstant(get_class($node), 'left'), $node->getLeftValue(), Criteria::LESS_THAN);
        $c->add(self::getColumnConstant(get_class($node), 'right'), $node->getRightValue(), Criteria::GREATER_THAN);
        if ($node->getScopeIdValue())
        {
            $c->add(self::getColumnConstant(get_class($node), 'scope'), $node->getScopeIdValue());
        }
        $c->addAscendingOrderByColumn(self::getColumnConstant(get_class($node), 'left'));

        return call_user_func(array($node->getPeer(), $peer_method), $c);
    }

    # ---- TREE MODIFICATIONS METHODS


    /**
     * Moves node to first child of given node.
     *
     * @param      BaseObject      $node
     * @param      BaseObject      $dest_node
     */
    public function moveToFirstChildOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->getScopeIdValue() != $node->getScopeIdValue())
        {
            $this->addPreSaveStackEntries(self::getUpdateNodesForTreeMigration($node, $dest_node->getLeftValue() + 1, $dest_node->getDepthValue() + 1, $dest_node->getScopeIdValue()));
            $node->setParentIdValue($dest_node->getPrimaryKey());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $node->setDepthValue($dest_node->getDepthValue() + 1);
        }
        else
        {
            $node->setParentIdValue($dest_node->getPrimaryKey());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            //$node->save();
            $this->addPreSaveStackEntries(self::getUpdateTreeQueries($node, $dest_node->getLeftValue() + 1, $dest_node->getDepthValue() + 1));
            $node->setDepthValue($dest_node->getDepthValue() + 1);
        }
    }

    /**
     * Moves node to last child of given node.
     *
     * @param      BaseObject      $node
     * @param      BaseObject      $dest_node
     */
    public function moveToLastChildOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->getScopeIdValue() != $node->getScopeIdValue())
        {
            $this->addPreSaveStackEntries(self::getUpdateNodesForTreeMigration($node, $dest_node->getRightValue(), $dest_node->getDepthValue() + 1, $dest_node->getScopeIdValue()));
            $node->setParentIdValue($dest_node->getPrimaryKey());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $node->setDepthValue($dest_node->getDepthValue() + 1);
        }
        else
        {
            $node->setParentIdValue($dest_node->getPrimaryKey());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $this->addPreSaveStackEntries(self::getUpdateTreeQueries($node, $dest_node->getRightValue(), $dest_node->getDepthValue() + 1));
            $node->setDepthValue($dest_node->getDepthValue() + 1);
        }
    }

    /**
     * Moves node to next sibling of given node.
     *
     * @param      BaseObject      $node
     * @param      BaseObject      $dest_node
     */
    public function moveToNextSiblingOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->getScopeIdValue() != $node->getScopeIdValue())
        {
            $this->addPreSaveStackEntries(self::getUpdateNodesForTreeMigration($node, $dest_node->getRightValue() + 1, $dest_node->getDepthValue(), $dest_node->getScopeIdValue()));
            $node->setParentIdValue($dest_node->getParentIdValue());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $node->setDepthValue($dest_node->getDepthValue());
        }
        else
        {
            $node->setParentIdValue($dest_node->getParentIdValue());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $this->addPreSaveStackEntries(self::getUpdateTreeQueries($node, $dest_node->getRightValue() + 1, $dest_node->getDepthValue()));
            $node->setDepthValue($dest_node->getDepthValue());
        }
    }

    /**
     * Moves node to previous sibling of given node.
     *
     * @param      BaseObject      $node
     * @param      BaseObject      $dest_node
     */
    public function moveToPrevSiblingOf(BaseObject $node, BaseObject $dest_node)
    {
        if ($dest_node->getScopeIdValue() != $node->getScopeIdValue())
        {
            $this->addPreSaveStackEntries(self::getUpdateNodesForTreeMigration($node, $dest_node->getLeftValue(), $dest_node->getDepthValue(), $dest_node->getScopeIdValue()));
            $node->setParentIdValue($dest_node->getParentIdValue());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $node->setDepthValue($dest_node->getDepthValue());
        }
        else
        {
            $node->setParentIdValue($dest_node->getParentIdValue());
            $node->setScopeIdValue($dest_node->getScopeIdValue());
            $this->addPreSaveStackEntries(self::getUpdateTreeQueries($node, $dest_node->getLeftValue(), $dest_node->getDepthValue()));
            $node->setDepthValue($dest_node->getDepthValue());
        }
    }

    /**
     * Deletes given node direct children.
     *
     * @param      BaseObject      $node
     */
    public function deleteChildren(BaseObject $node)
    {
        // array_reverse() call is necessary for root node properties to be correctly updated
        foreach (array_reverse($node->getChildren()) as $child)
        {
            $child->delete();
        }
    }

    /**
     * Deletes all nodes below given node (n level).
     *
     * @param      BaseObject      $node
     */
    public function deleteDescendants(BaseObject $node)
    {
        $peer_name = get_class($node->getPeer());
        $stub_name = get_class($node);
        $scope = $node->getScopeIdValue();

        $c = new Criteria();
        $c1 = $c->getNewCriterion(self::getColumnConstant($stub_name, 'left'), $node->getLeftValue(), Criteria::GREATER_THAN);
        $c2 = $c->getNewCriterion(self::getColumnConstant($stub_name, 'right'), $node->getRightValue(), Criteria::LESS_THAN);

        $c1->addAnd($c2);

        $c->add($c1);
        $c->add(self::getColumnConstant($stub_name, 'scope'), $scope);
        $c->addDescendingOrderByColumn(self::getColumnConstant($stub_name, 'right'));

        // Nodes are not directly deleted because we need to maintain adjacency list properties
        $descendants = call_user_func(array($peer_name, 'doDelete'), $c);

        $this->addPreDeleteStackEntries(self::shiftRLValues($peer_name, $node->getLeftValue(), -($node->getRightValue() + 1 - $node->getLeftValue()), $scope));
        $this->processPreDeleteStack();

    }

    # -- HELPER METHODS


    /**
     * Returns an up to date version of node.
     *
     * @param       BaseObject  $node
     * @return      BaseObject
     */
    public function reload(BaseObject $node)
    {
        return call_user_func(array($node->getPeer(), 'retrieveByPk'), $node->getPrimaryKey());
    }

    private static function getUpdateNodesForTreeMigration($node, $dest_left, $dest_depth, $dest_scope)
    {
        $statements = array();
        $peer_name = get_class($node->getPeer());
        $stub_name = self::getStubFromPeer($peer_name);
        $table_name = constant("$peer_name::TABLE_NAME");
        $scope_column = self::getColumnConstant($stub_name, 'scope');
        $left_column = self::getColumnConstant($stub_name, 'left');
        $right_column = self::getColumnConstant($stub_name, 'right');
        $depth_column = self::getColumnConstant($stub_name, 'depth');
        $tree_size = $node->getRightValue() - $node->getLeftValue() + 1;

        if ($node->getScopeIdValue())
        {
            $scope_sql = sprintf(' AND %s = %s', $scope_column, $node->getScopeIdValue());
        }

        $statements = array_merge($statements, self::shiftRLValues($peer_name, $dest_left, $tree_size, $dest_scope));

        $delta = $dest_left - $node->getLeftValue();

        $depth_delta = $dest_depth - $node->getDepthValue();

        $sql = 'UPDATE %1$s SET %4$s = %7$d, %5$s = %5$s + %6$d, %2$s = %2$s + %10$d, %3$s = %3$s + %10$d  WHERE %2$s >= %8$d AND %3$s <= %9$d %11$s';

        $statements[] = sprintf($sql, $table_name, $left_column, $right_column, $scope_column, $depth_column, $depth_delta, $dest_scope, $node->getLeftValue(), $node->getRightValue(), $delta, $scope_sql);

        $statements = array_merge($statements, self::shiftRLValues($peer_name, $node->getRightValue() + 1, -$tree_size, $node->getScopeIdValue()));

        return $statements;
    }

    private static function changeParentIdValues($peer_name, $from, $by_parent_id, $parent_id, $scopeId = null)
    {
        $statements = array();
        $stub_name = self::getStubFromPeer($peer_name);
        $table_name = constant("$peer_name::TABLE_NAME");
        $right_column = self::getColumnConstant($stub_name, 'right');
        $scope_column = self::getColumnConstant($stub_name, 'scope');
        $parent_column = self::getColumnConstant($stub_name, 'parent');

        $scope_sql = '';
        if (isset($scopeId))
        {
            $scope_sql = sprintf(' AND %s = %s', $scope_column, $scopeId);
        }

        $sql = 'UPDATE %1$s SET %2$s = %5$s WHERE %3$s >= %6$d AND %2$s = %4$s %7$s';

        $statements[] = sprintf($sql, $table_name, $parent_column, $right_column, $by_parent_id, $parent_id, $from, $scope_sql);

        return $statements;

    }

    public static function shiftRLValues($peer_name, $first, $delta, $scopeId = null)
    {
        $statements = array();
        $stub_name = self::getStubFromPeer($peer_name);
        $table_name = constant("$peer_name::TABLE_NAME");
        $left_column = self::getColumnConstant($stub_name, 'left');
        $right_column = self::getColumnConstant($stub_name, 'right');
        $scope_column = self::getColumnConstant($stub_name, 'scope');

        $scope_sql = '';
        if (isset($scopeId))
        {
            $scope_sql = sprintf(' AND %s = %s', $scope_column, $scopeId);
        }

        $sql = 'UPDATE %1$s SET %2$s = %2$s + %3$d WHERE %2$s >= %4$d %5$s';

        $statements[] = sprintf($sql, $table_name, $left_column, $delta, $first, $scope_sql);
        $statements[] = sprintf($sql, $table_name, $right_column, $delta, $first, $scope_sql);


        return $statements;
    }

    private static function shiftRLRange($peer_name, $first, $last, $delta, $scopeId = null)
    {
        $statements = array();
        $stub_name = self::getStubFromPeer($peer_name);
        $table_name = constant("$peer_name::TABLE_NAME");
        $left_column = self::getColumnConstant($stub_name, 'left');
        $right_column = self::getColumnConstant($stub_name, 'right');
        $scope_column = self::getColumnConstant($stub_name, 'scope');
        $depth_column = self::getColumnConstant($stub_name, 'depth');

        $scope_sql = '';
        if (!is_null($scopeId))
        {
            $scope_sql = sprintf(' AND %s = "%s"', $scope_column, $scopeId);
        }

        $sql = 'UPDATE %1$s SET %2$s = %2$s + %3$d WHERE %2$s >= %4$d AND %2$s <= %5$d %6$s';

        $statements[] = sprintf($sql, $table_name, $left_column, $delta, $first, $last, $scope_sql);
        $statements[] = sprintf($sql, $table_name, $right_column, $delta, $first, $last, $scope_sql);


        return $statements;
    }

    private static function shiftDepth($peer_name, $first, $last, $delta, $depth_delta, $scopeId = null)
    {
        $statements = array();
        $stub_name = self::getStubFromPeer($peer_name);
        $table_name = constant("$peer_name::TABLE_NAME");
        $left_column = self::getColumnConstant($stub_name, 'left');
        $right_column = self::getColumnConstant($stub_name, 'right');
        $scope_column = self::getColumnConstant($stub_name, 'scope');
        $depth_column = self::getColumnConstant($stub_name, 'depth');

        $scope_sql = '';

        if (!is_null($scopeId))
        {
            $scope_sql = sprintf(' AND %s = "%s"', $scope_column, $scopeId);
        }

        $sql = 'UPDATE %1$s SET %3$s = %3$s + %4$d WHERE %2$s >= %6$d AND %2$s <= %7$d %8$s';

        $statements[] = sprintf($sql, $table_name, $right_column, $depth_column, $depth_delta, $delta, $first, $last, $scope_sql);

        return $statements;
    }

    /**
     * Returns getter / setter name for requested column.
     *
     * @param     BaseObject    $node
     * @param     string        $prefix     Usually 'get' or 'set'
     * @param     string        $column     left|right|parent|scope
     */
    private static function forgeMethodName($node, $prefix, $column)
    {
        $method_name = sprintf('%s%s', $prefix, $node->getPeer()->translateFieldName(self::getColumnConstant(get_class($node), $column), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME));
        return $method_name;
    }

    /**
     * Returns the appropriate column name.
     *
     * @param   string   $node_class               Propel model class
     * @param   string   $column                   "generic" column name (either parent, left, right, scope)
     * @param   bool     $skip_table_name_prefix   Removes table name from column name if true (defaults to false)
     *
     * @return  string   Column's name
     */
    private static function getColumnConstant($node_class, $column, $skip_table_name_prefix = false)
    {
        $conf_directive = sprintf('propel_behavior_actasnestedset_%s_columns', $node_class);
        $columns = sfConfig::get($conf_directive);

        return $skip_table_name_prefix ? substr($columns[$column], strpos($columns[$column], '.') + 1) : $columns[$column];
    }

    /**
     * Adds entries to given stack.
     *
     * @param     string    $stack_name
     * @param     array     $entries
     */
    private function addStackEntries($stack_name, $entries = array())
    {
        $stack = $this->$stack_name;
        foreach ($entries as $entry)
        {
            $stack[] = $entry;
        }
        $this->$stack_name = $stack;
    }

    private function addPreDeleteStackEntries($entries = array())
    {
        $this->addStackEntries('predelete_stack', $entries);
    }

    private function addPreSaveStackEntries($entries = array())
    {
        $this->addStackEntries('presave_stack', $entries);
    }

    /**
     * Processes presave stack : runs stacked queries and saves stackes objects.
     */
    private function processStack($stack_name)
    {
        $con = Propel::getConnection();
        try
        {
            $con->begin();
            foreach ($this->$stack_name as $action)
            {
                array_shift($this->$stack_name);

                // stack entry is an object, let's save it
                if (is_object($action) && $action instanceof BaseObject)
                {
                    $action->save();
                }
                // stack entry is an sql query, let's execute it
                elseif (is_string($action))
                {

                    $statement = $con->createStatement();
                 
                    $result = $statement->executeQuery($action);
                }
                else
                {
                    $msg = sprintf('Unable to process %s stack entry: %s', $stack_name, serialize($action));
                    throw new PropelException($msg);
                }

            }
        }
        catch(PropelException $e)
        {
            $con->rollback();
            throw $e;
        }
    }

    private function processPreDeleteStack()
    {
        $this->processStack('predelete_stack');
    }

    private function processPreSaveStack()
    {
        $this->processStack('presave_stack');
    }

    /**
     * Returns queries needed to update tree.
     *
     * @param     BaseObject    $node
     * @param     integer       $dest_left
     *
     * @return array
     */
    private static function getUpdateTreeQueries(BaseObject $node, $dest_left, $dest_depth)
    {
        $statements = array();
        $peer_name = get_class($node->getPeer());

        $left = $node->getLeftValue();
        $right = $node->getRightValue();
        $depth = $node->getDepthValue();
        $tree_size = $right - $left + 1;

        $statements = array_merge($statements, self::shiftRLValues($peer_name, $dest_left, $tree_size, $node->getScopeIdValue()));

        if ($left >= $dest_left)
        {
            $left += $tree_size;
            $right += $tree_size;
        }
        $statements = array_merge($statements, self::shiftDepth($peer_name, $left, $right, $dest_left - $left, $dest_depth - $depth, $node->getScopeIdValue()));
        $statements = array_merge($statements, self::shiftRLRange($peer_name, $left, $right, $dest_left - $left, $node->getScopeIdValue()));
        $statements = array_merge($statements, self::shiftRLValues($peer_name, $right + 1, -$tree_size, $node->getScopeIdValue()));

        return $statements;

    }

    /**
     * Returns peer's stub name.
     *
     * @param    string    $peer_name
     * @return   string
     */
    public static function getStubFromPeer($peer_name)
    {
        return preg_replace('/^(\w+)Peer$/', '$1', $peer_name);
    }

    public function postHydrate(BaseObject $node, ResultSet $rs, $startcol = 1)
    {
        try
        {
            $node->depth = $rs->getInt($startcol);
        }
        catch(Exception $e)
        {
            $node->depth = 0;
        }

    }

}
