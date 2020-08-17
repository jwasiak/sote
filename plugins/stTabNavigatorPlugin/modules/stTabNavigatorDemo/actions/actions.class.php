<?php
/** 
 * SOTESHOP/stTabNavigatorPlugin 
 * 
 * Ten plik należy do aplikacji stTabNavigatorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTabNavigatorPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 1475 2009-10-14 12:23:20Z marcin $
 */

/** 
 * Akcje dla stTabNavigatorDemo.
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stTabNavigatorPlugin
 * @subpackage  actions
 */
class stTabNavigatorDemoActions extends sfActions
{
    /** 
     * Wyświetla zakładki
     */
    public function executeIndex()
    {
        $this->tabNav1 = stTabNavigator::getInstance($this->getContext(), 'navtab1', 'stTabNavigatorDemo/index');
        $this->tabNav1->addTab('Truskawka', 'stTabNavigatorDemo', 'fruits', array('kind' => 'Truskawki'));
        $this->tabNav1->addTab('Pomarańcz', 'stTabNavigatorDemo', 'fruits', array('kind' => 'Pomarańczy'));
        $this->tabNav1->addTab('Banan', 'stTabNavigatorDemo', 'fruits', array('kind' => 'Banana'));
        $this->tabNav1->setTab($this->getRequestParameter('navtab1'));

        $this->tabNav2 = stTabNavigator::getInstance($this->getContext(), 'navtab2', 'stTabNavigatorDemo/index');
        $this->tabNav2->addTab('Ziemniak', 'stTabNavigatorDemo', 'potato');
        $this->tabNav2->addTab('Pomidor', 'stTabNavigatorDemo', 'tomato');
        $this->tabNav2->addTab('Marchewka', 'stTabNavigatorDemo', 'carrot');
        $this->tabNav2->setTab($this->getRequestParameter('navtab2'));
    }

    /** 
     * Zwraca zawartość zakładki fruits
     */
    public function executeFruits()
    {
        $this->setLayout(false);
        $this->kind = $this->getRequestParameter('kind');
    }

    /** 
     * EZwraca zawartość zakładki potato
     */
    public function executePotato()
    {
        $this->setLayout(false);
    }

    /** 
     * Zwraca zawartość zakładki tomato
     */
    public function executeTomato()
    {
        $this->setLayout(false);
    }

    /** 
     * Zwraca zawartość zakładki carrot
     */
    public function executeCarrot()
    {
        $this->setLayout(false);
    }
}