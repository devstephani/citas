<?php

class paquetes extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Paquetes';
        $data['subtitle'] = 'Paquetes Disponibles';
       $this->views->getView('principal/paquetes/index', $data);
    }


}

?>