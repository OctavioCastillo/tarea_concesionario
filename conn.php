<?php

$db_host = 'localhost';
$db_username = 'sa';
$db_password = 'Octavio.71534';
$db_database = 'concesionario';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);

mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die('Error de conexión ['.$db->connect_errno.']');
}
else{
    echo "Conexión exitosa";
}

?>