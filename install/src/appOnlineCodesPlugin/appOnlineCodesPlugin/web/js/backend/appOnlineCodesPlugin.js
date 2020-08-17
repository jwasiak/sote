function appOnlineCodesProductManagment() {
}

appOnlineCodesProductManagment.updateForm = function updateForm(value, data) {
	stPrice.updateField('online_codes_product_code', data.c);
	stPrice.updateField('online_codes_product_name', data.n);
	stPrice.updateField('online_codes_product_id', data.id);
}

jQuery(function($) {
	appOnlineCodesProductManagment.fnFormatResult = function(value, data, currentValue) {
		var pattern = '(' + currentValue.replace($.fn.autocomplete.escapePattern, '\\$1') + ')';

		var name = data.c + ': ' + data.n;

		name = name.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');

		var template = $('#app_online_codes-autocomplete-template');

		template.find('h2').html(name);

		template.find('.price_netto').html(stPrice.round(data.pn));

		template.find('.price_brutto').html(stPrice.round(data.pb));

		template.find('img').attr('src', data.ip);

		return template.html();
	}
});

function appOnlineFilesProductManagment() {
}

appOnlineFilesProductManagment.updateForm = function updateForm(value, data) {
	stPrice.updateField('online_files_product_code', data.c);
	stPrice.updateField('online_files_product_name', data.n);
	stPrice.updateField('online_files_product_id', data.id);
}

jQuery(function($) {
	appOnlineFilesProductManagment.fnFormatResult = function(value, data, currentValue) {
		var pattern = '(' + currentValue.replace($.fn.autocomplete.escapePattern, '\\$1') + ')';

		var name = data.c + ': ' + data.n;

		name = name.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');

		var template = $('#app_online_codes-autocomplete-template');

		template.find('h2').html(name);

		template.find('.price_netto').html(stPrice.round(data.pn));

		template.find('.price_brutto').html(stPrice.round(data.pb));

		template.find('img').attr('src', data.ip);

		return template.html();
	}
});