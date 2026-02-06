<?php
Class Mkuesioner extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function lppm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","dosen.user=kuesioner.dosen");
		$this->db->where("kuesioner.nomor","lppm");
		$this->db->order_by("kuesioner.kirim","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function lppmpertahun($t)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","dosen.user=kuesioner.dosen");
		$this->db->where("kuesioner.nomor","lppm");
		$this->db->like("kuesioner.kirim",$t);
		//$this->db->order_by("kuesioner.kirim","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function pppm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","dosen.user=kuesioner.dosen");
		$this->db->where("kuesioner.nomor","pppm");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function pppmpertahun($t)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","dosen.user=kuesioner.dosen");
		$this->db->where("kuesioner.nomor","pppm");
		$this->db->like("kuesioner.kirim",$t);
		$this->db->order_by("kuesioner.kirim","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function tahun()
	{
		$data = array();
		$this->db->select("DISTINCT YEAR(kirim) as tahun");
		$this->db->from("kuesioner");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function jmldosen()
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("dosen");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function sudahlppm()
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","kuesioner.dosen=dosen.user");
		$this->db->where("kuesioner.nomor","lppm");
		$this->db->like("kuesioner.kirim",$thn);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function sudahpppm()
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","kuesioner.dosen=dosen.user");
		$this->db->where("kuesioner.nomor","pppm");
		$this->db->like("kuesioner.kirim",$thn);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function sudahlppmpertahun($t)
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","kuesioner.dosen=dosen.user");
		$this->db->where("kuesioner.nomor","lppm");
		$this->db->like("kuesioner.kirim",$t);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function sudahpppmpertahun($t)
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->join("dosen","kuesioner.dosen=dosen.user");
		$this->db->where("kuesioner.nomor","pppm");
		$this->db->like("kuesioner.kirim",$t);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function simpan()
	{
		$waktu = date('Y-m-d H:i:s');
		$kirim = date('Y-m-d');
		$data = array(
			"dosen"	=> $this->input->post("dosen",true),
			"nomor"	=> $this->input->post("ques",true),
			"ans1"	=> $this->input->post("ans1",true),
			"ans2"	=> $this->input->post("ans2",true),
			"ans3"	=> $this->input->post("ans3",true),
			"ans4"	=> $this->input->post("ans4",true),
			"ans5"	=> $this->input->post("ans5",true),
			"ans6"	=> $this->input->post("ans6",true),
			"ans7"	=> $this->input->post("ans7",true),
			"ans8"	=> $this->input->post("ans8",true),
			"ans9"	=> $this->input->post("ans9",true),
			"ans10"	=> $this->input->post("ans10",true),
			"ans11"	=> $this->input->post("ans11",true),
			"ans12"	=> $this->input->post("ans12",true),
			"ans13"	=> $this->input->post("ans13",true),
			"ans14"	=> $this->input->post("ans14",true),
			"ans15"	=> $this->input->post("ans15",true),
			"ans16"	=> $this->input->post("ans16",true),
			"saran"	=> $this->input->post("saran",true),
			"kirim" => $kirim
			);
			
		$this->db->insert("kuesioner",$data);
		
		// $datab = array(
		// 	"dosen"	=> $this->input->post("dosen",true),
		// 	"nomor"	=> $this->input->post("quesb",true),
		// 	"ans1"	=> $this->input->post("ans1b",true),
		// 	"ans2"	=> $this->input->post("ans2b",true),
		// 	"ans3"	=> $this->input->post("ans3b",true),
		// 	"ans4"	=> $this->input->post("ans4b",true),
		// 	"ans5"	=> $this->input->post("ans5b",true),
		// 	"ans6"	=> $this->input->post("ans6b",true),
		// 	"ans7"	=> $this->input->post("ans7b",true),
		// 	"ans8"	=> $this->input->post("ans8b",true),
		// 	"ans9"	=> $this->input->post("ans9b",true),
		// 	"ans10"	=> $this->input->post("ans10b",true),
		// 	"ans11"	=> $this->input->post("ans11b",true),
		// 	"ans12"	=> $this->input->post("ans12",true),
		// 	"ans13"	=> $this->input->post("ans13",true),
		// 	"ans14"	=> $this->input->post("ans14",true),
		// 	"ans15"	=> $this->input->post("ans15",true),
		// 	"ans16"	=> $this->input->post("ans16",true),
		// 	"saran"	=> $this->input->post("saranb",true),
		// 	"kirim" => $kirim
		// 	);
			
		// $this->db->insert("kuesioner",$datab);
		
		// echo $this->db->last_query();exit;
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah mengisi kuesioner pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
}