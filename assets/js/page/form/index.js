jQuery(document).ready(function() {
	protector.aes_password = $.cookie('aes_password');

	$('#example-form').submit(function() {
 		var err = protector.submit('example-form');
						
		/* allow form submit? */
		return false;
	});

}); /* close ready document */