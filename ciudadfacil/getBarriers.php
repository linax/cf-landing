<?php

require_once 'config.php';


$id_barrera = "por_defecto";

$id_datos_barrera = "por_defecto";

$latitud = "por_defecto";

$longitud = "por_defecto";

$tipo = "por_defecto";

$descripcion = "por_defecto";

$imagen = "por_defecto";

$id_usuario = $_POST['id_usuario'];

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

if (isset($_POST["id_usuario"])) {
    $sql = "select * from Barrera where id_usuario = '$id_usuario' ORDER BY fecha_creacion DESC";   
}else{  
    $sql = "select * from Barrera";
}


if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_barrera = $row['id_barrera'];

                $id_datos_barrera = $row['id_datos_barrera'];

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

                $sql_datos_lugar = "SELECT latitud, longitud, tipo, descripcion, imagen FROM Datos_barrera WHERE id_datos_barrera = '$id_datos_barrera'";

                if($res_datos_lugar = $mysqli->query($sql_datos_lugar)){
                

                    while($row_datos_lugar =$res_datos_lugar->fetch_assoc()){
                
                        $latitud = $row_datos_lugar['latitud'];

                        $longitud = $row_datos_lugar['longitud'];

                        $tipo = $row_datos_lugar['tipo'];

                        $descripcion = $row_datos_lugar['descripcion'];

                        $imagen = $row_datos_lugar['imagen'];

                    }

                }else{
                    echo "entre a este else";
                }

                //$direccion = $row['direccion'];

                $data= array("id_barrera"=>$id_barrera, "usuario"=>$usuario,"id_usuario"=>$id_user,"fecha_creacion"=>$fecha_creacion,"latitud"=>$latitud,"longitud"=>$longitud,"tipo"=>$tipo,"descripcion"=>$descripcion,"imagen"=>$imagen);

                $barrera[] = $data;

    }

    $barreras = array("barreras"=>$barrera);

    echo json_encode($barreras);


}

?>



