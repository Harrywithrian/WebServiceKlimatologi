<?php 

use Slim\Http\Request;
use Slim\Http\Response;

//list kelompok
$app->post('/api/kelompok/guru/tampil', function (Request $request, Response $response, array $args) {

	$nip	= $request->getParam('nip');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setTampilKelompokGuru($nip);
	$kelompok->tampilKelompokGuru();

});

//tambah kelompok
$app->post('/api/kelompok/guru/tambah', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');
	$nip			= $request->getParam('nip');
	$keterangan		= $request->getParam('keterangan');

	$db = new db();
	$db = $db->connect();

	$kelompok = new kelompok($db);
	$kode  = (string)$kelompok->validasiCount($nip, $kd_kelompok);

	$kd_kelompok = $kd_kelompok . "-" . $kode;

	$kelompok->setTambahKelompokGuru($kd_kelompok, $nip, $keterangan);
	$kelompok->tambahKelompokGuru();

});

//hapus kelompok
$app->delete('/api/kelompok/guru/hapus/{kd_kelompok}', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= filter_var($request->getAttribute('kd_kelompok'),FILTER_SANITIZE_STRING);

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setHapusKelompokGuru($kd_kelompok);
	$kelompok->hapusKelompokGuru();

});

//list request anggota
$app->post('/api/kelompok/detail/guru/pending', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDetailKelompok($kd_kelompok);
	$kelompok->reqAnggotaKelompok();

});

//acc siswa pending
$app->put('/api/kelompok/detail/guru/konfirmasi', function (Request $request, Response $response, array $args) {

	$nis			= $request->getParam('nis');
	$kd_kelompok	= $request->getParam('kd_kelompok');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDataSiswaKelompok($nis);
	$kelompok->konfirmasiAnggota();
	$kelompok->setDetailKelompok($kd_kelompok);
	$kelompok->AnggotaProgress();

});

//tolak siswa pending
$app->put('/api/kelompok/detail/guru/tolakReq', function (Request $request, Response $response, array $args) {

	$nis	= $request->getParam('nis');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDataSiswaKelompok($nis);
	$kelompok->tolakAnggota();

});

?>