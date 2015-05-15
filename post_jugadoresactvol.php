<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$id = mysql_real_escape_string($data->id);
$partido=mysql_real_escape_string($data->partido);


$result = jugadores($id,$partido);
$res =null;

    foreach ($result as $row ) {
        crearstat($row['idPersona'],$partido);      

    }

$res = getjugstat($id,$partido);

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
function getjugstat($id,$idPartido)
{   
        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare("SELECT * FROM persona,stat_vb where idPersona in(select persona_idPersona from inscrito where equipo_idEquipo=:id and titular='1') and idPersona=stat_vb.jugador_idJugador and  partido_idPartido=:idPartido");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 50);
            $stmt->bindParam(':idPartido', $idPartido, PDO::PARAM_STR, 50);
            
            $stmt->execute();
            $result = $stmt->fetchAll();
           
            $dbh = null;
            return $result;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo "getjugtat";
            $exito=false;
        }
        return null;
}

function jugadores($id,$partido)
{   
        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare("SELECT * FROM persona, inscrito where idPersona=persona_idPersona and equipo_idEquipo=:id  and idPersona not in (select jugador_idJugador from stat_vb where stat_vb.jugador_idJugador=persona_idPersona and partido_idPartido=:partido)");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 50);
            $stmt->bindParam(':partido', $partido, PDO::PARAM_STR, 50);

            $stmt->execute();
            $result = $stmt->fetchAll();

            $dbh = null;
            return $result;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo "++++juadores";
            $exito=false;
        }
        return null;
}

function crearstat($id,$idPartido)
{   
        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare(" INSERT into stat_vb(tiempo_juego, Efect_Saque, Bloqueo, Recepciones, Puntos, Salvadas, Jugador_idJugador,Partido_idPartido) values ('0','0','0','0','0','0',:idJugador,:idPartido)");
            $stmt->bindParam(':idJugador', $id, PDO::PARAM_STR, 50);
            $stmt->bindParam(':idPartido', $idPartido, PDO::PARAM_STR, 50);
            
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
