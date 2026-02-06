<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Dosen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

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

		$data['dosen'] = $this->mdosen->select();

		$data['page'] = 'master/dosen/dosen';
		$this->load->view('dashboard/dashboard', $data);
	}

	function keprodi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['dosen'] = $this->mdosen->selectkeprodi();

		$data['page'] = 'master/dosen/keprodi';
		$this->load->view('dashboard/dashboard', $data);
	}

	function ekspordosen()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['dosen'] = $this->mdosen->selectekspor();
		// echo $this->db->last_query();exit;

		$this->load->view('master/dosen/ekspordosen', $data);
	}

	function tambah()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		// ($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();

		$data['page'] = 'master/dosen/addosen';
		$this->load->view('dashboard/dashboard', $data);
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

	function datadosen()
	{
		$query = $this->mdosen->datadosen($this->uri->segment(3));

		$jum = count($query);
		if ($jum > 0) {
			$prodi = $this->mdosen->namaprodi($query['prodi']);

			$data = "<p></p>
				<h6>" . $query['namalengkap'] . "</h6>
					Prodi : " . $prodi['prodi'] . "<br>
					Email : " . $query['email'] . "<br>
					Skor Sinta : " . $query['skorsinta'] . "</p>
			";
			echo $data;
		}
	}

	function datamhs()
	{
		$query = $this->mdosen->datamhs($this->uri->segment(3));

		if ($query > 0) {
			echo "NPM sudah terdaftar.";
		}
		else {
			echo "NPM tersedia.";
		}
	}

	function edit()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['dosen'] = $this->mdosen->detail($this->uri->segment(3));

		$data['page'] = 'master/dosen/editdosen';
		$this->load->view('dashboard/dashboard', $data);
	}

	function gantipassword()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mdosen->gantipassword();
		redirect('dosen');
	}

	function update()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$this->mdosen->update();

		$this->session->set_flashdata('result', 'Data Dosen Telah Sukses Diupdate!');
		redirect('dosen');
	}

	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mdosen->simpan();
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Dosen Telah Sukses Disimpan!');
		if ($this->session->userdata('sesi_status') <> 1)
			$this->session->set_userdata('sesi_nama', $this->input->post('namalengkap', true));
		redirect($this->session->userdata('sesi_status') <> 3 ? 'dosen' : 'profil');
	}

	function hapus()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mdosen->hapus($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Dosen Telah Sukses Dihapus!');
		redirect('dosen');
	}
}
