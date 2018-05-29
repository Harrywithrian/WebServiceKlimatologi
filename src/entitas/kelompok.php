<?php

class kelompok {

	//variable
	private $nip;
	private $nis;
	private $nama;
	private $kd_kelompok;
	private $keterangan;
	private $progress;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//set data list kelompok (guru)
	public function setTampilKelompokGuru($nip) {
		$this->nip 		= $nip;
	}

	//set data kelompok (siswa)
	public function setTampilKelompokSiswa($nis) {
		$this->nis 		= $nis;
	}

	//set data cari kelompok (siswa)
	public function setCariKelompokSiswa($nama) {
		$this->nama 	= $nama;
	}

	//set data request masuk (siswa)
	public function setSiswaReqMasuk($nis, $kd_kelompok) {
		$this->nis 				= $nis;
		$this->kd_kelompok 		= $kd_kelompok;
	}

	//set data tambah kelompok (guru)
	public function setTambahKelompokGuru($kd_kelompok, $nip, $keterangan) {
		$this->kd_kelompok		= $kd_kelompok;
		$this->nip				= $nip;
		$this->keterangan		= $keterangan;
	}

	//set data hapus kelompok (guru)
	public function setHapusKelompokGuru($kd_kelompok) {
		$this->kd_kelompok 		= $kd_kelompok;
	}

	//set data detail kelompok (detail, list anggota kelompok, list pending anggota) (guru, siswa)
	public function setDetailKelompok($kd_kelompok) {
		$this->kd_kelompok 		= $kd_kelompok;
	}

	//set data siswa (konfirmasi/tolak) (guru)
	public function setDataSiswaKelompok($nis) {
		$this->nis 		= $nis;
	}

	//set tambah progress kelompok (siswa)
	public function setDataTambahProgress($kd_kelompok, $progress, $keterangan) {
		$this->kd_kelompok 		= $kd_kelompok;
		$this->progress 		= $progress;
		$this->keterangan 		= $keterangan;
	}

	//method load data list kelompok (guru)
	public function tampilKelompokGuru() {

		$sql = "SELECT * FROM kelompok WHERE nip = :nip ORDER BY kd_kelompok DESC;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nip', $this->nip);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method load data kelompok (siswa)
	public function tampilKelompokSiswa() {

		$sql = "SELECT
					siswa.stat_kelompok AS kondisi,
					kelompok.kd_kelompok,
					guru.nama AS guru
				FROM siswa,kelompok,guru
				WHERE 
					siswa.kd_kelompok = kelompok.kd_kelompok AND
					kelompok.nip = guru.nip AND
					siswa.nis = :nis;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method cari kelompok swakarya (siswa)
	public function cariKelompokSiswa() {

		$sql = "SELECT
					kelompok.kd_kelompok,
					guru.nama,
					SUM( CASE WHEN siswa.stat_kelompok = 'diterima' THEN 1 ELSE 0 END ) AS anggota
				FROM
					kelompok
					LEFT JOIN guru ON kelompok.nip = guru.nip
					LEFT JOIN siswa ON kelompok.kd_kelompok = siswa.kd_kelompok
				WHERE
					kelompok.progress < 30 AND
					guru.nama LIKE '%' :nama '%'
					GROUP BY kelompok.kd_kelompok;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nama', $this->nama);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method request masuk kelompok (siswa)
	public function SiswaReqMasuk() {

		$sql = "UPDATE
					siswa
				SET
					stat_kelompok = 'pending',
					kd_kelompok = :kd_kelompok 
				WHERE 
					nis = :nis";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'siswa berhasil request');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method count data kelompok (tambah kelompok) (guru)
	public function validasiCount($nip, $kd_kelompok) {

		$this->nip 			= $nip;
		$this->kd_kelompok 	= $kd_kelompok;

		$sql = "SELECT COUNT(kd_kelompok) AS count FROM kelompok WHERE nip = :nip AND kd_kelompok LIKE :kd_kelompok '%';";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nip', $this->nip);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$result[0]['count'] = $result[0]['count'] + 1;

			return $result[0]['count'];
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method tambah data kelompok (guru)
	public function tambahKelompokGuru() {

		$sql = "INSERT INTO kelompok
					(kd_kelompok, nip, keterangan)
				VALUES 
					(:kd_kelompok, :nip, :keterangan);";
		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);
			$stmt->bindParam(':nip', $this->nip);
			$stmt->bindParam(':keterangan', $this->keterangan);
			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'kelompok berhasil ditambah');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method hapus data kelompok (guru)
	public function hapusKelompokGuru() {

		$sql = "DELETE FROM kelompok WHERE kd_kelompok = :kd_kelompok";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);
			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'kelompok berhasil dihapus');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method detail kelompok (guru, siswa)
	public function detailKelompok() {

		$sql = "SELECT * FROM kelompok WHERE kd_kelompok = :kd_kelompok;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method list anggota kelompok (guru, siswa)
	public function anggotaKelompok() {

		$sql = "SELECT * FROM siswa WHERE kd_kelompok = :kd_kelompok AND stat_kelompok = 'diterima';";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method list request anggota kelompok (guru)
	public function reqAnggotaKelompok() {

		$sql = "SELECT * FROM siswa WHERE kd_kelompok = :kd_kelompok AND stat_kelompok = 'pending';";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($result);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method konfirmasi anggota kelompok (guru)
	public function konfirmasiAnggota() {

		$sql = "UPDATE siswa SET stat_kelompok = 'diterima' WHERE nis = :nis";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);

			$stmt->execute();
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method progress kelompok (guru)
	public function AnggotaProgress() {
		$sql = "UPDATE kelompok SET
									progress = progress + 4,
									keterangan = CASE WHEN progress = 32 THEN 'Menghitung Iklim' ELSE 'Memilih Siswa' END
								WHERE
									kd_kelompok = :kd_kelompok";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);

			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'siswa berhasil masuk');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method progress kelompok (siswa)
	public function tambahProgressKelompok() {
		$sql = "UPDATE kelompok SET
									progress = :progress,
									keterangan = :keterangan
								WHERE
									kd_kelompok = :kd_kelompok";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':kd_kelompok', $this->kd_kelompok);
			$stmt->bindParam(':progress', $this->progress);
			$stmt->bindParam(':keterangan', $this->keterangan);

			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'progress bertambah');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

	//method tolak/batal anggota kelompok (guru, siswa)
	public function tolakAnggota() {

		$sql = "UPDATE siswa SET stat_kelompok = 'non_aktif' WHERE nis = :nis;";

		try {
			//proses
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':nis', $this->nis);

			$stmt->execute();
			$arrayResponse = array("status" => true, "message" => 'siswa berhasil keluar kelompok');
			echo json_encode($arrayResponse);
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}

}

?>