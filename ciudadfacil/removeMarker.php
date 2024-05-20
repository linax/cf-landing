<?php



    

require_once 'config.php';



$id_marcador = $_POST['id_marcador'];

$tipo_marcador = $_POST['tipo_marcador'];

//echo
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

}



 



function commitTransaction()
{

    mysql_query("COMMIT");

    echo json_encode("Transaccion exitosa");

}

function removePlace($id_marcador){

    startTransaction();

    $sql = "SELECT id_datos_lugar, id_accesibilidad, id_usuario FROM Lugar WHERE id_lugar = '$id_marcador';";

    $query_lugar = mysql_query($sql) or die( breakTransaction() );

    $line = mysql_fetch_array($query_lugar, MYSQL_ASSOC);
    
    $id_datos_lugar = $line['id_datos_lugar'];
    $id_accesibilidad = $line['id_accesibilidad'];
    $id_usuario = $line['id_usuario'];

    $sql = "SELECT imagen FROM Datos_lugar WHERE id_datos_lugar = '$id_datos_lugar';";
    $query_filename = mysql_query($sql) or die( breakTransaction() );
    $line = mysql_fetch_array($query_filename, MYSQL_ASSOC);

    $filename = $line['imagen'] . ".png";

    $target_path = "uploads/";

    if (file_exists($target_path.$filename)) {
        //echo "The file $filename exists <br>" ;
        if(unlink($target_path.$filename)){
            //echo "File Deleted. <br>";
        }
    } else {
        //echo "The file $filename does not exist <br>";
    }


    mysql_query("DELETE FROM Lugar WHERE id_lugar = '$id_marcador';") or die( breakTransaction() );

    mysql_query("DELETE FROM Datos_lugar WHERE id_datos_lugar = '$id_datos_lugar';") or die( breakTransaction() );

    mysql_query("DELETE FROM Accesibilidad WHERE id_accesibilidad = '$id_accesibilidad';") or die( breakTransaction() );

    mysql_query("DELETE FROM Evaluacion_usuario_lugar WHERE id_lugar = '$id_marcador'") or die( breakTransaction() );    
    
    commitTransaction();
}

function removeBarrier($id_marcador){

    startTransaction();

    $sql = "SELECT id_datos_barrera, id_usuario FROM Barrera WHERE id_barrera = '$id_marcador';";

    $query_barrera = mysql_query($sql) or die( breakTransaction() );

    $line = mysql_fetch_array($query_barrera, MYSQL_ASSOC);
    
    $id_datos_barrera = $line['id_datos_barrera'];
    $id_usuario = $line['id_usuario'];

    $sql = "SELECT imagen FROM Datos_barrera WHERE id_datos_barrera = '$id_datos_barrera';";
    $query_filename = mysql_query($sql) or die( breakTransaction() );
    $line = mysql_fetch_array($query_filename, MYSQL_ASSOC);

    $filename = $line['imagen'] . ".png";

    $target_path = "uploads/";

    if (file_exists($target_path.$filename)) {
//        echo "The file $filename exists <br>" ;
        if(unlink($target_path.$filename)){
            //echo "File Deleted. <br>";
        }
    } else {
        //echo "The file $filename does not exist <br>";
    }


    mysql_query("DELETE FROM Barrera WHERE id_barrera = '$id_marcador';") or die( breakTransaction() );

    mysql_query("DELETE FROM Datos_barrera WHERE id_datos_barrera = '$id_datos_barrera';") or die( breakTransaction() );

    mysql_query("DELETE FROM Evaluacion_usuario_barrera WHERE id_barrera = '$id_marcador'") or die( breakTransaction() );    
    
    commitTransaction();
}

function removeParking($id_marcador){

    startTransaction();

    $sql = "SELECT id_datos_estacionamiento FROM Estacionamiento WHERE id_estacionamiento = '$id_marcador';";

    $query_estacionamiento = mysql_query($sql) or die( breakTransaction() );

    $line = mysql_fetch_array($query_estacionamiento, MYSQL_ASSOC);
    
    $id_datos_estacionamiento = $line['id_datos_estacionamiento'];

    mysql_query("DELETE FROM Estacionamiento WHERE id_estacionamiento = '$id_marcador';") or die( breakTransaction() );

    mysql_query("DELETE FROM Datos_estacionamiento WHERE id_datos_estacionamiento = '$id_datos_estacionamiento';") or die( breakTransaction() );

    mysql_query("DELETE FROM Evaluacion_usuario_estacionamiento WHERE id_estacionamiento = '$id_marcador'") or die( breakTransaction() );    
    
    commitTransaction();
}


if($tipo_marcador == "lugar"){
    removePlace($id_marcador);
}elseif ($tipo_marcador == "barrera") {
    removeBarrier($id_marcador);
}elseif ($tipo_marcador == "estacionamiento") {
    removeParking($id_marcador);
}else{
    //echo "fail";
}














































