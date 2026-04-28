<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class Pdf
{
	function createPDF($html, $filename = '', $download = TRUE, $paper = 'folio', $orientation = 'portrait', $simpan = 0)
	{
		$dompdf = new Dompdf\Dompdf([
			'enable_remote' => true,
			'chroot' => FCPATH,
		]);

		$dompdf->load_html($html);
		$dompdf->set_paper($paper, $orientation);
		// $dompdf->set_paper([0,0,609.4488,935.433]);
		$dompdf->render();

		if ($simpan == 1) {

			$output = $dompdf->output();
			$file_path = FCPATH . 'assets/uploadbox/' . $filename . '.pdf';
			file_put_contents($file_path, $output);
		}
		$dompdf->stream($filename . '.pdf', array('Attachment' => $download ? 1 : 0));

		/*--------- Test Simpan File ---------*/
	}
}
