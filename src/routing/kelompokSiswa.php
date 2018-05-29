<?php 

use Slim\Http\Request;
use Slim\Http\Response;

//tampil kelompok siswa
$app->post('/api/kelompok/siswa/tampil', function (Request $request, Response $response, array $args) {

	$nis	= $request->getParam('nis');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setTampilKelompokSiswa($nis);
	$kelompok->tampilKelompokSiswa();

});

//cari kelompok swakarya
$app->post('/api/kelompok/siswa/cariKelompok', function (Request $request, Response $response, array $args) {

	$nama	= $request->getParam('nama');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setCariKelompokSiswa($nama);
	$kelompok->cariKelompokSiswa();

});

//masuk request kelompok swakarya
$app->put('/api/kelompok/siswa/masukReq', function (Request $request, Response $response, array $args) {

	$nis	= $request->getParam('nis');
	$kd_kelompok = $request->getParam('kd_kelompok');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setSiswaReqMasuk($nis, $kd_kelompok);
	$kelompok->SiswaReqMasuk();

});

//batal permintaan req
$app->put('/api/kelompok/siswa/batalReq', function (Request $request, Response $response, array $args) {

	$nis	= $request->getParam('nis');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDataSiswaKelompok($nis);
	$kelompok->tolakAnggota();

});

//batal permintaan req
$app->put('/api/kelompok/detail/siswa/tambahProgress', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');
	$progress 		= $request->getParam('progress');
	$keterangan 	= $request->getParam('keterangan');

	$db = new db();
	$db = $db->connect();
	$kelompok = new kelompok($db);

	$kelompok->setDataTambahProgress($kd_kelompok, $progress, $keterangan);
	$kelompok->tambahProgressKelompok();

});

//kelompok generate iklim
$app->post('/api/kelompok/detail/siswa/generateIklim', function (Request $request, Response $response, array $args) {

	$tahunAwal	= $request->getParam('tahunAwal');
	$tahunAkhir	= $request->getParam('tahunAkhir');
	$bulan		= $request->getParam('bulan');

	$db = new db();
	$db = $db->connect();
	$kelompok = new klimatologi($db);

	$kelompok->setGenerateIklim($tahunAwal, $tahunAkhir, $bulan);
	$kelompok->generateIklimKelompok();

});

//simpan rata-rata iklim
$app->post('/api/kelompok/detail/siswa/simpanIklim', function (Request $request, Response $response, array $args) {

  	$kd_kelompok	= $request->getParam('kd_kelompok');
  	$kd_klasifikasi	= $request->getParam('kd_klasifikasi');
  	$tahunAwal		= $request->getParam('tahunAwal');
  	$tahunAkhir		= $request->getParam('tahunAkhir');
  	$suhu			= $request->getParam('suhu');
  	$kelembaban		= $request->getParam('kelembaban');
  	$curah_hujan	= $request->getParam('curah_hujan');
  	$lpm	  		= $request->getParam('lpm');
	$kd_klimatologi	= json_decode($request->getParam('kd_klimatologi'));

	$lpm = $lpm . ":00";

	$db = new db();
	$db1 = $db->connect();
	$db2 = $db->connect();

	$klasifikasi = new klasifikasi($db1);
	$periode 	 = new periode($db2);

	$klasifikasi->setHitungIklim($kd_klasifikasi, $kd_kelompok, $tahunAwal, $tahunAkhir, $suhu, $kelembaban, $curah_hujan, $lpm);

	$klasifikasi->hitungIklimKelompok();

	foreach ($kd_klimatologi as $item) {
		$periode->setPeriode($item, $kd_klasifikasi);
		$periode->tambahPeriode();
	}

	$klasifikasi->setLoadRataIklim($kd_klasifikasi);
	$klasifikasi->loadKlasifikasi();

});

//kelompok memilih tanaman
$app->put('/api/kelompok/detail/siswa/simpanTanaman', function (Request $request, Response $response, array $args) {

	$kd_kelompok	= $request->getParam('kd_kelompok');
	$kd_tanaman		= $request->getParam('kd_tanaman');

	$db = new db();
	$db = $db->connect();
	$kelompok = new tanaman($db);

	$kelompok->setSimpanTanaman($kd_kelompok, $kd_tanaman);
	$kelompok->simpanTanaman();

});

?>