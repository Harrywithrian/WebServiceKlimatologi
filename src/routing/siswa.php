<?php

use Slim\Http\Request;
use Slim\Http\Response;

// tampil siswa
$app->get('/api/siswa/tampil', function (Request $request, Response $response, array $args) {

	$db = new db();
	$db = $db->connect();
	$siswa = new siswa($db);

	$siswa->loadData();

});

// tambah siswa
$app->post('/api/siswa/tambah', function (Request $request, Response $response, array $args) {

	$nis		= $request->getParam('nis');
	$nip 		= $request->getParam('nip');
	$nama 		= $request->getParam('nama');
	$j_kelamin 	= $request->getParam('j_kelamin');
	$jurusan 	= $request->getParam('jurusan');
	$angkatan 	= $request->getParam('angkatan');
	$password 	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$siswa = new siswa($db);

	$siswa->setDataTambah($nis, $nip, $nama, $j_kelamin, $jurusan, $angkatan, $password);
	$siswa->tambah();

});

// ubah siswa
$app->put('/api/siswa/ubah', function (Request $request, Response $response, array $args) {

	$nisLama	= $request->getParam('nisLama');
	$nisBaru 	= $request->getParam('nisBaru');
	$nama 		= $request->getParam('nama');
	$j_kelamin 	= $request->getParam('j_kelamin');
	$jurusan 	= $request->getParam('jurusan');
	$angkatan 	= $request->getParam('angkatan');
	$password 	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$siswa = new siswa($db);

	$siswa->setDataUbah($nisLama, $nisBaru, $nama, $j_kelamin, $jurusan, $angkatan, $password);
	$siswa->ubah();

});

// hapus siswa
$app->delete('/api/siswa/hapus/{nis}', function (Request $request, Response $response, array $args) {

	$nis	= filter_var($request->getAttribute('nis'),FILTER_SANITIZE_STRING);

	$db = new db();
	$db = $db->connect();
	$siswa = new siswa($db);

	$siswa->setDataHapus($nis);
	$siswa->hapus();

});

// cari guru
$app->post('/api/siswa/cari', function (Request $request, Response $response, array $args) {

	$dataCari	= $request->getParam('dataCari');

	$db = new db();
	$db = $db->connect();
	$siswa = new siswa($db);

	$siswa->setDataCari($dataCari);
	$siswa->Cari();

});

// ubah password guru
$app->put('/api/siswa/ubahPassword', function (Request $request, Response $response, array $args) {

	$nis 		= $request->getParam('nis');
	$password 	= $request->getParam('password');

	$db = new db();
	$db = $db->connect();
	$siswa = new siswa($db);

	$siswa->setDataUbahPassword($nis, $password);
	$siswa->ubahPassword();

});

?>