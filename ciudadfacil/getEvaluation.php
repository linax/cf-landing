<?php



$tipo_marcador = $_POST['tipo_marcador'];

$id_marcador = $_POST['id_marcador'];



function getEvaluation($id_marcador, $tipo_marcador){
    require_once 'config.php';

    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if ($tipo_marcador === "lugar"){

        $sql = "SELECT id_datos_lugar FROM Lugar WHERE id_lugar = '$id_marcador'";

        if($res = $mysqli->query($sql)){

            while($row=$res->fetch_assoc()){

                $id_datos_lugar = $row['id_datos_lugar'];

                $sql_datos = "SELECT ev_positiva, ev_negativa FROM Datos_lugar WHERE id_datos_lugar = '$id_datos_lugar'";

                if($res_datos = $mysqli->query($sql_datos)){

                    while($row_datos =$res_datos->fetch_assoc()){

                        $ev_positiva = $row_datos['ev_positiva'];

                        $ev_negativa = $row_datos['ev_negativa'];

                    }

                }
            }
        }

        
        
    }elseif ($tipo_marcador === "barrera"){


        $sql = "SELECT id_datos_barrera FROM Barrera WHERE id_barrera = '$id_marcador'";

        if($res = $mysqli->query($sql)){

            while($row=$res->fetch_assoc()){

                $id_datos_barrera = $row['id_datos_barrera'];

                $sql_datos = "SELECT ev_positiva, ev_negativa FROM Datos_barrera WHERE id_datos_barrera = '$id_datos_barrera'";

                if($res_datos = $mysqli->query($sql_datos)){

                    while($row_datos =$res_datos->fetch_assoc()){

                        $ev_positiva = $row_datos['ev_positiva'];

                        $ev_negativa = $row_datos['ev_negativa'];

                    }

                }
            }
        }

    }else{

        if ($tipo_marcador === "estacionamiento"){

            $sql = "SELECT id_datos_estacionamiento FROM Estacionamiento WHERE id_estacionamiento = '$id_marcador'";

            if($res = $mysqli->query($sql)){

                while($row=$res->fetch_assoc()){

                    $id_datos_estacionamiento = $row['id_datos_estacionamiento'];

                    $sql_datos = "SELECT ev_positiva, ev_negativa FROM Datos_estacionamiento WHERE id_datos_estacionamiento = '$id_datos_estacionamiento'";

                    if($res_datos = $mysqli->query($sql_datos)){

                        while($row_datos=$res_datos->fetch_assoc()){

                            $ev_positiva = $row_datos['ev_positiva'];

                            $ev_negativa = $row_datos['ev_negativa'];

                        }
                    }

                }
            }
        }

    }

    echo $ev_positiva."|".$ev_negativa;
}

getEvaluation($id_marcador, $tipo_marcador);