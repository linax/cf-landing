<?php

require_once 'config.php';

$id_ruta = $_POST['id_ruta'];

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

function removeRoute($id_ruta){
    startTransaction();

    $sql = "SELECT archivo_xml FROM Ruta WHERE id_ruta = '$id_ruta';";

    $query_filename = mysql_query($sql) or die( breakTransaction() );

    $line = mysql_fetch_array($query_filename, MYSQL_ASSOC);

    $filename = $line['archivo_xml'];

    $target_path = "uploads/xml/";

    if (file_exists($target_path.$filename)) {

        //echo "The file $filename exists <br>" ;

        if(unlink($target_path.$filename)){

          //  echo "File Deleted. <br>";

        }

    } else {

        //echo "The file $filename does not exist <br>";

    }

    mysql_query("DELETE FROM Ruta WHERE id_ruta = '$id_ruta';") or die( breakTransaction() );

    commitTransaction();

}

removeRoute($id_ruta);



























































































