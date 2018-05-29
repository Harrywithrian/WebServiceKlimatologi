<?php 

use Slim\Http\Request;
use Slim\Http\Response;

//sensor value detik
$app->put('/api/dataSensorDetik', function (Request $request, Response $response, array $args) {

	//variable
	$kode 		= $request->getParam('kode');
	$suhu 		= $request->getParam('suhu');
	$tekanan 	= $request->getParam('tekanan');
	$kelembaban	= $request->getParam('kelembaban');
	$curahHujan	= $request->getParam('curahhujan');
	$k_air		= $request->getParam('k_air');
	$kecepatan 	= $request->getParam('kecepatan');
	$knot 		= $request->getParam('knot');
	$arahAngin 	= $request->getParam('arahangin');

	$db = new db();
	$db = $db->connect();
	$sensorValue = new klimatologi($db);

	$sensorValue->setDataSensorDetik($kode, $suhu, $tekanan, $kelembaban, $curahHujan, $k_air, $kecepatan, $knot, $arahAngin);
	$sensorValue->sensorValueDetik();

});

//sensor value
$app->post('/api/dataSensor', function (Request $request, Response $response, array $args) {

	//variable
	$kode 		= $request->getParam('kode');
	$jenis 		= $request->getParam('jenis');
	$suhu 		= $request->getParam('suhu');
	$tekanan 	= $request->getParam('tekanan');
	$kelembaban	= $request->getParam('kelembaban');
	$lpm 		= $request->getParam('lpm');
	$ketinggian	= $request->getParam('ketinggian');
	$curahHujan	= $request->getParam('curahhujan');
	$kecepatan 	= $request->getParam('kecepatan');
	$knot 		= $request->getParam('knot');
	$arahAngin 	= $request->getParam('arahangin');

	$db = new db();
	$db = $db->connect();
	$sensorValue = new klimatologi($db);

	$sensorValue->setDataSensor ($kode, $jenis, $suhu, $tekanan, $kelembaban, $lpm, $ketinggian, $curahHujan, $kecepatan, $knot, $arahAngin);
	$sensorValue->sensorValue();

	//cek rata-rata perhari
	if (substr($kode, 8,2) == '17') {
		$sensorValue->CuacaPerHari(substr($kode, 0, 8));
	}

});

//tampil cuaca
$app->get('/api/cuaca', function (Request $request, Response $response, array $args) {

	$db = new db();
	$db = $db->connect();
	$cuaca = new klimatologi($db);

	$cuaca->loadDataCuaca();

});

//tampil cuaca
$app->get('/api/cuaca/detik', function (Request $request, Response $response, array $args) {

	$db = new db();
	$db = $db->connect();
	$cuaca = new klimatologi($db);

	$cuaca->loadDataCuacaDetik();

});

//tampil cuaca
$app->post('/api/cuaca/harian', function (Request $request, Response $response, array $args) {

	//variable
	$kode 	= $request->getParam('kode');

	//proses
	$db = new db();
	$db = $db->connect();
	$cuaca = new klimatologi($db);

	$cuaca->setLoadCuacaJam($kode);
	$cuaca->loadDataCuacaJam();

});

?>