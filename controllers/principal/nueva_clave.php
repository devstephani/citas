<?php

class nueva_clave extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Login';
        $data['subtitle'] = 'Nuestros Servicios';
       $this->views->getView('principal/nueva_clave/index', $data);
    }


}

?>