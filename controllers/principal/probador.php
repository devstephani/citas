<?php

class probador extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Probador';
        $data['subtitle'] = 'Provador Virtual';
       $this->views->getView('principal/probador/index', $data);
    }


}

?>