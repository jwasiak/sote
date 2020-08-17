<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSocketView.class.php 7 2009-08-24 08:59:30Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Klasa pozwalająca na budowanie opcjonalnych powiązań między aplikacjami.
 *
 * @package     stBase
 * @subpackage  libs
 */
class stSocketView
{
    /** 
     * Otwiera socket.
     *
     * @param                 string      $type               (component|partial)
     * @param        string      $socketName
     * @return   void
     */
    static public function open($type, $socketName, $paramters = array())
    {
        $result = null;
        
        $st_socket = sfConfig::get('st_socket_' . $type);
        if (empty($st_socket[$socketName]))
            return;
        
        $socket = $st_socket[$socketName];
        foreach ($socket as $id=>$com)
        {

            $com['data'] = (!empty($paramters)) ? array_merge($paramters, $com['data']) : $com['data'];
            switch ($type)
            {
                case "component" :
                    $result .= st_get_component($com['module'], $com[$type], $com['data']);
                    break;
                case "partial" :
                    $result .= st_get_partial($com[$type], $com['data']);
                    break;
            }
        }
        
        return $result;
    }
    
    /** 
     * Zwraca komponent przypisane dla danego Socketa.
     *
     * @param   string      $socketName         nazwa Socketa
     */
    static public function openComponents($socketName, $parameters = array())
    {
        return stSocketView::open('component', $socketName, $parameters);
    }
    
    /** 
     * Zwaraca partial przypisany do danego Socketa
     *
     * @param   string      $socketName         nazwa Socketa
     */
    static public function openPartials($socketName, $parameters = array())
    {
        return stSocketView::open('partial', $socketName, $parameters);
    }
    
    /** 
     * Dodaje element do socketa.
     *
     * @param        string      $type
     * @param        string      $socketName
     * @param        string      $moduleName
     * @param        string      $param
     * @param         array       $data
     */
    static private function add($type, $socketName, $moduleName, $param, $data = array())
    {
        $st_socket = sfConfig::get('st_socket_' . $type);
        $st_socket[$socketName][] = array('module'=>$moduleName, $type=>$param, 'data'=>$data);
        sfConfig::add(array('st_socket_' . $type=>$st_socket));
    }
    
    /** 
     * Dodaje komponent do wskazanego Socketa.
     *
     * @param   string      $socketName         nazwa socketa do którego podłczamy komponenty 
     * @param   string      $moduleName         nazwa modułu, z którego odczytujemy komponent 
     * @param   string      $component          nazwa komponentu w pluginie $plugin
     * @param   array       $data               dodatkowe paramtery przekazywane do komponentu
     */
    static public function addComponent($socketName, $moduleName, $component, $data = array())
    {
        stSocketView::add('component', $socketName, $moduleName, $component, $data);
    }
    
    /** 
     * Dodaje partial do wskazanego socketa
     *
     * @param        string      $socketName
     * @param        string      $partial
     * @param   array       $data               dodatkowe parametry przekazywane do partial'a
     */
    static public function addPartial($socketName, $partial, $data = array())
    {
        stSocketView::add('partial', $socketName, '', $partial, $data);
    }
}