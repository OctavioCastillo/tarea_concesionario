<?php

//include() para importar archivo
include('conn.php'); 

$data = json_decode(file_get_contents('php://input'), true);

//función para verificar que tiene un valor
if(isset($data)){

    $accion = $data['accion'];


    if($accion == 'leer') {

        $sql = "SELECT * FROM autos WHERE 1";
        $result = $db->query($sql);


        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id_auto'];
                $item['marca'] = $fila['marca'];
                $item['año'] = $fila['año'];
                $item['no_serie'] = $fila['no_serie'];
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
        
        $marca = $data["marca"];
        $año = $data["año"];
        $no_serie = $data["no_serie"];

        $qry = "insert into autos (marca, año, no_serie) values ('$marca', '$año', '$no_serie')";

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
        $marca = $data["marca"];
        $año = $data["año"];
        $no_serie = $data["no_serie"];

        $qry = "UPDATE autos SET marca = '$marca', año = '$año', no_serie = '$no_serie' WHERE id_auto = $id";

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

        $qry = "delete from autos where id_auto = $id";

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
