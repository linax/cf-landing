<?php

require_once 'config.php';

$id_lugar = "por_defecto";



$latitud = "por_defecto";

$longitud = "por_defecto";

$titulo = "por_defecto";

$id_categoria = "por_defecto";

$id_subcategoria = "por_defecto";

$acc_exterior = "por_defecto";

$acc_interior = "por_defecto";

$bano = "por_defecto";

$id_usuario = $_POST['id_usuario'];

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

if (isset($_POST["id_usuario"])) {
    $sql = "select * from Lugar where id_usuario = '$id_usuario' ORDER BY fecha_creacion DESC";   
}else{  
    $sql = "select * from Lugar";
}



if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_lugar = $row['id_lugar'];

                $id_accesibilidad = $row['id_accesibilidad'];

                $id_datos_lugar = $row['id_datos_lugar'];

                $id_subcategoria = $row['id_subcategoria'];

                $id_user = $row['id_usuario'];

                $sql_datos_usuario = "SELECT usuario FROM Usuario WHERE id_usuario = '$id_user'";

                if($res_datos_usuario = $mysqli->query($sql_datos_usuario)){
                

                    while($row_datos_usuario =$res_datos_usuario->fetch_assoc()){
                
                        $usuario = $row_datos_usuario['usuario'];

                    }

                }else{
                    echo "entre a este else";
                }

                $fecha_creacion = $row['fecha_creacion'];

                $partes_fecha_creacion = explode("-", $fecha_creacion);
                $año = $partes_fecha_creacion[0];
                $mes = $partes_fecha_creacion[1];
                $dia = $partes_fecha_creacion[2];

                $fecha_creacion = $dia."-".$mes."-".$año;

                $sql_acc = "SELECT acc_exterior, acc_interior, bano FROM Accesibilidad WHERE id_accesibilidad = '$id_accesibilidad'";

                if($res_acc = $mysqli->query($sql_acc)){

                    while($row_acc =$res_acc->fetch_assoc()){

                        $acc_exterior = $row_acc['acc_exterior'];

                        $acc_interior = $row_acc['acc_interior'];

                        $bano = $row_acc['bano'];

                    }

                }else{

                    echo "holi";

                }

                $sql_datos_lugar = "SELECT latitud, longitud, titulo FROM Datos_lugar WHERE id_datos_lugar = '$id_datos_lugar'";

                if($res_datos_lugar = $mysqli->query($sql_datos_lugar)){

                    while($row_datos_lugar =$res_datos_lugar->fetch_assoc()){

                        $titulo = $row_datos_lugar['titulo'];

                        $latitud = $row_datos_lugar['latitud'];

                        $longitud = $row_datos_lugar['longitud'];

                    }

                }else{

                    echo "entre a este else";

                }

                $sql_categoria = "SELECT id_categoria FROM Subcategoria WHERE id_subcategoria = '$id_subcategoria'";

                if($res_categoria = $mysqli->query($sql_categoria)){

                    while($row_categoria = $res_categoria->fetch_assoc()){

                        $id_categoria = $row_categoria['id_categoria'];

                    }

                }else{

                    echo "entre a este else";

                }

                $data= array("id_lugar"=>$id_lugar, "usuario"=>$usuario,"id_usuario"=>$id_user, "fecha_creacion"=>$fecha_creacion,"latitud"=>$latitud,"longitud"=>$longitud,"titulo"=>$titulo,"acc_exterior"=>$acc_exterior,"acc_interior"=>$acc_interior, "bano"=>$bano, "id_categoria"=>$id_categoria, "id_subcategoria"=>$id_subcategoria);

                $lugar[] = $data;
    }

    $lugares = array("lugares"=>$lugar);

    echo json_encode($lugares);



    //echo "<pre>";



    //print_r($lugares);



}











?>



