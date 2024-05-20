<?php



    

require_once 'config.php';



$markerType = $_POST['markerType'];

$id_usuario = $_POST['id_usuario'];

$latitud = $_POST['latitud'];

$longitud = $_POST['longitud'];

$fecha_creacion = $_POST['fecha_creacion'];

$titulo = $_POST['titulo'];

$direccion = $_POST['direccion'];

$telefono = $_POST['telefono'];

$email = $_POST['email'];

$acc_exterior = $_POST['acc_exterior'];

$acc_interior = $_POST['acc_interior'];

$bano = $_POST['bano'];

$imagen = $_POST['imagen'];

$subcategoria = $_POST['subcategoria'];

$comentarios_extra = $_POST['comentarios_extra'];	

$tipo = $_POST['tipo'];

$descripcion = $_POST['descripcion'];

$cant_est_tot = $_POST['cant_total'];

$cant_est_res = $_POST['cant_reservados'];

$comentarios = $_POST['comentarios'];

$cumple_ordenanza = $_POST['cumple_ordenanza'];



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



 



function commitTransaction($msg)

{



    mysql_query("COMMIT");

    echo json_encode($msg);

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



    //saco la ID del ultimo lugar

    $sql = "SELECT id_lugar FROM Lugar ORDER BY id_lugar DESC LIMIT 1;";

    $query_lugar_id = mysql_query($sql) or die( breakTransaction() );;

    $line = mysql_fetch_array($query_lugar_id, MYSQL_ASSOC);

    $id_lugar = "";

    foreach ($line as $col_value) {

        //echo "</br>$col_value</br>";

        $id_lugar = $col_value;

    }



    commitTransaction($id_accesibilidad."*".$id_datos_lugar."*".$id_lugar);



}



function addBarrier($id_usuario, $latitud, $longitud, $tipo, $descripcion, $imagen, $fecha_creacion){



    startTransaction();



    //inserto datos barrera

    $sql = "INSERT INTO Datos_barrera(latitud, longitud, tipo, descripcion, imagen) 

            VALUES('".$latitud."', '".$longitud."', '".$tipo."', '".$descripcion."', '".$imagen."')";



    $query_datos_barrera = mysql_query($sql) or die(breakTransaction());







    //saco la ID del ultimo datos_barrera

    $sql = "SELECT id_datos_barrera FROM Datos_barrera ORDER BY id_datos_barrera DESC LIMIT 1;";

    $query_datos_barrera_id = mysql_query($sql);

    $line = mysql_fetch_array($query_datos_barrera_id, MYSQL_ASSOC);

    $id_datos_barrera = "";

    foreach ($line as $col_value) {



        //echo "</br>$col_value</br>";



        $id_datos_barrera = $col_value;



    }



    $sql = "INSERT INTO Barrera(id_datos_barrera, id_usuario, fecha_creacion) 



            VALUES ('".$id_datos_barrera."', '".$id_usuario."', '".$fecha_creacion."')";



    $query_lugar = mysql_query($sql) or die(breakTransaction());



     //saco la ID de ultima barrera

    $sql = "SELECT id_barrera FROM Barrera ORDER BY id_barrera DESC LIMIT 1;";

    $query_barrera_id = mysql_query($sql);

    $line = mysql_fetch_array($query_barrera_id, MYSQL_ASSOC);

    $id_barrera = "";

    foreach ($line as $col_value) {



        //echo "</br>$col_value</br>";



        $id_barrera = $col_value;



    }



    commitTransaction($id_datos_barrera."*".$id_barrera);







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



    //selecciono ultimo id_estacionamiento

	$sql = "SELECT id_estacionamiento FROM Estacionamiento ORDER BY id_estacionamiento DESC LIMIT 1;";



    $query_estacionamiento_id = mysql_query($sql);



    $line = mysql_fetch_array($query_estacionamiento_id, MYSQL_ASSOC);



    $id_estacionamiento = "";



    foreach ($line as $col_value) {

        $id_estacionamiento = $col_value;



    }



    commitTransaction($id_datos_estacionamiento."*".$id_estacionamiento);



}





if($markerType == "place"){



	addPlace($id_usuario, $latitud, $longitud, $titulo, $direccion, $telefono, $email, $acc_exterior, $acc_interior, $imagen, $subcategoria, $comentarios_extra, $fecha_creacion, $bano);

    //echo json_encode($id_usuario." ".$latitud." ".$longitud." ".$titulo." ".$direccion." ".$telefono." ".$email." ".$acc_exterior." ".$acc_interior." ".$imagen." ".$subcategoria." ".$comentarios_extra." ".$fecha_creacion." ".$bano);

}elseif ($markerType == "barrier") {



	addBarrier($id_usuario, $latitud, $longitud, $tipo, $descripcion, $imagen, $fecha_creacion);
    //echo json_encode($id_usuario." ".$latitud." ".$longitud." ".$tipo." ".$descripcion." ".$imagen." ".$fecha_creacion);


}elseif ($markerType == "parking") {



	addParking($id_usuario, $latitud, $longitud, $cant_est_tot, $cant_est_res, $comentarios, $cumple_ordenanza, $fecha_creacion);

    //echo json_encode($id_usuario." ".$latitud." ".$longitud." ".$cant_est_tot." ".$cant_est_res." ".$comentarios." ".$cumple_ordenanza." ".$fecha_creacion);

}











?>