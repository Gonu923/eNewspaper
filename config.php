<?php 

	require_once 'vendor/autoload.php';

	$google_client = new Google_Client();
	$google_client->setClientId('730052532493-jcarl5e7vl503vvb4d2mkemlcbuv6faa.apps.googleusercontent.com');
	$google_client->setClientSecret('fpQaY8K4qDWPW-2s-VCinBr1');
	$google_client->setRedirectUri('http://localhost/newspaper/index.php');
	$google_client->addScope('email');
	$google_client->addScope('profile');

	session_start();

?>