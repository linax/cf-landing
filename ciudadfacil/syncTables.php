<?php



require_once 'config.php';



$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

$mysqli->set_charset("utf8");



$categoryTable = $_POST["categoryTable"];

$subcategoryTable = $_POST["subcategoryTable"];

$accessibilityTable = $_POST["accessibilityTable"];

$placedataTable = $_POST["placedataTable"];

$placeTable = $_POST["placeTable"];

$barrierdataTable = $_POST["barrierdataTable"];

$barrierTable = $_POST["barrierTable"];

$parkingdataTable = $_POST["parkingdataTable"];

$parkingTable = $_POST["parkingTable"];

//echo json_encode($categoryTable.$subcategoryTable.$accessibilityTable.$placedataTable.$placeTable.$barrierdataTable.$barrierTable.$parkingdataTable.$parkingTable);



function getTableCategoria($mysqli){

	$sql = "SELECT * FROM Categoria";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_categoria = $row['id_categoria'];



	                $nombre_categoria = $row['nombre_categoria'];





	                $data= array("id_categoria"=>$id_categoria,"nombre_categoria"=>$nombre_categoria);



	                $categoria[] = $data;



	    }



	    $categorias = array("categorias"=>$categoria);



	    echo json_encode($categorias);



	    //echo "<pre>";



	    //print_r($categorias);



	}

}



function getTableSubcategoria($mysqli){

	$sql = "SELECT * FROM Subcategoria";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_subcategoria = $row['id_subcategoria'];



	                $id_categoria = $row['id_categoria'];



	                $nombre_subcategoria = $row['nombre_subcategoria'];



	                $data= array("id_subcategoria"=>$id_subcategoria,"id_categoria"=>$id_categoria,"nombre_subcategoria"=>$nombre_subcategoria);



	                $subcategoria[] = $data;



	    }



	    $subcategorias = array("subcategorias"=>$subcategoria);



	    echo json_encode($subcategorias);



	    //echo "<pre>";



	    //print_r($subcategorias);



	}

}



function getTableAccesibilidad($mysqli){

	$sql = "SELECT * FROM Accesibilidad";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_accesibilidad = $row['id_accesibilidad'];



	                $acc_exterior = $row['acc_exterior'];



	                $acc_interior = $row['acc_interior'];



	                $bano = $row['bano'];



	                $data= array("id_accesibilidad"=>$id_accesibilidad,

	                                "acc_exterior"=>$acc_exterior,

	                                "acc_interior"=>$acc_interior,

	                                "bano"=>$bano);



	                $accesibilidad_lugar[] = $data;



	    }



	    $accesibilidad_lugares = array("accesibilidad_lugares"=>$accesibilidad_lugar);



	    echo json_encode($accesibilidad_lugares);



	    //echo "<pre>";



	    //print_r($lugares);



	}

}



function getTableLugar($mysqli){



	$sql = "SELECT * FROM Lugar";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_lugar = $row['id_lugar'];



	                $id_datos_lugar = $row['id_datos_lugar'];



	                $id_accesibilidad = $row['id_accesibilidad'];



	                $id_usuario = $row['id_usuario'];



	                $id_subcategoria = $row['id_subcategoria'];



	                $fecha_creacion = $row['fecha_creacion'];

					$sql_datos_usuario = "SELECT usuario FROM Usuario WHERE id_usuario = '$id_usuario'";

	                if($res_datos_usuario = $mysqli->query($sql_datos_usuario)){
	                

	                    while($row_datos_usuario =$res_datos_usuario->fetch_assoc()){
	                
	                        $usuario = $row_datos_usuario['usuario'];

	                    }

	                }

	                $data= array("id_lugar"=>$id_lugar,"id_datos_lugar"=>$id_datos_lugar,"id_accesibilidad"=>$id_accesibilidad,"id_usuario"=>$id_usuario,"id_subcategoria"=>$id_subcategoria,"fecha_creacion"=>$fecha_creacion, "username"=>$usuario);



	                $lugar[] = $data;



	    }



	    $lugares = array("lugares"=>$lugar);



	    echo json_encode($lugares);



	    //echo "<pre>";



	    //print_r($lugares);



	}



}



function getTableBarrera($mysqli){

	$sql = "SELECT * FROM Barrera";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_barrera = $row['id_barrera'];



	                $id_datos_barrera = $row['id_datos_barrera'];



	                $id_usuario = $row['id_usuario'];



	                $fecha_creacion = $row['fecha_creacion'];


	                $sql_datos_usuario = "SELECT usuario FROM Usuario WHERE id_usuario = '$id_usuario'";

	                if($res_datos_usuario = $mysqli->query($sql_datos_usuario)){
	                

	                    while($row_datos_usuario =$res_datos_usuario->fetch_assoc()){
	                
	                        $usuario = $row_datos_usuario['usuario'];

	                    }

	                }

	                $data= array("id_barrera"=>$id_barrera,"id_datos_barrera"=>$id_datos_barrera,"id_usuario"=>$id_usuario,"fecha_creacion"=>$fecha_creacion, "username"=>$usuario);



	                $barrera[] = $data;



	    }



	    $barreras = array("barreras"=>$barrera);



	    echo json_encode($barreras);



	    //echo "<pre>";



	    //print_r($lugares);



	}

}



