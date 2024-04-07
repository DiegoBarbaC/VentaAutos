<?php
include ("conn.php");
$data =json_decode(file_get_contents("php://input"),true);
if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion =="leer"){

        $sql = "select * from cliente where 1";
        $result =$db->query($sql);

        if($result->num_rows>0){
            while($fila = $result-> fetch_assoc()){
                $item["cliente_id"]=$fila ["cliente_id"];
                $item["nombre"]=$fila ["nombre"];
                $item["correo"]=$fila ["correo"];
                $arrClientes[]= $item;
            }
            $response["status"]= "ok";
            $response["mensaje"]= $arrClientes;
            

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
        $nombre = $data["nombre"];
        $correo = $data["correo"];
        


        $qry = "INSERT INTO cliente (nombre, correo) values ('$nombre','$correo')";
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
        $nombre = $data["nombre"];
        $correo = $data["correo"];
        $qry = "update cliente set nombre='$nombre', correo='$correo' where cliente_id = '$cliente_id'";
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
        
        $qry = "delete from cliente where cliente_id = '$cliente_id'";
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

