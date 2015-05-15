<?php
require "connsql.php";
require "fpdf17/fpdf.php";
if(isset($_GET['modo'])){
$modo = $_GET['modo']; 
     
    function repusuarioes(){

        class PDF extends FPDF{}

        $pdf=new PDF ('P', 'mm', 'Letter');
        $pdf->SetMargins(8, 10);
        $pdf->AliasNbPages();
        $pdf->AddPage();


        $query = mysql_query("SELECT * FROM usuario"); 


        $pdf->Image("images/CSC_01_opt.png", 50);
        $pdf->SetFont("Arial", "b", 12);
        $pdf->Cell(0, 19, utf8_decode("REPORTES USUARIOS"), 0, 1,'C');

        $x =$pdf->GetX();
        $y =$pdf->GetY();
        $pdf-> SetTextColor(255, 255, 255);
        $pdf->SetFont("Arial", "b", 10);
        $pdf->MultiCell(75, 5, utf8_decode("USUARIO"), 0, 1, 'L',0);
        $pdf->SetXY($x + 75, $y);
        $pdf->MultiCell(75, 5, utf8_decode("CORREO"), 0, 1, 'L',0);
        $pdf->SetXY($x + 150, $y);
        $pdf->MultiCell(50, 5, utf8_decode("TIPO"), 0, 1, 'L',0);
        $pdf->SetXY($x + 200, $y);
        $pdf->Ln();

        while($row = mysql_fetch_row($query)){
            $usuario = $row['1'];
            $correo = $row['3'];
            $tipo = $row['4'];

        $x =$pdf->GetX();
        $y =$pdf->GetY();
        $pdf-> SetFillColor(255, 255, 255);    
        $pdf-> SetTextColor(0, 0, 0);
        $pdf->SetFont("Arial", "b", 9);
        $pdf->MultiCell(75, 5, utf8_decode($usuario), 1, 1, 'L',0);
        $pdf->SetXY($x + 75, $y);
        $pdf->MultiCell(75, 5, utf8_decode($correo), 1, 1, 'L',0);
        $pdf->SetXY($x + 150, $y);
        $pdf->MultiCell(50, 5, utf8_decode($tipo), 1, 1, 'L',0);
        $pdf->SetXY($x + 200, $y);
        $pdf->Ln();
        }
        $pdf->Output();
    }
    
     function repequiposes(){

        class PDF extends FPDF{}

        $pdf=new PDF ('P', 'mm', 'Letter');
        $pdf->SetMargins(8, 10);
        $pdf->AliasNbPages();
        $pdf->AddPage();


        $query = mysql_query("SELECT equipo.Nombre, torneo.Nombre, torneo.Categoria, torneo.Deporte FROM ins_torneo INNER JOIN equipo ON equipo_idEquipo=idEquipo INNER JOIN torneo ON torneo_idTorneo=idTorneo WHERE equipo.activo='1'"); 


        $pdf->Image("images/CSC_01_opt.png", 50);
        $pdf->SetFont("Arial", "b", 12);
        $pdf->Cell(0, 19, utf8_decode("REPORTES EQUIPOS"), 0, 1,'C');

        $x =$pdf->GetX();
        $y =$pdf->GetY();
        $pdf-> SetTextColor(255, 255, 255);
        $pdf->SetFont("Arial", "b", 10);
        $pdf->MultiCell(60, 5, utf8_decode("Nombre Equipo"), 0, 1, 'L',0);
        $pdf->SetXY($x + 60, $y);
        $pdf->MultiCell(60, 5, utf8_decode("Nombre Torneo"), 0, 1, 'L',0);
        $pdf->SetXY($x + 120, $y);
        $pdf->MultiCell(35, 5, utf8_decode("Categoria"), 0, 1, 'L',0);
        $pdf->SetXY($x + 155, $y);
        $pdf->MultiCell(40, 5, utf8_decode("Deporte"), 0, 1, 'L',0);
        $pdf->SetXY($x + 195, $y);
        $pdf->Ln();

        while($row = mysql_fetch_row($query)){
            $nombreeq = $row['0'];
            $nombretor = $row['1'];
            $depor = $row['2'];
            $cat = $row['3'];

        $x =$pdf->GetX();
        $y =$pdf->GetY();
        $pdf-> SetFillColor(255, 255, 255);    
        $pdf-> SetTextColor(0, 0, 0);
        $pdf->SetFont("Arial", "b", 9);
        $pdf->MultiCell(60, 5, utf8_decode($nombreeq), 1, 1, 'L',0);
        $pdf->SetXY($x + 60, $y);
        $pdf->MultiCell(60, 5, utf8_decode($nombretor), 1, 1, 'L',0);
        $pdf->SetXY($x + 120, $y);
        $pdf->MultiCell(35, 5, utf8_decode($depor), 1, 1, 'L',0);
        $pdf->SetXY($x + 155, $y);
        $pdf->MultiCell(40, 5, utf8_decode($cat), 1, 1, 'L',0);
        $pdf->SetXY($x + 195, $y);
        $pdf->Ln();
        }
        $pdf->Output();
    }
    
function reptorneoes(){

        class PDF extends FPDF{}

        $pdf=new PDF ('P', 'mm', 'Letter');
        $pdf->SetMargins(8, 10);
        $pdf->AliasNbPages();
        $pdf->AddPage();


        $query = mysql_query("SELECT * FROM torneo WHERE activo='1'"); 


        $pdf->Image("images/CSC_01_opt.png", 50);
        $pdf->SetFont("Arial", "b", 12);
        $pdf->Cell(0, 19, utf8_decode("REPORTES TORNEOS"), 0, 1,'C');

        $x =$pdf->GetX();
        $y =$pdf->GetY();
        $pdf-> SetTextColor(255, 255, 255);
        $pdf->SetFont("Arial", "b", 10);
        $pdf->MultiCell(75, 5, utf8_decode("NOMBRE"), 0, 1, 'L',0);
        $pdf->SetXY($x + 75, $y);
        $pdf->MultiCell(75, 5, utf8_decode("CATEGORIA"), 0, 1, 'L',0);
        $pdf->SetXY($x + 150, $y);
        $pdf->MultiCell(50, 5, utf8_decode("DEPORTE"), 0, 1, 'L',0);
        $pdf->SetXY($x + 200, $y);
        $pdf->Ln();

        while($row = mysql_fetch_row($query)){
            $cat = $row['1'];
            $depo = $row['2'];
            $name = $row['3'];

        $x =$pdf->GetX();
        $y =$pdf->GetY();
        $pdf-> SetFillColor(255, 255, 255);    
        $pdf-> SetTextColor(0, 0, 0);
        $pdf->SetFont("Arial", "b", 9);
        $pdf->MultiCell(75, 5, utf8_decode($name), 1, 1, 'L',0);
        $pdf->SetXY($x + 75, $y);
        $pdf->MultiCell(75, 5, utf8_decode($cat), 1, 1, 'L',0);
        $pdf->SetXY($x + 150, $y);
        $pdf->MultiCell(50, 5, utf8_decode($depo), 1, 1, 'L',0);
        $pdf->SetXY($x + 200, $y);
        $pdf->Ln();
        }
        $pdf->Output();
    }
        
    switch($modo){
        case "repusuarioes":
            repusuarioes();
            break;
        case "repequiposes":
            repequiposes();
            break;
        case "reptorneoes":
            reptorneoes();
            break;
     }
    

    
}else{
    echo "<script>alert('No existe ningún reporte por el momento')</script>";
}
?>
