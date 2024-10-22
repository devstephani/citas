<?php

class contacto extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Contacto';
        $data['subtitle'] = 'Contactenos';
       $this->views->getView('principal/contacto/index', $data);
    }


}

?>