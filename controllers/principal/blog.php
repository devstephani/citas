<?php

class blog extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['title'] = 'Blog';
        $data['subtitle'] = 'Contenido de Belleza';
       $this->views->getView('principal/blog/index', $data);
    }


}

?>