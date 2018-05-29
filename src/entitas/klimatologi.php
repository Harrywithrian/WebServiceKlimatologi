<?php 

class klimatologi {

	//variable cuaca
	private $kode;
	private $jenis;
	private $suhu;
	private $tekanan;
	private $kelembaban;
	private $lpm;
	private $ketinggian;
	private $curahHujan;
	private $kecepatan;
	private $knot;
	private $arahAngin;

	//variable iklim
	private $kodeAwal;
	private $kodeAkhir;

	//variable iklim kelompok
	private $tahunAwal;
	private $tahunAkhir;
	private $bulan;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//tampil per jam
	public function setLoadCuacaJam($kode) {
		$this->kode 		= $kode;
	}

	//set data sensor detik
	public function setDataSensorDetik($kode, $suhu, $tekanan, $kelembaban, $curahHujan, $k_air, $kecepatan, $knot, $arahAngin) {
		$this->kode 		= $kode;
		$this->suhu 		= $suhu;
		$this->tekanan 		= $tekanan;
		$this->kelembaban 	= $kelembaban;
		$this->curahHujan 	= $curahHujan;
		$this->k_air 		= $k_air;
		$this->kecepatan 	= $kecepatan;
		$this->knot		 	= $knot;
		$this->arahAngin 	= $arahAngin;
	}

	//set data sensor value
	public function setDataSensor ($kode, $jenis, $suhu, $tekanan, $kelembaban, $lpm, $ketinggian, $curahHujan, $kecepatan, $knot, $arahAngin) {
		$this->kode 		= $kode;
		$this->jenis 		= $jenis;
		$this->suhu 		= $suhu;
		$this->tekanan 		= $tekanan;
		$this->kelembaban 	= $kelembaban;
		$this->lpm 			= $lpm;
		$this->ketinggian 	= $ketinggian;
		$this->curahHujan 	= $curahHujan;
		$this->kecepatan 	= $kecepatan;
		$this->knot		 	= $knot;
		$this->arahAngin 	= $arahAngin;
	}

	//set data cari iklim
	public function setCariIklim ($kodeAwal, $kodeAkhir) {
		$this->kodeAwal 	= $kodeAwal;
		$this->kodeAkhir	= $kodeAkhir;
	}

	// set generate iklim (kelompok)
	public function setGenerateIklim($tahunAwal, $tahunAkhir, $bulan) {
		$this->tahunAwal  = $tahunAwal;
		$this->tahunAkhir = $tahunAkhir;
		$this->bulan 	  = $bulan;
	}

