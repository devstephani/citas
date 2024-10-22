<?php

class hora extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function verify() {
        $data['title'] = 'hora';
        $data['subtitle'] = 'Verificar Horas disponibles';
       $this->views->getView('principal/hora', $data);
    }


}

?>