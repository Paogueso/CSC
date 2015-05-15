<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$partido = $data->partido->idPartido;



$result = finalizar($partido);


if ($result != null) {
   
    header('Content-Type: application/json');
    if ($result) {
        $arr = array('msg' => true, 'error' => '');
        $jsn = json_encode($arr);
        print_r($jsn);
    } else {
        $arr = array('msg' => "", 'error' => 'Error In inserting record');
        $jsn = json_encode($arr);
        print_r($jsn);
    }
} else {
    $arr = array('msg' => "", 'error' => 'User Already exists with same email');
    $jsn = json_encode($arr);
    print_r($jsn);
}

function finalizar($partido)
{   
        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare(" UPDATE partido SET finalizado=1 WHERE idPartido=:idPartido");
            $stmt->bindParam(':idPartido', $partido, PDO::PARAM_STR, 50);
            
            $stmt->execute();

            $dbh = null;
            return true;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo "crearsat";
            $exito=false;
        }
        return null;
}

?>
