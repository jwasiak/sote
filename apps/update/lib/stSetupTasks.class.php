<?php

/**
 * SOTESHOP/stUpdate
 *
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE.
 * Do not modify this file, system will overwrite it during upgrade.
 *
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stSetupTasks.class.php 13528 2011-06-08 09:57:46Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
require_once sfConfig::get('sf_symfony_lib_dir').'/vendor/pake/pakeGetopt.class.php';

require_once sfConfig::get('sf_symfony_lib_dir').'/vendor/pake/pakeApp.class.php';

/**
 * Installation. Progress bar class.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stSetupTasks extends stInstallerTasks
{

   /**
    * Step.
    *
    * @param   integer     $step               step number
    * @return  integer     next step number (default $step+1)
    */
   public function step($step)
   {
      $pakeweb = new stPakeWeb();

      $task = '';

      $i18n = sfContext::getInstance()->getI18N();
      
      $offset = 1;

      pakeApp::get_instance()->handle_options(SF_ENVIRONMENT == 'prod' ? '--quiet' : '--verbose');

      switch ($step)
      {
         case 0:
            $this->msg = $i18n->__('Czyszczenie plików tymczasowych', null, 'stInstallerWeb');  // opis krok do przodu
            break;
         case 1:
            $this->msg = $i18n->__('Odświeżenie pamięci podręcznej aplikacji', null, 'stInstallerWeb');  // opis krok do przodu

            if (class_exists('stLock'))
            {
               stLock::lock('frontend');
               stLock::lock('backend');
            }
            // lock shop
            $task = 'cc --lock=false';
            break;
         case 2:
            $this->msg = $i18n->__('Kopiowanie plików', null, 'stInstallerWeb');
            break;
         case 3:
            $this->msg = $i18n->__('Konfiguracja instalacji', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'installer-sync';
            break;
         case 4:
            $this->msg = $i18n->__('Tworzenie modelu bazy danych - Usuwanie starych plików', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'setup-update';
            break;         // database update
         case 5:
            $this->msg = $i18n->__('Tworzenie modelu bazy danych - Generowanie schematów XML', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'installer-clean-model forced';
            break;
         case 6:
            $this->msg = $i18n->__('Tworzenie modelu bazy danych - Generowanie klas modeli', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'installer-convert-schema forced';
            break;
         case 7:
            $this->msg = $i18n->__('Tworzenie modelu bazy danych - Generowanie zapytań SQL', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'installer-build-model forced';
            break;
         case 8:
            $this->msg = $i18n->__('Tworzenie modelu bazy danych - Aktualizacja struktury bazy danych', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'installer-build-sql forced drop-tables';
            break;
         case 9:
            $this->msg = $i18n->__('Czyszczenie plików tymczasowych', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'installer-insert-sql forced';
            break;
         case 10:
            $this->msg = $i18n->__('Odświeżenie pamięci podręcznej aplikacji', null, 'stInstallerWeb');  // opis krok do przodu
            $task = 'cc --lock=false';
            break;
         case 11:
            $this->msg = $i18n->__('Wczytywanie danych', null, 'stInstallerWeb');
            break;
         case 12:
            //$this->msg = $i18n->__('Ładowanie domyślnych danych. Uruchomienie sklepu', null, 'stInstallerWeb');  // opis krok do przodu
            //sfLoader::loadPluginConfig();
            //$task = 'installer-load-data '.SF_ENVIRONMENT;
            break;
         case 13:
            if ($this->_installVerification())
            {
               // unlock shop
               if (class_exists('stLock'))
               {
                  stLock::unlock('frontend');
                  stLock::unlock('backend');
                  $this->cleanHistory();
               }
            }
            break;
      }

      if (!empty($task))
      {

         if ($pakeweb->run($task))
         {
            if (!empty($pakeweb->content))
            {
               $this->log("\n".date('Y-m-d G:i:s')."\n".'symfony '.$task."\n".$pakeweb->content);
            }
         }
         else
         {
            throw new Exception($pakeweb->error);
         }
      }

      // // if applications didn't synchronize properly, repeat step
      if ($task == 'installer-sync' && $this->_appsToSync())
      {
         $offset = 0;
      }

      if ($task == 'setup-update')
      {
         // rebuild robots.txt file
         $this->robotsTxtUpate();
         // rebuild web/.htaccess file
         $this->_htaccess(true);
      }

      $this->delay($step == 0 ? 0 : 10);

      return $step + $offset;
   }

   public function getTitle()
   {
      sfLoader::loadHelpers('I18N');
      return __("Instalacja aplikacji (Uwaga! Nie zamykaj okna przeglądarki, aż instalacja się nie skończy):", null, 'stInstallerWeb');
   }

   public function getFatalMessage()
   {
      sfLoader::loadHelpers('I18N');
      sfLoader::loadHelpers('Url');
      sfLoader::loadHelpers('stUpdate');

      return __('Wystąpił błąd podczas instalacji oprogramowania', null, 'stSetup').' '.st_program_name().', '.__('większość problemów można rozwiązać korzystając z', null, 'stSetup').
      ' <strong>'.link_to(__('podręcznika instalacji', null, 'stSetup'), __('http://www.sote.pl/trac/wiki/doc/soteshop_installation', null, 'stSetup'), array('target' => '_blank')).'</strong>';
   }

   public function close($opt=null)
   {

      $without_optimization = 0;
      parent::close($without_optimization, false);

      sfLoader::loadHelpers('Tag');
      sfLoader::loadHelpers('Javascript');

      $this->msg.="<script type=\"text/javascript\">document.getElementById('stSetup-install_actions').style.visibility=\"visible\";</script>";
   }

   /**
    * Delete history files after installation.
    */
   protected function cleanHistory()
   {
      $file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.history.reg';
      if (file_exists($file))
         unlink($file);
   }

   /**
    * Rebuild web/robots.txt
    */
   protected function robotsTxtUpate()
   {
      $from = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'stPositioningPlugin'.DIRECTORY_SEPARATOR.
              'stPositioningPlugin'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'robots.txt';
      $to = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'robots.txt';
      copy($from, $to);
   }

}
