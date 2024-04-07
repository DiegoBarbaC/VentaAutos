<?php
include ("conn.php");
$data =json_decode(file_get_contents("php://input"),true);
if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion =="leer"){

        $sql = "select * from auto_cliente where 1";
        $result =$db->query($sql);

        if($result->num_rows>0){
            while($fila = $result-> fetch_assoc()){
                $item["cliente_id"]=$fila ["cliente_id"];
                $item["auto_id"]=$fila ["auto_id"];
                $item["fecha_registro"]=$fila ["fecha_registro"];
                $arrAutoCliente[]= $item;
            }
            $response["status"]= "ok";
            $response["mensaje"]= $arrAutoCliente;
            

        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay clientes registrados";
        }
        header("Content-Type:application/json");
        echo json_encode($response);
    }
    if($accion =="join"){

        $sql = "SELECT cliente.nombre AS cliente, auto.marca, auto.modelo, auto.año, auto.num_serie
        FROM cliente
        INNER JOIN auto_cliente ON cliente.cliente_id = auto_cliente.cliente_id
        INNER JOIN auto ON auto_cliente.auto_id = auto.auto_id;
        ";
        $result =$db->query($sql);

        if($result->num_rows>0){
            while($fila = $result-> fetch_assoc()){
                $item["cliente"]=$fila ["cliente"];
                $item["marca"]=$fila ["marca"];
                $item["modelo"]=$fila ["modelo"];
                $item["año"]=$fila ["año"];
                $item["num_serie"]=$fila ["num_serie"];
                $arrJoin[]= $item;
            }
            $response["status"]= "ok";
            $response["mensaje"]= $arrJoin;
            

        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay clientes registrados";
        }
        header("Content-Type:application/json");
        echo json_encode($response);
    }
    
    
    
}

$data = json_decode(file_get_contents('php://input'), true);

//Si yo paso los datos como JSON a traves del body
if(isset($data)) {

    //obtengo la accion
    $accion = $data["accion"];

    //verifico el tipo de accion
    if($accion=='insertar') {

        //obtener los demas datos del body
        $cliente_id = $data["cliente_id"];
        $auto_id = $data["auto_id"];
        $fecha_registro = $data["fecha_registro"];

        


        $qry = "INSERT INTO auto_cliente (cliente_id, auto_id, fecha_registro) values ('$cliente_id','$auto_id','$fecha_registro')";
        if($db->query($qry)) {
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se creo correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo guardar el registro debido a un error';
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }
    if($accion=="modificar"){
        $cliente_id=$data["cliente_id"];
        $auto_id = $data["auto_id"];
        $fecha_registro = $data["fecha_registro"];
        $qry = "update auto_cliente set cliente_id='$cliente_id', auto_id='$auto_id', fecha_registro='$fecha_registro' where cliente_id = '$cliente_id' and auto_id= '$auto_id'";
        if($db->query($qry)) {
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se modifico correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo modificar el registro debido a un error';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if($accion=="borrar"){
        $cliente_id=$data["cliente_id"];
        $auto_id=$data["auto_id"];

        
        $qry = "delete from auto_cliente where cliente_id = '$cliente_id' and auto_id= '$auto_id'";
        if($db->query($qry)) {
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se borro correctamente';
        } else {
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'No se pudo borrar el registro debido a un error';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}