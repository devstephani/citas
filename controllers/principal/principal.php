<?php

class principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Pagina principal';

        //CONSULTA DEL SLIDERS
        $data['sliders'] =  $this->model->getSliders();
        $data['presentacion'] =  $this->model->getPresentacion();
        $data['hora'] =  $this->model->getHora();
        
        //TRAES LOS SERVICIOS 
        $data['servicios'] =  $this->model->getServicios();
        $this->views->getView('index', $data);
    }
}
