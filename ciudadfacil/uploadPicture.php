<?php


$ftp_server = "linax.webfactional.com";
$ftp_username   = "nacko";
$ftp_password   =  "3gn1c34";

//setup of connection

$conn_id = ftp_connect($ftp_server) or die("could not connect to ".$ftp_server);

$target_path = "uploads/";

/* Add the original filename to our target path.  
Result is "uploads/filename.extension" */
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    //echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    //" has been uploaded";
   chmod ("uploads/".basename( $_FILES['uploadedfile']['name']), 0644);
   echo json_encode("1");
} else{
   // echo "There was an error uploading the file, please try again!";
   //echo "filename: " .  basename( $_FILES['uploadedfile']['name']);
   //echo "target_path: " .$target_path;
	echo json_encode("0");
}

?>