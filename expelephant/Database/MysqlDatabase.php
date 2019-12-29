<?php

    namespace Expelephant\Database {
    use \PDO;

        class MysqlDatabase extends __DatabaseManagement {

            private $dbName;
            private $dbUser;
            private $dbPass;
            private $dbHost;
            
            private $pdo;

            public function __construct($dbName, $dbUser= 'root',  $dbPass = '', $dbHost = 'localhost') {
                $this->dbName = $dbName;
                $this->dbUser = $dbUser;
                $this->dbPass = $dbPass;
                $this->dbHost = $dbHost;
            }

            private function getPDO() { 
                if ($this->pdo === null) {
                    $pdo = new PDO("mysql:dbname=$this->db_name;dbhost=$this->db_host", $this->db_user, $this->db_pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $this->pdo = $pdo;
                }
                return $this->pdo;
            }
            
            public function query(string $statement, $className = null ,bool $TryingToGetPropertyOfNonObject = false) {             
                $request = $this->getPDO()->query($statement);
                    
                if (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0) {
                    return $request;
                }
                
                if  ($className === null) {
                    $request->setFetchMode(PDO::FETCH_OBJ);  
                } else {
                    $request->setFetchMode(PDO::FETCH_CLASS, $className);  
                }
                
                if  ($TryingToGetPropertyOfNonObject === true)
                {
                    $data = $request->fetch();
                } else {
                    $data = $request->fetchAll();
                }

                return $data;
            }
        
            public function prepare(string $statement,array $attributes , $className = null, bool $TryingToGetPropertyOfNonObject = false) {
                $request = $this->getPDO()->prepare($statement);
                $response = $request->execute($attributes);

                if  (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0) {
                    return $response;
                }

                if  ($className === null) {
                    $request->setFetchMode(PDO::FETCH_OBJ);  
                } else {
                    $request->setFetchMode(PDO::FETCH_CLASS, $className);  
                }
                
                if  ($TryingToGetPropertyOfNonObject === true) {
                    $data = $request->fetch();
                } else {
                    $data = $request->fetchAll();
                }

                return $data;
            }
        
            public function count(string $statement,array $attributes = null) {
                $req = $this->getPDO()->prepare($statement);
                
                if  ($attributes) {
                    $req->execute($attributes);
                } else {
                    $req->execute();
                }

                $count = $req->rowCount();
                $req->closeCursor();

                return $count;
            }
            
            public function lastInsertId() : int
            {
                return $this->getPDO()->lastInsertId();
            }
       
        }

   }

?>
