<?php

  namespace Expapp\App {

    class Autoload {

		const DS = DIRECTORY_SEPARATOR;
		
		public static function register() : void {
			spl_autoload_register([__CLASS__, 'autoload']);
		}

		public static function autoload(string $class) : void {

			if(strpos($class,__NAMESPACE__) === 0 ){
				$class = str_replace(__NAMESPACE__.self::DS, '', $class);
				$class = str_replace('\\', self::DS , $class);
				
				require __DIR__.self::DS.$class.'.php';
			}

		}

    }
    
  }

?>
