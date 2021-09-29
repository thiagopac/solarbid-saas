<?php

class External extends MY_Controller {

    public function assisted_visit(){
		if ($_POST){

			$this->theme_view = 'ajax';
			// var_dump($_POST);
            echo $_POST['conta'];
            // echo "deu certo";	
		}
	}
}

?>