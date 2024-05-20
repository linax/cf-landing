<?php

require_once 'config.php';

$id_estacionamiento = "por_defecto";

$id_datos_estacionamiento = "por_defecto";

$latitud = "por_defecto";

$longitud = "por_defecto";

$cant_est_total = "por_defecto";

$cant_est_reservados = "por_defecto";

$comentarios = "por_defecto";

$id_usuario = $_POST['id_usuario'];

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

if (isset($_POST["id_usuario"])) {
    $sql = "select * from Estacionamiento where id_usuario = '$id_usuario' ORDER BY fecha_creacion DESC";   
}else{  
    $sql = "select * from Estacionamiento";
}


if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){


                $id_estacionamiento = $row['id_estacionamiento'];

                $id_datos_estacionamiento = $row['id_datos_estacionamiento'];

                $fecha_creacion = $row['fecha_creacion'];

                $id_user = $row['id_usuario'];

                $sql_datos_usuario = "SELECT usuario FROM Usuario WHERE id_usuario = '$id_user'";

                if($res_datos_usuario = $mysqli->query($sql_datos_usuario)){
                

                    while($row_datos_usuario =$res_datos_usuario->fetch_assoc()){
                
                        $usuario = $row_datos_usuario['usuario'];

                    }

                }else{
                    echo "entre a este else";
                }

                $partes_fecha_creacion = explode("-", $fecha_creacion);

                $año = $partes_fecha_creacion[0];
                $mes = $partes_fecha_creacion[1];
                $dia = $partes_fecha_creacion[2];

                $fecha_creacion = $dia."-".$mes."-".$año;

                $sql_datos = "select latitud, longitud, cant_est_total, cant_est_reservados, comentarios, cumple_ordenanza from Datos_estacionamiento where id_datos_estacionamiento = '$id_datos_estacionamiento'";

                if($res_datos = $mysqli->query($sql_datos)){

                    while($row_datos=$res_datos->fetch_assoc()){
                        $latitud = $row_datos['latitud'];

                        $longitud = $row_datos['longitud'];
                        
                        $cant_est_total = $row_datos['cant_est_total'];
                        
                        $cant_est_reservados = $row_datos['cant_est_reservados'];

                        $comentarios = $row_datos['comentarios'];

                        $cumple_ordenanza = $row_datos['cumple_ordenanza'];
                    }
                }

                $data= array("id_estacionamiento"=>$id_estacionamiento, "usuario"=>$usuario,"id_usuario"=>$id_user,"fecha_creacion"=>$fecha_creacion,"latitud"=>$latitud,"longitud"=>$longitud,"cant_est_total"=>$cant_est_total,"cant_est_reservados"=>$cant_est_reservados, "comentarios"=>$comentarios,"cumple_ordenanza"=>$cumple_ordenanza);

                $estacionamiento[] = $data;
    }

    $estacionamientos = array("estacionamientos"=>$estacionamiento);

    echo json_encode($estacionamientos);
}























?>







