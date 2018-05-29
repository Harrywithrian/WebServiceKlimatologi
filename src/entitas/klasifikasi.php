<?php 

class klasifikasi {

	//variable kelompok
	private $kd_kelompok;

	//variable iklim
	private $kd_klasifikasi;
	private $suhu;
	private $kelembaban;
	private $curah_hujan;
	private $lpm;
	private $evaporasi;
	
	//variable waktu
	private $tahunAwal;
	private $tahunAkhir;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//set tampil klasifikasi
	public function setTampilKlasifikasi($kd_klasifikasi) {
		$this->kd_klasifikasi 	= $kd_klasifikasi;
	}

	//tampil periode kelompok
	public function tampilKlasifikasi() {

		$sql = "SELECT * FROM klasifikasi
				where kd_klasifikasi = :kd_klasifikasi;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_klasifikasi', $this->kd_klasifikasi);

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

	//set hitung rata-rata iklim
	public function setHitungIklim($kd_klasifikasi, $kd_kelompok, $tahunAwal, $tahunAkhir, $suhu, $kelembaban, $curah_hujan, $lpm) {

		$this->kd_kelompok 		= $kd_kelompok;
		$this->kd_klasifikasi 	= $kd_klasifikasi;
		$this->tahunAwal 		= $tahunAwal;
		$this->tahunAkhir 		= $tahunAkhir;
		$this->suhu 			= $suhu;
		$this->kelembaban 		= $kelembaban;
		$this->curah_hujan 		= $curah_hujan;
		$this->lpm  			= $lpm;
	}

	//set load rata-rata iklim
	public function setLoadRataIklim($kd_klasifikasi) {
		$this->$kd_klasifikasi = $kd_klasifikasi;
	}

	//method simpan data iklim
	public function hitungIklimKelompok() {

		$sql = "INSERT INTO klasifikasi
				(kd_klasifikasi,
				 kd_kelompok,
				 thn_awal,
				 thn_akhir,
				 rata_suhu,
				 rata_kelembaban,
				 rata_ch,
				 rata_lpm)
				VALUES
				(:kd_klasifikasi,
				 :kd_kelompok,
				 :tahunAwal,
				 :tahunAkhir,
				 :suhu,
				 :kelembaban,
				 :curah_hujan,
				 :lpm)";
		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_klasifikasi', $this->kd_klasifikasi);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);
			$stmt->bindParam(':tahunAwal', $this->tahunAwal);
			$stmt->bindParam(':tahunAkhir', $this->tahunAkhir);
			$stmt->bindParam(':suhu', $this->suhu);
			$stmt->bindParam(':kelembaban', $this->kelembaban);
			$stmt->bindParam(':curah_hujan', $this->curah_hujan);
			$stmt->bindParam(':lpm', $this->lpm);

			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'berhasil disimpan');
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method load data rata-rata
	public function loadKlasifikasi() {

		$sql = "SELECT * FROM klasifikasi WHERE kd_klasifikasi = :kd_klasifikasi;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_klasifikasi', $this->kd_klasifikasi);

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