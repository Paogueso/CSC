<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$jugador = $data->jugador;



$result = crearstat($jugador);




            //$tiempo = substr($tiempo, 0, strpos($tiempo, '('));

           

if ($result != null) {
   
    header('Content-Type: application/json');
    if ($result) {
        $arr = array('msg' => $result, 'error' => '');
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
            $tiempo=$jugador->tiempo_juego;
            //$tiempo = substr($tiempo, 0, strpos($tiempo, '('));

            


            $stmt = $dbh->prepare(" UPDATE stat_bkb SET tiempo_juego=:tiempo_juego, tiros_1=:tiros_1, tiros_fallados_1=:tiros_fallados_1, tiros_por_1=:tiros_por_1, tiros_2=:tiros_2, tiros_fallados_2=:tiros_fallados_2, tiros_por_2=:tiros_por_2, tiros_3=:tiros_3, tiros_fallados_3=:tiros_fallados_3, tiros_por_3=:tiros_por_3, asistencias=:asistencias, faltas=:faltas, perdidas=:perdidas, rebotes_def=:rebotes_def, rebotes_of=:rebotes_of, Faltas_of=:Faltas_of, Faltas_def=:Faltas_def WHERE Jugador_idJugador=:idJugador AND Partido_idPartido=:idPartido");
            $stmt->bindParam(':tiempo_juego', $tiempo, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_1', $jugador->tiros_1, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_fallados_1', $jugador->tiros_fallados_1, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_por_1', $jugador->tiros_por_1, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_2', $jugador->tiros_2, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_fallados_2', $jugador->tiros_fallados_2, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_por_2', $jugador->tiros_por_2, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_3', $jugador->tiros_3, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_fallados_3', $jugador->tiros_fallados_3, PDO::PARAM_STR, 50);
            $stmt->bindParam(':tiros_por_3', $jugador->tiros_por_3, PDO::PARAM_STR, 50);
            $stmt->bindParam(':asistencias', $jugador->asistencias, PDO::PARAM_STR, 50);
            $stmt->bindParam(':faltas', $jugador->faltas, PDO::PARAM_STR, 50);
            $stmt->bindParam(':perdidas', $jugador->perdidas, PDO::PARAM_STR, 50);
            $stmt->bindParam(':rebotes_def', $jugador->rebotes_def, PDO::PARAM_STR, 50);
            $stmt->bindParam(':rebotes_of', $jugador->rebotes_of, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Faltas_of', $jugador->Faltas_of, PDO::PARAM_STR, 50);
            $stmt->bindParam(':Faltas_def', $jugador->Faltas_def, PDO::PARAM_STR, 50);
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
