<?php 

class db{
	//local
	private $dbhost = 'localhost';
	private $dbuser = 'root';
	private $dbpass = '';
	private $dbname = 'klimatologi';

	//online
	// private $dbhost = 'mysql.hostinger.co.id';
	// private $dbuser = 'u398245243_klima';
	// private $dbpass = '94648664';
	// private $dbname = 'u398245243_klima';

	//connect
	public function connect(){
		$mysql_connect_str = "mysql:host=$this->dbhost;
							  	    dbname=$this->dbname;";
		$dbConnection = new PDO($mysql_connect_str,
								$this->dbuser,
								$this->dbpass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $dbConnection;
	}
}

?>