<?php
include '../function/connection.php';

if(isset($_POST['submit'])) :
	if($_POST['date-start'] && $_POST['date-end']) :
		$date_start = $_POST["date-start"];
		$date_end = $_POST["date-end"];
		$start = date_format(date_create($date_start), 'd-m-Y');
		$end = date_format(date_create($date_end), 'd-m-Y');
		$title_report = 'LAPORAN PERJALANAN MINGGUAN';

		// fetch data based on date range from database
		$query = "SELECT name, no_hp_wa, COUNT(*) AS destination FROM business_trip a JOIN driver b ON a.id_driver=b.id_driver WHERE date_today BETWEEN '$date_start' AND '$date_end' GROUP BY name";
		$result = mysqli_query($conn, $query);
	elseif($_POST['month']):
		$month_start = $_POST["month"];
		$month = date_format(date_create($month_start), 'm-Y');
		$title_report = 'LAPORAN PERJALANAN BULANAN';

		// fetch data based on month from database
		$query = "SELECT name, no_hp_wa, COUNT(*) AS destination FROM business_trip a JOIN driver b ON a.id_driver=b.id_driver WHERE LEFT(date_today,7)='$month_start' GROUP BY name";
		$result = mysqli_query($conn, $query);
	else:
		$year_start = $_POST["year"];
		$year = date_format(date_create($year_start), 'Y');
		$title_report = 'LAPORAN PERJALANAN TAHUNAN';

		// fetch data based on year from database
		$query = "SELECT name, no_hp_wa, COUNT(*) AS destination FROM business_trip a JOIN driver b ON a.id_driver=b.id_driver WHERE LEFT(date_today,4)='$year_start' GROUP BY name";
		$result = mysqli_query($conn, $query);
	endif;
endif;

require('fpdf.php');

class PDF extends FPDF {
	function Header() {
		global $title_ministry;
		global $title_institution;
		global $address;
		
		$this->Image('../assets/img/logo-tut-wuri-handayani.png',10,12.5,25);
		
		// Thickness of frame (1 mm)
  	$this->SetLineWidth(1);
		
		$this->SetFont('Arial','B',12);
		$this->Cell(210,10,$title_ministry,0,0,'C');
		$this->Ln(6);
		$this->SetFont('Arial','B',15);
		$this->MultiCell(210,3,$title_institution,0,'C');
		$this->Ln(2);
		$this->SetFont('Arial','I',9.5);
		$this->MultiCell(210,2,$address,0,'C');
		$this->Line(10,46,200,46);
		$this->Ln(10);
	}
	function ReportTitle() {
		// Report title
		global $title_report;
		// Calculate width of title and position
    $w_r = $this->GetStringWidth($title_report)+6;
  	$this->SetX((210-$w_r)/2);
		$this->SetFont('Arial','B',13);
		$this->Cell($w_r,2,$title_report,0,0,'C');
		$this->Ln(5);

		// Report time range (date, month, or year)
		$this->SetFont('Arial','',12);
  	$this->SetX((210-$w_r)/2);
		global $start;
		global $end;
		global $month;
		global $year;

		if(!empty($start && $end)) :
			$this->Cell($w_r,2,'Tanggal: '.$start.' s.d. '.$end,0,0,'C');
		elseif(!empty($month)):
			$this->Cell($w_r,2,'Bulan: '.$month,0,0,'C');
		else:
			$this->Cell($w_r,2,'Tahun: '.$year,0,0,'C');
		endif;
		$this->Ln(10);
	}
	function Table() {
		// Set Table Title
    $this->SetFont('Arial','B',11);
    $this->SetFillColor(0,162,233);
    $this->SetX(10);
    $this->Cell(15,8,'No',1,0,'C',1);
    $this->Cell(70,8,'Nama Supir',1,0,'C',1);
    $this->Cell(50,8,'HP/WA',1,0,'C',1);
    $this->Cell(55,8,'Data Perjalanan',1,0,'C',1);
 	  $this->Ln(8);

		// Set Table Data
    $this->SetFont('Arial','',11);
    $this->SetFillColor(255,255,255);
    $this->SetX(10);

    global $result;
    $no = 1;
    $sum = 0;
    foreach ($result as $row) {
	    $this->Cell(15,8,$no++,1,0,'C',1);
	    $this->Cell(70,8,$row['name'],1,0,'C',1);
	    $this->Cell(50,8,$row['no_hp_wa'],1,0,'C',1);
	    $count = $row['destination'];
	    $this->Cell(55,8,$count,1,0,'C',1);
	 	  $this->Ln(8);
	 	  $sum += $count;
	 	  // print_r($sum);
	 	}
    $this->Cell(135,8,'Total Perjalanan',1,0,'C',1);
    $this->Cell(55,8,$sum,1,0,'C',1);
 	  $this->Ln(20);
	}
	function Signature() {
		// Set Table Title
		$date = date('j-m-Y');
    $this->SetFont('Arial','',11);
    $this->SetX(145);
    $this->Cell(55,7,'Makassar, '.$date,0,0,'C',1);
    $this->Ln(10);
    $this->SetX(145);
    $this->Cell(55,7,'Kepala Balai',0,0,'C',1);
 	  $this->Ln(30);
    $this->SetX(145);
    $this->Cell(55,7,'Drs. Arman Agung, M.Pd.',0,0,'C',1);
	}
	function Layout() {
		$this->AddPage();
		$this->ReportTitle();
		$this->Table();
		$this->Signature();
	}
	// function Footer() {
	// 	$this->SetY(-20);
	// 	$this->SetFont('Arial','',12);
	// 	$this->Cell(0,10,$this->PageNo(),0,0,'C');
	// }
}

/* Orientasi: P (portrait), L (landscape)
 * Unit: mm, pt, cm, in
 * Size: A4, Letter, Legal
 * Default (without parameteres) : 'P', 'mm', 'A4'
 */
$pdf = new PDF();
$title_ministry = 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi';
$title_institution = "
	BALAI PENGEMBANGAN PENDIDIKAN ANAK USIA DINI\n
	DAN PENDIDIKAN MASYARAKAT SULAWESI SELATAN\n
	(BP-PAUD & DIKMAS SULSEL)";
$address = "
	Alamat: Jl.Adhyaksa No.2, Panakkukang, Makassar 90231, Telepon: 0411-440065, Fax: 0411-421460\n
	Laman: http://bppauddikmas-sulsel.id, Email: bppauddikmassulsel@kemdikbud.go.id, SMS/WA: 08114441102
";
$pdf->SetTitle($title_ministry);
$pdf->SetTitle($title_institution);
$pdf->SetTitle($title_report);
$pdf->SetAuthor('Tim KKLP STMIK AKBA 2022');
$pdf->Layout();
if($start && $end) :
	$pdf->Output('I','Laporan Mingguan - '.$start.'_'.$end,false);
elseif($month) :
	$pdf->Output('I','Laporan Bulanan - '.$month,false);
else :
	$pdf->Output('I','Laporan Tahunan - '.$year,false);
endif;
?>