<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Register extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mpengguna', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
	}

	public function index()
	{
		$data['fakultas'] = $this->mdosen->fakultas();
		$this->load->view('login/register', $data);
	}

	function cekemail()
	{
		$email = $this->input->post('email');
		$exists = $this->mpengguna->cekuser($email);

		try {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception('Email tidak valid');
			if ($exists > 0) throw new Exception('Email sudah digunakan');

			$msg = [
				'valid' => true,
				'msg' => 'Email tersedia',
			];
		} catch (Exception $e) {
			$msg = [
				'valid' => false,
				'msg' => $e->getMessage(),
			];
		}

		/*
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if ($exists > 0) {
				$msg = [
					'valid' => false,
					'msg' => 'Email sudah digunakan',
				];
			} else {
				$msg = [
					'valid' => true,
					'msg' => 'Email tersedia',
				];
			}
		} else {
			$msg = [
				'valid' => false,
				'msg' => 'Email tidak valid',
			];
		}
		*/

		echo json_encode($msg);
	}

	function simpan()
	{
		$email = $this->input->post("email", true);
		$captcha = $this->input->post("captcha", true);

		try {
			if ($this->mpengguna->cekuser($email) > 0) throw new Exception('Email sudah Dipakai! Ulangi Lagi!');
			if ($captcha != $this->session->userdata('setlog')) throw new Exception('Captcha tidak sesuai');

			$this->mpengguna->simpan();

			$msg = 'Pengguna Telah Sukses Dibuat! Silakan Login!';
			$next = "login";
		} catch (Exception $e) {
			$msg = $e->getMessage();
			$next = "register";
		}

		$this->session->set_flashdata('result', $msg);
		redirect($next);

		/*
		if ($this->mpengguna->cekuser($email) > 0) {
			$this->session->set_flashdata('result', 'Email sudah Dipakai! Ulangi Lagi!');
			redirect("register");
		} else {
			if ($captcha == $this->session->userdata('setlog')) {
				$this->mpengguna->simpan();

				$this->session->set_flashdata('result', 'Pengguna Telah Sukses Dibuat! Silakan Login!');
				redirect("login");
			} else {
				$this->session->set_flashdata('result', 'Captcha tidak sesuai');
				redirect("register");
			}
		}
		*/
		// echo $this->db->last_query();exit;	
	}
}
