<?php

  

require_once 'config.php';





$id_usuario = $_POST['id_usuario'];

$latitud = $_POST['latitud'];

$longitud = $_POST['longitud'];

$cant_est_tot = $_POST['cant_total'];

$cant_est_res = $_POST['cant_reservados'];

$comentarios = $_POST['comentarios'];

$cumple_ordenanza = $_POST['cumple_ordenanza'];

$fecha_creacion = $_POST['fecha_creacion'];

/*$id_usuario = '1';

$latitud = '-45';

$longitud = '45';

$cant_est_tot = '30';

$cant_est_res = '10';*/
//connection to the database

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");

mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);
mysql_query("SET NAMES 'utf8'");

function startTransaction()

{

    mysql_query("START TRANSACTION");

}

function breakTransaction($str = "")

{

    $msg = "Transaccion abortada debido a un error: ".mysql_error();

    mysql_query("ROLLBACK");

    echo json_encode($str." ".$msg);

    //die("alert(\"$str $msg\");\n");

}

function commitTransaction()

{

    mysql_query("COMMIT");

    echo json_encode("Transaccion exitosa");

}

function addParking($id_usuario, $latitud, $longitud, $cant_est_tot, $cant_est_res, $comentarios, $cumple_ordenanza, $fecha_creacion){

    startTransaction();

    //agrego acc_ext y int aAccesibilidad


    $sql = "INSERT INTO Datos_estacionamiento(latitud, longitud, cant_est_total, cant_est_reservados, cumple_ordenanza, comentarios) 

           VALUES('".$latitud."', '".$longitud."', '".$cant_est_tot."', '".$cant_est_res."', '".$cumple_ordenanza."', '".$comentarios."')";

    $query_acc = mysql_query($sql) or die( breakTransaction() );

    $sql = "SELECT id_datos_estacionamiento FROM Datos_estacionamiento ORDER BY id_datos_estacionamiento DESC LIMIT 1;";

    $query_datos_estacionamiento_id = mysql_query($sql);

    $line = mysql_fetch_array($query_datos_estacionamiento_id, MYSQL_ASSOC);

    $id_datos_estacionamiento = "";

    foreach ($line as $col_value) {

        //echo "</br>$col_value</br>";

        $id_datos_estacionamiento = $col_value;

    }

    $sql = "INSERT INTO Estacionamiento(id_usuario, id_datos_estacionamiento, fecha_creacion) 

           VALUES('".$id_usuario."','".$id_datos_estacionamiento."', '".$fecha_creacion."')";

    $query_acc = mysql_query($sql) or die( breakTransaction() );

    commitTransaction();

}

addParking($id_usuario, $latitud, $longitud, $cant_est_tot, $cant_est_res, $comentarios, $cumple_ordenanza, $fecha_creacion);







































