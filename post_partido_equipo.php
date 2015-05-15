<?php
include_once 'conn.php';
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;



$res = equipos($id);

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

function equipos($id)
{   
        try {

            $dbh =conectarbase();
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $dbh->prepare("SELECT * FROM partido, equipo where idEquipo in (equipo_idEquipo1,equipo_idEquipo2) and idPartido=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR, 50);
            
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
