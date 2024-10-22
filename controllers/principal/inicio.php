<?php

class login extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Inicio';
        $data['subtitle'] = 'Nuestros Servicios';
       $this->views->getView('principal/inicio/index', $data);
    }


}

?>