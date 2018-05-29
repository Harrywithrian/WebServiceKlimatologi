<?php 

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/api/cariIklim', function (Request $request, Response $response, array $args) {

	$kodeAwal = $request->getParam('kodeAwal');
	$kodeAkhir = $request->getParam('kodeAkhir');

	$db = new db();
	$db = $db->connect();
	$iklim = new klimatologi($db);

	$iklim->setCariIklim($kodeAwal, $kodeAkhir);
	$iklim->CariIklim();

});

?>