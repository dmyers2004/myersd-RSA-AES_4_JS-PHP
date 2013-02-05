<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?=$sitename ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link href="<?=$base_url ?>/assets/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link href="<?=$base_url ?>/assets/css/grid.min.css" rel="stylesheet">
		<link href="<?=$base_url ?>/assets/css/site.css" rel="stylesheet">

		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="<?=$base_url ?>/assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=$base_url ?>/assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=$base_url ?>/assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=$base_url ?>/assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?=$base_url ?>/assets/ico/apple-touch-icon-57-precomposed.png">

		<script>
		var base_url = '<?=$base_url ?>';
		var rsa_pub = '<?=$rsapub ?>';
		</script>
		<script src="<?=$base_url ?>/assets/js/jquery/jquery.1.8.2.js"></script>
		<script src="<?=$base_url ?>/assets/js/bootstrap/bootstrap.js"></script>

		<script src="<?=$base_url ?>/assets/js/security-package/aes.js"></script>
		<script src="<?=$base_url ?>/assets/js/security-package/jsbn.js"></script>
		<script src="<?=$base_url ?>/assets/js/security-package/misc.js"></script>
		<script src="<?=$base_url ?>/assets/js/security-package/rsa.js"></script>
		<script src="<?=$base_url ?>/assets/js/security-package/sha256.js"></script>

		<script src="<?=$base_url ?>/assets/js/jquery-extras/form.js"></script>
		<script src="<?=$base_url ?>/assets/js/jquery-extras/jquery.json-2.3.js"></script>
		<script src="<?=$base_url ?>/assets/js/jquery-extras/jstorage.js"></script>

		<script src="<?=$base_url ?>/assets/js/site.js"></script>
		<?=$js ?>
	</head>
	<body>
		<div class="container <?php if ($_SERVER['MODE'] == 'DEBUG') { ?>showgrid<?php } ?>">
		<?=$body ?>
		</div>
	</body>
</html>