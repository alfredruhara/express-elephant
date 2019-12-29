<?php

    namespace Expelephant\Controller {

        class Controller {

            protected $viewPath;
            protected $template = DS.'default'.DS.'index';
        
            protected function render($view, $variabes = []){
              
                extract($variabes);
        
                ob_start();
                    require($this->viewPath.str_replace('.', DS , $view). '.php');
                $layout = ob_get_clean();
              
                require($this->viewPath.'templates'.DS.$this->template.'.php');
             
            }

        }

    }

?>
