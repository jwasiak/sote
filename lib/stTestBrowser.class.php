<?php
/** 
 * SOTESHOP/stTestPlugin 
 * 
 * Ten plik należy do aplikacji stTestPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stTestPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTestBrowser.class.php 3292 2008-12-15 08:53:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stTestBrowser
 *
 * @package     stTestPlugin
 * @subpackage  libs
 */
class stTestBrowser extends sfTestBrowser
{
    /** 
     * Logownie do panelu sklepu
     *
     * @param   string      $username           Nazwa użytkownika  
     * @param   string      $password           Hasło użytkownika 
     */
    public function login($username = 'admin@example.com', $password = '123456')
    {
        $this->call('/login', 'post', array("username" => $username, "password" => $password));
        return $this;
    }

    /** 
     * Przechodzenie do wybranej strony
     *
     * @param   string      $url                Adres strony do której ma przejść test 
     */
    public function go($url)
    {
        if (empty($url)) $this->test()->fail('Pramater $url is invalid.');
        if (!stSoteshop::isRouting(preg_replace('/\/([a-zA-Z0-9]+)$/','', $url))) $this->test()->fail('Routing for '.$url.' doesn\'t exist.');
        $this->get($url);
        return $this;
    }

    /** 
     * Przechodzenie do wybranej strony i sprawdzanie parametrów
     *
     * @param   string      $url                Adres strony do której ma przejść test 
     * @param   string      $module             Nazwa modułu 
     * @param   string      $action             Nazwa akcji
     * @param   integer     $statusCode         Kod statusu połączenia 
     */
    public function goAndCheck($url, $module = '', $action = '', $statusCode = '')
    {
        $this->go($url);
        if (!empty($statusCode)) $this->checkStatusCode($statusCode);
        if (!empty($module)) $this->checkRequestParameter('module', $module);
        if (!empty($action)) $this->checkRequestParameter('action', $action);
        return $this;
    }

    /** 
     * Sprawdzanie kodu statusu połączenia
     *
     * @param   integer     $statusCode         Kod statusu połączenia, domyślna wartość 200 
     */
    public function checkStatusCode($statusCode = 200)
    {
        $this->isStatusCode($statusCode);
        return $this;
    }

    /** 
     * Sprawdzanie paramertów z requesta
     *
     * @param   string      $name               Nazwa parametru
     * @param   string      $value              Wartość parametru 
     */
    public function checkRequestParameter($name, $value)
    {
        $this->isRequestParameter($name, $value);
        return $this;
    }

    /** 
     * Sprawdzanie czy tekst istnieje
     *
     * @param                string      $texts              Teksty
     */
    public function checkText($texts)
    {
        $texts = func_get_args();
        if (is_array($texts))
        {
            foreach ($texts as $text)
            {
                $this->responseContains($text);
            }
        }
        return $this;
    }

    /** 
     * Sprawdzanie sortowania
     *
     * @param   string      $url                Adres pod którym ma zostać wykonany test 
     * @param   array       $fields             Pola do sortowania
     */
    public function checkSort($url, $fields)
    {
        $this->go($url);

        if (is_array($fields))
        {
            foreach ($fields as $name => $field)
            {
                $this->click($field);
                $this->isRequestParameter('sort', $name);
                $this->isRequestParameter('type', 'asc');

                $this->click($field);
                $this->isRequestParameter('sort', $name);
                $this->isRequestParameter('type', 'desc');
            }
        } else {
            $this->test()->fail('Parameter $fields is invalid.');
        }
        return $this;
    }

    /** 
     * Sprawdzanie walidacji
     *
     * @param   string      $url                Adres pod którym ma zostać wykonany test 
     */
    public function checkValidation($url)
    {
        $this->go($url);

        $action = $this->getRequest()->getParameter('action');
        if($action == 'create')
        {
            $this->click('Zapisz');

            if (!strpos($this->getResponse()->getContent(), 'Popraw dane w formularzu.'))
            {
                $this->test()->fail('Validation not found.');
            }
        } else {
            $this->test()->fail('Method checkValidation can by used only in create action.');
        }
        return $this;
    }

    /** 
     * Dodawanie nowego rekordu
     *
     * @param   string      $url                Adres pod którym ma zostać wykonany test 
     * @param   array       $fields             Wartości jakie mają zostać dodane 
     */
    public function addRecord($url, $fields)
    {
        $this->go($url);

        $action = $this->getRequest()->getParameter('action');
        if($action == 'create')
        {
            if(is_array($fields))
            {
                foreach ($fields as $name => $value)
                {
                    $this->setField($name, $value);
                }
                $this->click('Zapisz');
            }
        } else {
            $this->test()->fail('Method addRecord can by used only in create action.');
        }
        return $this;
    }

    /** 
     * Usuwanie pierwszego rekordu z posortowanej listy wg parametru Id
     *
     * @param   string      $url                Adres pod którym ma zostać wykonany test 
     */
    public function deleteRecordFromList($url)
    {
        $this->go($url);

        $action = $this->getRequest()->getParameter('action');
        if($action == 'list')
        {
            $this->click('Id');
            if ($this->getRequest()->getParameter('type') == 'desc')
            {
                $this->click('delete');
            } else {
                $this->click('Id');
                $this->click('delete');
            }
        } else {
            $this->test()->fail('Method deleteFromList can by used only in list action.');
        }
        return $this;
    }
}