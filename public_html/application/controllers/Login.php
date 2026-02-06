<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('mpengguna', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
	}

	public function index()
	{
		$this->load->view('login/user');
	}

	function cek()
	{
		$hasil = $this->mpengguna->login();
		// echo $this->db->last_query(); exit;	
		if ($hasil) {
			$data['user'] = $hasil;
			//liat id dosen/tambah
			$id_dosen = $this->mpengguna->id_dosen($hasil['id_user']);
			$skorsinta = $this->mdosen->skorsinta($hasil['id_user']);
			// Untuk Session-nya
			// echo $hasil['jenis'];exit();
			if ($hasil['jenis'] == 4) {
				$this->session->set_userdata('sesi_user', $hasil['email']);
				$this->session->set_userdata('sesi_nama', $hasil['namalengkap']);
				$this->session->set_userdata('sesi_status', $hasil['jenis']);
				$this->session->set_userdata('sesi_id', $hasil['id_user']);
				$this->session->set_userdata('sesi_dosen', $id_dosen['id_dosen']);
				// $this->session->set_userdata('sesi_institusi', $hasil['institusiluar']);
			} else {
				$this->session->set_userdata('sesi_user', $hasil['email']);
				$this->session->set_userdata('sesi_nama', $hasil['namalengkap']);
				$this->session->set_userdata('sesi_prodi', $hasil['prodi']);
				$this->session->set_userdata('sesi_fakultas', $hasil['fakultas']);
				$this->session->set_userdata('sesi_verified', $hasil['verified']);
				$this->session->set_userdata('sesi_status', $hasil['jenis']);
				$this->session->set_userdata('sesi_id', $hasil['id_user']);
				$this->session->set_userdata('sesi_wadek', $hasil['wadek']);
				$this->session->set_userdata('sesi_dosen', $id_dosen['id_dosen']);
				$this->session->set_userdata('sesi_sinta', $skorsinta['kolom1']);
				$this->session->set_userdata('sesi_jafung', $id_dosen['jabatanakademik']);
				$this->session->set_userdata('sesi_jenjang', $id_dosen['jenjangpendidikan']);
			}
			$data['sesi_status'] = $this->session->userdata('sesi_status');

			// Arahkan
			if (in_array($data['sesi_status'], [1, 2, 3, 4])) {
				$cek = $this->mpengguna->cekprofil();
				$this->mpengguna->logmasuk();

				$next = !$cek && in_array($data['sesi_status'], [2, 3]) ? "dosen/tambah" : "dashboard";
				redirect($next, $data);
			} else {
				$data['sesi_status'] = "";

				$this->session->set_flashdata('result', 'Maaf Anda Tidak Berhak Melihat Halaman Ini !!!!');
				redirect('login');
			}
		} else {
			$this->session->set_flashdata('result', 'Maaf Username dan Password Anda Salah');
			redirect('login');
		}
	}
}
