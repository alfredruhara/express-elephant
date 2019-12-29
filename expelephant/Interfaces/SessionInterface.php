<?php

    namespace Expelephant\Interfaces {

        interface SessionInterface {

            public function get(string $key) ;

            public function set(string $key, $value) : void ;

            public function delete(string $key) : void ; 

            public function exist(string $key) : ? string ; 
            
        }  

    }

?>
