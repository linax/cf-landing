<?php

require_once 'config.php';



$id_marcador = $_POST['id_marcador'];

$tipo_marcador = $_POST['tipo_marcador'];

//echo
//connection to the database

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");




function breakTransaction($str = "")
{

    $msg = "Transaccion abortada debido a un error: ".mysql_error();

    mysql_query("ROLLBACK");

    echo json_encode($str." ".$msg);

}


function checkPlace($mysqli, $id_marcador){

    

    $sql = "SELECT * FROM Lugar WHERE id_lugar = '$id_marcador';";

    
    if ($result = $mysqli->query($sql)) {

         /* determinar el número de filas del resultado */
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0){
            echo json_encode("1");
        }else{
            echo json_encode("0");
        }

    }  
    
}

function checkBarrier($mysqli, $id_marcador){

    $sql = "SELECT * FROM Barrera WHERE id_barrera = '$id_marcador';";

    if ($result = $mysqli->query($sql)) {

         /* determinar el número de filas del resultado */
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0){
            echo json_encode("1");
        }else{
            echo json_encode("0");
        }

    }      
    
}

function checkParking($mysqli, $id_marcador){

    $sql = "SELECT * FROM Estacionamiento WHERE id_estacionamiento = '$id_marcador';";

    if ($result = $mysqli->query($sql)) {

         /* determinar el número de filas del resultado */
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0){
            echo json_encode("1");
        }else{
            echo json_encode("0");
        }

    }      

}


if($tipo_marcador == "lugares"){
    checkPlace($mysqli, $id_marcador);
}elseif ($tipo_marcador == "barreras") {
    checkBarrier($mysqli, $id_marcador);
}elseif ($tipo_marcador == "estacionamientos") {
    checkParking($mysqli, $id_marcador);
}else{
    //echo "fail";
}
