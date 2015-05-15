<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$nombre = mysql_real_escape_string($data->nombre);

$res = jugadores($nombre);

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
    $arr = array('msg' => "", 'error' => 'User Already exists with same email'. $nombre);
    $jsn = json_encode($arr);
    print_r($jsn);
}

function jugadores($nombre)
{   

        try {

            $dbh =conectarbase();
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare("SELECT * FROM persona, inscrito, equipo WHERE idPersona= persona_idPersona and idEquipo=equipo_idEquipo and equipo.idEquipo = :idEquipo");
            $stmt->bindParam(':idEquipo', $nombre, PDO::PARAM_STR, 50);
            
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            $dbh = null;
            return $result;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            $exito=false;
        }
        return null;

}
?>
