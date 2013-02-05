<?php
include('php/header.php');	
include('php/body.php');

echo '<a href="index.php">Index</a>';

$config = array(
	"private_key_bits"=>1024
);

// Create the keypair
$res=openssl_pkey_new($config);
openssl_pkey_export($res, $privkey);

echo '<p>'.$privkey."</p>";
file_put_contents('keys/private.key',$privkey);

echo '<p><br></p>';

// Get public key
$pubkey=openssl_pkey_get_details($res);
$pubkey=$pubkey["key"];

echo '<p>'.$pubkey.'</p>';
file_put_contents('keys/public.key',$pubkey);

include('php/footer.php');