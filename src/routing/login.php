<?php 

use Slim\Http\Request;
use Slim\Http\Response;

// login
$app->post('/api/login', function (Request $request, Response $response, array $args) {

	//variable
	$no_induk 	= $request->getParam('no_induk');
	$password	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$login = new login($db);

	$login->setDataLogin($no_induk, $password);
	$login->login();

});

?>