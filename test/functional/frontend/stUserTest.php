<?php
/** 
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  tests
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stUserTest.php 617 2009-04-09 13:02:31Z michal $
 * @author      Michał Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Wymagane biblioteki.
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new stTestBrowser();
$browser->initialize();

$browser->test()->diag('Test usera');

/**
 * Sprawdzanie logowania
 */

$browser->test()->diag('Login test');

$browser->get('/stUser/loginUser');
$browser->isStatusCode(200);
$browser->isRequestParameter('module', 'stUser');
$browser->isRequestParameter('action', 'loginUser');
$browser->responseContains('Zaloguj');
$browser->responseContains('Logowanie');
  
//$random=rand(1,1000);  
//  
//$browser->click('Zaloguj',array("user"=>array("email"=>'jan@example.com', "password"=>'123456')));
//$browser->isRedirected();
//$browser->followRedirect();
//$browser->responseContains('jan@example.com');
//$browser->responseContains('Jan');
//$browser->responseContains('Kowalski');
//$browser->responseContains('wyloguj');
//
//$browser->click('wyloguj');
//$browser->isRedirected();
//$browser->followRedirect();
//$browser->get('/stUser/loginUser');
//$browser->responseContains('Logowanie');
//$browser->responseContains('Moje konto');
//$browser->responseContains('Zaloguj');

//$b->    
//  click('Zarejestruj się')->
//  responseContains('Rejestracja')->
//  responseContains('E-mail (login)')->
//  responseContains('Hasło')->
//  responseContains('Potwierdź hasło')->
//  responseContains('Zarejestruj');  

//$b->
//  click('Zarejestruj',array("user"=>array("email"=>'jan@example.com')))->
//  responseContains('Takie adres już istnieje w bazie danych.')->
//  responseContains('Nie podałeś hasła.')->
//  responseContains('Zarejestruj');