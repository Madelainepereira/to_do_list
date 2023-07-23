<?php 

namespace Database;

class DatabaseConnection
{
	private	$serverName;
	private	$userName;
	private	$password;
	private	$dataBase;
	private $conn;

	function __construct($serverName, $userName, $password, $dataBase)
	{
		$this->serverName = $serverName;
		$this->userName = $userName;
		$this->password = $password;
		$this->dataBase = $dataBase;
	}

	public function connect()
	{
		try 
		{
			$this->conn = new \PDO("mysql:host=$this->serverName;dbname=$this->dataBase", $this->userName, $this->password);
			// set the PDO error mode to exception
			$this->conn -> setAttribute(\PDO::ATTR_ERRMODE, 
										\PDO::ERRMODE_EXCEPTION);
		} 
		catch(\PDOException $e) 
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}

	public function	getConnection()
	{
		return ($this->conn);
	}
}

	/*$serverName = "localhost";
	$userName = "root";
	$password = "";
	$dbName = "to_do_list";

	$connection = new DatabaseConnection($serverName, $userName, $password, $dbName);
	$connection -> connect();
	$query = "SELECT * FROM to_do";
	$results = $connection -> getConnection() -> prepare($query);
	var_dump($results);*/
?>