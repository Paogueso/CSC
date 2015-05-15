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
            
            $stmt = $dbh->prepare(" UPDATE stat_vb SET tiempo_juego=:tiempo_juego, Efect_Saque= :Efect_Saque, Bloqueo=:Bloqueo, Recepciones=:Recepciones, Puntos=:Puntos, Salvadas=:Salvadas WHERE Jugador_idJugador=:idJugador AND Partido_idPartido=:idPartido");
            $stmt->bindParam(':tiempo_juego', $jugador->tiempo_juego, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Efect_Saque', $jugador->Efect_Saque, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Bloqueo', $jugador->Bloqueo, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Recepciones', $jugador->Recepciones, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Puntos', $jugador->Puntos, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Salvadas', $jugador->Salvadas, PDO::PARAM_STR, 50);
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
