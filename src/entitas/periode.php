<?php 

class periode {

	//variable kode
	private $kd_klimatologi;
	private $kd_klasifikasi;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//set tampil periode kelompok
	public function setTampilPeriode($kd_klasifikasi) {
		$this->kd_klasifikasi = $kd_klasifikasi;
	}

	//set tambah periode
	public function setPeriode($item, $kd_klasifikasi) {
		$this->kd_klimatologi  = $item;
		$this->kd_klasifikasi = $kd_klasifikasi;
	}

	//tampil periode kelompok
	public function tampilPeriode() {

		$sql = "SELECT * FROM periode, klimatologi
				where periode.kd_klimatologi = klimatologi.kd_klimatologi AND periode.kd_klasifikasi = :kd_klasifikasi;";

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

	//simpan periode
	public function tambahPeriode() {
		$sql = "INSERT INTO periode
				(kd_klasifikasi, kd_klimatologi)
				VALUES
				(:kd_klasifikasi, :kd_klimatologi);";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_klasifikasi', $this->kd_klasifikasi);
			$stmt->bindParam(':kd_klimatologi', $this->kd_klimatologi);

			$stmt->execute();
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}
}

?>