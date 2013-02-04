jQuery(document).ready(function() {
	var rsakey = RSA.getPublicKey(rsa_pub);

	$('#login-form').submit(function() {

		var err = protector.login('login-form',$('#email').val(),$('#password').val(),rsakey);
						
		/* allow form submit? */
		return true;
	});

}); /* close ready document */