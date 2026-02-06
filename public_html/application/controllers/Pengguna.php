<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Pengguna extends CI_Controller
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
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('tampil')) ? 25 : $this->input->post('tampil');
		$data['pengguna'] = $this->mpengguna->select($pilih);
		// echo $this->db->last_query();exit;	

		$data['page'] = 'master/pengguna/pengguna';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();

		$data['page'] = 'master/pengguna/adduser';
		$this->load->view('dashboard/dashboard', $data);
	}

	function edit()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['pengguna'] = $this->mpengguna->detail($this->uri->segment(3));

		$data['page'] = 'master/pengguna/edituser';
		$this->load->view('dashboard/dashboard', $data);
	}

	function load_prodi($fak)
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$query = $this->mdosen->prodi($fak);
		$data = "<option value=''>-- Pilih Prodi --</option>";
		foreach ($query as $value) {
			$data .= "<option value='" . $value->id_prodi . "'>" . $value->prodi . "</option>";
		}

		echo $data;
	}

	function gantipassword()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengguna->gantipassword();

		redirect('dashboard');
	}

	function update()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$this->mpengguna->update();

		$this->session->set_flashdata('result', 'Data Pengguna Telah Sukses Diupdate!');
		redirect('pengguna');
	}

	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengguna->simpan();
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Pengguna Telah Sukses Disimpan!');
		redirect("pengguna");
	}

	function verifikasi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengguna->verifikasi($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Pengguna Telah Sukses Diverifikasi!');
		redirect('pengguna');
	}

	function blok()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengguna->blok($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Pengguna Telah Sukses Diblok!');
		redirect('pengguna');
	}

	function hapus()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengguna->hapus($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Pengguna Telah Sukses Dihapus!');
		redirect('pengguna');
	}
}
