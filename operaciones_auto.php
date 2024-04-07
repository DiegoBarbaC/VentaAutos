<?php
include ("conn.php");
$data =json_decode(file_get_contents("php://input"),true);
if(isset($_GET["accion"])){
    $accion = $_GET["accion"];

    if($accion =="leer"){

        $sql = "select * from auto where 1";
        $result =$db->query($sql);

        if($result->num_rows>0){
            while($fila = $result-> fetch_assoc()){
                $item["auto_id"]=$fila ["auto_id"];
                $item["marca"]=$fila ["marca"];
                $item["modelo"]=$fila ["modelo"];
                $item["año"]=$fila ["año"];
                $item["num_serie"]=$fila ["num_serie"];
                $arrAutos[]= $item;
            }
            $response["status"]= "ok";
            $response["mensaje"]= $arrAutos;
            

        } else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay autos registrados";
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
        $marca = $data["marca"];
        $modelo = $data["modelo"];
        $año = $data["año"];
        $num_serie = $data["num_serie"];


        $qry = "INSERT INTO auto (marca, modelo, año, num_serie) values ('$marca','$modelo','$año','$num_serie')";
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
        $auto_id=$data["auto_id"];
        $marca = $data["marca"];
        $año = $data["año"];
        $num_serie = $data["num_serie"];
        $qry = "update auto set marca='$marca', año='$año',num_serie='$num_serie' where auto_id = '$auto_id'";
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
        $auto_id=$data["auto_id"];
        
        $qry = "delete from auto where auto_id = '$auto_id'";
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

