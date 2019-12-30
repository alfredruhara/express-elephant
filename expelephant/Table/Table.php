<?php

    namespace Expelephant\Table {
    
    use Expelephant\Database\__DatabaseManagement;
        
        class Table {

            protected $table;
            protected $db;
            
            public function __construct(__DatabaseManagement $db) {
                $this->db = $db;
                
                if ($this->table === null) {
                    $parts = explode('\\', get_class($this));
                    $class_name = end($parts);
                    $this->table = strtolower(str_replace('Table', '', $class_name));
                }
                return  $this->table;
            }
           
            public function query(string $statement, array $attributes = null, bool $TryingToGetPropertyOfNonObject = false) {     
                if ($attributes != null) {
                    return $this->db->prepare($statement, $attributes, str_replace('Table', 'Entity', get_class($this)), $TryingToGetPropertyOfNonObject);
                } else {
                    return $this->db->query($statement, str_replace('Table', 'Entity', get_class($this)), $TryingToGetPropertyOfNonObject);
                }
            }
            
            public function create(array $fields) {
                $attributes = [];
                foreach ($fields as $key => $value) {
                    $parts[] = "$key = ? ";
                    $attributes [] = $value;
                }
                $composition = implode(', ', $parts);
            
                return $this->query("INSERT INTO $this->table SET $composition ", $attributes, true);
            }
            
            public function update($id, array $fields) {
                $attributes = [];
                foreach ($fields as $key => $value) {
                    $parts[] = "$key = ? ";
                    $attributes [] = $value;
                }
                $attributes[] =  $id;
                $composition = implode(', ' ,$parts);
        
                return $this->query("UPDATE $this->table SET $composition WHERE id = ?", $attributes, true);
            }

            public function delete(int $id) {
                return $this->query("DELETE FROM $this->table WHERE id = ?", [$id], true);
            }

            public function readAll() {
                return $this->query("SELECT * FROM $this->table");
            }
            
            public function readOne(int $id) {
                return $this->query("SELECT * FROM $this->table WHERE id = ? ", [$id], true);
            }

            public function readAllBy(int $id) {
                return $this->query("SELECT * FROM $this->table WHERE id = ? ", [$id]);
            }
            
            public function _list(int $key, string $value, array $records = []) {
                $keyValue = [];
        
                foreach ($records as $val) {
                    $keyValue[$val->$key] = $val->$value;
                }
            
                return $keyValue ;
            }

            public function _lastInsertId(){
                return $this->db->lastInsertId();
            }

            public function _count(string $statement,array $attributes = null){
                return $this->db($statement, $attributes);
            }

        }

    }

?>
