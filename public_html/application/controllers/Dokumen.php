<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Dokumen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mdownload', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
	}

	public function index()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['bagian'] = 'Surat Tugas Penelitian';
		$data['download'] = $this->mdownload->risetugas();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'publik';
		$data['page'] = "master/download/{$access}dok";
		$this->load->view('dashboard/dashboard', $data);
	}

	function risetugas()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Surat Tugas Penelitian';
		$data['download'] = $this->mdownload->risetugas();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function risetkontrak()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Surat Kontrak Penelitian';
		$data['download'] = $this->mdownload->risetkontrak();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function risetserti()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Sertifikat Penelitian';
		$data['download'] = $this->mdownload->risetserti();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function risetijin()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Surat Ijin Penelitian';
		$data['download'] = $this->mdownload->risetijin();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function risetusulan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Template Usulan Penelitian';
		$data['download'] = $this->mdownload->risetusulan();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function risetkemajuan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Template Laporan Kemajuan Penelitian';
		$data['download'] = $this->mdownload->risetkemajuan();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function risetakhir()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Template Laporan Akhir Penelitian';
		$data['download'] = $this->mdownload->risetakhir();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmtugas()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Surat Tugas Pengabdian';
		$data['download'] = $this->mdownload->pkmtugas();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmkontrak()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Surat Kontrak Pengabdian';
		$data['download'] = $this->mdownload->pkmkontrak();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmserti()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Sertifikat Pengabdian';
		$data['download'] = $this->mdownload->pkmserti();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmijin()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Surat Ijin Pengabdian';
		$data['download'] = $this->mdownload->pkmijin();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmusulan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Template Usulan Pengabdian';
		$data['download'] = $this->mdownload->pkmusulan();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmkemajuan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Template Laporan Kemajuan Pengabdian';
		$data['download'] = $this->mdownload->pkmkemajuan();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pkmakhir()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Template Laporan Akhir Pengabdian';
		$data['download'] = $this->mdownload->pkmakhir();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function pedoman()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - Pedoman';
		$data['download'] = $this->mdownload->pedoman();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function sop()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - SOP';
		$data['download'] = $this->mdownload->sop();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function kebijakan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - Kebijakan';
		$data['download'] = $this->mdownload->kebijakan();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function sentrahki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - Sentra HKI';
		$data['download'] = $this->mdownload->sentrahki();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function unjayapress()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - Unjaya Press';
		$data['download'] = $this->mdownload->unjayapress();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function etik()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - Etik Penelitian';
		$data['download'] = $this->mdownload->etik();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function lain()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data['bagian'] = 'Dokumen LPPM - Lain - Lain';
		$data['download'] = $this->mdownload->lain();

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : 'data';
		$this->load->view("master/download/{$access}table", $data);
	}

	function tambah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'master/download/addfile';
		$this->load->view('dashboard/dashboard', $data);
	}

	function edit()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['download'] = $this->mdownload->detail($this->uri->segment(3));

		$data['page'] = 'master/download/editfile';
		$this->load->view('dashboard/dashboard', $data);
	}

	function update()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		// if ($_FILES["dokumen"]["error"] == 4) {
		// $file = '';
		// }
		// else {
		// $konversi = $this->input->post("judul", true) . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = 'dokumen_lppm' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'doc|docx|pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("dokumen");
		$data = $this->upload->data();
		$file = $data["file_name"];
		// }

		$this->mdownload->update($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Telah Sukses Diupdate!');
		redirect("dokumen");

	}

	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		// $konversi = $this->input->post("judul", true) . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = 'dokumen_lppm' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'doc|docx|pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("dokumen");
		$data = $this->upload->data();
		$file = $data["file_name"];

		$this->mdownload->simpan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Telah Sukses Disimpan!');
		redirect("dokumen");
	}

	function hapus()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mdownload->hapus($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Dokumen Telah Sukses Dihapus!');
		redirect('dokumen');
	}
}
