<?php
class Reserva extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function verify()
     {   
        if (isset($_GET['f_reserva']) && isset($_GET['hora']) && isset($_GET['servicio'])) {
            $f_reserva = strClean($_GET['f_reserva']);
            $hora = strClean($_GET['hora']);
            $servicio = strClean($_GET['servicio']);

            if (empty($f_reserva) || empty($hora) || empty($servicio)) {
                header('location: ' . RUTA_PRINCIPAL . '?respuesta=warning');

            } else {
                $reserva= $this->model->getDisponibilidad($f_reserva, $hora, $servicio);
                $data['title'] = 'Reservas';
                $data['subtitle'] = 'Verificar fechas disponibles';
                $data['disponible'] = [
                    'f_reserva' => $f_reserva,
                    'hora' => $hora,
                    'servicio' => $servicio
                ];

                if (empty($reserva)){
                    $data ['mensaje']= ' DISPONIBLE';
                    $data ['tipo']= 'success';
                }else{
                    $data ['mensaje']= 'NO DISPONIBLE';
                    $data ['tipo']= 'danger';
                }
                
                $this->views->getView('principal/reservas', $data);
            }
        }
    }

public function lista($parametros){
        $array = explode(',', $parametros);
        $f_reserva = (!empty($array[0])) ? $array[0] : null;
        $hora = (!empty($array[1])) ? $array[1] : null;
        $servicio = (!empty($array[2])) ? $array[2] : null;
        $results = [];
        //hay error en el for no ejecuta no extraer nada de la base de datos y da error
        if ($f_reserva != null && $hora != null && $servicio != null) {
            $reservas = $this->model->getServicio($servicio);

            print_r(count($reservas));
            for ($i = 0; $i < count($reservas); $i++) {
                $datos['id'] = $reservas[$i]['id'];
                $datos['title'] = 'RESERVADO';
                $datos['start'] = $reservas[$i]['fecha_reserva'];
                $datos['end'] = $reservas[$i]['hora_reserva'];
                $datos['color'] = '#dc3545';
                array_push($results, $datos);
            }
            $data['id'] = $servicio;
            $data['title'] = 'COMPROBANDO';
            $data['start'] = $f_reserva;
            $data['end'] = $hora;
            $data['color'] = '#198754';
            array_push($results, $data);
        }
        die();
    }
    
}



?>
