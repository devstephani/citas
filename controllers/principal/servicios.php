<?php

class servicios extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Servicios';
        $data['subtitle'] = 'Nuestros Servicios';
       $this->views->getView('principal/servicios/index', $data);
    }


}

?>