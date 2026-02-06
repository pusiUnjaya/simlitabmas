<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Profil extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('mpengguna', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
	}

	public function index()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';

		$data['profil'] = $this->mpengguna->profil();

		$data['page'] = 'dashboard/profil';
		$this->load->view('dashboard/dashboard', $data);
	}

	function gantipic()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$konversi = str_replace('.', '', $this->session->userdata('sesi_nama'));
		$konversi = str_replace(',', '', $konversi);

		$config['image_library'] = 'gd2';
		$config['file_name'] = $konversi;
		$config['upload_path'] = './assets/profilebox/';
		$config['allowed_types'] = 'png|jpg|jpeg|bmp';
		$this->load->library('upload', $config);

		$this->upload->do_upload("gantipic");
		$data = $this->upload->data();

		$max_height = 450;
		$max_width = 450;
		if ($data['image_width'] > $max_width || $data['image_height'] > $max_height) {
			$configResize = array(
				'source_image' => $data['full_path'],
				'width' => $max_width,
				'height' => $max_height,
				'maintain_ratio' => FALSE
			);

			$this->load->library('image_lib', $configResize);
			$this->image_lib->resize();
		}

		$file = $data["file_name"];
		$this->mpengguna->gantipic($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Foto Profil Telah Sukses Disimpan!');
		redirect("profil");
	}

	function edit()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['dosen'] = $this->mdosen->detail($this->uri->segment(3));

		$data['page'] = 'dashboard/editprofil';
		$this->load->view('dashboard/dashboard', $data);
	}

	function update()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$this->mdosen->update();

		$this->session->set_flashdata('result', 'Data Dosen Telah Sukses Diupdate!');
		redirect('profil');
	}
}
