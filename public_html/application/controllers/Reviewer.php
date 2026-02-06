<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Reviewer extends CI_Controller
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
		($this->session->userdata('sesi_status') <> 1) and redirect('/');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['dosen'] = $this->mdosen->selectreviewer();

		$data['page'] = 'master/dosen/reviewer';
		$this->load->view('dashboard/dashboard', $data);
	}

	function setreviewer()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$id = $this->uri->segment(3);
		$this->mdosen->setreviewer($id);

		$this->session->set_flashdata('result', 'Data Dosen Telah Sukses Diupdate jadi Reviewer!');
		redirect('reviewer');
	}

	function unsetreviewer()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$id = $this->uri->segment(3);
		$this->mdosen->unsetreviewer($id);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Dosen Telah Sukses Diupdate Non Reviewer!');
		redirect("reviewer");
	}

}
