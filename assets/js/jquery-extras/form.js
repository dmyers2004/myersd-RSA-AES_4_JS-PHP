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

protector = {};

protector.login = function(formid,email,password,rsakey) {
	var form = $('#'.formid);
	
	form.mvcFormHidden('secure_password',RSA.encrypt(password, rsakey));
	
	var ts = Math.floor((new Date()).getTime() / 1000); /* UTC timestamp */
	form.mvcFormHidden('secure_timestamp',ts);

	var hmac = sha256(email + password + ts); /* create a hash-based message authentication code */
	form.mvcFormHidden('hmac',hmac);

	/* AES Password so you real password isn't stored */
	var aes_password = sha256(Math.random() + email + password);
	form.mvcFormHidden('secure_session_key',RSA.encrypt(aes_password, rsakey));

	$.cookie('aes_password', aes_password);
}

function makePayload(formid,submit) {
	var payload = $('#'+formid).mvcForm2Obj();
	var password = $.jStorage.get('secure_session_key');
	var payload_aes = Aes.Ctr.encrypt($.toJSON(payload), password, 256);
	
	$('body').append('<form id="payload_form" method="post" action="' + $('#exampleform').attr('action') + '"><input type="hidden" id="payload" name="payload" value=""></form>');
	$('#payload').val(payload_aes);
	if (!submit) {
		$('#payload_form').submit();
	}
}