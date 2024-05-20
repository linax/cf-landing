<?php

    
require_once 'config.php';

$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
$titulo = $_POST['titulo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$acc_exterior = $_POST['acc_exterior'];
$acc_interior = $_POST['acc_interior'];
$bano = $_POST['bano'];
$id_usuario = $_POST['id_usuario'];
$imagen = $_POST['imagen'];
$subcategoria = $_POST['subcategoria'];
$comentarios_extra = $_POST['comentarios_extra'];
$fecha_creacion = $_POST['fecha_creacion'];

/*$latitud = '-44.11874392657647';
$longitud = '-88.40554443001747';
$titulo = 'algunas titulo';
$direccion = 'runcaz 666';
$telefono = '34223423';
$email = 'asd@asdas';
$acc_exterior = '0';
$acc_interior = '2';
$usuario = 'admin';
$imagen = jaja.png;
$subcategoria = '60';
/*$prueba = $arrayName = array('a' => '1', 'b' => '2');
print_r("a: ".$prueba['a']."<br>");
print_r("b: ".$prueba['b']."<br>");*/
//$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    
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



function addPlace($id_usuario, $latitud, $longitud, $titulo, $direccion, $telefono, $email, $acc_exterior, $acc_interior, $imagen, $subcategoria, $comentarios_extra, $fecha_creacion, $bano){

    startTransaction();

    //agrego acc_ext y int aAccesibilidad
    $sql = "INSERT INTO Accesibilidad(acc_exterior, acc_interior, bano) 
           VALUES('".$acc_exterior."', '".$acc_interior."', '".$bano."')";
    $query_acc = mysql_query($sql) or die( breakTransaction() );
    //echo "<br> valores 3, 3 agregados en accesibilidad<br>";

    //saco la ultima ID de accesibilidad
    $sql = "SELECT id_accesibilidad FROM Accesibilidad ORDER BY id_accesibilidad DESC LIMIT 1;";
    $query_acc_id = mysql_query($sql) or die( breakTransaction() );
    $line = mysql_fetch_array($query_acc_id, MYSQL_ASSOC);
    $id_accesibilidad ="";
    foreach ($line as $col_value) {
        //echo "</br>$col_value</br>";
        $id_accesibilidad = $col_value;
    }

    //inserto datos lugar
    $sql = "INSERT INTO Datos_lugar(latitud, longitud, titulo, direccion, telefono, email, imagen, comentarios_extra) 
            VALUES('".$latitud."', '".$longitud."', '".$titulo."', '".$direccion."', '".$telefono."', '".$email."', '".$imagen."', '".$comentarios_extra."')";
    $query_datos_lugar = mysql_query($sql) or die(breakTransaction());

    //saco la ID de los ultimos datos lugar
    $sql = "SELECT id_datos_lugar FROM Datos_lugar ORDER BY id_datos_lugar DESC LIMIT 1;";
    $query_datlugar_id = mysql_query($sql) or die( breakTransaction() );;
    $line = mysql_fetch_array($query_datlugar_id, MYSQL_ASSOC);
    $id_datos_lugar = "";
    foreach ($line as $col_value) {
        //echo "</br>$col_value</br>";
        $id_datos_lugar = $col_value;
    }

    $sql = "INSERT INTO Lugar(id_datos_lugar, id_accesibilidad, id_usuario, id_subcategoria, fecha_creacion) 
            VALUES ('".$id_datos_lugar."', '".$id_accesibilidad."', '".$id_usuario."', '".$subcategoria."', '".$fecha_creacion."')";
    $query_lugar = mysql_query($sql) or die(breakTransaction());

    commitTransaction();

}

addPlace($id_usuario, $latitud, $longitud, $titulo, $direccion, $telefono, $email, $acc_exterior, $acc_interior, $imagen, $subcategoria, $comentarios_extra, $fecha_creacion, $bano);



















