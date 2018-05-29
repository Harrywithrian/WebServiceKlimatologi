<?php 

class login {

	//variable
	private $no_induk;
	private $password;

	//koneksi db
	public function __construct($connect) {
		$this->connect = $connect;
	}

	//set data login
	public function setDataLogin($no_induk, $password) {
		$this->no_induk = $no_induk;
		$this->password	= $password;
	}

	//method login
	public function login() {

		$sql = "SELECT * FROM login WHERE no_induk = :no_induk AND password = :password";

		try {

			//input
			$stmt = $this->connect->prepare($sql);
			$stmt->bindParam(':no_induk', $this->no_induk);
			$stmt->bindParam(':password', $this->password);

			//eksekusi
			$stmt->execute();

			//output
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);

			if (count($result) >=1 ) {
				$arrayResponse = array("validasi" => true, "message" => $result);
				echo json_encode($arrayResponse);
			} else {
				$arrayResponse = array("validasi" => false);
				echo json_encode($arrayResponse);
			}
		}
		catch (PDOException $e) {
			echo '{"error": {"text": '.$e->getMessage().'}}';
		}
	}
}

?>