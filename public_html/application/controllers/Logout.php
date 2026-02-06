<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Logout extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mpengguna', '', TRUE);
	}

	public function index()
	{
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		$data = [
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " logout pada tanggal $wkt dari $_SERVER[REMOTE_ADDR]",
		];
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem

		$sesi_items = [
			'sesi_user' => '',
			'sesi_status' => '',
			'sesi_id' => '',
			'sesi_nama' => '',
		];
		$this->session->unset_userdata($sesi_items);
		session_destroy();

		redirect("login");
	}

}
