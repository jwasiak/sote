function stUser()
{
};

stUser.updateAnonymousForms = function(country_id, update_delivery_country) {
   jQuery(function($) {
      var different_delivery = $('#different_delivery');
      var different_selected = $('#user_data_billing_country > option[value='+country_id+']:selected').length;
      
      if (!different_selected && different_delivery.length && !different_delivery.prop('checked')) {
         different_delivery.get(0).click();
      } 

      if (!different_selected) {
         if (!different_delivery.prop('disabled')) {
            different_delivery
               .prop('disabled', true)
               .after('<input type="hidden" value="1" name="'+different_delivery.attr('name')+'" id="different_delivery_hidden" />'); 
         }
      } else {
         $('#different_delivery_hidden').remove();
         different_delivery.prop('disabled',false);
      }

      if (update_delivery_country == undefined || update_delivery_country == true) {
         $('#user_data_delivery_country > option[value='+country_id+']').prop('selected', true);
      }
   });    
}