<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require APPPATH . '/third_party/PhpOffice/autoload.php';
include APPPATH . 'third_party/vendor/PhpOffice/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rekap extends LPPM_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load_models(['dosen', 'submit', 'pengabdian', 'rekap', 'roadmap']);
	}

	private function check_wadek()
	{
		($this->is_dosen() && !$this->is_wadek()) and redirect('/');
	}

	public function index()
	{
		$this->check_wadek();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();

		$data['page'] = 'rekap/penelitian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function stat()
	{
		$this->check_wadek();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['hitprodi'] = $this->mroadmap->hitroadmapprodi();
		$data['hitdosen'] = $this->mroadmap->hitroadmapdosen();

		if ($this->sesi_status != 1 && $this->session->userdata('sesi_wadek') != 1)
			return redirect('/rekap/statprodi/' . $this->session->userdata('sesi_prodi'));

		$data['page'] = 'stat/statkinerja';
		$this->load->view('dashboard/dashboard', $data);
		/*
			  if ($this->session->userdata('sesi_status') == 1 || ($this->session->userdata('sesi_wadek') == 1 && $this->session->userdata('sesi_id') == 109))
				  $data['page'] = 'stat/statkinerja';
			  else
				  return redirect('/rekap/statprodi/' . $this->session->userdata('sesi_prodi'));
			  $this->load->view('dashboard/dashboard', $data);
			  */
	}

	function statprodi()
	{
		$this->check_wadek();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tahun'] = $pilih;
		$data['usulan'] = $this->msubmit->statpilihusulan($pilih);
		$data['abdi'] = $this->mpengabdian->usulan($pilih);
		$data['namaprodi'] = $this->mroadmap->namaprodi($this->uri->segment(3));
		$data['namadosen'] = $this->mroadmap->namadosen($this->uri->segment(3));

		$data['page'] = 'stat/statprodi';
		$this->load->view('dashboard/dashboard', $data);
	}

	function penelitian($periode = null, $prodi = null)
	{
		$this->check_wadek();

		if ($this->input->method() == 'post') {
			$periode = $this->input->post('periode');
			$prodi = $this->input->post('prodi');
			redirect("/rekap/penelitian/$periode/$prodi");
		}

		empty($periode) and $periode = date('Y');
		empty($prodi) and $prodi = 'Semua';

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		// $data['daftar_fakultas'] = $this->mdosen->fakultas();
		$data['daftar_prodi'] = $this->mdosen->selectprodi();

		$data['periode'] = $periode;
		$data['prodi'] = $prodi;

		$riwayat = $this->mrekap->penelitian($periode, $prodi);
		$tambahan = $this->mrekap->tambahan($periode, $prodi);
		// echo $this->db->last_query();exit;
		$data['data'] = array_map(function($p) {
			return [
				'Judul' => ucwords(strtolower($p->judul)),
				'Tahun' => isset($p->tglmulai) ? substr($p->tglmulai, 0, 4) : $p->tahun,
				'Ketua' => isset($p->pengusul) ? $this->mdosen->dosennya($p->pengusul)['namalengkap'] : (
					!empty($p->ketua) ? $this->mdosen->namadosenprodi($p->ketua)['namalengkap'] : ''
				),
				'Sumber Dana' => $p->sumberdana,
				'Anggota' => join(', ', isset($p->anggotadosen) ? array_map(function($id) {
					return $this->mdosen->namadosen($id)['namalengkap'];
				}, explode(',', $p->anggotadosen)) : array_map(function($id) {
					return $this->mdosen->namadosenprodi($id)['namalengkap'];
				}, explode(',', $p->anggota))),
				'Skema' => isset($p->skema) ? $p->skema : $p->jenis,
				'Dokumen' => join('<br>', array_map(function($x) {
					return '<a href="'.base_url("assets/uploadbox/$x").'" target="_blank">'.$x.'</a>';
				}, array_filter([
					isset($p->file_laporan) ? $p->file_laporan : null,
					$p->file_laporan_akhir,
				]))),
			];
		}, array_merge($riwayat, $tambahan));

		$data['page'] = 'rekap/penelitian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function hasilreview()
	{
		$this->check_admin();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();

		$data['page'] = 'rekap/hasilreview';
		$this->load->view('dashboard/dashboard', $data);
	}

	function reviewer()
	{
		$this->check_admin();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['dosen'] = $this->mrekap->reviewer();
			$data['fasenya'] = $this->input->post('fase');
			$this->session->set_userdata('tahunfase', $this->input->post('periode'));
			$this->session->set_userdata('fasenya', $this->input->post('fase'));
			$data['thn'] = $this->input->post('periode');
		} else {
			$data['dosen'] = $this->mrekap->reviewer();
			$data['fasenya'] = 'Usulan';
			$data['thn'] = date('Y');
			$this->session->set_userdata('tahunfase', date('Y'));
			$this->session->set_userdata('fasenya', 'Usulan');
			// echo $this->db->last_query();exit;	
		}
		$data['page'] = 'rekap/reviewer';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detailrevriset()
	{
		$this->check_admin();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->uri->segment(3) == 'Usulan') {
			$data['review'] = $this->mrekap->detailrevusulanpenelitian($this->uri->segment(4), $this->session->userdata('tahunfase'));
			// echo $this->db->last_query();exit;
			$data['hitreview'] = $this->mrekap->hitrevusulanpenelitian($this->uri->segment(4), $this->session->userdata('tahunfase'));
		} else {
			$data['review'] = $this->mrekap->detailrevlaporanpenelitian($this->uri->segment(4), $this->session->userdata('tahunfase'));
			$data['hitreview'] = $this->mrekap->hitrevlappenelitian($this->uri->segment(4), $this->session->userdata('tahunfase'));
		}

		$data['page'] = 'rekap/detailrevriset';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detailrevpkm()
	{
		$this->check_admin();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->uri->segment(3) == 'Usulan') {
			$data['review'] = $this->mrekap->detailrevusulanpkm($this->uri->segment(4), $this->session->userdata('tahunfase'));
			// echo $this->db->last_query();exit;
			$data['hitreview'] = $this->mrekap->hitrevusulanpkm($this->uri->segment(4), $this->session->userdata('tahunfase'));
		} else {
			$data['review'] = $this->mrekap->detailrevlappkm($this->uri->segment(4), $this->session->userdata('tahunfase'));
			$data['hitreview'] = $this->mrekap->hitrevlappkm($this->uri->segment(4), $this->session->userdata('tahunfase'));
		}

		$data['page'] = 'rekap/detailrevpkm';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detailrisetdosen()
	{
		empty($this->session->userdata('sesi_status')) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['review'] = $this->mrekap->detailrisetdosen($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
		$data['hitreview'] = $this->mrekap->hitrisetdosen($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));

		$data['page'] = 'rekap/detailrisetdosen';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detailpkmdosen()
	{
		empty($this->session->userdata('sesi_status')) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['review'] = $this->mrekap->detailpkmdosen($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
		$data['hitreview'] = $this->mrekap->hitpkmdosen($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));

		$data['page'] = 'rekap/detailpkmdosen';
		$this->load->view('dashboard/dashboard', $data);
	}

	function ekspordatareviewer()
	{
		$this->check_admin();

		$data = [];
		$data['active'] = 'active ';
		$data['date'] = date('dmYHis');
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['dosen'] = $this->mrekap->reviewer();
		$data['fasenya'] = $this->session->userdata('fasenya');
		$data['thn'] = $this->session->userdata('tahunfase');
		// echo $this->db->last_query();exit;	

		$this->load->view('rekap/ekspordatareviewer', $data);

		$this->check_admin();

		$data = [];
		// $data['date'] = date('dmYHis');
		$date = date('dmYHis');
		// $data['penelitian'] = $this->mrekap->revisipenelitian($tahun ?: date('Y'));

		// $this->load->view('rekap/eksporrevisiusulanpenelitian', $data);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Ketua');
		$sheet->setCellValue('C1', 'Judul Penelitian');
		$sheet->setCellValue('D1', 'Skema');
		$sheet->setCellValue('E1', 'Fakultas');
		$sheet->setCellValue('F1', 'Program Studi');
		$sheet->setCellValue('G1', 'Tahun');
		$sheet->setCellValue('H1', 'Unggah Revisi');
		
		$penelitian = $this->mrekap->revisipenelitian($tahun ?: date('Y'));
		$no = 1;
		$x = 2;
		foreach($penelitian as $p)
		{
			$total = $this->msubmit->totalrab($p->id_usulan);
			$fakultas = $this->mdosen->namafakultas($p->fakultas);
			$prodi = $this->mdosen->namaprodi($p->prodi);
			if($p->pengusul<>'')
			{
				$ketua = $this->mdosen->dosennya($p->pengusul);
				$ketua = $ketua['namalengkap'];
			}
			else
			$ketua = '';

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $ketua);
			$sheet->setCellValue('C'.$x, ucwords(strtolower($p->judul)));
			$sheet->setCellValue('D'.$x, $p->skema);
			$sheet->setCellValue('E'.$x, $fakultas['fakultas']);
			$sheet->setCellValue('F'.$x, $prodi['prodi']);
			$sheet->setCellValue('G'.$x, date('Y',strtotime($p->tglmulai)));
			$sheet->setCellValue('H'.$x, ($p->filerevisi<>''?'Sudah':'Belum'));
			$x++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'rekap_reviewer_'.$date;
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function eksporhasilreview()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		// urldecode($this->uri->segment(5)
		$data['hasilreview'] = ($this->input->post('periode') == 'usulan')
			? $this->mrekap->semuajurnalusulan()
			: $this->mrekap->jurnalusulan($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));

		$this->load->view('rekap/eksporhasilreview', $data);
	}

	function eksporlapkemajuan()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		// urldecode($this->uri->segment(5)
		$data['lapkemajuan'] = $this->mrekap->lapkemajuanriset();
		// echo $this->db->last_query();exit;

		$this->load->view('rekap/eksporlapkemajuan', $data);
	}

	function pengabdian($periode = null, $prodi = null)
	{
		$this->check_wadek();

		if ($this->input->method() == 'post') {
			$periode = $this->input->post('periode');
			$prodi = $this->input->post('prodi');
			redirect("/rekap/pengabdian/$periode/$prodi");
		}

		empty($periode) and $periode = date('Y');
		empty($prodi) and $prodi = 'Semua';

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['daftar_prodi'] = $this->mdosen->selectprodi();

		$data['periode'] = $periode;
		$data['prodi'] = $prodi;

		$riwayat = $this->mrekap->pengabdian($periode, $prodi);
		$tambahan = $this->mrekap->tambahanpkm($periode, $prodi);
		// echo $this->db->last_query();exit;
		$data['data'] = array_map(function($p) {
			return [
				'Judul' => ucwords(strtolower($p->judul)),
				'Tahun' => isset($p->tglmulai) ? substr($p->tglmulai, 0, 4) : $p->tahun,
				'Ketua' => isset($p->pengusul) ? $this->mdosen->dosennya($p->pengusul)['namalengkap'] : (
					!empty($p->ketua) ? $this->mdosen->namadosenprodi($p->ketua)['namalengkap'] : ''
				),
				'Sumber Dana' => $p->sumberdana,
				'Anggota' => join(', ', isset($p->anggotadosen) ? array_map(function($id) {
					return $this->mdosen->namadosen($id)['namalengkap'];
				}, explode(',', $p->anggotadosen)) : array_map(function($id) {
					return $this->mdosen->namadosenprodi($id)['namalengkap'];
				}, explode(',', $p->anggota))),
				'Skema' => isset($p->skema) ? $p->skema : $p->jenis,
				'Dokumen' => join('<br>', array_map(function($x) {
					return '<a href="'.base_url("assets/uploadbox/$x").'" target="_blank">'.$x.'</a>';
				}, array_filter([
					isset($p->file_revisi) ? $p->file_revisi : null,
					isset($p->file_laporan) ? $p->file_laporan : null,
					isset($p->file_laporan_akhir) ? $p->file_laporan_akhir : null,
					isset($p->file_pendukung) ? $p->file_pendukung : null,
				]))),
			];
		}, array_merge($riwayat, $tambahan));

		$data['page'] = 'rekap/pengabdian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function jurnal()
	{
		$this->is_dosen() and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['rekapjurnal'] = $this->mrekap->jurnalusulan($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
			$data['rekapan'] = $this->mrekap->jurnal($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
		} else {
			if ($this->session->userdata('sesi_status') == 1) {
				$data['rekapjurnal'] = $this->mrekap->jurnalusulan(date('Y'), 'Semua', 'Luaran Penelitian');
				$data['rekapan'] = $this->mrekap->jurnal(date('Y'), 'Semua', 'Luaran Penelitian');
				// echo $this->db->last_query();exit;
			} else {
				$data['rekapjurnal'] = $this->mrekap->jurnalusulan(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
				$data['rekapan'] = $this->mrekap->jurnal(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
				// echo $this->db->last_query();exit;
			}
		}

		$data['page'] = 'rekap/jurnal';
		$this->load->view('dashboard/dashboard', $data);
	}

	function hki()
	{
		$this->is_dosen() and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['rekaphki'] = $this->mrekap->hkiusulan($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
			$data['rekapan'] = $this->mrekap->hki($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
		} else {
			if ($this->session->userdata('sesi_status') == 1) {
				$data['rekaphki'] = $this->mrekap->hkiusulan(date('Y'), 'Semua', 'Luaran Penelitian');
				$data['rekapan'] = $this->mrekap->hki(date('Y'), 'Semua', 'Luaran Penelitian');
			} else {
				$data['rekaphki'] = $this->mrekap->hkiusulan(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
				$data['rekapan'] = $this->mrekap->hki(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
			}
		}

		// echo $this->db->last_query();exit;

		$data['page'] = 'rekap/hki';
		$this->load->view('dashboard/dashboard', $data);
	}

	function prosiding()
	{
		$this->is_dosen() and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['rekaprosiding'] = $this->mrekap->prosiding($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
		} else {
			if ($this->session->userdata('sesi_status') == 1) {
				$data['rekaprosiding'] = $this->mrekap->prosiding(date('Y'), 'Semua', 'Luaran Penelitian');
			} else {
				$data['rekaprosiding'] = $this->mrekap->prosiding(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
			}
		}

		$data['page'] = 'rekap/prosiding';
		$this->load->view('dashboard/dashboard', $data);
	}

	function buku()
	{
		$this->is_dosen() and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['rekabuku'] = $this->mrekap->buku($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
		} else {
			if ($this->session->userdata('sesi_status') == 1) {
				$data['rekabuku'] = $this->mrekap->buku(date('Y'), 'Semua', 'Luaran Penelitian');
			} else {
				$data['rekabuku'] = $this->mrekap->buku(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
			}
		}

		$data['page'] = 'rekap/buku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function naskah()
	{
		$this->is_dosen() and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['rekabuku'] = $this->mrekap->naskah($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
		} else {
			if ($this->session->userdata('sesi_status') == 1) {
				$data['rekabuku'] = $this->mrekap->naskah(date('Y'), 'Semua', 'Luaran Penelitian');
			} else {
				$data['rekabuku'] = $this->mrekap->naskah(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
			}
		}

		$data['page'] = 'rekap/naskah';
		$this->load->view('dashboard/dashboard', $data);
	}

	function karya()
	{
		$this->is_dosen() and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		if ($this->input->post('periode') <> '') {
			$data['rekabuku'] = $this->mrekap->karya($this->input->post('periode'), $this->input->post('prodi'), $this->input->post('sebagai'));
		} else {
			if ($this->session->userdata('sesi_status') == 1) {
				$data['rekabuku'] = $this->mrekap->karya(date('Y'), 'Semua', 'Luaran Penelitian');
			} else {
				$data['rekabuku'] = $this->mrekap->karya(date('Y'), $this->session->userdata('sesi_prodi'), 'Luaran Penelitian');
			}
		}

		$data['page'] = 'rekap/karya';
		$this->load->view('dashboard/dashboard', $data);
	}

	function eksporjurnal()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		//urldecode($this->uri->segment(5)
		if ($this->uri->segment(3) == 'semua') {
			$data['jurnalusulan'] = $this->mrekap->semuajurnalusulan();
			$data['jurnal'] = $this->mrekap->semuajurnal();
		} else {
			$data['jurnalusulan'] = $this->mrekap->jurnalusulan($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));
			$data['jurnal'] = $this->mrekap->jurnal($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));
		}

		$this->load->view('rekap/eksporjurnal', $data);
	}

	function eksporhki()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($this->uri->segment(3) == 'semua') {
			$data['hkiusulan'] = $this->mrekap->semuahkiusulan();
			// echo $this->db->last_query();exit;
			$data['hki'] = $this->mrekap->semuahki();
		} else {
			$data['hkiusulan'] = $this->mrekap->hkiusulan($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));
			$data['hki'] = $this->mrekap->hki($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));
		}
		// echo $this->db->last_query();exit;

		$this->load->view('rekap/eksporhki', $data);
	}

	function eksporprosiding()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($this->uri->segment(3) == 'semua')
			$data['prosiding'] = $this->mrekap->semuaprosiding();
		else
			$data['prosiding'] = $this->mrekap->prosiding($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));

		$this->load->view('rekap/eksporprosiding', $data);
	}

	function eksporbuku()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($this->uri->segment(3) == 'semua')
			$data['buku'] = $this->mrekap->semuabuku();
		else
			$data['buku'] = $this->mrekap->buku($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));

		$this->load->view('rekap/eksporbuku', $data);
	}

	function ekspornaskah()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($this->uri->segment(3) == 'semua')
			$data['naskah'] = $this->mrekap->semuanaskah();
		else
			$data['naskah'] = $this->mrekap->naskah($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));

		$this->load->view('rekap/ekspornaskah', $data);
	}

	function eksporkarya()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($this->uri->segment(3) == 'semua')
			$data['karya'] = $this->mrekap->semuakarya();
		else
			$data['karya'] = $this->mrekap->karya($this->uri->segment(3), $this->uri->segment(4), urldecode($this->uri->segment(5)));

		$this->load->view('rekap/eksporkarya', $data);
	}

	function eksporpenelitian($tahun = null, $prodi = null)
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($tahun == 'semua') {
			$data['penelitian'] = $this->mrekap->semuapenelitian();
			// echo $this->db->last_query();exit();
			$data['tambahan'] = $this->mrekap->semuatambahan();
		} else {
			$data['penelitian'] = $this->mrekap->penelitian($tahun, $prodi);
			$data['tambahan'] = $this->mrekap->tambahan($tahun, $prodi);
		}

		$this->load->view('rekap/eksporpenelitian', $data);
	}

	function eksporreviewpenelitian($tahun = null)
	{
		$this->check_admin();

		$data = [];
		// $data['penelitian'] = $this->mrekap->reviewpenelitian($tahun ?: date('Y'));

		// $this->load->view('rekap/eksporreviewusulanpenelitian', $data);
		$data = [];
		// $data['date'] = date('dmYHis');
		$date = date('dmYHis');
		// $data['penelitian'] = $this->mrekap->revisipenelitian($tahun ?: date('Y'));

		// $this->load->view('rekap/eksporrevisiusulanpenelitian', $data);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Ketua');
		$sheet->setCellValue('C1', 'Nama Anggota Dosen');
		$sheet->setCellValue('D1', 'Jumlah Anggota Mahasiswa');
		$sheet->setCellValue('E1', 'Nama Anggota Mahasiswa');
		$sheet->setCellValue('F1', 'Judul Penelitian');
		$sheet->setCellValue('G1', 'Skema');
		$sheet->setCellValue('H1', 'Fakultas');
		$sheet->setCellValue('I1', 'Program Studi');
		$sheet->setCellValue('J1', 'Tahun');
		$sheet->setCellValue('K1', 'Nama Reviewer 1');
		$sheet->setCellValue('L1', 'Nama Reviewer 2');
		$sheet->setCellValue('M1', 'Nilai Rata-rata');
		$sheet->setCellValue('N1', 'Catatan Reviewer 1');
		$sheet->setCellValue('O1', 'Catatan Reviewer 2');
		$sheet->setCellValue('P1', 'Target Luaran');
		$sheet->setCellValue('Q1', 'Dana');
		$sheet->setCellValue('R1', 'Realisasi Luaran');
		$sheet->setCellValue('S1', 'Relevansi MK');
		$sheet->setCellValue('T1', 'Relevansi bentuk Integrasi');
		
		$penelitian = $this->mrekap->reviewpenelitian($tahun ?: date('Y'));
		// echo $this->db->last_query();exit;
		$no = 1;
		$x = 2;
		foreach($penelitian as $p)
		{
			$total = $this->msubmit->totalrab($p->id_usulan);
			$fakultas = $this->mdosen->namafakultas($p->fakultas);
			$prodi = $this->mdosen->namaprodi($p->prodi);
			if($p->pengusul<>'')
			{
				$ketua = $this->mdosen->dosennya($p->pengusul);
				$ketua = $ketua['namalengkap'];
			}
			else
			$ketua = '';
			
			$ad = '';
			$am = '';
			
			$ambil = explode(',',$p->anggotadosen);
			$hit = count($ambil);
			
			if($p->anggotadosen<>'') 
			{
				// $ad = '<ol>';
				for($i=0;$i<$hit;$i++)
				{
					$dosen = $this->mdosen->namadosen($ambil[$i]);
					if($hit>1)
					$ad .= ($i+1).'. ';
					
					$ad .= $dosen['namalengkap']."\r";
				}
				// $ad .= '</ol>';
			}
			else
			$ad = 'Tidak Ada Anggota Dosen'; 

			$jumsplit = 0;
			if($p->anggotamhs<>'')
			{
				$split = explode(',',$p->anggotamhs);
				$jumsplit = count($split);
				if($jumsplit>1)
				{
					for($i=0;$i<$jumsplit;$i++)
					{
							$namamhs = $this->msubmit->namamhs($split[$i]);
							$prodi = $this->mdosen->namaprodi($namamhs['prodi']);
							if($jumsplit>1)
							{
								$am .= ($i+1).'. ';
								$am .= $namamhs['namamhs'].' ( '.$prodi['prodi'].' )'."\r";
							}
							else
								$am .= $namamhs['namamhs'].' ( '.$prodi['prodi'].' )';
					}
				}
				else
				{
					$am .= "<pre>".$p->anggotamhs."</pre>";
				}
			}
			else
			{
				$am .= "Tidak Ada Anggota Mahasiswa";
			}

			if($p->revnya<>'')
			{
				$pisah = explode(',',$p->revnya);
				$reviewer1 = $this->mdosen->namadosen($pisah[0]);
				$reviewer2 = $this->mdosen->namadosen($pisah[1]);
			
			//Nilai reviewer
				$nilai1 = $this->mrekap->nilaiusulanreviewer($p->id_usulan,$reviewer1['user']);
				$hitnilai1 = $this->mrekap->hitnilaiusulanreviewer($p->id_usulan,$reviewer1['user']);
				
				if($hitnilai1>0)
				{				
					if($nilai1['skor']=='')
					{
						$skor =',,,,,';
						$review = explode(',',$skor);
						$nilai = 0;;
						$hasilreview = $nilai1['hasilreview'];
					}	
					else
					{
						$skor = $nilai1['skor'];
						$review = explode(',',$skor);
						$skor1 = ((intval($review[0])*20)+(intval($review[1])*15)+(intval($review[2])*20)+(intval($review[3])*15)+(intval($review[4])*10)+(intval($review[5])*20))/7;
						$hasilreview = $nilai1['hasilreview'];
					}
				}
				else
				{
					$skor1 = 0;
					$hasilreview = '';
				}
				
				$nilai2 = $this->mrekap->nilaiusulanreviewer($p->id_usulan,$reviewer2['user']);
				$hitnilai2 = $this->mrekap->hitnilaiusulanreviewer($p->id_usulan,$reviewer2['user']);
				
				if($hitnilai2>0)
				{
					if($nilai2['skor']=='')
					{
						$skor =',,,,,';
						$review = explode(',',$skor);
						$nilai = 0;
						$hasilreview2 = $nilai2['hasilreview'];
					}	
					else
					{
						$skor = $nilai2['skor'];
						$review = explode(',',$skor);
						$skor2 = ((intval($review[0])*20)+(intval($review[1])*15)+(intval($review[2])*20)+(intval($review[3])*15)+(intval($review[4])*10)+(intval($review[5])*20))/7;
						$hasilreview2 = $nilai2['hasilreview'];
					}
				}
				else
				{
					$skor2 = 0;
					$hasilreview2 = '';
				}
			}

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $ketua);
			$sheet->setCellValue('C'.$x, $ad);
			$sheet->setCellValue('D'.$x, $p->jumlahmhs);
			$sheet->setCellValue('E'.$x, $am);
			$sheet->setCellValue('F'.$x, ucwords(strtolower($p->judul)));
			$sheet->setCellValue('G'.$x, $p->skema);
			$sheet->setCellValue('H'.$x, $fakultas['fakultas']);
			$sheet->setCellValue('I'.$x, $prodi['prodi']);
			$sheet->setCellValue('J'.$x, date('Y',strtotime($p->tglmulai)));
			$sheet->setCellValue('K'.$x, $reviewer1['namalengkap']);
			$sheet->setCellValue('L'.$x, $reviewer2['namalengkap']);
			$sheet->setCellValue('M'.$x, number_format(($skor1+$skor2)/2,2));
			$sheet->setCellValue('N'.$x, $hasilreview);
			$sheet->setCellValue('O'.$x, $hasilreview2);
			$sheet->setCellValue('P'.$x, $p->luaran);
			$sheet->setCellValue('Q'.$x, $total['lapor']);
			$sheet->setCellValue('R'.$x, $p->luaran);
			$sheet->setCellValue('S'.$x, $p->luaran);
			$sheet->setCellValue('T'.$x, $p->luaran);
			$x++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'rekap_review_usulan_penelitian_'.$date;
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function eksporrevisipenelitian($tahun = null)
	{
		$this->check_admin();

		$data = [];
		// $data['date'] = date('dmYHis');
		$date = date('dmYHis');
		// $data['penelitian'] = $this->mrekap->revisipenelitian($tahun ?: date('Y'));

		// $this->load->view('rekap/eksporrevisiusulanpenelitian', $data);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Ketua');
		$sheet->setCellValue('C1', 'Judul Penelitian');
		$sheet->setCellValue('D1', 'Skema');
		$sheet->setCellValue('E1', 'Fakultas');
		$sheet->setCellValue('F1', 'Program Studi');
		$sheet->setCellValue('G1', 'Tahun');
		$sheet->setCellValue('H1', 'Unggah Revisi');
		
		$penelitian = $this->mrekap->revisipenelitian($tahun ?: date('Y'));
		$no = 1;
		$x = 2;
		foreach($penelitian as $p)
		{
			$total = $this->msubmit->totalrab($p->id_usulan);
			$fakultas = $this->mdosen->namafakultas($p->fakultas);
			$prodi = $this->mdosen->namaprodi($p->prodi);
			if($p->pengusul<>'')
			{
				$ketua = $this->mdosen->dosennya($p->pengusul);
				$ketua = $ketua['namalengkap'];
			}
			else
			$ketua = '';

			$sheet->setCellValue('A'.$x, $no++);
			$sheet->setCellValue('B'.$x, $ketua);
			$sheet->setCellValue('C'.$x, ucwords(strtolower($p->judul)));
			$sheet->setCellValue('D'.$x, $p->skema);
			$sheet->setCellValue('E'.$x, $fakultas['fakultas']);
			$sheet->setCellValue('F'.$x, $prodi['prodi']);
			$sheet->setCellValue('G'.$x, date('Y',strtotime($p->tglmulai)));
			$sheet->setCellValue('H'.$x, ($p->filerevisi<>''?'Sudah':'Belum'));
			$x++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'rekap_revisi_usulan_penelitian_'.$date;
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	function eksporrevisiusulanpkm($tahun = null)
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['pengabdian'] = $this->mrekap->revisipkm($tahun ?: date('Y'));

		$this->load->view('rekap/eksporrevisiusulanpkm', $data);
	}

	function eksporreviewlaporanpenelitian()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['penelitian'] = $this->mrekap->reviewlaporanpenelitian();

		$this->load->view('rekap/eksporreviewlaporanpenelitian', $data);
	}

	function eksporreviewusulanpkm($tahun = null)
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['penelitian'] = $this->mrekap->reviewusulanpkm($tahun ?: date('Y'));

		$this->load->view('rekap/eksporreviewusulanpkm', $data);
	}

	function eksporreviewlaporanpkm()
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['penelitian'] = $this->mrekap->reviewlaporanpkm();

		$this->load->view('rekap/eksporreviewlaporanpkm', $data);
	}

	function eksporpengabdian($periode, $prodi)
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		if ($periode == 'semua') {
			$data['pengabdian'] = $this->mrekap->semuapengabdian();
			$data['tambahan'] = $this->mrekap->semuatambahanpkm();
			// echo $this->db->last_query();exit();
		} else {
			$data['pengabdian'] = $this->mrekap->pengabdian($periode, $prodi);
			$data['tambahan'] = $this->mrekap->tambahanpkm($periode, $prodi);
		}

		$this->load->view('rekap/eksporpengabdian', $data);
	}

	function load_prodi($fak)
	{
		$query = $this->mdosen->prodi($fak);
		$data = "<option value=''>-- Pilih Prodi --</option>";
		foreach ($query as $value) {
			$data .= "<option value='" . $value->id_prodi . "'>" . $value->prodi . "</option>";
		}

		echo $data;
	}
}
