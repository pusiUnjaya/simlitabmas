<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Klinik extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mklinik', '', TRUE);
		$this->load->model('mroadmap', '', TRUE);
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

		$data['klinik'] = $this->mklinik->selectpenelitian();

		$access = $this->session->userdata('sesi_status') == 1 ? 'daftarklinik' : 'klinikprivat';
		$data['page'] = "klinik/$access";
		$this->load->view('dashboard/dashboard', $data);
	}

	function prodi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['namaprodi'] = $this->mklinik->namaprodi($this->uri->segment(3));
		$data['prodi'] = $this->mklinik->namadosen($this->uri->segment(3));
		// echo $this->db->last_query();exit;

		$access = $this->uri->segment(4) == 'pkm' ? 'pkm' : '';
		$data['page'] = "klinik/prodi$access";
		$this->load->view('dashboard/dashboard', $data);
	}

	function penelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['klinik'] = $this->mklinik->selectpenelitian();

		$access = $this->session->userdata('sesi_status') == 1 ? 'daftarklinik' : 'klinikprivat';
		$data['page'] = "klinik/$access";
		$this->load->view('dashboard/dashboard', $data);
	}

	function editpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['klinik'] = $this->mklinik->detailprop($this->uri->segment(3));

		$data['page'] = 'klinik/editpenelitian';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editpkm()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['klinik'] = $this->mklinik->detailprop($this->uri->segment(3));

		$data['page'] = 'klinik/editpkm';
		$this->load->view('dashboard/dashboard', $data);
	}

	function pengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['klinik'] = $this->mklinik->selectpkm();

		$access = $this->session->userdata('sesi_status') == 1 ? 'daftarklinik' : 'klinikprivat';
		$data['page'] = "klinik/{$access}pkm";
		$this->load->view('dashboard/dashboard', $data);
	}

	function uploadpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'klinik/upload';
		$this->load->view('dashboard/dashboard', $data);
	}

	function uploadpengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'klinik/uploadpkm';
		$this->load->view('dashboard/dashboard', $data);
	}

	function updatepenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$konversi = 'klinik_' . $this->input->post("jenis", true) . '_' . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("proposal");
		$data = $this->upload->data();

		$file = $_FILES['proposal']['size'] && $_FILES['proposal']['name'] ? $data["file_name"] : '';
		$this->mklinik->updatepenelitian($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Klinik Telah Sukses Diupdate!');
		redirect("klinik");

	}

	function updatepkm()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$konversi = 'klinik_' . $this->input->post("jenis", true) . '_' . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("proposal");
		$data = $this->upload->data();

		$file = $_FILES['proposal']['size'] && $_FILES['proposal']['name'] ? $data["file_name"] : '';
		$this->mklinik->updatepenelitian($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Klinik Telah Sukses Diupdate!');
		redirect("klinik/pengabdian");

	}

	function simpanpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$konversi = 'klinik_' . $this->input->post("jenis", true) . '_' . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("proposal");
		$data = $this->upload->data();
		$file = $data["file_name"];

		$this->mklinik->simpanpenelitian($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Klinik Proposal Telah Sukses Disimpan!');
		redirect("klinik");
	}

	function simpanpkm()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$konversi = 'klinik_' . $this->input->post("jenis", true) . '_' . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("proposal");
		$data = $this->upload->data();
		$file = $data["file_name"];

		$this->mklinik->simpanpenelitian($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Klinik Proposal Telah Sukses Disimpan!');
		redirect("klinik/pengabdian");
	}

	function verifikasi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mklinik->verifikasi($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Dokumen Klinik Telah Sukses Diverifikasi!');
		redirect('klinik');
	}

	function hapuspenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mklinik->hapuspenelitian($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Dokumen Klinik Telah Sukses Dihapus!');
		redirect('klinik');
	}

	function hapuspkm()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mklinik->hapuspenelitian($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Dokumen Klinik Telah Sukses Dihapus!');
		redirect('klinik/pengabdian');
	}
}
