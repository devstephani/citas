<?php

class recuperar_contra extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Login';
        $data['subtitle'] = 'Nuestros Servicios';
       $this->views->getView('principal/recuperar_contra/index', $data);
    }


}

?>