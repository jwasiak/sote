<?php
/** 
 * SOTESHOP/stCategory 
 * 
 * Ten plik należy do aplikacji stCategory opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCategory
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stNestedIterator.class.php 318 2009-09-07 12:39:29Z michal $
 */

/** 
 * Klasa pomocnicza do poruszanie sie po elementach zagnieżdżonych
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stCategory
 * @subpackage  libs
 */
class stNestedIterator
{
    private $rootTree = null;

    private $descendants = array();

    static private $depthIndex = array();

    /** 
     * Ustawia korzeń
     *
     * @param   BaseObject  $node               korzeń  
     */
    public function setRoot(BaseObject $node)
    {
        $this->rootTree = $node;
    }
    
    /** 
     * Zwraca korzeń
     *
     * @return   unknown
     */
    public function getRoot()
    {
        return $this->rootTree;
    }
    
    /** 
     * Ustawia potomków drzewa
     *
     * @param   array       of                  BaseObject $descendants
     */
    public function setDescendants($descendants = array())
    {
        $this->descendants = $descendants;
    }
    
    /** 
     * Zwraca potomków drzewa
     *
     * @return  array       of BaseObject
     */
    public function getDescendants()
    {
        return $this->descendants;
    }
    
    /** 
     * Zwraca potomków drzewa.
     */
    public function hasDescendants()
    {
        return !empty($this->descendants);
    }
    
    /** 
     * Zwraca obiekty stNestedIterator
     *
     * @return  array       of stNestedIterator objects
     */
    static public function retrieveTree(Criteria $categoryCriteria = null)
    {
        $c = new Criteria();

        $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);

        $objects = array();

        $descendants = CategoryPeer::doSelect($c);

        if ($descendants)
        {
            foreach ($descendants as $descendant)
            {
                if (is_null($categoryCriteria))
                {
                    $c = new Criteria();    
                }
                else 
                {
                    $c = clone $categoryCriteria;
                }
                
                $c->add(CategoryPeer::LFT, $descendant->getLft(), Criteria::GREATER_THAN);
                $c->add(CategoryPeer::RGT, $descendant->getRgt(), Criteria::LESS_THAN);
                $c->add('tparent.SCOPE', 'tparent.SCOPE = ' . $descendant->getScope(), Criteria::CUSTOM);
                $c->add(CategoryPeer::SCOPE, 'tparent.SCOPE = ' . CategoryPeer::SCOPE, Criteria::CUSTOM);

                $childs = CategoryPeer::doSelectNestedSet($c);

                $object = new self();
                $descendant->setLevel(1);
                $object->setRoot($descendant);
                $object->setDescendants($childs);
                $objects[] = $object;
            }
        }
        return $objects;
    }
   
    /** 
     * Zwraca numer zagnieżdżenia danego elementu w drzewie
     *
     * @param   BaseObject  $node               Element drzewa
     * @return  string      (1., 1.1, 2., ...)
     */
    static public function getDepthNumber(BaseObject $node)
    {
        $depthNumber = '';
        $level = $node->getLevel();
        
        if (!isset(self::$depthIndex[$node->getScope()][$level]))
        {
            self::$depthIndex[$node->getScope()][$level] = 0;
        }
        
        if (!$node->isRoot())
        {
            self::$depthIndex[$node->getScope()][$level]++;
        }

        for ($i=1; $i <= $level; $i++)
        {

            $depthNumber .= (self::$depthIndex[$node->getScope()][$i]).'.';
        }

        return $depthNumber;
    }
    
    /** 
     * Pobiera listę drzew
     *
     * @param   Criteria    $c                  dodatkowe kryteria
     * @return  Array       tablica obiektów Category  
     */
    static public function retrieveRoots($c = null)
    {
        if (is_null($c))
        {
            $c = new Criteria();
        }
        else 
        {
            $c = clone $c;
        }
        
        $c->add(CategoryPeer::PARENT_ID, null, Criteria::ISNULL);
        
        return CategoryPeer::doSelect($c);
    }
    
    /** 
     * Pobiera ścieżkę kategorii do podanych potomków drzewa
     */
    static public function getPathToDescendant($descendants = array(), BaseObject $descendant)
    {
        $pathArray = array();
        foreach ($descendants as $d)
        {
            if ($d->getLft() < $descendant->getLft() && $d->getRgt() > $descendant->getRgt())
            {
                $pathArray[] = $d->getName();
                if ($d->getLevel() == $descendant->getLevel() - 1) break;
            }  
        }
        return $pathArray;
    }
}