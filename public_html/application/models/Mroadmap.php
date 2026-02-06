<?php
Class Mroadmap extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("roadmap");
		if($this->session->userdata('sesi_status')<>1) 
		{
			$this->db->where("user",$this->session->userdata('sesi_id'));
		}
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectekspor()
	{
		$data = array();
		$this->db->select("*,d.fakultas,d.prodi");
		$this->db->from("dosen d");
		$this->db->join("users","users.id_user=d.user");
		$this->db->join("roadmap","roadmap.user=d.user","left");
		//$this->db->where("roadmap.jenis","Roadmap Dosen");
		$this->db->where("users.verified","1");
		$this->db->order_by("d.fakultas,d.prodi,d.namalengkap","asc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectlainya()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("roadmap");
		if($this->session->userdata('sesi_status')=='2') 
		{
			$this->db->where("user <> ",$this->session->userdata('sesi_id'));
			$this->db->where("prodi",$this->session->userdata('sesi_prodi'));
			$this->db->where("jenis",'Roadmap Dosen');
		}
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function hitroadmapprodi()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("roadmap");
		$this->db->where("jenis","Roadmap Prodi");
		$this->db->where("user",$this->session->userdata('sesi_id'));
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}

	function rmprodi()
	{
		$data = array();
		// $this->db->select("*");
		// $this->db->from("roadmap");
		// $this->db->where("jenis","Roadmap Prodi");
		// $this->db->where("prodi",$this->session->userdata('sesi_prodi'));
		// $this->db->order_by("modified","desc");
		// $hasil = $this->db->get();
		
		// if($hasil->num_rows() > 0)
		// {
			// $data = $hasil->result();
		// }
		
		$query = $this->db->query("
			SELECT rd.*
			FROM roadmap rd
			JOIN (
				SELECT `user`, MAX(modified) AS modified
				FROM roadmap
				GROUP BY `user`
			) latest
			ON rd.`user` = latest.`user` AND rd.modified = latest.modified
			WHERE rd.prodi = ".$this->session->userdata('sesi_prodi')." and rd.jenis = 'Roadmap Prodi'
		");
		
		$data = $query->result();
		
		return $data;
	}
	
	function hitroadmapdosen()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("roadmap");
		$this->db->where("jenis","Roadmap Dosen");
		$this->db->where("user",$this->session->userdata('sesi_id'));
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function simpan($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		if($this->input->post("jenis",true)=='Roadmap Prodi')
			$ok = 1;
		elseif($this->session->userdata('sesi_status')==2)
			$ok = 1;
		else
			$ok = 0;
		
		$data = array(
			"user"			=> $this->session->userdata('sesi_id'),
			"prodi"			=> $this->session->userdata('sesi_prodi'),
			"jenis"			=> $this->input->post("jenis",true),
			"verifikasi"	=> $ok,
			"file"			=> $file,
			"modified"		=> $waktu
			);
			
		$this->db->insert("roadmap",$data);
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Dokumen Roadmap dengan nama ".$file." telah ditambahkan pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function update($file)
	{
		$waktu = date('Y-m-d H:i:s');
		if($file=='') {
			$data = array(
				"jenis"			=> $this->input->post("jenis",true),
				"modified"		=> $waktu
			);
		}
		else {
			$data = array(
				"jenis"			=> $this->input->post("jenis",true),
				"file"			=> $file,
				"modified"		=> $waktu
			);
		}
			
		
		$this->db->where("idroadmap",$this->input->post("id",true));
		$this->db->update("roadmap",$data);	
		
		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah mengubah Dokumen Roadmap ".$file." ".tgl_indo($waktu,1)
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
	
	function detail($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("roadmap");
		$this->db->where("idroadmap",$id);
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
	
	function roadmaprodi($id)
	{
		$data = array();
		// $this->db->select("*");
		// $this->db->from("roadmap");
		// $this->db->where("prodi",$id);
		// $this->db->where("jenis","Roadmap Prodi");
		// $hasil = $this->db->get();
		
		$query = $this->db->query("
			SELECT rd.* 
			FROM roadmap rd 
			JOIN ( 
				SELECT prodi, MAX(modified) AS modified 
				FROM roadmap WHERE jenis = 'Roadmap Prodi' 
				GROUP BY prodi ) latest 
			ON rd.prodi = latest.prodi AND rd.modified = latest.modified 
			WHERE rd.jenis = 'Roadmap Prodi' and rd.prodi = ".$id."; 
		");
		
		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
		}
		return $data;
	}
	
	function hitroadmaprodi($id)
	{
		$data = array();
		$query = $this->db->query("
			SELECT rd.* 
			FROM roadmap rd 
			JOIN ( 
				SELECT prodi, MAX(modified) AS modified 
				FROM roadmap WHERE jenis = 'Roadmap Prodi' 
				GROUP BY prodi ) latest 
			ON rd.prodi = latest.prodi AND rd.modified = latest.modified 
			WHERE rd.jenis = 'Roadmap Prodi' and rd.prodi = ".$id."; 
		");
		
		$data = $query->num_rows();
		
		return $data;
	}
	
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
		$this->db->select("dosen.id_dosen,dosen.user,users.jenis level,dosen.namalengkap namadosen");
		$this->db->from("dosen");
		$this->db->join("users","users.id_user=dosen.user");
		// $this->db->join("roadmap","roadmap.user=dosen.user","left");
		$this->db->where("dosen.prodi",$id);
		$this->db->where("users.verified",1);
		$this->db->order_by("dosen.namalengkap","asc");
		$hasil = $this->db->get();
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		
		return $data;
	}
	
	// function dokumen($id)
	// {
		// $data = array();
		// $this->db->select("*");
		// $this->db->from("roadmap");
		// $this->db->where("user",$id);
		// $this->db->where("jenis","Roadmap Dosen");
		// $this->db->order_by("modified","desc");
		// $hasil = $this->db->get();
		// if($hasil->num_rows() > 0)
		// {
			// $data = $hasil->result();
		// }
		
		// return $data;
	// }
	
	function dokumen($id)
	{
		$data = array();
		$query = $this->db->query("
			SELECT rd.*
			FROM roadmap rd
			JOIN (
				SELECT `user`, MAX(modified) AS modified
				FROM roadmap
				GROUP BY `user`
			) latest
			ON rd.`user` = latest.`user` AND rd.modified = latest.modified
			WHERE rd.user = ".$id." and rd.jenis='Roadmap Dosen'
		");
		
		$hit = $query->num_rows();
		
		if($hit > 0)
		{
			$data = $query->result();
		}
		
		return $data;
	}
	
	function hitdokumen($id)
	{
		$data = array();
		$query = $this->db->query("
			SELECT rd.*
			FROM roadmap rd
			JOIN (
				SELECT `user`, MAX(modified) AS modified
				FROM roadmap
				GROUP BY `user`
			) latest
			ON rd.`user` = latest.`user` AND rd.modified = latest.modified
			WHERE rd.user = ".$id." and rd.jenis='Roadmap Dosen'
		");
		$data = $query->num_rows();
		
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
		$this->db->from("roadmap");
		$this->db->where("prodi",$id);
		$this->db->where("jenis",'Roadmap Dosen');
		$this->db->where("file <> ",'');
		$hasil = $this->db->get();
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function roadmapvalid($id)
	{
		$data = array();
		$query = $this->db->query("
			SELECT rd.*
			FROM roadmap rd
			JOIN (
				SELECT `user`, MAX(modified) AS modified
				FROM roadmap
				GROUP BY `user`
			) latest
			ON rd.`user` = latest.`user` AND rd.modified = latest.modified
			WHERE prodi = ".$id."
		");
		$data = $query->num_rows();
		
		return $data;
	}
	
	function hapus($id)
	{
		//lihat dokumen
		$this->db->select("*");
		$this->db->from("roadmap");
		$this->db->where("idroadmap",$id);
		$hapusin = $this->db->get();
		$mohapus = $hapusin->row_array();
		
		$this->db->where("idroadmap",$id);
		$this->db->delete("roadmap");
		
		unlink('./assets/uploadbox/'.$mohapus['file']);
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Dokumen Roadmap ".$mohapus['judul']." pada tanggal ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
}