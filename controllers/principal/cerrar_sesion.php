<?php
    include_once './../../config/config.php';
    session_start(); 
    session_destroy();
    header(header: "location: " . RUTA_PRINCIPAL);

?>