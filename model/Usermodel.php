<?php 
class Usermodel{
	public static $instance = null;
	private $pool;
	private PDO $conn;
	private $databaseDriver;

	// public static function UserModelInstance(PDO $connection){
    // 	if(self::$instance==null){
    // 		self::$instance = new Usermodel($connection);
    // 	}
    // 	return self::$instance;
    // }

	public function __construct($driver){
		$this->databaseDriver = $driver;
	}

	public function insertCabang($data){
		$conn = $this->databaseDriver->getPool()->pop();
		if ($conn==null) {
			$this->conn = $this->databaseDriver->getPool()->pop();
		}
		try {
			$query = "INSERT INTO cabang (id_cabang,id_perusahaan) 
			VALUES (:id, :cabang)";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':id', $data['id'], PDO::PARAM_STR);
			$stmt->bindParam(':cabang', $data['cabang'], PDO::PARAM_STR);

			if (!$stmt->execute()) {
	            throw new RuntimeException('Failed to create user');
	        }	
	        return true;
		} catch (Exception $e) {
			echo $e;
			return false;
		}		

	}

	public function insertUser($data){

		try {
			$query = "INSERT INTO users (username,password,nama,email,lahir,telepon,status,tipe,team) 
			VALUES (:username, :password, :nama, :email, :dob, :phone, :status, :type, :team)";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':username', $data->username, PDO::PARAM_STR);
			$stmt->bindParam(':password', $data->password, PDO::PARAM_STR);
			$stmt->bindParam(':nama', $data->nama, PDO::PARAM_STR);
			$stmt->bindParam(':email', $data->email, PDO::PARAM_STR);
			$stmt->bindParam(':dob', $data->dob, PDO::PARAM_STR);
			$stmt->bindParam(':phone', $data->phone, PDO::PARAM_STR);
			$stmt->bindParam(':status', $data->status, PDO::PARAM_STR);
			$stmt->bindParam(':type', $data->type, PDO::PARAM_STR);
			$stmt->bindParam(':team', $data->team, PDO::PARAM_STR);

			if (!$stmt->execute()) {
	            throw new RuntimeException('Failed to create user');
	        }	
	        return true;
		} finally {
			$this->pool->put($conn);
		}
		

	}
}