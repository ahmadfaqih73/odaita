<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model("user_model");
		$this->load->library('FPDF', '', 'fnpdf');
		if ($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$render = $this->db->query("
		SELECT
c.dimensi as dimensi,SUM(b.skor) / COUNT(b.skor) as avr,'' as clr,0 as per
FROM
kuisioner a
INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
INNER JOIN dimensi c ON c.id_dimensi = a.id_dimensi


GROUP BY a.id_dimensi
		");
		$jum = 0;
		$clrArr = array("bg-danger", "bg-warning", "", "bg-info", "bg-success");
		foreach ($render->result() as $i => $row) {
			$jum += $row->avr;
			$row->clr = $clrArr[$i];
		}


		foreach ($render->result() as $row) {
			$row->per = round($row->avr / $jum, 3) * 100;
		}

		$output['dim'] = $render;
		$this->load->view('pages/dashboard', $output);
	}
	//print PDF SIngle File export to PDF
	public function printPDF()
	{
		$renderTemp = $this->db->query("
        SELECT
        j.id_jawaban,
        u.username,
        j.tanggal,
        
        j.code_quisioner,
        CASE WHEN NOT kh.avr IS NULL THEN kh.avr ELSE 0 END AS 'Harapan',
        CASE WHEN NOT kp.avr IS NULL THEN kp.avr ELSE 0 END AS 'Persepsi',
      
        j.hasil

        FROM
        jawaban j 
        INNER JOIN users u ON j.user_id = u.user_id
        LEFT OUTER JOIN 
        (
            SELECT
            code_quisioner as id,SUM(b.skor) / COUNT(b.skor) as avr
            FROM
          
            kuisioner a
            INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
        
            WHERE a.jenis = 'Harapan'
        
            GROUP BY code_quisioner
            
        )kh ON kh.id = j.code_quisioner
        
        
        LEFT OUTER JOIN 
        (
            SELECT
            code_quisioner as id,SUM(b.skor) / COUNT(b.skor) as avr
            FROM
          
            kuisioner a
            INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
        
            WHERE a.jenis = 'Persepsi'
        
            GROUP BY code_quisioner
            
        )kp ON kp.id = j.code_quisioner
        ");
		$pdfHeader = Array("ID","NM","TGL","CQ","H","P","HSL");
		$widthArr = Array(50,50,50,50,50,50,50,50,50);
		$pdf = $this->fnpdf;
		$pdf->AddPage("L", "Legal");

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(0, 7, 'Laporan ', 0, 1, 'C');
		$pdf->Ln();
		if ($renderTemp->num_rows() > 0) {
			$height = 5;
			$width = 25;

			//$pdf->Image(base_url()."assets/images/logo.png",12,5,20);
			//$pdf->Image(base_url()."assets/images/approved.png",140,30,-200);

			//header

			//sub header

			$pdf->SetFont('Arial', '', 6);

			//echo count($pdfHeader);
			$i = 0;
			foreach ($pdfHeader as $label) {

				if ($i < count($pdfHeader)) {
					$nextLine = 0;
					if ($i == count($pdfHeader) - 1)
						$nextLine = 1;
					$pdf->Cell($widthArr[$i], $height, $label, 1, $nextLine, 'C');
				}
				$i++;
			}
			foreach ($renderTemp->result() as $row) {

				$i = 0;
				foreach ($row as $label) {
					if ($i < count($pdfHeader)) {
						$nextLine = 0;
						if ($i == count($pdfHeader) - 1)
							$nextLine = 1;
						$pdf->Cell($widthArr[$i], $height, $label, 1, $nextLine, 'C');
					}
					$i++;
				}
			}
		} else {

			$pdf->Cell(0, 0, "No data", 1, 0, 'C');
		}

		$pdf->Output("I");
	}
}
