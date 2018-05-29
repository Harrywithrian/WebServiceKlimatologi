<?php 

use Slim\Http\Request;
use Slim\Http\Response;

// tampil tanaman
$app->get('/api/tanaman/tampil', function (Request $request, Response $response, array $args) {

	$db = new db();
	$db = $db->connect();
	$tanaman = new tanaman($db);

	$tanaman->loadData();

});

// tambah tanaman
$app->post('/api/tanaman/tambah', function (Request $request, Response $response, array $args) {

	$kd_tanaman 	 = $request->getParam('kd_tanaman');
	$nip		 	 = $request->getParam('nip');
	$nama 	 	 	 = $request->getParam('nama');
	$lama_tanam 	 = $request->getParam('lama_tanam');
	$suhu_min	 	 = $request->getParam('suhu_min');
	$suhu_maks  	 = $request->getParam('suhu_maks');
	$kelembaban_min  = $request->getParam('kelembaban_min');
	$kelembaban_maks = $request->getParam('kelembaban_maks');
	$ch_min			 = $request->getParam('ch_min');
	$ch_maks 		 = $request->getParam('ch_maks');
	$lpm_min 		 = $request->getParam('lpm_min');
	$lpm_maks 		 = $request->getParam('lpm_maks');

	$db = new db();
	$db = $db->connect();
	$tanaman = new tanaman($db);

	$tanaman->setDataTambah($kd_tanaman, $nip, $nama, $lama_tanam, $suhu_min, $suhu_maks, $kelembaban_min, $kelembaban_maks, $ch_min, $ch_maks, $lpm_min, $lpm_maks);
	$tanaman->tambah();

});

// ubah tanaman
$app->put('/api/tanaman/ubah', function (Request $request, Response $response, array $args) {

	$kd_tanaman 	 = $request->getParam('kd_tanaman');
	$kd_tanaman_lama = $request->getParam('kode_lama');
	$nama 	 	 	 = $request->getParam('nama');
	$lama_tanam 	 = $request->getParam('lama_tanam');
	$suhu_min	 	 = $request->getParam('suhu_min');
	$suhu_maks  	 = $request->getParam('suhu_maks');
	$kelembaban_min  = $request->getParam('kelembaban_min');
	$kelembaban_maks = $request->getParam('kelembaban_maks');
	$ch_min			 = $request->getParam('ch_min');
	$ch_maks 		 = $request->getParam('ch_maks');
	$lpm_min 		 = $request->getParam('lpm_min');
	$lpm_maks 		 = $request->getParam('lpm_maks');

	$db = new db();
	$db = $db->connect();
	$tanaman = new tanaman($db);

	$tanaman->setDataUbah($kd_tanaman, $kd_tanaman_lama, $nama, $lama_tanam, $suhu_min, $suhu_maks, $kelembaban_min, $kelembaban_maks, $ch_min, $ch_maks, $lpm_min, $lpm_maks);
	$tanaman->ubah();

});

// hapus tanaman
$app->delete('/api/tanaman/hapus/{kode}', function (Request $request, Response $response, array $args) {

	$kd_tanaman	= filter_var($request->getAttribute('kode'),FILTER_SANITIZE_STRING);

	$db = new db();
	$db = $db->connect();
	$tanaman = new tanaman($db);

	$tanaman->setDataHapus($kd_tanaman);
	$tanaman->hapus();

});

// tambah tanaman
$app->post('/api/tanaman/cari', function (Request $request, Response $response, array $args) {

	$dataCari 	 = $request->getParam('dataCari');

	$db = new db();
	$db = $db->connect();
	$tanaman = new tanaman($db);

	$tanaman->setDataCari($dataCari);
	$tanaman->cari();

});

?>