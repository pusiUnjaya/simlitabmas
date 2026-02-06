<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mdosen', '', TRUE);
		$this->load->model('mpengguna', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('mdownload', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('msubmitpribadi', '', TRUE);
		$this->load->model('mrekap', '', TRUE);
	}

	public function index()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';

		if ($this->session->userdata('sesi_status') == 4) {
			$data['page'] = 'dashboard/home_revluar';
		} else {
			$data['profil'] = $this->mpengguna->profil();
			$data['cekskor'] = $this->mdosen->hitskorsinta($this->session->userdata('sesi_id'));
			$data['riwayat'] = $this->msubmitpribadi->histori();
			$data['tambahan'] = $this->msubmitpribadi->tambahan();
			$data['tambahanpkm'] = $this->msubmitpribadi->tambahanpkm();
			// echo $this->db->last_query();exit;
			$data['riwayatpkm'] = $this->msubmitpribadi->historipkm();
			// echo $this->session->userdata('sesi_dosen');exit;
			$data['listjurnal'] = $this->msubmitpribadi->selectjurnal();
			// $penulisnya = $this->msubmitpribadi->caripenulisjurnal(196);
			// echo $this->db->last_query();exit;
			$data['bukaan'] = $this->msubmitpribadi->bukaan();
			$data['listhki'] = $this->msubmitpribadi->selecthki();
			$data['listpros'] = $this->msubmitpribadi->selectpros();
			$data['listbuku'] = $this->msubmitpribadi->selectbuku();
			$data['listkarya'] = $this->msubmitpribadi->selectkarya();
			$data['listnaskah'] = $this->msubmitpribadi->selectnaskah();
			$data['skor'] = $this->mdosen->skorsinta($this->session->userdata('sesi_id'));

			$data['page'] = 'dashboard/home2';
		}
		$this->load->view('dashboard/dashboard', $data);
	}

	function revluar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';

		$data['page'] = 'dashboard/home_revluar';
		$this->load->view('dashboard/dashboard_revluar', $data);
	}

	function tambahpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/penelitian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editpenelitian();

		$data['page'] = 'dashboard/editpenelitian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function updatepenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_penelitian", true);

		$config['file_name'] = 'penelitian_tambahan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->updatepenelitian($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Penelitian Tambahan Telah Sukses Diupdate!');
		redirect("dashboard/index/penelitian");
	}

	function cekjuduljurnal()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		if (!empty($this->input->post("judul_jurnal", true))) {
			$judul = $this->input->post("judul_jurnal", true);

			$checkdata = $this->msubmitpribadi->cekjudul($judul);
			// echo $this->db->last_query();exit;

			echo($checkdata > 0 ? "Judul Telah Terpakai" : "Judul Belum Ada yang Memakai");
			exit();
		}
	}

	function cekjudulhki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		if (!empty($this->input->post("judul_hki", true))) {
			$judul = $this->input->post("judul_hki", true);

			$checkdata = $this->msubmitpribadi->cekjudulhki($judul);
			// echo $this->db->last_query();exit;

			echo($checkdata > 0 ? "Judul Telah Terpakai" : "Judul Belum Ada yang Memakai");
			exit();
		}
	}

	function cekjudulpros()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		if (!empty($this->input->post("judul_pros", true))) {
			$judul = $this->input->post("judul_pros", true);

			$checkdata = $this->msubmitpribadi->cekjudulpros($judul);
			// echo $this->db->last_query();exit;

			echo($checkdata > 0 ? "Judul Telah Terpakai" : "Judul Belum Ada yang Memakai");
			exit();
		}
	}

	function cekjudulbuku()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		if (!empty($this->input->post("judul_buku", true))) {
			$judul = $this->input->post("judul_buku", true);

			$checkdata = $this->msubmitpribadi->cekjudulbuku($judul);
			// echo $this->db->last_query();exit;

			echo($checkdata > 0 ? "Judul Telah Terpakai" : "Judul Belum Ada yang Memakai");
			exit();
		}
	}

	function cekjudulkarya()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		if (!empty($this->input->post("judul_karya", true))) {
			$judul = $this->input->post("judul_karya", true);

			$checkdata = $this->msubmitpribadi->cekjudulkarya($judul);
			// echo $this->db->last_query();exit;

			echo($checkdata > 0 ? "Judul Telah Terpakai" : "Judul Belum Ada yang Memakai");
			exit();
		}
	}

	function cekjudulnaskah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		if (!empty($this->input->post("judul_naskah", true))) {
			$judul = $this->input->post("judul_naskah", true);

			$checkdata = $this->msubmitpribadi->cekjudulnaskah($judul);
			// echo $this->db->last_query();exit;

			echo($checkdata > 0 ? "Judul Telah Terpakai" : "Judul Belum Ada yang Memakai");
			exit();
		}
	}

	function tambahpengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/pengabdian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editpengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editpengabdian();

		$data['page'] = 'dashboard/editpengabdian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function bukatutup()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_pengabdian", true);

		$this->msubmitpribadi->bukatutup();
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Setting Buka Tutup Pendaftaran Berhasil!');
		redirect("dashboard");
	}

	function updatepengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_pengabdian", true);

		// $config['file_name'] = 'pendukung_pkm_tambahan'.'_'.date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("filependukung");
		$data = $this->upload->data();
		$file = $_FILES['filependukung']['size'] && $_FILES['filependukung']['name'] ? $data["file_name"] : '';

		// $config2['file_name'] = 'pengabdian_tambahan'.'_'.date('dmyhis');
		$config2['upload_path'] = './assets/uploadbox/';
		$config2['allowed_types'] = 'pdf';
		$this->load->library('upload', $config2);

		$this->upload->do_upload("fileupload");
		$data2 = $this->upload->data();
		$file2 = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data2["file_name"] : '';

		$this->msubmitpribadi->updatepengabdian($file, $file2);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Pengabdian Tambahan Telah Sukses Diupdate!');
		redirect("dashboard/index/pengabdian");
	}

	function tambahjurnal()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/jurnal';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editjurnal()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editjurnal();

		$data['page'] = 'dashboard/editjurnal';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambahhki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/hki';
		$this->load->view('dashboard/dashboard', $data);
	}

	function hapuspenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapuspenelitian($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Penelitian Telah Sukses Dihapus!');
		redirect("dashboard/index/penelitian");
	}

	function hapuspengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapuspengabdian($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Pengabdian Telah Sukses Dihapus!');
		redirect("dashboard/index/pengabdian");
	}

	function hapushki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapushki($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data HKI Telah Sukses Dihapus!');
		redirect("dashboard/index/hki");
	}

	function hapusjurnal()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapusjurnal($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Jurnal Telah Sukses Dihapus!');
		redirect("dashboard/index/jurnal");
	}

	function hapusprosiding()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapusprosiding($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Prosiding Telah Sukses Dihapus!');
		redirect("dashboard/index/prosiding");
	}

	function hapusbuku()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapusbuku($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Buku Telah Sukses Dihapus!');
		redirect("dashboard/index/buku");
	}

	function hapuskarya()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapuskarya($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Karya Monumental Telah Sukses Dihapus!');
		redirect("dashboard/index/karya");
	}

	function hapusnaskah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapusnaskah($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Naskah Akademik Telah Sukses Dihapus!');
		redirect("dashboard/index/naskah");
	}

	function edithki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->edithki();

		$data['page'] = 'dashboard/edithki';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambahprosiding()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/prosiding';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editprosiding()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editprosiding();

		$data['page'] = 'dashboard/editprosiding';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambahbuku()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/buku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editbuku()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editbuku();

		$data['page'] = 'dashboard/editbuku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambahkarya()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/karya';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editkarya()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editkarya();

		$data['page'] = 'dashboard/editkarya';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambahnaskah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'dashboard/naskah';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editnaskah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tambahan'] = $this->msubmitpribadi->editnaskah();

		$data['page'] = 'dashboard/editnaskah';
		$this->load->view('dashboard/dashboard', $data);
	}

	function verifikasi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['ver'] = $this->mpengguna->verifikasi();
		redirect('pengguna');
	}

	function open()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mdosen->open($this->uri->segment(3));
		redirect('dashboard');
	}

	function close()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mdosen->close($this->uri->segment(3));
		redirect('dashboard');
	}

	function test()
	{

		$data = file_get_contents('https://sinta.ristekbrin.go.id/authors/detail?id=6058587&view=overview');

		preg_match('/<div class="stat2-val">([^<]+)<\/div>/i', $data, $matches);

		print_r($matches);

	}

	function coba()
	{
		//$html = file_get_contents('https://sinta.kemdikbud.go.id/authors/profile/6716698/');
                $html = file_get_contents('https://sinta.kemdiktisaintek.go.id/authors/profile/6716698/');



		//sinta overall
		$overall = stripos($html, '<i class="el el-user"></i></div>
                        <div class="col-4 col-lg col-sm-4 col-md-4">
                            <div class="pr-num">');
		$overallend = stripos($html, '</div>
                            <div class="pr-txt">', $offset = $overall);
		$length = $overallend - $overall;

		$htmlOverall = substr($html, $overall, $length);
		$pecahover = explode('<div class="pr-num">', $htmlOverall);

		echo $pecahover[1];

		//sinta tiga
		$tiga = stripos($html, '<div class="pr-ic ic-blue col-2 col-lg-1 col-sm-1 col-md-2 text-center pt-2"><i class="zmdi zmdi-graduation-cap"></i></div>
                        <div class="col-4 col-lg col-sm-4 col-md-4">
                            <div class="pr-num">');

		$tigaend = stripos($html, '</div>
                            <div class="pr-txt">SINTA Score 3Yr</div>', $offset = $tiga);

		$length = $tigaend - $tiga;

		$htmlTiga = substr($html, $tiga, $length);

		$pecahtiga = explode('<div class="pr-num">', $htmlTiga);

		echo $pecahtiga[1];


	}

	function getsinta()
	{

                //ini_set('display_errors', 1);
		//ini_set('display_startup_errors', 1);
		//error_reporting(E_ALL);

		empty($this->session->userdata('sesi_user')) and redirect('login');

		$cekdosen = $this->mdosen->cekdosen($this->session->userdata('sesi_id'));
		$tiga = '';
		if ($cekdosen > 0) {
			$sinta = $this->mdosen->idsinta($this->session->userdata('sesi_id'));
			//$html = file_get_contents("https://sinta.kemdikbud.go.id/authors/profile/$sinta[id_sinta]/");
              //          $html = file_get_contents("https://sinta.kemdiktisaintek.go.id/authors/profile/$sinta[id_sinta]/");
			//sinta overall
			//$html = file_get_contents("https://sinta.kemdikbud.go.id/authors/profile/$sinta[id_sinta]/");
                        $url = "https://sinta.kemdiktisaintek.go.id/authors/profile/$sinta[id_sinta]/";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			$html = curl_exec($ch);
                       
                 //       echo "https://sinta.kemdiktisaintek.go.id/authors/profile/$sinta[id_sinta]/";
//print_r($html);

			$doc = new DOMDocument();
			$poin = array();
			@$doc->loadHTML($html);

			$xpath = new DOMXPath($doc);

			$elements = $xpath->query('//div[contains(@class, "pr-num")]');

			foreach ($elements as $element) {
			    array_push($poin, $element->nodeValue);  
			}


			$waktu = date('Y-m-d H:i:s');
			$data = [
				"kolom1" => $poin[0],
				"kolom2" => $poin[1],
				"kolom3" => $poin[2],
				"user" => $this->session->userdata('sesi_id'),
				"modified" => $waktu
			];

			$this->db->insert("skor", $data);

			$this->session->set_userdata('sesi_sinta', $pecahover[1]);

			
		} else {
			$this->session->set_flashdata('result', 'Maaf Anda tidak mempunyai akun SINTA');
		}
		redirect("dashboard/index/sinta");
	}

	function hapus()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->msubmitpribadi->hapus($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data ' . ucfirst($this->uri->segment(3)) . ' Telah Sukses Dihapus!');
		redirect('dosen');
	}

	function simpanpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_penelitian", true);

		$config['file_name'] = 'penelitian_tambahan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpanpenelitian($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Penelitian Tambahan Telah Sukses Disimpan!');
		redirect("dashboard/index/penelitian");
	}

	function simpanpengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_pengabdian", true);

		// $config['file_name'] = 'pendukung_pkm_tambahan'.'_'.date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("filependukung");
		$data = $this->upload->data();
		$file = $_FILES['filependukung']['size'] && $_FILES['filependukung']['name'] ? $data["file_name"] : '';

		// $config2['file_name'] = 'pengabdian_tambahan'.'_'.date('dmyhis');
		$config2['upload_path'] = './assets/uploadbox/';
		$config2['allowed_types'] = 'pdf';
		$this->load->library('upload', $config2);

		$this->upload->do_upload("fileupload");
		$data2 = $this->upload->data();
		$file2 = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data2["file_name"] : '';

		$this->msubmitpribadi->simpanpengabdian($file, $file2);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Pengabdian Tambahan Telah Sukses Disimpan!');
		redirect("dashboard/index/pengabdian");
	}

	function simpanjurnal()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("idusulan_jurnal", true);

		$config['file_name'] = 'jurnal' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpanjurnal($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Jurnal Telah Sukses Disimpan!');
		redirect("dashboard/index/jurnal");
	}

	function simpanhki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("idusulan_hki", true);

		$config['file_name'] = 'hki' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpanhki($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'HKI Telah Sukses Disimpan!');
		redirect("dashboard/index/hki");
	}

	function simpanprosiding()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_prosiding", true);

		$config['file_name'] = 'prosiding' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpanprosiding($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Prosiding Telah Sukses Disimpan!');
		redirect("dashboard/index/prosiding");
	}

	function simpanbuku()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_buku", true);

		$config['file_name'] = 'buku' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpanbuku($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Buku Telah Sukses Disimpan!');
		redirect("dashboard/index/buku");
	}

	function simpankarya()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_karya", true);

		$config['file_name'] = 'karya' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpankarya($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Karya Monumental Telah Sukses Disimpan!');
		redirect("dashboard/index/karya");
	}

	function simpannaskah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id_naskah", true);

		$config['file_name'] = 'naskah' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->msubmitpribadi->simpannaskah($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Naskah Telah Sukses Disimpan!');
		redirect("dashboard/index/naskah");
	}
}
