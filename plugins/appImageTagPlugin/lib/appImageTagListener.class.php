<?php

class appImageTagListener
{
   public static function generateStCategory(sfEvent $event)
   {
      $generator = $event->getSubject();

      $display = $generator->getValueForParameter('edit.display');

      if (!isset($display["NONE"]))
      {
         $display = array("NONE" => $display);
      }

      $display["Kolekcja produktów"] = array(
         'is_app_image_tag_active',
         'app_it_image'
      );

      $fields = $generator->getValueForParameter('edit.fields');

      $fields = array_merge($fields, array(
         'is_app_image_tag_active' => array(
            'name' => 'Włącz kolekcje produktów',
            'i18n' => 'appImageTagBackend',
            'help' => "Pole jest ignorowane jeżeli w <b>Konfiguracja -> Konfiguracja modułów -> Kategorie</b> opcja <b>Włącz kolekcje produktów</b> jest odznaczona",
         ),
         'app_it_image' => array(
            'name' => 'Załącz/Zmień zdjęcia',
            'type' => 'app_it_image',
            'i18n' => 'appImageTagBackend',
         ),
      ));

      $generator->setValueForParameter('edit.fields', $fields);

      $generator->setValueForParameter('edit.display', $display);

      $display = $generator->getValueForParameter('config.display');

      $display["Kolekcje produktów"] = array('enable_image_tag', 'image_tag_view_mode');

      $generator->setValueForParameter('config.display', $display);

      $generator->setValueForParameter('config.i18n.Kolekcje produktów', 'appImageTagBackend');

      $generator->setValueForParameter('config.fields.enable_image_tag', array('name' => 'Włącz', 'type' => 'checkbox', 'i18n' => 'appImageTagBackend')); 

      $generator->setValueForParameter('config.fields.image_tag_view_mode', array(
         'name' => 'Tryb wyświetlania', 
         'type' => 'select', 
         'i18n' => 'appImageTagBackend',
         'display' =>  array('stretch', 'fill'),
         'options' => array(
            'stretch' => array('name' => 'Rozciągaj zdjęcie na dostępną szerokość', 'i18n' => 'appImageTagBackend'),
            'fill' => array('name' => 'Wypełniaj zdjęciem dostępną szerokość', 'i18n' => 'appImageTagBackend'),
         )
      )); 


      

      $use_helper = $generator->getValueForParameter('edit.use_helper', array());

      $use_helper[] = 'appImageTag';

      $generator->setValueForParameter('edit.use_helper', $use_helper);
   }

   public static function postSaveCategory(sfEvent $event)
   {  
      $category = $event['modelInstance'];
      $request = $event->getSubject()->getRequest();

      $app_it_images = $request->getParameter('app_it_images');

      $delete = $app_it_images['delete'] ? explode(',', $app_it_images['delete']) : array();

      $modified = $app_it_images['modified'] ? explode(',', $app_it_images['modified']) : array();

      $upload_dir = sfConfig::get('sf_web_dir').'/uploads/plupload/'.$app_it_images['namespace'];

      if ($delete)
      {
         foreach (appCategoryImageTagGalleryPeer::retrieveByPKs($delete) as $tag)
         {
            $tag->delete();
         }
      }

      if ($modified)
      {
         foreach ($modified as $position => $filename)
         {
            if (is_numeric($filename) && $filename)
            {
               $cit = appCategoryImageTagGalleryPeer::retrieveByPK($filename);
            }
            else
            {
               $cit = new appCategoryImageTagGallery();
               $cit->setCategoryId($category->getId());
               if (!$filename)
               {
                  $tag = appCategoryImageTagPeer::retrieveByCategory($category);
                  if (null !== $tag)
                  {
                     $cit->setTags($tag->getTags());
                  }
               }
               if ($filename)
               {
                  $path = $upload_dir.'/'.$filename;
                  $cit->createImage($path);
               }
            }

            $cit->setPosition($position);
            $cit->save();
         }
      }   
   } 

   protected static function getOrCreate($category)
   {
      $tag = appCategoryImageTagPeer::retrieveByPK($category->getId());  

      if (null === $tag)
      {
         $tag = new appCategoryImageTag();
         $tag->setId($category->getId());
         $tag->setTags(array());
      }

      return $tag;
   }
   
   public static function prepend(sfEvent $event, $components)
   {
      if(stConfig::getInstance('stCategory')->get('enable_image_tag'))
      {
         switch($event['slot'])
         {
            case 'product-list-after-title':
            $components[] = $event->getSubject()->createComponent('appImageTagFrontend', 'showCategoryImageTags');                             
            break;
         }
      }

      return $components;
   }
   
}