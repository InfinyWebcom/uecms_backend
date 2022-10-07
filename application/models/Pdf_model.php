<?php

Class Pdf_Model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->library("Pdf");
    }

    public function downloadAttendance($data, $date){
          
        $pdf = new FPDF();
        $pdf->AddPage('L');

        $pdf->SetXY(10,5);
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(290,8, ucwords("UECMS Attendance"),0,1,'C');

        $pdf->SetX(20);
        $pdf->SetTextColor(230, 0, 0);
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(270,5, date('F, Y', strtotime($date)),0,1,'C');
        

        $pdf->Ln(5);
        $pdf->SetX(5);
        $pdf->SetTextColor(0, 0, 0);   
        $pdf->SetFillColor(204, 220, 255);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(31,8,'Name',"T,L,R,B",0,'C');
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(27,8,'Type','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,8,'Present Days','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,8,'Absent Days','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,8,'Daily Wage','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,8,'Salary','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(24,8,'Work Hours','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,8,'Over Time','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,8,'Travel','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,8,'Misc','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,8,'Debit','T,R,B',0,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,8,'Payable','T,R,B',1,'C');

        $total_payable = 0;
        foreach ($data as $key => $value) {
            $pdf->SetX(5);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(31,7,ucwords($value['name']),"B,L,R",0,'L');
            
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(27,7,ucwords($value['user_type']),'B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(25,7,$value['user_type'] != 'worker' ? $value['present_days']: 'N/A','B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(25,7,$value['user_type'] != 'worker' ? $value['absent_days']: 'N/A','B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(25,7,$value['user_type'] == 'worker' ? $value['daily_wage']: 'N/A','B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(25,7,$value['user_type'] != 'worker' ? $value['monthly_salary']: 'N/A','B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(24,7,$value['user_type'] == 'worker' ? $value['Total_work_hours']: 'N/A','B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,7,$value['Total_ot_hours'],'B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,7,$value['Total_travel'],'B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,7,$value['Total_misc'],'B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(20,7,$value['Total_debit'],'B,R',0,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(25,7,number_format($value['payable'], 2),'B,R',1,'L');
            $total_payable += $value['payable'];
        }
        $pdf->SetX(5);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(262,7,'Total Payable','L,B,R',0,'R');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,7,number_format($total_payable, 2),'B,R',1,'L');
        $pdf->Output();
    }
   
}