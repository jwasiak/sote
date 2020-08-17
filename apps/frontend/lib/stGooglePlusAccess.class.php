<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */ 
class stGooglePlusAccess extends stUser
{

    function __construct()
    {
        require_once 'google/Google_Client.php';
        require_once 'google/contrib/Google_Oauth2Service.php';        
        
    }

    public static function authUser($back)
    {
        $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
        
        $client = new Google_Client();
        $client->setApplicationName("Google+ PHP Starter Application");
        
        $client->setClientId($user_config->get('google_client_id'));
        $client->setClientSecret($user_config->get('google_secret_id'));
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'].'/user/googleOAuthSingIn');
        $client->setDeveloperKey($user_config->get('google_developer_key'));

        new Google_Oauth2Service($client);
        
        sfContext::getInstance()->getUser()->setAttribute('google_back', $back);
        
        $authUrl = $client->createAuthUrl();
        
        return $authUrl;
    }

  public static function getAuthUser()
    {
        $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
        
        $client = new Google_Client();
        $client->setApplicationName("Google+ PHP Starter Application");

        $client->setClientId($user_config->get('google_client_id'));
        $client->setClientSecret($user_config->get('google_secret_id'));
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'].'/user/googleOAuthSingIn');
        $client->setDeveloperKey($user_config->get('google_developer_key'));

        $plus = new Google_Oauth2Service($client);
        
        if (isset($_GET['code'])) {
          $client->authenticate($_GET['code']);
          $_SESSION['access_token'] = $client->getAccessToken();
        }

        if ($client->getAccessToken()) {
            $me = $plus->userinfo->get();
            $username = $me['email']; 
        }
        
        return $username;
     
    }

         
}