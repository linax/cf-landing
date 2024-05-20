<?php



    

require_once 'config.php';



$markerType = $_POST['markerType'];

$id_usuario = $_POST['id_usuario'];
$imagen = $_POST['imagen'];

$id_lugar = $_POST['id_lugar'];
$titulo = $_POST['titulo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$acc_exterior = $_POST['acc_exterior'];
$acc_interior = $_POST['acc_interior'];
$bano = $_POST['bano'];
$subcategoria = $_POST['subcategoria'];
$comentarios_extra = $_POST['comentarios_extra'];	

$id_barrera = $_POST['id_barrera'];
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];

$id_estacionamiento = $_POST['id_estacionamiento'];
$cant_est_tot = $_POST['cant_total'];
$cant_est_res = $_POST['cant_reservados'];
$cumple_ordenanza = $_POST['cumple_ordenanza'];
$comentarios = $_POST['comentarios'];



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

function commitTransaction($msg)
{
    mysql_query("COMMIT");
    echo json_encode($msg);
}


function editPlace($id_usuario, $id_lugar, $titulo, $direccion, $telefono, $email, $acc_exterior, $acc_interior, $bano, $imagen, $subcategoria, $comentarios_extra){

    startTransaction();

    //saco la ID de los ultimos datos lugar
    $sql = "SELECT id_datos_lugar, id_accesibilidad FROM Lugar WHERE id_lugar='$id_lugar'";
    $query_datlugar_id = mysql_query($sql) or die( breakTransaction() );
    $id_datos_lugar = "";
    $id_accesibilidad = "";
    while ($line = mysql_fetch_array($query_datlugar_id, MYSQL_ASSOC)) {
        //echo "</br>$col_value</br>";
        $id_datos_lugar = $line['id_datos_lugar'];
        $id_accesibilidad = $line['id_accesibilidad'];
    }

    $sql = "SELECT imagen FROM Datos_lugar WHERE id_datos_lugar ='$id_datos_lugar'";
    $query_imagen = mysql_query($sql) or die( breakTransaction() );
    $imagenServidor = "";

    while ($line = mysql_fetch_array($query_imagen, MYSQL_ASSOC)) {
        //echo "</br>$col_value</br>";
        $imagenServidor = $line['imagen'];
    }

    if($imagen != $imagenServidor)
    {
        $filename = $imagenServidor . ".png";

        $target_path = "uploads/";

        if (file_exists($target_path.$filename)) {
            //echo "The file $filename exists <br>" ;
            if(unlink($target_path.$filename)){
                //echo "File Deleted. <br>";
            }
        } else {
            //echo "The file $filename does not exist <br>";
        }
    }

    $sql = "UPDATE Lugar SET id_subcategoria = '$subcategoria' WHERE id_datos_lugar = '$id_datos_lugar'";
    $query_update_lugar = mysql_query($sql) or die(breakTransaction());

    $sql = "UPDATE Datos_lugar SET titulo = '$titulo', direccion = '$direccion', telefono = '$telefono', email = '$email', imagen = '$imagen', comentarios_extra = '$comentarios_extra' WHERE id_datos_lugar = '$id_datos_lugar'";
    $query_update_lugar = mysql_query($sql) or die(breakTransaction());

    $sql = "UPDATE Accesibilidad SET acc_exterior = '$acc_exterior', acc_interior = '$acc_interior', bano = '$bano' WHERE id_accesibilidad = '$id_accesibilidad'";
    $query_update_lugar = mysql_query($sql) or die(breakTransaction());

    commitTransaction($id_accesibilidad."*".$id_datos_lugar);

}

function editBarrier($id_usuario, $id_barrera, $tipo, $descripcion, $imagen){

    startTransaction();
    
    $sql = "SELECT id_datos_barrera FROM Barrera WHERE id_barrera ='$id_barrera'";
    $query_barrera = mysql_query($sql) or die( breakTransaction() );
    $id_datos_barrera = "";

    while ($line = mysql_fetch_array($query_barrera, MYSQL_ASSOC)) {
        //echo "</br>$col_value</br>";
        $id_datos_barrera = $line['id_datos_barrera'];
    }

    $sql = "SELECT imagen FROM Datos_barrera WHERE id_datos_barrera ='$id_datos_barrera'";
    $query_imagen = mysql_query($sql) or die( breakTransaction() );
    $imagenServidor = "";

    while ($line = mysql_fetch_array($query_imagen, MYSQL_ASSOC)) {
        //echo "</br>$col_value</br>";
        $imagenServidor = $line['imagen'];
    }

    if($imagen != $imagenServidor)
    {
        $filename = $imagenServidor . ".png";

        $target_path = "uploads/";

        if (file_exists($target_path.$filename)) {
            //echo "The file $filename exists <br>" ;
            if(unlink($target_path.$filename)){
                //echo "File Deleted. <br>";
            }
        } else {
            //echo "The file $filename does not exist <br>";
        }
    }

    

    $sql = "UPDATE Datos_barrera SET tipo = '$tipo', descripcion = '$descripcion', imagen = '$imagen' WHERE id_datos_barrera = '$id_datos_barrera'";
    $query_update_barrera = mysql_query($sql) or die(breakTransaction());


    commitTransaction($id_datos_barrera."*1");
}

function editParking($id_usuario, $id_estacionamiento, $cant_est_tot, $cant_est_res, $cumple_ordenanza, $comentarios){

    startTransaction();

    //agrego acc_ext y int aAccesibilidad
    $sql = "SELECT id_datos_estacionamiento FROM Estacionamiento WHERE id_estacionamiento ='$id_estacionamiento'";
    $query_estacionamiento = mysql_query($sql) or die( breakTransaction() );
    $id_datos_estacionamiento = "";
    while ($line = mysql_fetch_array($query_estacionamiento, MYSQL_ASSOC)) {
        //echo "</br>$col_value</br>";
        $id_datos_estacionamiento = $line['id_datos_estacionamiento'];
    }

    $sql = "UPDATE Datos_estacionamiento SET cant_est_total = '$cant_est_tot', cant_est_reservados = '$cant_est_res', cumple_ordenanza = '$cumple_ordenanza', comentarios = '$comentarios' WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";
    $query_update_estacionamiento = mysql_query($sql) or die(breakTransaction());

    commitTransaction($id_datos_estacionamiento."*1");

}


if($markerType == "place"){

	editPlace($id_usuario, $id_lugar, $titulo, $direccion, $telefono, $email, $acc_exterior, $acc_interior, $bano, $imagen, $subcategoria, $comentarios_extra);

    //echo json_encode($id_usuario." ".$latitud." ".$longitud." ".$titulo." ".$direccion." ".$telefono." ".$email." ".$acc_exterior." ".$acc_interior." ".$imagen." ".$subcategoria." ".$comentarios_extra." ".$fecha_creacion." ".$bano);

}elseif ($markerType == "barrier") {

	editBarrier($id_usuario, $id_barrera, $tipo, $descripcion, $imagen);

}elseif ($markerType == "parking") {

	editParking($id_usuario, $id_estacionamiento, $cant_est_tot, $cant_est_res, $cumple_ordenanza, $comentarios);

}











?>