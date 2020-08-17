<?php

class stSmartySlotExport
{

   protected $parser = null;
   protected $theme = null;

   public static function export(Theme $theme, $file)
   {
      $parser = new stSmartySlotParser(file_get_contents($file));

      $export = new stSmartySlotExport($parser, $theme);

      $export->execute();
   }

   public function __construct(stSmartySlotParser $parser, Theme $theme)
   {
      $this->parser = $parser;

      $this->theme = $theme;
   }

   public function execute()
   {
      $this->parser->parse(array($this, 'callback'));
   }

   public function callback($slot_params, $components)
   {
      $slot_name = $slot_params['name'];

      $slot = ThemeSlotPeer::doSelectByNameAndThemeId($slot_name, $this->theme->getId());

      if (null === $slot)
      {
         $slot = new ThemeSlot();

         $slot->setName($slot_name);

         $slot->setThemeId($this->theme->getId());

         $slot->save();
      }

      foreach ($components as $component)
      {
         $tc = new ThemeComponent();

         $tc->setName($component['attr']['name']);

         $tc->setType($component['type']);

         $tc->setIsShared(isset($component['attr']['shared']) ? $component['attr']['shared'] : false);

         $tc->setThemeId($this->theme->getId());

         $tshc = new ThemeSlotHasComponent();

         $tshc->setSlotId($slot->getId());

         $tshc->setThemeComponent($tc);

         $tshc->save();
      }
   }

}