<?php

class principalModel extends Query{
    
    public function __construct() {
       parent::__construct();
    }
    //RECUPERAR LOS SLIDERS
    public function getSliders(){
        return $this->selectAll("SELECT * FROM sliders");
    }
        //RECUPERAR LOS SERVICIOS
        public function getServicios(){
            return $this->selectAll("SELECT * FROM servicios");
        }
                //RECUPERAR LOS HORAS
                public function getHora(){
                    return $this->selectAll("SELECT * FROM horas_del_servicio");
                }
                        //BUSCAR PRESENTACION
        public function getPresentacion(){
            return $this->selectAll("SELECT * FROM presentacion");
        }
        public function getServicio(){
            return $this->selectAll("SELECT * FROM reservas");
        }

}


?>