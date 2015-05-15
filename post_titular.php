<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$jugador = $data->jugador;

$res = jugadores($jugador);

if ($res != null) {
   
    header('Content-Type: application/json');
    if ($res) {
        $arr = array('msg' => $res, 'error' => '');
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

function jugadores($jugador)
{   

        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare("UPDATE inscrito SET titular=:titular WHERE idInscrito=:idInscrito");
            $stmt->bindParam(':titular', $jugador->titular, PDO::PARAM_STR, 50);
            $stmt->bindParam(':idInscrito', $jugador->idInscrito, PDO::PARAM_STR, 50);
            
            $stmt->execute();
            $result = $stmt->fetchAll();

            $dbh = null;
            return 'true';
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            $exito=false;
        }
        return null;

}
?>
