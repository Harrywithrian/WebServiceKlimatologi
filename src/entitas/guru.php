<?php 

class guru {

	//deklarasi variable
	private $nip;
	private $nipLama;
	private $nipBaru;
	private $nama;
	private $status;
	private $password;
	private $connect;
	private $dataCari;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//set data tambah
	public function setDataTambah($nip, $nama, $status, $password) {
		$this->nip 		= $nip;
		$this->nama 	= $nama;
		$this->status 	= $status;
		$this->password = $password;
	}

	//set data ubah
	public function setDataUbah($nipLama, $nipBaru, $nama, $status, $password) {
		$this->nipLama 	= $nipLama;
		$this->nipBaru 	= $nipBaru;
		$this->nama 	= $nama;
		$this->status 	= $status;
		$this->password = $password;
	}

	//set data ubah password
	public function setDataUbahPassword($nip, $password) {
		$this->nip 		= $nip;
		$this->password = $password;
	}

	//set data hapus
	public function setDataHapus($nip) {
		$this->nip 	= $nip;
	}

	//set data cari
	public function setDataCari($dataCari) {
		$this->dataCari 	= $dataCari;
	}

	//method tampil
	public function loadData() {

		$sql = "SELECT * FROM guru;";

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

		$sql = "INSERT INTO guru
				 (nip, nama, status, password)
				 VALUES 
				 (:nip, :nama, :status, :password)";

		try {

			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nip', $this->nip);
			$stmt->bindParam(':nama', $this->nama);
			$stmt->bindParam(':status', $this->status);
			$stmt->bindParam(':password', $this->password);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'guru berhasil ditambah');
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

		$sql = "UPDATE guru
				SET
					nip = :nipBaru,
					nama = :nama,
					status = :status,
					password = :password
				WHERE 
					nip = :nipLama;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nipLama', $this->nipLama);
			$stmt->bindParam(':nipBaru', $this->nipBaru);
			$stmt->bindParam(':nama', $this->nama);
			$stmt->bindParam(':status', $this->status);
			$stmt->bindParam(':password', $this->password);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'guru berhasil diubah');
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

	//ubah password
	public function ubahPassword() {

		$sql = "UPDATE guru
				SET
					password = :password
				WHERE 
					nip = :nip;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nip', $this->nip);
			$stmt->bindParam(':password', $this->password);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'password berhasil diubah');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method hapus
	public function hapus() {

		$sql = "DELETE FROM guru WHERE nip = :nip;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nip', $this->nip);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'guru berhasil dihapus');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method cari
	public function cari() {

		$sql = "SELECT * FROM guru
				WHERE
					nip LIKE '%' :dataCari '%' OR 
					nama LIKE '%' :dataCari '%' OR 
					status LIKE '%' :dataCari '%';";

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
}

?>