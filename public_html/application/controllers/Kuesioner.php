<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Kuesioner extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('mpengguna', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('mkuesioner', '', TRUE);
	}

	public function index()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'submit/kuesioner';
		$this->load->view('dashboard/dashboard', $data);
	}

	function data()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['tahun'] = $this->mkuesioner->tahun();
		$data['lppm'] = $this->mkuesioner->lppm();
		$data['pppm'] = $this->mkuesioner->pppm();
		$data['dosen'] = $this->mkuesioner->jmldosen();
		$data['sudahlppm'] = $this->mkuesioner->sudahlppm();
		$data['sudahpppm'] = $this->mkuesioner->sudahpppm();

		$data['page'] = 'kuesioner/datakuesioner';
		$this->load->view('dashboard/dashboard', $data);
	}

	function ekspor()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->uri->segment(3) == 'lppm' && $this->uri->segment(4) == '')
			$data['lppm'] = $this->mkuesioner->lppm();
		elseif ($this->uri->segment(3) == 'lppm' && $this->uri->segment(4) <> '')
			$data['lppm'] = $this->mkuesioner->lppmpertahun($this->uri->segment(4));
		elseif ($this->uri->segment(3) == 'pppm' && $this->uri->segment(4) <> '')
			$data['lppm'] = $this->mkuesioner->pppmpertahun($this->uri->segment(4));
		else
			$data['lppm'] = $this->mkuesioner->pppm();

			$data['date'] = date('dmYHis');
		$data['jenis'] = $this->uri->segment(3);

		$this->load->view('kuesioner/ekspor', $data);
	}

	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mkuesioner->simpan();
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Kuesioner Telah Sukses Disimpan!');
		redirect("submit");
	}
}
