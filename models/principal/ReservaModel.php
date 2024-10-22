<?php

class ReservaModel extends Query{
    
    public function __construct() {
       parent::__construct();
    }
                //LLAMAR LAS RESERVAS
                public function getDisponibilidad($f_reserva , $hora, $servicio){
                    $data = $this->select("SELECT * FROM reservas 
                    WHERE fecha_reserva = '$f_reserva'
                    AND hora_reserva = '$hora' AND id_servicio = $servicio"); 
                    return $data; 
                }

                public function getServicio($servicio){
                    $data = $this->selectAll("SELECT * FROM reservas 
                    WHERE id_servicio = $servicio");
                    return $data;
                }

}

?>