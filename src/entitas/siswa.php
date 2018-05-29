<?php

class siswa {

	private $nis;
	private $nisLama;
	private $nisBaru;
	private $nip;
	private $nama;
	private $j_kelamin;
	private $jurusan;
	private $angkatan;
	private $password;
	private $dataCari;
	private $connect;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//set data tambah
	public function setDataTambah($nis, $nip, $nama, $j_kelamin, $jurusan, $angkatan, $password) {
		$this->nis 		 = $nis;
		$this->nip 		 = $nip;
		$this->nama 	 = $nama;
		$this->j_kelamin = $j_kelamin;
		$this->jurusan 	 = $jurusan;
		$this->angkatan  = $angkatan;
		$this->password  = $password;
	}

	//set data ubah
	public function setDataUbah($nisLama, $nisBaru, $nama, $j_kelamin, $jurusan, $angkatan, $password) {
		$this->nisLama	 = $nisLama;
		$this->nisBaru   = $nisBaru;
		$this->nama 	 = $nama;
		$this->j_kelamin = $j_kelamin;
		$this->jurusan 	 = $jurusan;
		$this->angkatan  = $angkatan;
		$this->password  = $password;
	}

	//set data ubah password
	public function setDataUbahPassword($nis, $password) {
		$this->nis 		= $nis;
		$this->password = $password;
	}

	//set data hapus
	public function setDataHapus($nis) {
		$this->nis 	= $nis;
	}

	//set data cari
	public function setDataCari($dataCari) {
		$this->dataCari 	= $dataCari;
	}

	//method tampil
	public function loadData() {

		$sql = "SELECT * FROM siswa;";

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

		$sql = "INSERT INTO siswa
				 (nis, nip, nama, j_kelamin, jurusan, angkatan, password)
				 VALUES 
				 (:nis, :nip, :nama, :j_kelamin, :jurusan, :angkatan, :password)";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);
			$stmt->bindParam(':nip', $this->nip);
			$stmt->bindParam(':nama', $this->nama);
			$stmt->bindParam(':j_kelamin', $this->j_kelamin);
			$stmt->bindParam(':jurusan', $this->jurusan);
			$stmt->bindParam(':angkatan', $this->angkatan);
			$stmt->bindParam(':password', $this->password);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'siswa berhasil ditambah');
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

		$sql = "UPDATE siswa
				SET
					nis = :nisBaru,
					nama = :nama,
					j_kelamin = :j_kelamin,
					jurusan = :jurusan,
					angkatan = :angkatan,
					password = :password
				WHERE 
					nis = :nisLama;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nisBaru', $this->nisBaru);
			$stmt->bindParam(':nisLama', $this->nisLama);
			$stmt->bindParam(':nama', $this->nama);
			$stmt->bindParam(':j_kelamin', $this->j_kelamin);
			$stmt->bindParam(':jurusan', $this->jurusan);
			$stmt->bindParam(':angkatan', $this->angkatan);
			$stmt->bindParam(':password', $this->password);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'siswa berhasil diubah');
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

		$sql = "UPDATE siswa
				SET
					password = :password
				WHERE 
					nis = :nis;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);
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

		$sql = "DELETE FROM siswa WHERE nis = :nis;";

		try {
			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);

			//eksekusi
			$stmt->execute();

			//output
			$arrayResponse = array("validasi" => true, "message" => 'siswa berhasil dihapus');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method cari
	public function cari() {

		$sql = "SELECT * FROM siswa
				WHERE
					nis LIKE '%' :dataCari '%' OR 
					nama LIKE '%' :dataCari '%' OR 
					jurusan LIKE '%' :dataCari '%' OR
					angkatan LIKE '%' :dataCari '%';";

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