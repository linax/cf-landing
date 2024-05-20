<?php
//Usado desde la web
require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT dl.id_datos_lugar as id_datos_lugar, dl.latitud as latitud, dl.longitud as longitud, dl.titulo as titulo, dl.direccion as dir, dl.imagen as img, a.acc_exterior as acc_ext, a.acc_interior as acc_int
  FROM Lugar l, Datos_lugar dl,  Accesibilidad a WHERE 
		l.id_lugar=dl.id_datos_lugar
		AND l.id_accesibilidad = a.id_accesibilidad";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_datos_lugar = $row['id_datos_lugar'];

                $latitud = $row['latitud'];

                $longitud = $row['longitud'];

                $titulo = $row['titulo'];

                $dir= $row['dir'];

                $img = $row['img'];

                $acc_ext = $row['acc_ext'];

                $acc_int = $row['acc_int'];

                $data= array("id_datos_lugar"=>$id_datos_lugar,
                                "latitud"=>$latitud,
                                "longitud"=>$longitud,
                                "titulo"=>$titulo,
                                "dir"=>$dir,
                                "img"=>$img,
                                "acc_ext"=>$acc_ext,
                                "acc_int"=>$acc_int);

                $datos_lugar[] = $data;

    }

    $datos_lugares = array("datos_lugares"=>$datos_lugar);

    echo json_encode($datos_lugares);

    //echo "<pre>";

    //print_r($lugares);

}

?>