	//method sensor value detik
	public function sensorValueDetik() {

		$sql = "UPDATE klimatologi
				SET
					kd_klimatologi = :kode,
					suhu = :suhu,
					tekanan = :tekanan,
					kelembaban = :kelembaban,
					curah_hujan = :ch,
					k_air = :k_air,
					k_angin = :k_angin,
					knot = :knot,
					arah_angin = :arahAngin
				WHERE 
					status = 'detik';";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kode',$this->kode);
			$stmt->bindParam(':suhu',$this->suhu);
			$stmt->bindParam(':tekanan',$this->tekanan);
			$stmt->bindParam(':kelembaban',$this->kelembaban);
			$stmt->bindParam(':ch',$this->curahHujan);
			$stmt->bindParam(':k_air',$this->k_air);
			$stmt->bindParam(':k_angin',$this->kecepatan);
			$stmt->bindParam(':knot',$this->knot);
			$stmt->bindParam(':arahAngin',$this->arahAngin);

			//eksekusi
			$stmt->execute();
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method sensor value
	public function sensorValue() {

		$sql = "INSERT INTO klimatologi
				 (kd_klimatologi, status, suhu, tekanan, kelembaban, lpm, curah_hujan, k_air, k_angin, knot, arah_angin)
				 VALUES 
				 (:kode, :status, :suhu, :tekanan, :kelembaban, :lpm, :ch, :k_air, :k_angin, :knot, :arahAngin)";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kode',$this->kode);
			$stmt->bindParam(':status',$this->jenis);
			$stmt->bindParam(':suhu',$this->suhu);
			$stmt->bindParam(':tekanan',$this->tekanan);
			$stmt->bindParam(':kelembaban',$this->kelembaban);
			$stmt->bindParam(':lpm',$this->lpm);
			$stmt->bindParam(':ch',$this->curahHujan);
			$stmt->bindParam(':k_air',$this->ketinggian);
			$stmt->bindParam(':k_angin',$this->kecepatan);
			$stmt->bindParam(':knot',$this->knot);
			$stmt->bindParam(':arahAngin',$this->arahAngin);

			//eksekusi
			$stmt->execute();
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//proses rata-rata
	public function CuacaPerHari($kodeTgl) {

		$sql = "SELECT * FROM klimatologi WHERE
					(SUBSTR(kd_klimatologi,9,2) = '07' OR
					 SUBSTR(kd_klimatologi,9,2) = '13' OR
					 SUBSTR(kd_klimatologi,9,2) = '17') AND
					 SUBSTR(kd_klimatologi,1,8) = :kodeTgl;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kodeTgl',$kodeTgl);

			//eksekusi
			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($result);

			if (count($result) == 3) {

				//variable
				$suhu = 0;
				$kelembaban = 0;
				$tekanan = 0;
				$k_angin = 0;
				$knot = 0;
				$evaporasi = 0;
				$curah_hujan = 0;
				$arah_angin;
				$lpm;

				foreach ($result as $item) {
					$suhu 		= $suhu + floatval($item['suhu']);
					$kelembaban = $kelembaban + floatval($item['kelembaban']);
					$tekanan	= $tekanan + floatval($item['tekanan']);
					$k_angin 	= $k_angin + floatval($item['k_angin']);
					$knot	    = $knot + floatval($item['knot']);
				}

				$evaporasi		= abs($result[0]['k_air'] - $result[2]['k_air']);
				$curah_hujan	= $result[2]['curah_hujan'];
				$lpm 			= $result[2]['lpm'];
				$arah_angin		= $result[2]['arah_angin'];
				$suhu 			= number_format($suhu / 3, 1);
				$kelembaban 	= number_format($kelembaban / 3, 1);
				$tekanan 		= number_format($tekanan / 3, 1);
				$k_angin 		= number_format($k_angin / 3, 1);
				$knot 			= intval($knot / 3);

				$this->rataHari($kodeTgl, $suhu, $kelembaban, $tekanan, $curah_hujan, $evaporasi, $lpm, $arah_angin, $k_angin, $knot);
			}
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method simpan rata-rata hari
	public function rataHari($kodeTgl, $suhu, $kelembaban, $tekanan, $curah_hujan, $evaporasi, $lpm, $arah_angin, $k_angin, $knot) {

		$sql = "INSERT INTO klimatologi
				 (kd_klimatologi, status, suhu, tekanan, curah_hujan, lpm, arah_angin, evaporasi, kelembaban, k_angin, knot)
				 VALUES 
				 (:kode, 'hari', :suhu, :tekanan, :curah_hujan, :lpm, :arah_angin, :evaporasi, :kelembaban, :k_angin, :knot)";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kode',$kodeTgl);
			$stmt->bindParam(':suhu',$suhu);
			$stmt->bindParam(':tekanan',$tekanan);
			$stmt->bindParam(':curah_hujan',$curah_hujan);
			$stmt->bindParam(':evaporasi',$evaporasi);
			$stmt->bindParam(':lpm',$lpm);
			$stmt->bindParam(':arah_angin',$arah_angin);
			$stmt->bindParam(':kelembaban',$kelembaban);
			$stmt->bindParam(':k_angin',$k_angin);
			$stmt->bindParam(':knot',$knot);

			//eksekusi
			$stmt->execute();
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method tampil cuaca
	public function loadDataCuaca() {

		$sql = "SELECT * FROM klimatologi
				WHERE
					kd_klimatologi = (SELECT MAX(kd_klimatologi) FROM klimatologi WHERE status = 'menit');";

		try {
			//input
			$stmt = $this->connect->prepare($sql);

			//eksekusi
			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method tampil cuaca perdetik
	public function loadDataCuacaDetik() {

		$sql = "SELECT * FROM klimatologi
				WHERE
					status = 'detik';";

		try {
			//input
			$stmt = $this->connect->prepare($sql);

			//eksekusi
			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method tampil cuaca per jam
	public function loadDataCuacaJam() {

		$sql = "SELECT * FROM klimatologi WHERE
					(SUBSTR(kd_klimatologi,9,2) = '07' OR
					 SUBSTR(kd_klimatologi,9,2) = '13' OR
					 SUBSTR(kd_klimatologi,9,2) = '17') OR
					 status = 'hari' AND
					 SUBSTR(kd_klimatologi,1,8) = :kode;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kode',$this->kode);

			//eksekusi
			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method cari iklim
	public function cariIklim() {

		$sql = "SELECT * FROM klimatologi
				where kd_klimatologi >= :kodeAwal and kd_klimatologi <= :kodeAkhir and status = 'bulan';";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kodeAwal',$this->kodeAwal);
			$stmt->bindParam(':kodeAkhir',$this->kodeAkhir);

			//eksekusi
			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		
		} catch (PDOException $e) {
			echo '{
				{"error": {"text": '.$e->getMessage().'}
			}';
		}
	}

	//method generate iklim (kelompok)
	public function generateIklimKelompok() {

		$sql = "SELECT * FROM klimatologi
				WHERE SUBSTRING(kd_klimatologi,5) = :bulan AND kd_klimatologi BETWEEN :tahunAwal AND :tahunAkhir;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':tahunAwal', $this->tahunAwal);
			$stmt->bindParam(':tahunAkhir', $this->tahunAkhir);
			$stmt->bindParam(':bulan', $this->bulan);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}
}

?>