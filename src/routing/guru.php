<?php

use Slim\Http\Request;
use Slim\Http\Response;

// tampil guru
$app->get('/api/guru/tampil', function (Request $request, Response $response, array $args) {

	$db = new db();
	$db = $db->connect();
	$guru = new guru($db);

	$guru->loadData();

});

// tambah guru
$app->post('/api/guru/tambah', function (Request $request, Response $response, array $args) {

	$nip 		= $request->getParam('nip');
	$nama 		= $request->getParam('nama');
	$status 	= $request->getParam('status');
	$password 	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$guru = new guru($db);

	$guru->setDataTambah($nip, $nama, $status, $password);
	$guru->tambah();

});

// ubah guru
$app->put('/api/guru/ubah', function (Request $request, Response $response, array $args) {

	$nipLama	= $request->getParam('nipLama');
	$nipBaru 	= $request->getParam('nipBaru');
	$nama 		= $request->getParam('nama');
	$status 	= $request->getParam('status');
	$password 	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$guru = new guru($db);

	$guru->setDataUbah($nipLama, $nipBaru, $nama, $status, $password);
	$guru->ubah();

});

// hapus guru
$app->delete('/api/guru/hapus/{nip}', function (Request $request, Response $response, array $args) {

	$nip	= filter_var($request->getAttribute('nip'),FILTER_SANITIZE_STRING);

	$db = new db();
	$db = $db->connect();
	$guru = new guru($db);

	$guru->setDataHapus($nip);
	$guru->hapus();

});

// cari guru
$app->post('/api/guru/cari', function (Request $request, Response $response, array $args) {

	$dataCari	= $request->getParam('dataCari');

	$db = new db();
	$db = $db->connect();
	$guru = new guru($db);

	$guru->setDataCari($dataCari);
	$guru->Cari();

});

// ubah password guru
$app->put('/api/guru/ubahPassword', function (Request $request, Response $response, array $args) {

	$nip 		= $request->getParam('nip');
	$password 	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$guru = new guru($db);

	$guru->setDataUbahPassword($nip, $password);
	$guru->ubahPassword();

});

?>