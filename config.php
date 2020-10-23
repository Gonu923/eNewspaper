<?php 

	require_once 'vendor/autoload.php';

	$google_client = new Google_Client();
	$google_client->setClientId('730052532493-jcarl5e7vl503vvb4d2mkemlcbuv6faa.apps.googleusercontent.com');
	$google_client->setClientSecret('Nlf7WmxTP1PrMasiX_W4HSLP');
	$google_client->setRedirectUri('https://enewspaper923.herokuapp.com');
	$google_client->addScope('email');
	$google_client->addScope('profile');

	session_start();

?>
