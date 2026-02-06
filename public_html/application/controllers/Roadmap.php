<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Roadmap extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

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

		$data['roadmap'] = $this->mroadmap->select();
		$data['roadmapdosen'] = $this->mroadmap->selectlainya();
		$data['hitprodi'] = $this->mroadmap->hitroadmapprodi();
		$data['hitdosen'] = $this->mroadmap->hitroadmapdosen();

		if ($this->session->userdata('sesi_status') == 1)
			$data['page'] = 'roadmap/peta';
		else
			$data['page'] = 'roadmap/petaprivat';
		$this->load->view('dashboard/dashboard', $data);
	}

	function prodi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> '1') and redirect('dashboard');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['namaprodi'] = $this->mroadmap->namaprodi($this->uri->segment(3));
		$data['roadmaprodi'] = $this->mroadmap->roadmaprodi($this->uri->segment(3));
		$data['hitroadmaprodi'] = $this->mroadmap->hitroadmaprodi($this->uri->segment(3));
		$data['prodi'] = $this->mroadmap->namadosen($this->uri->segment(3));
		$data['roadmap'] = $this->mroadmap->roadmaprodi($this->uri->segment(3));
		// echo $this->db->last_query();exit;
		
		$data['page'] = 'roadmap/prodi';
		$this->load->view('dashboard/dashboard', $data);
	}

	function update()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		// if($_FILES["dokumen"]["error"] == 4) {
		// $file = '';
		// }
		// else {
		$konversi = $this->input->post("judul", true) . date(his);
		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'doc|docx|pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("dokumen");
		$data = $this->upload->data();
		$file = $data["file_name"];
		// }

		$this->mroadmap->update($file);
		// echo $this->db->last_query();exit;

		$this->session->set_flashdata('result', 'Dokumen Roadmap Telah Sukses Diupdate!');
		redirect("roadmap");
	}

	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$konversi = $this->input->post("jenis", true) . '_' . date('his');

		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("dokumen");
		$data = $this->upload->data();

		$file = $data["file_name"];
		$this->mroadmap->simpan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Dokumen Roadmap Telah Sukses Disimpan!');
		redirect("roadmap");
	}

	function verifikasi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mroadmap->verifikasi($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Dokumen Roadmap Telah Sukses Diverifikasi!');
		redirect('roadmap');
	}

	function hapus()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mroadmap->hapus($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Dokumen Roadmap Telah Sukses Dihapus!');
		redirect('roadmap');
	}
}
