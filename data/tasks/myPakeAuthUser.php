<?php
/**
 * Dodanie użytkownika do logowania do backend'u/
 * 
 * @package   
 * @author    Bartosz Alejski <bartosz.alejski@sote.pl>
 * @version   $Id: myPakeAuthUser.php 251 2009-03-30 11:35:06Z marek $
 * @license   SOTE
 * @copyright SOTE 
 */   
                   
pake_desc('(SOTE) Add administrator user');
pake_task('add-auth-user', 'project_exists');


/**
 * Opis 
 * symfony add-auth-user admin@example.com 123456
 *
 * @param PakeTask $task
 * @param array    $args 
 */
function run_add_auth_user($task, $args)
{
                                   
      if (empty($args[0]) && empty($args[1])) throw new pakeException('You must provide parameters login (email) and password. Example: symfony add-auth-user admin@example.com 123456 ');
       
      if (empty($args[0]))  throw new pakeException('You must provide parameter login(email). Example: symfony add-auth-user admin@example.com 123456 ');
      $username=$args[0];
      
      $email = explode('@',$username);
      if(empty($email[1])) throw new pakeException('Wrong email format.');
      
      if (empty($args[1]))  throw new pakeException('You must provide parameter password. Example: symfony add-auth-user admin@example.com 123456 ');
      $password=$args[1];
      
      if ($password{5}=="")  throw new pakeException('Wrong password min 6 chars.');   
      
      $data=sfYaml::load(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'sfGuardUser.yml');
      
      $data['sfGuardUser']['admin']['username']=$username;
      $data['sfGuardUser']['admin']['password']=$password;  
      $data['sfGuardUser']['admin']['is_super_admin']="true";
      $data['sfGuardUser']['admin']['is_confirm']="true";  
      
      
      file_put_contents(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."fixtures".DIRECTORY_SEPARATOR."sfGuardUser.yml",sfYaml::dump($data));
      
      pake_echo('Fixtures update - path:'.sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'sfGuardUser.yml');
}
