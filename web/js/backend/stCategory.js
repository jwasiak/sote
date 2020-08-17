document.observe('dom:loaded', function() {
   if ($('config_hide_root').checked)
   {
      var config_expand_root = $('config_expand_root');

      config_expand_root.options[0].disabled = true;

      if (config_expand_root.selectedIndex == 0)
      {
         config_expand_root.selectedIndex = 1;
      }

      $('config_expand_always').disabled = $('config_tree_type').selectedIndex > 0;
   }
   else
   {
      $('config_expand_always').disabled = $('config_expand_root').selectedIndex == 0;
   }
   

   if ($('config_tree_type').selectedIndex > 0)
   {
      $$('#config_expand_root option').each(function(o) {
         if (o.index > 1)
         {
            o.disabled = true;
         }
      });
   }
   else
   {
      $$('#config_expand_root option').each(function(o) {
         if (o.index > 1)
         {
            o.disabled = false;
         }
      });
   }

   $('config_hide_root').observe('click', function()
   {
      var config_expand_root = $('config_expand_root');

      if (this.checked)
      {
         config_expand_root.options[0].disabled = true;

         if (config_expand_root.selectedIndex == 0)
         {
            config_expand_root.selectedIndex = 1;
         }

         $('config_expand_always').disabled = $('config_tree_type').selectedIndex > 0;
      }
      else
      {
         config_expand_root.options[0].disabled = false;

         $('config_expand_always').disabled = false;
      }
   });

   $('config_tree_type').observe('change', function() {
      var config_expand_root = $('config_expand_root');

      if (this.selectedIndex > 0)
      {
         $$('#config_expand_root option').each(function(o) {
            if (o.index > 1)
            {
               o.disabled = true;
            }
         });

         if (config_expand_root.selectedIndex > 1)
         {
            config_expand_root.selectedIndex = 1;
         }

         $('config_expand_always').disabled = $('config_hide_root').checked || config_expand_root.selectedIndex == 0;
      }
      else
      {
         $$('#config_expand_root option').each(function(o) {
            if (o.index > 1)
            {
               o.disabled = false;
            }
         });

         $('config_expand_always').disabled = config_expand_root.selectedIndex == 0;
      }
   });

   $('config_expand_root').observe('change', function()
   {
      $('config_expand_always').disabled = $('config_expand_root').selectedIndex == 0;
   });
});