function getTableEstacionamiento($mysqli){



	$sql = "SELECT * FROM Estacionamiento";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_estacionamiento = $row['id_estacionamiento'];



	                $id_datos_estacionamiento = $row['id_datos_estacionamiento'];



	                $id_usuario = $row['id_usuario'];



	                $fecha_creacion = $row['fecha_creacion'];


	                $sql_datos_usuario = "SELECT usuario FROM Usuario WHERE id_usuario = '$id_usuario'";

	                if($res_datos_usuario = $mysqli->query($sql_datos_usuario)){
	                

	                    while($row_datos_usuario =$res_datos_usuario->fetch_assoc()){
	                
	                        $usuario = $row_datos_usuario['usuario'];

	                    }

	                }

	                $data= array("id_estacionamiento"=>$id_estacionamiento,

	                                "id_datos_estacionamiento"=>$id_datos_estacionamiento,

	                                "id_usuario"=>$id_usuario,

	                                "fecha_creacion"=>$fecha_creacion,

	                                "username"=>$usuario);



	                $estacionamiento[] = $data;



	    }



	    $estacionamientos = array("estacionamientos"=>$estacionamiento);



	    echo json_encode($estacionamientos);



	    //echo "<pre>";



	    //print_r($lugares);



	}



}



function getTableDatosLugar($mysqli){



	$sql = "SELECT * FROM Datos_lugar";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_datos_lugar = $row['id_datos_lugar'];



	                $latitud = $row['latitud'];



	                $longitud = $row['longitud'];



	                $titulo = $row['titulo'];



	                $direccion = $row['direccion'];



	                $telefono = $row['telefono'];



	                $email = $row['email'];



	                $imagen = $row['imagen'];



	                $comentarios_extra = $row['comentarios_extra'];

	                $data= array("id_datos_lugar"=>$id_datos_lugar,

	                                "latitud"=>$latitud,

	                                "longitud"=>$longitud,

	                                "titulo"=>$titulo,

	                                "direccion"=>$direccion,

	                                "telefono"=>$telefono,

	                                "email"=>$email,

	                                "imagen"=>$imagen,

	                                "comentarios_extra"=>$comentarios_extra);



	                $datos_lugar[] = $data;



	    }



	    $datos_lugares = array("datos_lugares"=>$datos_lugar);



	    echo json_encode($datos_lugares);



	    //echo "<pre>";



	    //print_r($lugares);



	}

}



function getTableDatosBarrera($mysqli){



	$sql = "SELECT * FROM Datos_barrera";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_datos_barrera = $row['id_datos_barrera'];



	                $latitud = $row['latitud'];



	                $longitud = $row['longitud'];



	                $tipo = $row['tipo'];



	                $descripcion = $row['descripcion'];



	                $imagen = $row['imagen'];


	                $data= array("id_datos_barrera"=>$id_datos_barrera,

	                                "latitud"=>$latitud,

	                                "longitud"=>$longitud,

	                                "tipo"=>$tipo,

	                                "descripcion"=>$descripcion,

	                                "imagen"=>$imagen);



	                $datos_barrera[] = $data;



	    }



	    $datos_barreras = array("datos_barreras"=>$datos_barrera);



	    echo json_encode($datos_barreras);



	    //echo "<pre>";



	    //print_r($lugares);



	}

}



function getTableDatosEstacionamiento($mysqli){



	$sql = "SELECT * FROM Datos_estacionamiento";



	if($res = $mysqli->query($sql)){



	    while($row=$res->fetch_assoc()){



	                $id_datos_estacionamiento = $row['id_datos_estacionamiento'];



	                $latitud = $row['latitud'];



	                $longitud = $row['longitud'];



	                $cant_est_total = $row['cant_est_total'];



	                $cant_est_reservados = $row['cant_est_reservados'];



	                $cumple_ordenanza = $row['cumple_ordenanza'];



	                $comentarios = $row['comentarios'];


	                $data= array("id_datos_estacionamiento"=>$id_datos_estacionamiento,

	                                "latitud"=>$latitud,

	                                "longitud"=>$longitud,

	                                "cant_est_total"=>$cant_est_total,

	                                "cant_est_reservados"=>$cant_est_reservados,

	                                "cumple_ordenanza"=>$cumple_ordenanza,

	                                "comentarios"=>$comentarios);



	                $datos_estacionamiento[] = $data;



	    }



	    $datos_estacionamientos = array("datos_estacionamientos"=>$datos_estacionamiento);



	    echo json_encode($datos_estacionamientos);



	    //echo "<pre>";



	    //print_r($lugares);



	}

}



$echoResults = "";



for ($i = 0; $i <= 8; $i++) {

	$echoMysql = "";



    if ($i == 0 && $categoryTable == "1") {



		ob_start();

		getTableCategoria($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 1 && $subcategoryTable == "1") {



		ob_start();

		getTableSubcategoria($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 2 && $accessibilityTable == "1") {



		ob_start();

		getTableAccesibilidad($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 3 && $placedataTable == "1") {



		ob_start();

		getTableDatosLugar($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 4 && $placeTable == "1") {



		ob_start();

		getTableLugar($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 5 && $barrierdataTable == "1") {



		ob_start();

		getTableDatosBarrera($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 6 && $barrierTable == "1") {



		ob_start();

		getTableBarrera($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 7 && $parkingdataTable == "1") {



		ob_start();

		getTableDatosEstacionamiento($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}elseif ($i == 8 && $parkingTable == "1") {



		ob_start();

		getTableEstacionamiento($mysqli);

		$echoMysql = ob_get_contents();

		ob_end_clean();

		if($echoResults != ""){

		$echoResults = $echoResults."*".$echoMysql;

		}else{

			$echoResults = $echoMysql;

		}



	}
}



echo $echoResults;



?>