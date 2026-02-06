<?php
Class Mdownload extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		// $this->db->where("jenis <>","1");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetugas()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Surat Tugas");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetkontrak()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Surat Kontrak");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetserti()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Sertifikat");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetijin()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Ijin Penelitian");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetusulan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Template - Usulan");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetkemajuan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Template - Kemajuan");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function risetakhir()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Template - Akhir");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmtugas()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Surat Tugas");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmkontrak()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Surat Kontrak");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmijin()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Ijin Penelitian");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmserti()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Sertifikat");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmusulan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Template - Usulan");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmkemajuan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Template - Kemajuan");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmakhir()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Pengabdian");
		$this->db->where("katedok","Template - Akhir");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pedoman()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","Pedoman");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function sop()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","SOP");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function kebijakan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","Kebijakan");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function sentrahki()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","Sentra HKI");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function unjayapress()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","Unjaya Press");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function etik()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","Etik Penelitian");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function lain()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Dokumen LPPM");
		$this->db->where("katedok","Lain - Lain");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function hitrisetkontrak()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("jenisdok","Penelitian");
		$this->db->where("katedok","Surat Kontrak");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function simpan($file)
	{
		$waktu = date('Y-m-d H:i:s');
		if($this->input->post("jenisdok",true)=='Dokumen LPPM')
			$isian = $this->input->post("lppmdok",true);
		else
			$isian = $this->input->post("katedok",true);
		
		$data = array(
			"judul"			=> $this->input->post("judul",true),
			"keterangan"	=> $this->input->post("keterangan",true),
			"jenisdok"		=> $this->input->post("jenisdok",true),
			"katedok"		=> $isian,
			"file"			=> $file,
			"modified"		=> $waktu
			);
			
		$this->db->insert("download",$data);
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Dokumen dengan nama ".$file." telah ditambahkan pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function update($file)
	{
		$waktu = date('Y-m-d H:i:s');

		if($this->input->post("jenisdok",true)=='Dokumen LPPM')
			$isian = $this->input->post("elppmdok",true);
		else
			$isian = $this->input->post("ekatedok",true);

		if($file=='') {
			$data = array(
				"judul"			=> $this->input->post("judul",true),
				"keterangan"	=> $this->input->post("keterangan",true),
				"jenisdok"		=> $this->input->post("jenisdok",true),
				"katedok"		=> $isian,
				"modified"		=> $waktu
			);
		}
		else {
			$data = array(
				"judul"			=> $this->input->post("judul",true),
				"keterangan"	=> $this->input->post("keterangan",true),
				"jenisdok"		=> $this->input->post("jenisdok",true),
				"katedok"		=> $isian,
				"file"			=> $file,
				"modified"		=> $waktu
			);
		}
			
		
		$this->db->where("id_file",$this->input->post("id",true));
		$this->db->update("download",$data);	
		
		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah mengubah Dokumen ".$file." ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function detail($id)
	{
			$data = array();
			$this->db->select("*");
			$this->db->from("download");
			$this->db->where("id_file",$id);
			$hasil = $this->db->get();
			if($hasil->num_rows() > 0)
			{
				$data = $hasil->row_array();
			}
			$hasil->free_result();
			return $data;
	}
	
	function hapus($id)
	{
		//lihat dokumen
		$this->db->select("*");
		$this->db->from("download");
		$this->db->where("id_file",$id);
		$hapusin = $this->db->get();
		$mohapus = $hapusin->row_array();
		
		$this->db->where("id_file",$id);
		$this->db->delete("download");
		
		unlink('./assets/uploadbox/'.$mohapus['file']);
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Dokumen ".$mohapus['judul']." pada tanggal ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
}