<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$jugador = $data->jugador->idPersona;
$id = $data->id;

$res = insjug($jugador,$id);

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

function insjug($jugador,$equipo)
{   

        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("INSERT INTO inscrito(Posicion, equipo_idEquipo, persona_idPersona) VALUES ('9', :idequipo, :idpersona)");
            $stmt->bindParam(':idequipo', $equipo, PDO::PARAM_STR, 50);
            $stmt->bindParam(':idpersona', $jugador, PDO::PARAM_STR, 50);

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
