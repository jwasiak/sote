<?php

function object_category(appProductAttribute $app_product_attribute, $method, $options = array())
{
   $context = sfContext::getInstance();

   $request = $context->getRequest();

   $defaults = array();

   if ($request->hasErrors()) 
   {      
      $parameters = $request->getParameter($options['control_name']);
      $defaults = stJQueryToolsHelper::parseTokensFromRequest($parameters);
   }
   elseif ($app_product_attribute->isNew())
   {
      $category_filter = sfContext::getInstance()->getUser()->getAttribute('category_filter', 0, 'soteshop/appProductAttribute');

      if ($category_filter)
      {
         $c = new Criteria();

         $c->add(CategoryPeer::ID, $category_filter);

         $defaults = ProductPeer::doSelectCategoriesTokens($c);
      }
   }
   else
   {  

      $defaults = appProductAttributePeer::doSelectCategoriesForTokenInput($app_product_attribute);
   }

   $title = __('Drzewo kategorii');

   $title2 = __('drzewo kategorii');

   $button_label = __('Zastosuj');

   $url = st_url_for('@stCategoryAction?action=ajaxCategoryTree');

   $id = get_id_from_name($options['control_name']);

   $overlay = <<<OVERLAY
   <a id="category_overlay_trigger" href="#" rel="#category_overlay">$title2</a>
   <div id="category_overlay" class="popup_window" style="border: 1px solid #dddddd;">
      <div class="close" style="position: absolute; right: -20px; text-align: right; top: -20px; width: 100%;"><img src="/images/frontend/theme/default2/buttons/close.png" alt="" /></div>
      <h2 style="border-bottom: medium none; color: #000; font-size: 16px; font-weight: normal; margin-top: 45px; padding: 0 25px 0 10px; text-align: center;">$title</h2>
      <div class="content preloader_160x24" style="width: 500px; max-height: 400px; min-height: 100px; overflow: auto; margin-bottom: -1px; padding: 28px 20px;">
      </div>
      <div style="background: #fff; padding: 10px; text-align: right">
         <button class="submit" type="button" style="background: none repeat scroll 0 0 #ddd; font-size: 14px; padding: 5px 20px; white-space: nowrap;">$button_label</button>
      </div>
   </div>
   <script type="text/javascript">
      jQuery(function($) {
         $('#category_overlay .submit').click(function() {

            var api = $('#category_overlay_trigger').data('overlay');

            var content = api.getOverlay().children('.content');

            var jstree = $('#jstree');

            content.addClass('preloader_160x24');

            var checked_inputs = jstree.find('input:checkbox:checked');

            jstree.css({ 'visibility': 'hidden' });

            var tokeninput = $('#$id');

            if (checked_inputs.length > 0) {
                  tokeninput.tokenInput("clear");
                  
                  var instance = $.jstree._reference(jstree);

                  $.each(checked_inputs, function() {
                  	if (!this.disabled) {
	                     var path = instance.get_path($('#jstree-'+this.value));

	                     tokeninput.tokenInput("add", { id: this.value, 'name': path.join(' / ') });
                  	}
                  });

                  api.close();
            } else {
               tokeninput.tokenInput("clear");
               api.close();
            }       
        
         });

         $('#category_overlay_trigger').overlay({
            speed: 'fast',
            close: $('#category_overlay > .close img'),
            load: false,
            mask: {
               color: '#444',
               loadSpeed: 'fast',
               opacity: 0.5,
            },
            closeOnClick: false,
            closeOnEsc: false,
            onBeforeLoad: function() {
               var api = this;
               var value = $('#$id').val();
               var assigned = [];

               if (value) {               
                  var tokens = $.parseJSON(value);

                  $.each(tokens, function() {
                     assigned.push(this.id);
                  });
               }
               
               $.get('$url', { 'assigned': assigned.join(), 'show_default': 0, 'allow_assign_root': true }, function(html) {
                  var content = api.getOverlay().children('.content');
                  content.removeClass('preloader_160x24');                  
                  content.html(html);
                  var jstree = $('#jstree');
                  jstree.click(function(event) {
         				var target = $(event.target).filter('input:checkbox'); 

         				if (target.length) {
         					var checked = event.target.checked;
         					$('#jstree-'+target.val()).find('.assigned').each(function(index) {
         						if (index > 0) {
	         						this.checked = checked;
	         						this.disabled = checked;
         						}
         					});
         				
         				}
         			});

					   jstree.bind("load_node.jstree", function (event, data) {

						   if (data.rslt.obj != -1) {
						   	var input = data.rslt.obj.children('.assigned');

						   	var checked = input.attr('checked');

						   	if (checked) {
							   	data.rslt.obj.find('.assigned').each(function(index) {
							   		if (index > 0) {
							   			this.checked = true;
							   			this.disabled = true;
							   		}
							   	});
								}
                                          }
                                          else
                                          {
                                                var checked = jstree.find('li:has(>input:checked)');

                                              

                                                checked.find('ul .assigned').prop('checked', true).prop('disabled', true);
                                          }
						});
               });
            }
         });
      });
   </script>
OVERLAY;

   return st_tokenizer_input_tag($options['control_name'], st_url_for('@appProductAttributesPlugin?action=ajaxCategoryToken'), $defaults, array(
      'tokenizer' => array(
         'preventDuplicates' => true, 
         'hintText' => __('Wpisz nazwę szukanej kategorii'),
      )
   )).$overlay;
}

