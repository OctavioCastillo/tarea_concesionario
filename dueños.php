<?php

//include() para importar archivo
include('conn.php'); 

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data)){

    $accion = $data['accion'];

    if ($accion == 'leer') {

        $sql = "SELECT * FROM dueños ORDER BY id";
        $result = $db->query($sql);


        //array donde se van a agregar los alumnos
        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['id_auto'] = $fila['id_auto'];
                $item['id_cliente'] = $fila['id_cliente'];
                $array[] = $item;
            }
            
            $response["status"] = "Okay";
            $response["mensaje"] = $array;

        } else {
            $response["status"] = "Error";
            $response["mensaje"] = "No hay registros";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    if ($accion == 'filtrar') {

        $user = $data['user'];

        $sql = "SELECT cl.nombre, cl.email, a.marca, a.año FROM clientes cl INNER JOIN dueños d ON cl.id_cliente = d.id_cliente INNER JOIN autos a ON a.id_auto = d.id_auto WHERE cl.nombre = '$user'";
        $result = $db->query($sql);


        //array donde se van a agregar los alumnos
        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['nombre'] = $fila['nombre'];
                $item['email'] = $fila['email'];
                $item['marca'] = $fila['marca'];
                $item['año'] = $fila['año'];
                $arrCarros[] = $item;
            }
            
            $response["status"] = "Okay";
            $response["mensaje"] = $arrCarros;

        } else {
            $response["status"] = "Error";
            $response["mensaje"] = "No hay registros";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'insertar') {
        
        $id_auto = $data["id_auto"];
        $id_cliente = $data["id_cliente"];

        $qry = "insert into dueños (id_auto, id_cliente) values ('$id_auto', '$id_cliente')";

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
        $id_auto = $data["id_auto"];
        $id_cliente = $data["id_cliente"];

        $qry = "UPDATE dueños SET id_auto = '$id_auto', id_cliente = '$id_cliente' WHERE id_auto = $id";

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

        $qry = "delete from dueños where id = $id";

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