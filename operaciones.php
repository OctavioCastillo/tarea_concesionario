<?php

include('conn.php');

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data)) {

    $action = $data["action"];

    if ($action == 'filtrar') {
        $sql = "SELECT cl.nombre, a.marca, a.año, a.img FROM clientes cl INNER JOIN dueños d ON cl.id_cliente = d.id_cliente INNER JOIN autos a ON a.id_auto = d.id_auto WHERE cl.id_cliente = 1";
        $result = $db->query($sql);

        if($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
                $item['nombre'] = $row['nombre'];
                $item['marca'] = $row['marca'];
                $item['año'] = $row['año'];
                $item['img'] = $row['img'];
                $list[] = $item;
            }

            $response["status"] = "Okay";
            $response["mensaje"] = $list;

        } else {
            $response["status"] = "Error";
            $response["mensaje"] = "Error en la consulta SQL";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

echo $data
?>