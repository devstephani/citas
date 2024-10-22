<?php

class codigo extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Login';
        $data['subtitle'] = 'Nuestros Servicios';
       $this->views->getView('principal/codigo/index', $data);
    }


}

?>