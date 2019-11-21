<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
$response = array();
$upload_dir = 'uploads/';
$server_url = 'http://127.0.0.1:8000';
if ( isset($_FILES['image']['tmp_name']) ) {
    // open mysqli db connection
    $mysqli = new mysqli('127.0.0.1:3306','root','','images');

    // get image data
    $binary = file_get_contents($_FILES['image']['tmp_name']);

    // get mime type
    $finfo = new finfo(FILEINFO_MIME);
    $type = $finfo->file($_FILES['image']['tmp_name']);
    $mime = substr($type, 0, strpos($type, ';'));

    $query = "INSERT INTO `images` 
                    (`data`,`mime`,`name`) 
    VALUES('".$mysqli->real_escape_string($binary)."',
            '".$mysqli->real_escape_string($mime)."',
            '".$mysqli->real_escape_string($_FILES['image']['name'])."')";

    if($mysqli->query($query)){
        $response = array(
            "status" => "success",
            "error" => false,
            "message" => "File uploaded successfully",
        );
    }
    else{
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading the file!"
        );
    }
}
echo json_encode($response);
?>