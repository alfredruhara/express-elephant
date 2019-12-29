<?php

    declare(strict_types = 1);
    use Expelephant\Database\MysqlDatabase;

    class App {

        private  $title = 'Express Elephant';
        private  $_dbInstance;

        private static $_instance;
        private static $DS = DIRECTORY_SEPARATOR;

        #----------------------------------#
        #    Core Express Elephant App     #
        #----------------------------------#
        
        public static function run() : void {
            require ROOT.DS.'expapp'.DS.'app'.DS.'Autoload.php';
            Expapp\App\Autoload::register();
            
            require ROOT.DS.'expelephant'.DS.'Autoload.php';
            Expelephant\Autoload::register();
        }
        
        public static function getInstance() : App {
            if(is_null(self::$_instance)){
                self::$_instance = new System();
            }
            return self::$_instance;
        }

        public function getTable(string $name) {
           $class_name = '\\Expapp\\App\\Table\\'.ucfirst($name).'Table';
           return new $class_name($this->getDb());
        }

        public function getDb() {
            $cf = \Expelephant\Config::getInstance(ROOT.DS.'expapp'.DS.'config'.DS.'dbConfig.php');
    
            if (is_null($this->_dbInstance)) {
                $this->_dbInstance = new MysqlDatabase($cf->get('db_name'), $cf->get('db_user'), $cf->get('db_pass'), $cf->get('db_host'));
            }
            return $this->db_instance;
        }
     
        public function formatInput(string $data) : string {
            $trim = trim($data);
            $stripslashes = stripslashes($trim);
            $clear_input = htmlspecialchars($stripslashes);
            return strtolower($clear_input);
        }
          
        public function getTitle() : string {
            return $this->title;
        }

        public function setTitle(string $title) : void {
            $this->title = $title.' - '.$this->title; 
        }
                
    }

?>
