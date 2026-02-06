<?php
Class Maward extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function selectbuku($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		$this->db->where("tahun_terbit",$pilih);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectprosiding($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		$this->db->where("tahun",$pilih);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectjurnalq12()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("tahun_publikasi",date('Y'));
		$this->db->where("status_jurnal",'Published');
		$this->db->where("jenis_publikasi",'Jurnal Internasional Bereputasi');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectjurnalq34()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("tahun_publikasi",date('Y'));
		$this->db->where("status_jurnal",'Published');
		$this->db->where("jenis_publikasi",'Jurnal Internasional');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectjurnals12()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("tahun_publikasi",date('Y'));
		$this->db->where("status_jurnal",'Published');
		$this->db->where("jenis_publikasi",'Jurnal Nasional Terakreditasi 1-2');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectjurnals36()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("tahun_publikasi",date('Y'));
		$this->db->where("status_jurnal",'Published');
		$this->db->where("jenis_publikasi",'Jurnal Nasional Terakreditasi 3-6');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectjurnalissn($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("tahun_publikasi",$pilih);
		$this->db->where("status_jurnal",'Published');
		$this->db->where("jenis_publikasi",'Jurnal Nasional BerISSN');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function sudahisibelum()
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->where("dosen",$this->session->userdata('sesi_id'));
		$this->db->like("kirim",$thn);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}

	function validasi()
	{
		$skorsis = $this->input->post("skorsis",true);
		$skorval = $this->input->post("skorsis",true);
		$hit = count($skorsis);
		for($i=0;$i<$hit;$i++)
		{
			$data = array(
				"user"		=> $this->input->post("user",true),
				"skorsis"	=> $skorsis[$i],
				"skorval"	=> $skorval[$i]
				);
				
			$this->db->insert("topten",$data);
		}
	}
}