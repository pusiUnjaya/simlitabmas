<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class Pdf
{
	function createPDF($html, $filename='', $download=TRUE, $paper='folio', $orientation='portrait')
	{
		$dompdf = new Dompdf\Dompdf([
			'enable_remote' => true,
			'chroot' => FCPATH,
		]);

		$dompdf->load_html($html);
		$dompdf->set_paper($paper, $orientation);
		// $dompdf->set_paper([0,0,609.4488,935.433]);
		$dompdf->render();
		$dompdf->stream($filename.'.pdf', array('Attachment' => $download ? 1 : 0));
	}
}
?>