<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi extends CI_Controller {
	function __construct()
	{
		parent::__construct();
        $this->load->model('mdosen', '', TRUE);
        $this->load->model('mpengguna', '', TRUE);
        $this->load->model('msubmit', '', TRUE);
        $this->load->model('mdownload', '', TRUE);
        $this->load->model('mpengabdian', '', TRUE);
        $this->load->model('msubmitpribadi', '', TRUE);
		$this->load->model('mvalidasi', '', TRUE);
		$this->load->model('mroadmap', '', TRUE);
	}
	
	public function index()
	{
		if($this->session->userdata('sesi_status')==3 && $this->session->userdata('sesi_wadek')==0)
			return redirect('/');
		
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['page'] = 'validasi/penelitian';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function penelitian()
	{
		if($this->session->userdata('sesi_status')==2 || $this->session->userdata('sesi_status')==3)
			return redirect('/');
		
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		
		$data['tambahan'] = $this->mvalidasi->risettambahan();
		$data['hitplus'] = count($data['tambahan']);
		$data['page'] = 'validasi/penelitian';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function pengabdian()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		
		$data['tambahan'] = $this->mvalidasi->pkmtambahan();
		$data['hitplus'] = count($data['tambahan']);
		$data['page'] = 'validasi/pengabdian';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function jurnal()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tambahan'] = $this->mvalidasi->jurnaltambahan();
		// echo $this->db->last_query();exit;
		$data['hitplus'] = count($data['tambahan']);
		
		$data['page'] = 'validasi/jurnal';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function hki()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tambahan'] = $this->mvalidasi->hkitambahan();
		$data['hitplus'] = count($data['tambahan']);
		
		$data['page'] = 'validasi/hki';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function prosiding()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tambahan'] = $this->mvalidasi->prosidingtambahan();
		$data['hitplus'] = count($data['tambahan']);
		$data['page'] = 'validasi/prosiding';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function buku()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tambahan'] = $this->mvalidasi->bukutambahan();
		$data['hitplus'] = count($data['tambahan']);
		$data['page'] = 'validasi/buku';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function naskah()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tambahan'] = $this->mvalidasi->naskahtambahan();
		$data['hitplus'] = count($data['tambahan']);
		$data['page'] = 'validasi/naskah';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function karya()
	{
		if($this->session->userdata('sesi_status')==3)
			return redirect('/');
		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['prodi'] = $this->mdosen->selectprodi();
		$data['tambahan'] = $this->mvalidasi->karyatambahan();
		$data['hitplus'] = count($data['tambahan']);
		$data['page'] = 'validasi/karya';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	function load_prodi($fak)
	{
		$query = $this->mdosen->prodi($fak);
		$data = "<option value=''>-- Pilih Prodi --</option>";
		foreach($query as $value) {
			$data .= "<option value='".$value->id_prodi."'>".$value->prodi."</option>";
		}
		echo $data;
	}

	function detailpenelitian()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');

		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['tambahan'] = $this->mvalidasi->detailpenelitian();
		$data['page'] = 'validasi/detailpenelitian';
		$this->load->view('dashboard/dashboard',$data);
	}

	function updatepenelitian()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updateriset($this->uri->segment(3));
		$this->session->set_flashdata('result', 'Validasi Data Penelitian Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/penelitian");
	}

	function detailpengabdian()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');

		$data = array();
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['tambahan'] = $this->mvalidasi->detailpengabdian();
		$data['page'] = 'validasi/detailpengabdian';
		$this->load->view('dashboard/dashboard',$data);
	}

	function updatepkm()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updatepkm($this->uri->segment(3));
		$this->session->set_flashdata('result', 'Validasi Data PkM Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/pengabdian");
	}

	function updatejurnal()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updatejurnal();
		$this->session->set_flashdata('result', 'Validasi Data Jurnal Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/jurnal");
	}

	function updatehki()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updatehki();
		$this->session->set_flashdata('result', 'Validasi Data HKI Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/hki");
	}

	function updateprosiding()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updateprosiding($this->uri->segment(3));
		$this->session->set_flashdata('result', 'Validasi Data Prosiding Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/prosiding");
	}

	function updatebuku()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updatebuku($this->uri->segment(3));
		$this->session->set_flashdata('result', 'Validasi Data Buku Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/buku");
	}

	function updatekarya()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updatekarya($this->uri->segment(3));
		$this->session->set_flashdata('result', 'Validasi Data Karya Monumental Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/karya");
	}

	function updatenaskah()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->mvalidasi->updatenaskah($this->uri->segment(3));
		$this->session->set_flashdata('result', 'Validasi Data Naskah Akademik Telah Sukses Disimpan!');
		// echo $this->db->last_query();exit;	
		redirect("validasi/naskah");
	}
}
