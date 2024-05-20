<?php







require_once 'config.php';





$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

$mysqli->set_charset("utf8");



$sql = "select email from Usuario";



$count = 0;



$lista_email = "";

if($res = $mysqli->query($sql)){



    while($row=$res->fetch_assoc()){



                $count = $count + 1;



                $lista_email = $lista_email.", ".$row['email'];



    }



    $data= array("cantidad_de_usuarios"=>$count,"lista_email"=>$lista_email);



    $datos[] = $data;



    echo "<pre>";



    print_r($datos);



}











?>



