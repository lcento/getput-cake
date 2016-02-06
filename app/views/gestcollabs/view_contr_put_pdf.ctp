<?php
	App::import('Vendor','xtcpdf');
	// create new PDF document
	$tcpdf = new XTCPDF();
	//$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);
	// disable font subsetting
	$tcpdf->setFontSubsetting( false );

	// format page
	$page_format = 'A4';

	//$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'
	$textfont = 'helvetica'; // looks better, finer, and more condensed than 'dejavusans'

	$tcpdf->SetAuthor("ILMATTINO S.p.A.");
	$tcpdf->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM );

	//set image scale factor
	$tcpdf->setImageScale( PDF_IMAGE_SCALE_RATIO );

	// set default monospaced font
	$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set header information if enabled
	$tcpdf->setHeaderFont(array($textfont,'',12));
	$tcpdf->xheadercolor = array(190,213,190);
	$tcpdf->xheadertext = 'Contributi Inviati';
	$tcpdf->xfootertext = 'Contributi Inviati - Page ';
	$tcpdf->setPrintHeader( false );


	// add a page (required with recent versions of tcpdf)
	$tcpdf->AddPage('P',$page_format);
	//background color of next Cell
	$tcpdf->SetFillColor(190,213,190);
	// Now you position and print your page content
	$tcpdf->Cell(0,10, "Contributi Inviati", 0,1,'L',1);
	// Print subheader
	$tcpdf->Ln(2);
	//background color of next Cell
	$tcpdf->SetFillColor(201,209,208);
	$tcpdf->SetFont($textfont,'',8);
	$tcpdf->Cell(0,5, "data : ".$report_date_filter."            tipo : ".$report_type_filter, 0,1,'L',1);


	$tcpdf->Ln(5);

	// Color & Font for header
	$tcpdf->SetTextColor(0, 0, 0);
	$tcpdf->SetFont($textfont,'B',8);

	// set header info
	$w = array(15, 25, 30);
	$header = array('Num', 'Redazione', 'Totale');
	$num_headers = count($header);

	// print header information
	for($i = 0; $i < $num_headers; ++$i) {
		$tcpdf->Cell($w[$i], 10, $header[$i], 0, 0, 'L', 0);
	}

	$tcpdf->Ln(8);

	// Color & Font for body
	//$tcpdf->setFillColor(224, 235, 255);
	$tcpdf->setFillColor(225, 225, 225);
	$tcpdf->SetTextColor(0, 0, 0);
	$tcpdf->SetLineWidth(0.3);
	$tcpdf->SetFont($textfont,'',7);

	// Data
	$fill = 1;
	$num = 1;
	$tot = 0;

	$tcpdf->Cell(array_sum($w), 0, '', 'T');

	$tcpdf->Ln(2);

	foreach($report_pdf as $report)
	{
		$tcpdf->Cell($w[0], 6, $num, 0, 0, 'LR', $fill);
		$tcpdf->Cell($w[1], 6, $report['ActivityFileputHistory']['activity_fileput_history_filedest'], 0, 0, 'LR', $fill);
		$tcpdf->Cell($w[2], 6, $report['ActivityFileputHistory']['total_put'], 0, 0, 'LR', $fill,'',3);

		$tot = $tot + $report['ActivityFileputHistory']['total_put'];

		$tcpdf->Ln();
		$fill = !$fill;

		++$num;
	}

	// Color & Font for bottom
	$tcpdf->SetTextColor(0, 0, 0);
	$tcpdf->SetFont($textfont,'B',7);

	// Print total contrib bottom
	$tcpdf->Cell(array_sum($w), 0, '', 'T');

	$tcpdf->Ln(2);

	$tcpdf->Cell($w[0], 6, "Totale", 0, 0, 'LR', 0);
	$tcpdf->Cell($w[1], 6, "", 0, 0, 'LR', 0);
	$tcpdf->Cell($w[2], 6, $tot, 0, 0, 'LR', '', 3);

	//Output pdf
	echo $tcpdf->Output('report.pdf', 'D');
?>