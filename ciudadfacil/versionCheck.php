<?php



    

require_once 'config.php';



$version = $_POST['version'];



/*$version = '2'*/

    

//connection to the database

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");



mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);

mysql_query("SET NAMES 'utf8'");



function checkVersion($version){

    $sql = "SELECT Numero_version FROM Version";

    $query_version_num = mysql_query($sql);

    $line = mysql_fetch_array($query_version_num, MYSQL_ASSOC);

    $app_version ="";

    foreach ($line as $col_value) {

        //echo "</br>$col_value</br>";

        $app_version = $col_value;

    }



    if ($version < $app_version){

        //0: version antigua

        echo "0";

    }else{

        //1: misma version

        echo "1";

    }

    

}



checkVersion($version);