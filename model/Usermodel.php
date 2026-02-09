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

	private function DebugMessage($message){
		$this->databaseDriver->DebugMessage( '[' . __CLASS__ . '] ' . $message);
	}

	private function InfoMessage($message){
		$this->databaseDriver->InfoMessage( '[' . __CLASS__ . '] ' . $message);
	}

	private function ErrorMessage($message){
		$this->databaseDriver->ErrorMessage( '[' . __CLASS__ . '] ' . $message);
	}

	public function __construct($driver){
		$this->databaseDriver = $driver;
	}

	public function insertCabang($data){
		$conn = $this->databaseDriver->getPool()->pop();
		try {
			$query = "INSERT INTO cabang (id_cabang,id_perusahaan) 
			VALUES (:id, :cabang)";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':id', $data['id'], PDO::PARAM_STR);
			$stmt->bindParam(':cabang', $data['cabang'], PDO::PARAM_STR);

			$this->DebugMessage('executing query: ' . $query);
			if (!$stmt->execute()) {
				$this->ErrorMessage('Failed to create user');
	            throw new RuntimeException('Failed to create user');
	        }
			
			$this->DebugMessage('Return connection to the pool');
			$this->databaseDriver->getPool()->push($conn);
	        return true;
		} catch (Exception $e) {
			$this->ErrorMessage($e->getMessage());
			return false;
		}		

	}

	public function insertUser($data){

		try {
			$conn = $this->databaseDriver->getPool()->pop();
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
				$this->ErrorMessage('Failed to create user');
	            throw new RuntimeException('Failed to create user');
	        }	
	        return true;
		} catch (Exception $e) {
			$this->ErrorMessage($e->getMessage());
			return false;
		} finally {
			$this->DebugMessage('Return connection to the pool');
			$this->databaseDriver->getPool()->push($conn);
		}

	}
}