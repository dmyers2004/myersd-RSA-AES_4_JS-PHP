jQuery(document).ready(function() {
	protector.rsakey = RSA.getPublicKey(rsa_pub);
	protector.aes_password = $.cookie('aes_password');

	$('#login-form').submit(function() {

		var err = protector.login('login-form',$('#email').val(),$('#password').val());
						
		/* allow form submit? */
		return true;
	});

}); /* close ready document */