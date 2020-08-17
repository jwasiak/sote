
function stOrderPriceModifiers() { }

stOrderPriceModifiers.params = {};

function stOrderProductPriceManagment(fields, updateCallback)
{
   function updateTotalAmount()
   {
      stOrderProductPriceManagment.updateTotalAmount(fields);

      if (updateCallback) {
         updateCallback(fields);
      }
   }
   
   jQuery(fields.discount).on('change', function() {
      var input = jQuery(this);

      if (input.next('select').val() == '%') {
         this.value = stPrice.fixNumberFormat(this.value, 1); 
         if (this.value > 99) {
            this.value = 99;
         }  
      } else {
         this.value = stPrice.fixNumberFormat(this.value, 0);
      }

      updateTotalAmount();
   });



   jQuery(fields.quantity).on('change', function() {
      this.value = stPrice.fixNumberFormat(this.value);

      updateTotalAmount();
   });

   jQuery(fields.discount_type).on('change', function() { 
      var select = jQuery(this);

      select.prev('input').change();
      
      updateTotalAmount(); 
   });

   return new stPriceTaxManagment({
      taxValues: stOrderProductPriceManagment.params.taxValues,
      taxField: jQuery(fields.tax).attr('id'),
      onChange: updateTotalAmount,
      priceFields: [{
         price: jQuery(fields.price_netto).attr('id'),
         priceWithTax: jQuery(fields.price_brutto).attr('id')
      }]
   });
}

jQuery(function($) {
   stOrderProductPriceManagment.updateProductForm = function updateProductForm(value, data)
   {
      $('#code').val(data.c);

      $('#name').val(data.n);

      $('#price_netto').val(stPrice.round(data.pn));

      $('#tax option').each(function() {
         if (this.value == data.t) {
            this.selected = true
         }
      });

      $('#price_brutto').val(stPrice.round(data.pb));

   //   $('hidden_data').value = Object.toJSON(data.hd);

      stOrderProductPriceManagment.updateTotalAmount({
         price_brutto: '#price_brutto',
         discount: '#discount',
         quantity: '#quantity',
         total_amount: '#total_amount',
         discount_type: '#discount_type',
         tax: '#tax',
         price_brutto_discount: '#price_brutto_discount'
      });
   }

   stOrderProductPriceManagment.updateTotalAmount = function(fields)
   {
      var tax_index = $(fields.tax).get(0).selectedIndex;

      var tax_value = stOrderProductPriceManagment.params.taxValues[tax_index];

      var discount_type_field = $(fields.discount_type).get(0);

      if (discount_type_field.options[discount_type_field.selectedIndex].value == '%') {
         var price_value = stPrice.applyDiscount($(fields.price_brutto).val(), $(fields.discount).val());
      } else {
         var price_value = $(fields.price_brutto).val() - $(fields.discount).val();

         if (price_value < 0) {
            price_value = 0;
            $(fields.discount).val(Math.round($(fields.price_brutto).val()));
         }
      }

      $(fields.price_brutto_discount).val(price_value);

      $(fields.total_amount).val(stPrice.round(price_value * $(fields.quantity).val()));
   }

   stOrderProductPriceManagment.fnFormatResult = function(value, data, currentValue)
   {
      var pattern = '(' + currentValue.replace($.fn.autocomplete.escapePattern, '\\$1') + ')';

      var name = data.c+': '+data.n;

//      if (data.hd.pm.length)
//      {
//         var option_label = '';
//
//         $.each(data.hd.pm, function()
//         {
//            option_label += ', '+this.label;
//         });
//
//         name += ' ['+option_label.substr(2)+']';
//      }
      
      name = name.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');

      var template = $('#st_order-autocomplete-template');

      template.find('h2').html(name);

      template.find('.price_netto').html(stPrice.round(data.pn));

      template.find('.price_brutto').html(stPrice.round(data.pb));

      template.find('img').attr('src', data.ip);

      return template.html();
   }

   stOrderProductPriceManagment.getPriceModifiersLabel = function(price_modifiers)
   {
      var option_label = '';

      $.each(price_modifiers, function()
      {
         option_label += ', '+this.label;
      });

      return option_label.substr(2);
   }

   stOrderPriceModifiers.show = function(target)
   {
      var hidden_data = target.parents('tr').find('.hidden_data').val().evalJSON(true);

      var url = stOrderPriceModifiers.params.url+'?id='+hidden_data.id+'&ids='+hidden_data.pm.map(function(data) { return data.custom.id }).join('-');

      var container = target.data('container');

      if (container == undefined)
      {
         $.getJSON(url, function(data) {
         
            container = stOrderPriceModifiers.createContainer(data.data);

            container.appendTo(target.parent('div'));

            target.data('container', container);        
         });
      }
      else
      {
         container.show();
      }
   }


   stOrderPriceModifiers.update = function()
   {
      var container = $(this).parent('div');

      var values = container.find('select').serializeArray();

      var hidden_data_field = $(this).parents('tr').find('.hidden_data');

      var hidden_data = hidden_data_field.val().evalJSON(true);

      var ids = $.map(values, function(data) {return data.value});
      
      var url = stOrderPriceModifiers.params.url+'?id='+hidden_data.id+'&ids='+ids.join('-');

      $.getJSON(url, function(data) {

         var parent = container.parent('div');

         container.remove();

         container = stOrderPriceModifiers.createContainer(data.data);

         container.appendTo(parent);

         parent.find('a').data('container', container);
      });
   }

   stOrderPriceModifiers.hide = function(target)
   {
      var container = target.data('container');

      if (container)
      {
         container.hide();
      }
   }

   stOrderPriceModifiers.createContainer = function(data)
   {
      container = $('<div></div>');

      $.each(data, function(index) {
         var current = this;

         container.append($('<p>'+this.field+'</p>'));

         var select = $('<select name="price_modifier['+index+']"></select>');

         $.each(current.data, function(index){

            var option = $('<option value="'+index+'">'+this+'</option>');

            if (current.selected == index)
            {
               option.attr('selected', 'selected');
            }

            select.append(option)
         });

         select.change(stOrderPriceModifiers.update);

         container.append(select);
      });

      return container;
   }
});

stOrderProductPriceManagment.setParams = function(params)
{
   stOrderProductPriceManagment.params = params;
}


