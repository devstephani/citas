<?php

class inicio_admin extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Admin';
        $data['subtitle'] = 'Nuestros Servicios';
       $this->views->getView('principal/inicio_admin/index', $data);
    }


}

?>