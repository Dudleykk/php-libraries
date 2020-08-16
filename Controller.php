<?php
class Controller {

    function __construct() {
        //echo 'Main controller<br />';
        $this->view = new View();
    }
    
    /**
     * 
     * @param string $name Name of the model
     * @param string $path Location of the models
     */
    public function loadModel($name) {
		$path = 'models/' . $name.'_model.php';
        if (file_exists($path)) {
            require $path;
            $modelName = $name . '_model';
            $this->model = new $modelName();
        }        
    }

}