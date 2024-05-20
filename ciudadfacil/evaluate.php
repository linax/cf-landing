<?php



  



require_once 'config.php';

$id_usuario = $_POST['id_usuario'];

$tipo_marcador = $_POST['tipo_marcador'];

$id_marcador = $_POST['id_marcador'];

$evaluacion = $_POST['evaluacion'];
/*$id_usuario = '26';

$tipo_marcador = 'estacionamiento';

$id_marcador = '1';

$evaluacion = '1';*/

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");

mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);

function startTransaction()

{

    mysql_query("START TRANSACTION");

}

function breakTransaction($str = "")

{

    $msg = "Transaccion abortada debido a un error: ".mysql_error();

    mysql_query("ROLLBACK");

    echo "ROLLBACK";

}

function commitTransaction()

{

    mysql_query("COMMIT");

    echo "1";

}



function evaluate($id_usuario, $id_marcador, $tipo_marcador, $evaluacion){

    $sql = "";
    if ($tipo_marcador === "lugar"){
        $sql = "SELECT tipo_evaluacion FROM Evaluacion_usuario_lugar WHERE id_lugar = '$id_marcador' and id_usuario = '$id_usuario'";
    }elseif ($tipo_marcador === "barrera"){
        $sql = "SELECT tipo_evaluacion FROM Evaluacion_usuario_barrera WHERE id_barrera = '$id_marcador' and id_usuario = '$id_usuario'";
    }else{
        if ($tipo_marcador === "estacionamiento"){
            $sql = "SELECT tipo_evaluacion FROM Evaluacion_usuario_estacionamiento WHERE id_estacionamiento = '$id_marcador' and id_usuario = '$id_usuario'";
        }
    }
    $query_ifEvaluated = mysql_query($sql);
    //echo mysql_num_rows($query_ifEvaluated);
    if(mysql_num_rows($query_ifEvaluated) == 0){
       $tipo_evaluacion = "";
    }else{

        $line_ifEvaluated = mysql_fetch_array($query_ifEvaluated, MYSQL_ASSOC);

        foreach ($line_ifEvaluated as $col_value) {

            $tipo_evaluacion = $col_value;

        }
    }

    
    //echo "tipo_evaluacion: ".$tipo_evaluacion. " | ";
    $status = "";

    if ($tipo_evaluacion === ""){

       $status = "1"; //No evaluado, hay que insertar

    }else{

        if ($evaluacion === $tipo_evaluacion){

            $status = "0"; //Intenta hacer la misma evaluacion

        }else{

            $status = "2"; //Hay que hacer update

        }

    }

    if ($status === "1"){

        startTransaction();
        //insertar evaluacion

        if ($tipo_marcador === "lugar"){

            $sql = "INSERT INTO Evaluacion_usuario_lugar(id_lugar, id_usuario, tipo_evaluacion) 
                 VALUES('".$id_marcador."','".$id_usuario."', '".$evaluacion."')";

            $query_insertar_evaluacion = mysql_query($sql) or die( breakTransaction() );

            $sql = "SELECT id_datos_lugar FROM Lugar WHERE id_lugar = '$id_marcador'";

            $query_datos = mysql_query($sql);

            $line = mysql_fetch_array($query_datos, MYSQL_ASSOC);

            foreach ($line as $col_value) {

                $id_datos_lugar = $col_value;

            }
            
            if ($evaluacion === "0"){
                
                $sql = "UPDATE Datos_lugar SET ev_negativa=ev_negativa+1 WHERE id_datos_lugar = '$id_datos_lugar'";
        
            }elseif ($evaluacion === "1") {

                $sql = "UPDATE Datos_lugar SET ev_positiva=ev_positiva+1 WHERE id_datos_lugar = '$id_datos_lugar'";

            }

            $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

        }elseif ($tipo_marcador === "barrera") {

            $sql = "INSERT INTO Evaluacion_usuario_barrera(id_barrera, id_usuario, tipo_evaluacion) 
                 VALUES('".$id_marcador."','".$id_usuario."', '".$evaluacion."')";

            $query_insertar_evaluacion = mysql_query($sql) or die( breakTransaction() );

            $sql = "SELECT id_datos_barrera FROM Barrera WHERE id_barrera = '$id_marcador'";

            $query_datos = mysql_query($sql);

            $line = mysql_fetch_array($query_datos, MYSQL_ASSOC);

            foreach ($line as $col_value) {

                $id_datos_barrera = $col_value;

            }

            if ($evaluacion === "0"){
                
                $sql = "UPDATE Datos_barrera SET ev_negativa=ev_negativa+1 WHERE id_datos_barrera = '$id_datos_barrera'";
        
            }elseif ($evaluacion === "1") {

                $sql = "UPDATE Datos_barrera SET ev_positiva=ev_positiva+1 WHERE id_datos_barrera = '$id_datos_barrera'";

            }

            $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

        }else{
            if ($tipo_marcador === "estacionamiento") {

                $sql = "INSERT INTO Evaluacion_usuario_estacionamiento(id_estacionamiento, id_usuario, tipo_evaluacion) 
                 VALUES('".$id_marcador."','".$id_usuario."', '".$evaluacion."')";

                $query_insertar_evaluacion = mysql_query($sql) or die( breakTransaction() );

                $sql = "SELECT id_datos_estacionamiento FROM Estacionamiento WHERE id_estacionamiento = '$id_marcador'";

                $query_datos = mysql_query($sql);

                $line = mysql_fetch_array($query_datos, MYSQL_ASSOC);

                foreach ($line as $col_value) {

                    $id_datos_estacionamiento = $col_value;

                }

                if ($evaluacion === "0"){
                
                    $sql = "UPDATE Datos_estacionamiento SET ev_negativa=ev_negativa+1 WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";
        
                }elseif ($evaluacion === "1") {

                    $sql = "UPDATE Datos_estacionamiento SET ev_positiva=ev_positiva+1 WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";

                }

                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

            }
        }

        commitTransaction();

    }elseif ($status === "2") {
        startTransaction();

        if ($tipo_marcador === "lugar"){

            $sql = "UPDATE Evaluacion_usuario_lugar SET tipo_evaluacion='$evaluacion' WHERE id_lugar = '$id_marcador' and id_usuario = '$id_usuario'";
        
            $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

            //echo 'update lugar | ';

            $sql = "SELECT id_datos_lugar FROM Lugar WHERE id_lugar = '$id_marcador'";

            $query_datos = mysql_query($sql);

            $line = mysql_fetch_array($query_datos, MYSQL_ASSOC);

            foreach ($line as $col_value) {

                $id_datos_lugar = $col_value;

            }
            
            if ($evaluacion === "0"){
                
                $sql = "UPDATE Datos_lugar SET ev_negativa=ev_negativa+1 WHERE id_datos_lugar = '$id_datos_lugar'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
                $sql = "UPDATE Datos_lugar SET ev_positiva=ev_positiva-1 WHERE id_datos_lugar = '$id_datos_lugar'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
        
            }elseif ($evaluacion === "1") {

                $sql = "UPDATE Datos_lugar SET ev_positiva=ev_positiva+1 WHERE id_datos_lugar = '$id_datos_lugar'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
                $sql = "UPDATE Datos_lugar SET ev_negativa=ev_negativa-1 WHERE id_datos_lugar = '$id_datos_lugar'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

            }
            

        }elseif ($tipo_marcador === "barrera") {
            
            $sql = "UPDATE Evaluacion_usuario_barrera SET tipo_evaluacion='$evaluacion' WHERE id_barrera = '$id_marcador' and id_usuario = '$id_usuario'";
        
            $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

            //echo 'update barrera | ';

            $sql = "SELECT id_datos_barrera FROM Barrera WHERE id_barrera = '$id_marcador'";

            $query_datos = mysql_query($sql);

            $line = mysql_fetch_array($query_datos, MYSQL_ASSOC);

            foreach ($line as $col_value) {

                $id_datos_barrera = $col_value;

            }
            
            if ($evaluacion === "0"){
                
                $sql = "UPDATE Datos_barrera SET ev_negativa=ev_negativa+1 WHERE id_datos_barrera = '$id_datos_barrera'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
                $sql = "UPDATE Datos_barrera SET ev_positiva=ev_positiva-1 WHERE id_datos_barrera = '$id_datos_barrera'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
        
            }elseif ($evaluacion === "1") {

                $sql = "UPDATE Datos_barrera SET ev_positiva=ev_positiva+1 WHERE id_datos_barrera = '$id_datos_barrera'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
                $sql = "UPDATE Datos_barrera SET ev_negativa=ev_negativa-1 WHERE id_datos_barrera = '$id_datos_barrera'";
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

            }

        }else{
            if ($tipo_marcador === "estacionamiento") {
                
                $sql = "UPDATE Evaluacion_usuario_estacionamiento SET tipo_evaluacion='$evaluacion' WHERE id_estacionamiento = '$id_marcador' and id_usuario = '$id_usuario'";
        
                $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

                //echo 'update estacionamiento | ';
                $sql = "SELECT id_datos_estacionamiento FROM Estacionamiento WHERE id_estacionamiento = '$id_marcador'";

                $query_datos = mysql_query($sql);

                $line = mysql_fetch_array($query_datos, MYSQL_ASSOC);

                foreach ($line as $col_value) {

                    $id_datos_estacionamiento = $col_value;

                }

                if ($evaluacion === "0"){
                
                    $sql = "UPDATE Datos_estacionamiento SET ev_negativa=ev_negativa+1 WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";
                    $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
                    $sql = "UPDATE Datos_estacionamiento SET ev_positiva=ev_positiva-1 WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";
                    $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
        
                }elseif ($evaluacion === "1") {

                    $sql = "UPDATE Datos_estacionamiento SET ev_positiva=ev_positiva+1 WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";
                    $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );
                    $sql = "UPDATE Datos_estacionamiento SET ev_negativa=ev_negativa-1 WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";
                    $query_update_evaluacion = mysql_query($sql) or die( breakTransaction() );

                }

            }
        }

        commitTransaction();
    }else{

        if ($status === "0") {

            echo "0";

        }

    }
    
}

evaluate($id_usuario, $id_marcador, $tipo_marcador, $evaluacion);