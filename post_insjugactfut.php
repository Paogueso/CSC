<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$jugador = $data->jugador;



$result = crearstat($jugador);


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

function crearstat($jugador)
{   
        try {

            $dbh =conectarbase(); 
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare(" UPDATE stat_fut SET tiempo_juego=:tiempo_juego, Gol=:gol, tiros_a_puerta=:tiros_a_puerta, tiros_desviados=:tiros_desviados, tiros_por=:tiros_por, pases=:pases, asistencias=:asistencias, faltas=:faltas, fuera_lugar=:fuera_lugar, barridas=:barridas, amarillas=:amarillas, rojas=:rojas WHERE Jugador_idJugador=:idJugador AND Partido_idPartido=:idPartido");
            $stmt->bindParam(':tiempo_juego', $jugador->tiempo_juego, PDO::PARAM_STR, 50);
            $stmt->bindParam(':gol', $jugador->Gol, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_a_puerta', $jugador->tiros_a_puerta, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_desviados', $jugador->tiros_desviados, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_por', $jugador->tiros_por, PDO::PARAM_STR, 50);
            $stmt->bindParam(':pases', $jugador->pases, PDO::PARAM_STR, 50);
            $stmt->bindParam(':asistencias', $jugador->asistencias, PDO::PARAM_STR, 50);
            $stmt->bindParam(':faltas', $jugador->faltas, PDO::PARAM_STR, 50);
            $stmt->bindParam(':fuera_lugar', $jugador->fuera_lugar, PDO::PARAM_STR, 50);
            $stmt->bindParam(':barridas', $jugador->barridas, PDO::PARAM_STR, 50);
            $stmt->bindParam(':amarillas', $jugador->amarillas, PDO::PARAM_STR, 50);
            $stmt->bindParam(':rojas', $jugador->rojas, PDO::PARAM_STR, 50);
            $stmt->bindParam(':idJugador', $jugador->Jugador_idJugador, PDO::PARAM_STR, 50);
            $stmt->bindParam(':idPartido', $jugador->Partido_idPartido, PDO::PARAM_STR, 50);
            
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
