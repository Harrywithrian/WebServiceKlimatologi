<?php 

class tanaman {

	//deklarasi variable
	private $kd_tanaman;
	private $kd_tanaman_lama;
	private $nip;
	private $nama;
	private $lama_tanam;
	private $suhu_min;
	private $kelembaban_min;
	private $kelembaban_maks;
	private $ch_min;
	private $ch_maks;
	private $lpm_min;
	private $lpm_maks;
	private $dataCari;

	//variable kelompok
	private $kd_kelompok;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	public function setDataTambah($kd_tanaman, $nip, $nama, $lama_tanam, $suhu_min, $suhu_maks, $kelembaban_min, $kelembaban_maks, $ch_min, $ch_maks, $lpm_min, $lpm_maks) {

		$this->kd_tanaman 		= $kd_tanaman;
		$this->nip 				= $nip;
		$this->nama 			= $nama;
		$this->lama_tanam 		= $lama_tanam;
		$this->suhu_min 		= $suhu_min;
		$this->suhu_maks 		= $suhu_maks;
		$this->kelembaban_min 	= $kelembaban_min;
		$this->kelembaban_maks	= $kelembaban_maks;
		$this->ch_min 			= $ch_min;
		$this->ch_maks 			= $ch_maks;
		$this->lpm_min 			= $lpm_min;
		$this->lpm_maks 		= $lpm_maks;

	}

	//set data ubah
	public function setDataUbah($kd_tanaman, $kd_tanaman_lama, $nama, $lama_tanam, $suhu_min, $suhu_maks, $kelembaban_min, $kelembaban_maks, $ch_min, $ch_maks, $lpm_min, $lpm_maks) {

		$this->kd_tanaman 		= $kd_tanaman;
		$this->kd_tanaman_lama 	= $kd_tanaman_lama;
		$this->nama 			= $nama;
		$this->lama_tanam 		= $lama_tanam;
		$this->suhu_min 		= $suhu_min;
		$this->suhu_maks 		= $suhu_maks;
		$this->kelembaban_min 	= $kelembaban_min;
		$this->kelembaban_maks	= $kelembaban_maks;
		$this->ch_min 			= $ch_min;
		$this->ch_maks 			= $ch_maks;
		$this->lpm_min 			= $lpm_min;
		$this->lpm_maks 		= $lpm_maks;
	}

	//set data hapus
	public function setDataHapus($kd_tanaman) {
		$this->kd_tanaman 	= $kd_tanaman;
	}

	public function setDataCari($dataCari) {
		$this->dataCari 	= $dataCari;
	}

	//set data simpan tanaman (siswa)
	public function setSimpanTanaman($kd_kelompok, $kd_tanaman) {
		$this->kd_kelompok 		= $kd_kelompok;
		$this->kd_tanaman 		= $kd_tanaman;
	}

	//set tampil tanaman kelompok (siswa, guru)
	public function setTampilTanamanKelompok($kd_kelompok) {
		$this->kd_kelompok 		= $kd_kelompok;
	}

	//method tampil
	public function loadData() {

		$sql = "SELECT * FROM tanaman;";

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

	//method tambah
	public function tambah() {

		$sql = "INSERT INTO tanaman
				 (kd_tanaman, nip, nama, lama_tanam, suhu_min, suhu_maks, kelembaban_min, kelembaban_maks, ch_min, ch_maks, lpm_min, lpm_maks)
				 VALUES 
				 (:kd_tanaman, :nip, :nama, :lama_tanam, :suhu_min, :suhu_maks, :kelembaban_min, :kelembaban_maks, :ch_min, :ch_maks, :lpm_min, :lpm_maks)";

		try {

			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_tanaman', $this->kd_tanaman);
			$stmt->bindParam(':nip', $this->nip);
			$stmt->bindParam(':nama', $this->nama);
			$stmt->bindParam(':lama_tanam', $this->lama_tanam);
			$stmt->bindParam(':suhu_min', $this->suhu_min);
			$stmt->bindParam(':suhu_maks', $this->suhu_maks);
			$stmt->bindParam(':kelembaban_min', $this->kelembaban_min);
			$stmt->bindParam(':kelembaban_maks', $this->kelembaban_maks);
			$stmt->bindParam(':ch_min', $this->ch_min);
			$stmt->bindParam(':ch_maks', $this->ch_maks);
			$stmt->bindParam(':lpm_min', $this->lpm_min);
			$stmt->bindParam(':lpm_maks', $this->lpm_maks);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'tanaman berhasil ditambah');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			if ($e->getCode() == '23000') {
				$arrayResponse = array("validasi" => false);
				echo json_encode($arrayResponse);
			} else {
				echo '{"error": {"text": '.$e->getMessage().'}}';
			}
		}
	}

	//method ubah
	public function ubah() {

		$sql = "UPDATE tanaman
				SET
					kd_tanaman = :kd_tanaman,
					nama = :nama,
					lama_tanam = :lama_tanam,
					suhu_min = :suhu_min,
					suhu_maks = :suhu_maks,
					kelembaban_min = :kelembaban_min,
					kelembaban_maks = :kelembaban_maks,
					ch_min = :ch_min,
					ch_maks = :ch_maks,
					lpm_min = :lpm_min,
					lpm_maks = :lpm_maks
				WHERE 
					kd_tanaman = :kd_tanaman_lama;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_tanaman', $this->kd_tanaman);
			$stmt->bindParam(':kd_tanaman_lama', $this->kd_tanaman_lama);
			$stmt->bindParam(':nama', $this->nama);
			$stmt->bindParam(':lama_tanam', $this->lama_tanam);
			$stmt->bindParam(':suhu_min', $this->suhu_min);
			$stmt->bindParam(':suhu_maks', $this->suhu_maks);
			$stmt->bindParam(':kelembaban_min', $this->kelembaban_min);
			$stmt->bindParam(':kelembaban_maks', $this->kelembaban_maks);
			$stmt->bindParam(':ch_min', $this->ch_min);
			$stmt->bindParam(':ch_maks', $this->ch_maks);
			$stmt->bindParam(':lpm_min', $this->lpm_min);
			$stmt->bindParam(':lpm_maks', $this->lpm_maks);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'tanaman berhasil diubah');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			if ($e->getCode() == '23000') {
				$arrayResponse = array("validasi" => false);
				echo json_encode($arrayResponse);
			} else {
				echo '{"error": {"text": '.$e->getMessage().'}}';
			}
		}
	}

	//method hapus
	public function hapus() {

		$sql = "DELETE FROM tanaman WHERE kd_tanaman = :kd_tanaman;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_tanaman', $this->kd_tanaman);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'tanaman berhasil dihapus');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method cari
	public function cari() {

		$sql = "SELECT * FROM tanaman
				WHERE
					kd_tanaman LIKE '%' :dataCari '%' OR 
					nama LIKE '%' :dataCari '%' OR 
					lama_tanam LIKE '%' :dataCari '%';";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':dataCari', $this->dataCari);

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

	//method tampil tanaman kelompok (siswa)
	public function tampilTanamanKelompok() {

		$sql = "SELECT * from kelompok, tanaman
				WHERE
					kelompok.kd_tanaman = tanaman.kd_tanaman AND 
					kelompok.kd_kelompok = :kd_kelompok;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method simpan tanaman kelompok (siswa)
	public function simpanTanaman() {

		$sql = "UPDATE
					kelompok
				SET
					kd_tanaman = :kd_tanaman 
				WHERE 
					kd_kelompok = :kd_kelompok";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);
			$stmt->bindParam(':kd_tanaman', $this->kd_tanaman);

			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'tanaman berhasil disimpan');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

}

?>