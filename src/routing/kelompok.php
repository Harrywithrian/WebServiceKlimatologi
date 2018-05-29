<?php 

use Slim\Http\Request;
use Slim\Http\Response;

//detail kelompok (guru, siswa)
$app->post('/api/kelompok/detail', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDetailKelompok($kd_kelompok);
	$kelompok->detailKelompok();

});

//list anggota kelompok (guru, siswa)
$app->post('/api/kelompok/detail/both/anggota', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDetailKelompok($kd_kelompok);
	$kelompok->anggotaKelompok();

});

//tampil periode
$app->post('/api/kelompok/detail/both/tampilPeriode', function (Request $request, Response $response, array $args) {

	$kd_klasifikasi	= $request->getParam('kd_klasifikasi');

	$db = new db();
	$db = $db->connect();
	$kelompok = new periode($db);

	$kelompok->setTampilPeriode($kd_klasifikasi);
	$kelompok->tampilPeriode();

});

//tampil periode
$app->post('/api/kelompok/detail/both/tampilKlasifikasi', function (Request $request, Response $response, array $args) {

	$kd_klasifikasi	= $request->getParam('kd_klasifikasi');

	$db = new db();
	$db = $db->connect();
	$kelompok = new klasifikasi($db);

	$kelompok->setTampilKlasifikasi($kd_klasifikasi);
	$kelompok->tampilKlasifikasi();

});

//tampil tanaman
$app->post('/api/kelompok/detail/both/tampilTanaman', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');

	$db = new db();
	$db = $db->connect();
	$kelompok = new tanaman($db);

	$kelompok->setTampilTanamanKelompok($kd_kelompok);
	$kelompok->tampilTanamanKelompok();

});

?>