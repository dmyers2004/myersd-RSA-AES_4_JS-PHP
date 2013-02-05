protector = {};
	
jQuery(document).ready(function() {

	protector.rsakey = RSA.getPublicKey(rsa_pub);
	protector.aes_password = $.jStorage.get('aes_password');

	/* for login example */
	$('#login-submit').click(function() {
		protector.aes_password = sha256(Math.ceil(Math.random()*9999) + password + Math.floor((new Date()).getTime() / 1000));
		$.jStorage.set('aes_password', protector.aes_password);

		var password_aes = RSA.encrypt(protector.aes_password, protector.rsakey);

		$('#login-form').protectorSend({},{aes_password: password_aes});
	});

	/* for form example */
	$('#form-submit').click(function() {
		$('#example-form').protectorSend();
	});

}); /* close ready document */
