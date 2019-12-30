<?php

    declare(strict_types = 1);
    use Expelephant\Database\MysqlDatabase;

    class App {

        private  $title = 'Express Elephant';
        private  $_dbInstance;

        private static $_appInstance;
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
            if(is_null(self::$_appInstance)){
                self::$_appInstance = new App();
            }
            return self::$_appInstance;
        }

        public function getTable(string $name) {
           $class_name = '\\Expapp\\App\\Table\\'.ucfirst($name).'Table';
           return new $class_name($this->getDb());
        }

        public function getDb() : MysqlDatabase {
            $cf = \Expelephant\Config::getInstance(ROOT.DS.'expapp'.DS.'config'.DS.'dbConfig.php');
    
            if (is_null($this->_dbInstance)) {
                $this->_dbInstance = new MysqlDatabase($cf->get('dbName'), $cf->get('dbUser'), $cf->get('dbPass'), $cf->get('dbHost'));
            }
            return $this->_dbInstance;
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