function app_product_attribute_variant_tokenizer(appProductAttribute $attribute, Product $product)
{
	static $fc = null;

	if (null === $fc) 
	{
		$fc = new stFunctionCache('appProductAttributeVariant');
	}	

   $id = $attribute->getId();

   $type = $attribute->getType();

   $dc = new Criteria();

   $dc->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

   $dc->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeVariantHasProductPeer::VARIANT_ID);

   $dc->add(appProductAttributeVariantHasProductPeer::PRODUCT_ID, $product->getId());

   $dc->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $attribute->getId());

   $vc = new Criteria();

   $vc->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

   $vc->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $id);   

   if ($type == 'B')
   {
      $checked = appProductAttributeVariantPeer::doCount($dc);

      $vc->addSelectColumn(appProductAttributeVariantPeer::ID);

      $variant_id = appProductAttributeVariantPeer::doSelectSingleScalar($vc);

      return checkbox_tag('app_product_attribute_variant['.$id.']', $variant_id, $checked, array('id' => 'token-input-app_product_attribute_variant_'.$id));
   }
   elseif ($type == 'T' || $type == 'C' || $type == 'S')
   {
      $defaults = appProductAttributeVariantPeer::doSelectTokens($dc, $type); 

      $variants = $fc->cacheCall(array('appProductAttributeVariantPeer', 'doSelectTokens'), array($vc, $type));

      $tokenizer = array(
         'createNew' => $type != 'C',
         'preventDuplicates' => true, 
         'hintText' => __('Wpisz nazwę szukanego wariantu'),
         'tokenLimit' => 20,
         'animateDropdown' => false,
         'propertyToSearch' => $type == 'C' ? 'name' : 'value'
      );

      if ($type == 'C')
      {
         $tokenizer['resultsFormatter'] = _variant_tokens_results_formatter();
         $tokenizer['tokenFormatter'] = _variant_tokens_token_formatter();
      }
      elseif ($type == 'S')
      {
         $tokenizer['onBeforeAdd'] = _variant_tokens_on_add();
      }

      
      return st_tokenizer_input_tag(
         'app_product_attribute_variant['.$id.']', 
         $variants, 
         $defaults, 
         array('tokenizer' => $tokenizer) 
      ); 
   }  
}

function _variant_tokens_results_formatter()
{
   return "function (item, token_input, query) { 
      if (item['type'] == 'C') {
         var style = 'background-color: #'+item['value'];
      } else {
         var style = 'background-image: url(/'+item['value']+')';
      }
      return '<li class=\"app_variant_token\"><div class=\"background\"><div style=\"'+style+'\"></div></div><span class=\"name\">'+item['name']+'</span></li>';
   }"; 
}

function _variant_tokens_token_formatter()
{
   return "function (item, token_input, query) { 
      if (item['type'] == 'C') {
         var style = 'background-color: #'+item['value'];
      } else {
         var style = 'background-image: url(/'+item['value']+')';
      }
      return '<li class=\"app_variant_token\"><div class=\"background\"><div style=\"'+style+'\"></div></div><span class=\"name\">'+item['name']+'</span></li>';
   }"; 
}

function _variant_tokens_on_add()
{
   return "function(item) {
      
      $(this).data('tokenInputObject').clear();

   }";
}