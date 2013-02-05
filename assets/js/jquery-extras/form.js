/* Don Myers 2011 MIT License */

/*
Convert Form to JSON Object
basic
$("#form_id").mvcForm2Obj();
advanced - add additional payload
$("#form_id").mvcForm2Obj({'extra':'abc123'});
*/
jQuery.fn.mvcForm2Obj = function(obj) {
	obj = obj || {};

	/* convert form to json object */
	jQuery.each(jQuery(this).serializeArray(), function () {
		if (obj[this.name]) {
			if (!obj[this.name].push) {
				obj[this.name] = [obj[this.name]];
			}
			obj[this.name].push(this.value || '');
		} else {
			obj[this.name] = this.value || '';
		}
	});

	return obj;
};

/*
basic - add/update hidden
$("#form_id").mvcFormHidden('primary',23);
*/
jQuery.fn.mvcFormHidden = function (name, value) {
	return this.each(function () {
		if (jQuery('#' + name).length > 0) {
			jQuery('#' + name).attr('value', value);
		} else {
			jQuery('<input />').attr('type', 'hidden').attr('id', name).attr('name', name).val(value).appendTo(this);
		}
	});
};

jQuery.fn.protectorSend = function (payloadextra,hiddenextra,send) {
	var form = jQuery(this);

	jQuery('#payload_form').remove();
	jQuery('<form />').attr('id', 'payload_form').attr('method', 'post').attr('action', form.attr('action')).appendTo('body');

	var payload = form.mvcForm2Obj();

	payload.timestamp = Math.floor((new Date()).getTime() / 1000); /* UTC timestamp */

	/* add payload extras */
	if (payloadextra) {
		for (var key in payloadextra) {
			payload[key] = payloadextra[key];
		}
	}
	
	var payload_aes = Aes.Ctr.encrypt($.toJSON(payload), protector.aes_password, 256);
	
	jQuery('#payload_form').mvcFormHidden('payload',payload_aes);
	
	/* add hidden extras */
	if (hiddenextra) {
		for (var key in hiddenextra) {
			jQuery('#payload_form').mvcFormHidden(key,hiddenextra[key]);
		}
	}

	if (!send) {
		jQuery('#payload_form').submit();
	}
}
