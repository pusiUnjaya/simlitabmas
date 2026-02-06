<?php
Class Mklinik extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function selectpenelitian()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		if($this->session->userdata('sesi_status')<>1) 
		{
			$this->db->where("user",$this->session->userdata('sesi_id'));
		}
		$this->db->where("jenis","Penelitian");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectpkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		if($this->session->userdata('sesi_status')<>1) 
		{
			$this->db->where("user",$this->session->userdata('sesi_id'));
		}
		$this->db->where("jenis","Pengabdian");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function hitklinikdosen()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		$this->db->where("jenis","Roadmap Dosen");
		$this->db->where("user",$this->session->userdata('sesi_id'));
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function simpanpenelitian($file)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post("rab",true));
		$data = array(
			"user"			=> $this->session->userdata('sesi_id'),
			"jenis"			=> $this->input->post("jenis",true),
			"judul"			=> $this->input->post("judul",true),
			"skema"			=> $this->input->post("skema",true),
			"anggota"		=> $this->input->post("iddosen",true),
			"rab"			=> $dana,
			"dokumen"		=> $file,
			"modified"		=> $waktu
			);
			
		$this->db->insert("dokumenklinik",$data);
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Dokumen Klinik Proposal dengan nama ".$file." telah ditambahkan pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function updatepenelitian($file)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post("rab",true));
		
		if($file=='') {
			$data = array(
			"judul"			=> $this->input->post("judul",true),
			"skema"			=> $this->input->post("skema",true),
			"anggota"		=> $this->input->post("iddosen",true),
			"rab"			=> $dana,
			"modified"		=> $waktu
			);
		}
		else {
			$data = array(
			"judul"			=> $this->input->post("judul",true),
			"skema"			=> $this->input->post("skema",true),
			"anggota"		=> $this->input->post("iddosen",true),
			"rab"			=> $dana,
			"dokumen"		=> $file,
			"modified"		=> $waktu
			);
		}
			
		
		$this->db->where("idklinik",$this->input->post("idklinik",true));
		$this->db->update("dokumenklinik",$data);	
		
		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah mengubah Dokumen Proposal ".$file." ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function verifikasi($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
				"verifikasi"	=> '1'
			);
			
		$this->db->where("idroadmap",$id);
		$this->db->update("roadmap",$data);	
		
		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah memverifikasi Dokumen Roadmap ".$file." ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function detailprop($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		$this->db->where("idklinik",$id);
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}
	
	function prodi($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prodi");
		$this->db->where("fakultas",$id);
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function proposal($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		$this->db->join("dosen","dosen.user=dokumenklinik.user");
		$this->db->where("dosen.prodi",$id);
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	// function hitklinikprodi($id)
	// {
		// $data = array();
		// $this->db->select("*");
		// $this->db->from("dokumenklinik");
		// $this->db->where("prodi",$id);
		// $this->db->where("jenis","Roadmap Prodi");
		// $hasil = $this->db->get();
		// $data = $hasil->num_rows();
		
		// return $data;
	// }
	
	function namaprodi($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prodi");
		$this->db->where("id_prodi",$id);
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function namadosen($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->join("users","users.id_user=dosen.user");
		$this->db->join("dokumenklinik","dokumenklinik.user=dosen.user","left");
		$this->db->where("dosen.prodi",$id);
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		
		return $data;
	}
	
	function cekprodi($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("roadmap");
		$this->db->where("prodi",$id);
		$this->db->where("jenis",'Roadmap Prodi');
		$this->db->where("file <> ",'');
		$hasil = $this->db->get();
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekdosen($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		$this->db->join("dosen","dosen.user=dokumenklinik.user");
		$this->db->where("dosen.prodi",$id);
		$this->db->where("dokumenklinik.jenis",'Penelitian');
		$this->db->where("dokumenklinik.dokumen <> ",'');
		$hasil = $this->db->get();
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekdosenpkm($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		$this->db->join("dosen","dosen.user=dokumenklinik.user");
		$this->db->where("dosen.prodi",$id);
		$this->db->where("dokumenklinik.jenis",'Pengabdian');
		$this->db->where("dokumenklinik.dokumen <> ",'');
		$hasil = $this->db->get();
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function jumlahdosen($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->join("users","users.id_user=dosen.user");
		$this->db->where("dosen.prodi",$id);
		$this->db->where("users.verified",1);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function hapuspenelitian($id)
	{
		//lihat dokumen
		$this->db->select("*");
		$this->db->from("dokumenklinik");
		$this->db->where("idklinik",$id);
		$hapusin = $this->db->get();
		$mohapus = $hapusin->row_array();
		
		$this->db->where("idklinik",$id);
		$this->db->delete("dokumenklinik");
		
		unlink('./assets/uploadbox/'.$mohapus['file']);
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Dokumen Klinik Proposal ".$mohapus['judul']." pada tanggal ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
}