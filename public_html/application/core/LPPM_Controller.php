<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LPPM_Controller extends CI_Controller
{

	protected $sesi_id;
	protected $sesi_status;

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');

		$this->sesi_id = $this->session->userdata('sesi_id');
		$this->sesi_status = $this->session->userdata('sesi_status');
	}

	protected function check_login()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
	}

	protected function check_admin()
	{
		$this->is_admin() or redirect('/');
	}

	protected function check_dosen()
	{
		$this->is_dosen() or redirect('/');
	}

	protected function fail($msg)
	{
		throw new Exception($msg);
	}

	protected function is_admin()
	{
		return $this->sesi_status == 1;
	}

	protected function is_kaprodi()
	{
		return $this->sesi_status == 2;
	}

	protected function is_dosen()
	{
		return in_array($this->sesi_status, [2, 3]);
	}

	protected function is_external()
	{
		return $this->sesi_status == 4;
	}

	protected function is_wadek()
	{
		return $this->session->userdata('sesi_wadek') == 1;
	}

	protected function load_models($models)
	{
		foreach ($models as $model) {
			$this->load->model("m$model", '', true);
		}
	}
}
