<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Award extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('mdosen', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('msubmitpribadi', '', TRUE);
		$this->load->model('maward', '', TRUE);
	}

	public function index()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$tahun = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['tahunan'] = $tahun;
		$data['buku'] = $this->maward->selectbuku($tahun);
		$data['prosiding'] = $this->maward->selectprosiding($tahun);

		$data['dosen'] = $this->mdosen->select();
		$data['riwayat'] = $this->msubmitpribadi->histori();
		$data['tambahan'] = $this->msubmitpribadi->tambahan();
		$data['tambahanpkm'] = $this->msubmitpribadi->tambahanpkm();
		$data['riwayatpkm'] = $this->msubmitpribadi->historipkm();

		// $data['listjurnal'] = $this->msubmitpribadi->selectjurnal();
		// $data['listhki'] = $this->msubmitpribadi->selecthki();

		$data['page'] = 'award/nominasi';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detail()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['dosen'] = $this->mdosen->select();
		$data['buku'] = $this->maward->selectbuku($this->uri->segment(6));
		$data['prosiding'] = $this->maward->selectprosiding($this->uri->segment(6));
		$data['riwayat'] = $this->msubmitpribadi->histori();
		$data['tambahan'] = $this->msubmitpribadi->tambahan();
		$data['tambahanpkm'] = $this->msubmitpribadi->tambahanpkm();
		$data['riwayatpkm'] = $this->msubmitpribadi->historipkm();

		// $data['listjurnal'] = $this->msubmitpribadi->selectjurnal();
		// $data['listhki'] = $this->msubmitpribadi->selecthki();

		$data['page'] = 'award/detail';
		$this->load->view('dashboard/dashboard', $data);
	}

	function validasi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$user = $this->input->post("user", true);
		$dosen = $this->input->post("dosen", true);
		$skor = $this->input->post("skor", true);
		$tahun = $this->input->post("tahun", true);

		$this->maward->validasi();
		// echo $this->db->last_query();exit;

		$this->session->set_flashdata('result', 'Nilai LPPM Award Telah Sukses Divalidasi!');
		redirect("award/detail/$user/$dosen/$skor/$tahun");
	}
}