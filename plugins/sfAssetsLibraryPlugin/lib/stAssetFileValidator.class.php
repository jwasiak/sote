<?php

class stAssetFileValidator extends sfFileValidator
{

   public function execute(&$value, &$error)
   {
      if (isset($value['tmp_name']) && !$value['tmp_name'] && $value['error'] == UPLOAD_ERR_NO_FILE)
      {
         if ($this->getParameter('required'))
         {
            $error = $this->getParameter('required_error');

            return false;
         }
         else
         {
            return true;
         }
      }

      if (!ini_get('file_uploads'))
      {
         $error = $this->getParameter('file_uploads_disabled_error');

         return false;
      }

      if (!is_array($value) || !isset($value['tmp_name']) || $value['error'] == UPLOAD_ERR_INI_SIZE)
      {
         $error = $this->getParameter('max_size_error');

         return false;
      }

      if (!parent::execute($value, $error))
      {
         return false;
      }

      if ($this->getParameter('predefined') == '@web_images')
      {
         $info = getimagesize($value['tmp_name']);

         if (!$info)
         {
            $error = $this->getParameter('mime_types_error');

            return false;
         }

         list($width, $height, $type) = $info;

         $mime_type = image_type_to_mime_type($type);

         $mime_types = array_flip($this->getParameter('mime_types', array()));

         if (!isset($mime_types[$mime_type]))
         {
            $error = $this->getParameter('mime_types_error');

            return false;
         }

         list($cwidth, $cheight) = $this->getParameter('max_image_size', array(2048, 2048));

         if ($width > $cwidth || $height > $cheight)
         {
            $error = $this->getParameter('max_image_size_error');

            return false;
         }
      }

      return true;
   }

   public function initialize($context, $parameters = null)
   {
      parent::initialize($context, $parameters);

      $i18n = sfContext::getInstance()->getI18N();

      if (!is_array($parameters['mime_types']))
      {
         $this->setParameter('predefined', $parameters['mime_types']);

         if ($parameters['mime_types'] == '@web_images')
         {
            $this->setParameter('mime_types_error', $i18n->__('Zdjęcie musi być formatu jpeg, gif lub png', null, 'stAssetImageConfiguration'));
         }
      }

      if (!$this->getParameter('required_error'))
      {
         $this->setParameter('required_error', $i18n->__('Musisz załączyć plik', null, 'stAssetImageConfiguration'));
      }

      if (!$this->getParameter('max_image_size_error'))
      {
         $this->setParameter('max_image_size_error', $i18n->__('Rozmiar zdjęcia nie może przekraczać 1280x1280 pikseli', null, 'stAssetImageConfiguration'));
      }

      if (!$this->getParameter('file_uploads_disabled_error'))
      {
         $this->setParameter('file_uploads_disabled_error', $i18n->__('Brak obsługi kopiowania plików na serwer. Skontaktuj sie z administratorem serwera, aby uaktywnił opcję "file_uploads" w konfiguracji php', null, 'stAssetImageConfiguration'));
      }

      $max_size = max(array($this->strToBytes('2M'), $this->strToBytes(ini_get('upload_max_filesize'))));

      if ($max_size)
      {
         $this->setParameter('max_size', $max_size);

         if ($max_size < 1024 * 1024)
         {
            $max_value = number_format($max_size / 1024, 1).' KB';
         }
         else
         {
            $max_value = number_format($max_size / (1024 * 1024), 1).' MB';
         }
      }
 
      $this->setParameter('max_size_error', sprintf($i18n->__('Rozmiar pliku nie może przekraczać %s.', null, 'stAssetImageConfiguration'), $max_value));

      return true;
   }

   protected function strToBytes($size_str)
   {
      switch (substr($size_str, -1))
      {
         case 'M': case 'm': return (int) $size_str * 1048576;
         case 'K': case 'k': return (int) $size_str * 1024;
         case 'G': case 'g': return (int) $size_str * 1073741824;
         default: return $size_str;
      }
   }

}
