<?php

//include() para importar archivo
include('conn.php'); 

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data)){

    $accion = $data['accion'];


    if($accion == 'leer') {

        $sql = "SELECT * FROM clientes WHERE 1";
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id_cliente'];
                $item['nombre'] = $fila['nombre'];
                $item['email'] = $fila['email'];
                $arrCliente[] = $item;
            }
            
            $response["status"] = "Okay";
            $response["mensaje"] = $arrCliente;

        } else {
            $response["status"] = "Error";
            $response["mensaje"] = "No hay registros";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'insertar') {
        
        $nombre = $data["nombre"];
        $email = $data["email"];

        $qry = "insert into clientes (nombre, email) values ('$nombre', '$email')";

        if($db->query($qry)){
            $response["status"] = "Ok";
            $response["mensaje"] = "El registro se creo correctamente";
        } else {
            $response["status"] = "ERROR";
            $response["mensaje"] = "No se pudo guardar el registro";
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }

    if($accion == 'modificar') {

        $id = $data["id"];
        $nombre = $data["nombre"];
        $email = $data["email"];

        $qry = "UPDATE clientes SET nombre = '$nombre', email = '$email' WHERE id_cliente = $id";

        if($db->query($qry)){
            $response["status"] = "Ok";
            $response["mensaje"] = "El registro se modificó correctamente";
        } else {
            $response["status"] = "ERROR";
            $response["mensaje"] = "No se pudo modificar el registro";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'borrar') {

        $id = $data["id"];

        $qry = "delete from clientes where id = $id";

        if($db->query($qry)){
            $response["status"] = "Ok";
            $response["mensaje"] = "El registro se eliminó correctamente";
        } else {
            $response["status"] = "ERROR";
            $response["mensaje"] = "No se pudo eliminar el registro";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
}


?>