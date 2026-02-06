<?php
Class Msubmitpribadi extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function histori()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->join("lap_akhir","lap_akhir.id_usulan=usulan.id_usulan");
		$this->db->where("lap_akhir.file_laporan_akhir <>","");
		$this->db->order_by("usulan.tglmulai","desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function bukaan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("bukaan");
		$this->db->order_by("idbukaan","asc");
		$this->db->limit(1);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}

	function bukatutup()
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
				"tglbuka"	=> $this->input->post("buka",true),
				"tgltutup"	=> $this->input->post("tutup",true),
				"modified"	=> $waktu
				);
		$this->db->where("idbukaan",1);
		$this->db->update("bukaan",$data);
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Pengabdian Tambahan telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function historipkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm","lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.file_laporan_akhir <>","");
		$this->db->order_by("usulan_pkm.tglmulai","desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function cekjudul($ini)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("judul",$ini);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekjudulhki($ini)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("judul",$ini);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekjudulpros($ini)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		$this->db->where("judul",$ini);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekjudulbuku($ini)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		$this->db->where("judul",$ini);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekjudulkarya($ini)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("karya_monumental");
		$this->db->where("judul",$ini);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function cekjudulnaskah($ini)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		$this->db->where("judul",$ini);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function tambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("penelitian_tambahan");
		$this->db->join("dosen","dosen.user=penelitian_tambahan.user");
		//$this->db->where("penelitian_tambahan.file_laporan_akhir <>","");
		// if(penelitian_tambahan.tahun>=2023)
		// 	$this->db->where("penelitian_tambahan.validasi","1");
		$this->db->order_by("penelitian_tambahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function tambahanpkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("pengabdian_tembahan");
		$this->db->join("dosen","dosen.user=pengabdian_tembahan.user");
		//$this->db->where("pengabdian_tembahan.filelaporan <>","");
		$this->db->order_by("pengabdian_tembahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function editpenelitian()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("penelitian_tambahan");
		$this->db->join("dosen","dosen.user=penelitian_tambahan.user");
		$this->db->where("penelitian_tambahan.id_penelitian",$this->uri->segment(3));
		$this->db->order_by("penelitian_tambahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function editpengabdian()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("pengabdian_tembahan");
		$this->db->join("dosen","dosen.user=pengabdian_tembahan.user");
		$this->db->where("pengabdian_tembahan.id_pengabdian",$this->uri->segment(3));
		$this->db->order_by("pengabdian_tembahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function editjurnal()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->join("dosen","dosen.user=jurnal.user");
		$this->db->where("jurnal.id_jurnal",$this->uri->segment(3));
		$this->db->order_by("jurnal.tahun_publikasi","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function edithki()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->join("dosen","dosen.user=hki.user");
		$this->db->where("hki.id_hki",$this->uri->segment(3));
		$this->db->order_by("hki.tahun_pelaksanaan","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function caripenulisjurnal($usulan)
	{
		$data = array();
		$this->db->select("anggotadosen,pengusul,authorlain");
		$this->db->from("usulan");
		$this->db->join("jurnal","jurnal.usulan=usulan.id_usulan");
		$this->db->where("usulan.id_usulan",$usulan);
		$this->db->where("jurnal.status_jurnal","Published");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function hitpenulisjurnal($usulan)
	{
		$data = array();
		$this->db->select("anggotadosen,pengusul,authorlain");
		$this->db->from("usulan");
		$this->db->join("jurnal","jurnal.usulan=usulan.id_usulan");
		$this->db->where("usulan.id_usulan",$usulan);
		$this->db->where("jurnal.status_jurnal","Published");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function caripenulisjurnalpkm($usulan)
	{
		$data = array();
		$this->db->select("anggotadosen,pengusul,authorlain");
		$this->db->from("usulan_pkm");
		$this->db->join("jurnal","jurnal.usulan=usulan_pkm.id_usulan");
		$this->db->where("usulan_pkm.id_usulan",$usulan);
		$this->db->where("jurnal.status_jurnal","Published");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function hitpenulisjurnalpkm($usulan)
	{
		$data = array();
		$this->db->select("anggotadosen,pengusul,authorlain");
		$this->db->from("usulan_pkm");
		$this->db->join("jurnal","jurnal.usulan=usulan_pkm.id_usulan");
		$this->db->where("usulan_pkm.id_usulan",$usulan);
		$this->db->where("jurnal.status_jurnal","Published");
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function hapuspenelitian($id)
	{
		$this->db->where("id_penelitian",$id);
		$this->db->delete("penelitian_tambahan");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Penelitian ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapuspengabdian($id)
	{
		$this->db->where("id_pengabdian",$id);
		$this->db->delete("pengabdian_tembahan");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Pengabdian ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapushki($id)
	{
		$this->db->where("id_hki",$id);
		$this->db->delete("hki");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data HKI ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapusjurnal($id)
	{
		$this->db->where("id_jurnal",$id);
		$this->db->delete("jurnal");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Jurnal ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapusprosiding($id)
	{
		$this->db->where("id_prosiding",$id);
		$this->db->delete("prosiding");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Prosiding ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapusbuku($id)
	{
		$this->db->where("id_buku",$id);
		$this->db->delete("buku");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Buku ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapuskarya($id)
	{
		$this->db->where("id_karya",$id);
		$this->db->delete("karya_monumental");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Karya Monumental ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function hapusnaskah($id)
	{
		$this->db->where("id_naskah",$id);
		$this->db->delete("naskah_akademik");
		
		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama')." telah menghapus Data Naskah Akademik ".$id." ".$wkt
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function editprosiding()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		$this->db->join("dosen","dosen.user=prosiding.user");
		$this->db->where("prosiding.id_prosiding",$this->uri->segment(3));
		$this->db->order_by("prosiding.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function editbuku()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		$this->db->join("dosen","dosen.user=buku.user");
		$this->db->where("buku.id_buku",$this->uri->segment(3));
		$this->db->order_by("buku.tahun_terbit","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function editkarya()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("karya_monumental");
		$this->db->join("dosen","dosen.user=karya_monumental.user");
		$this->db->where("karya_monumental.id_karya",$this->uri->segment(3));
		$this->db->order_by("karya_monumental.tahun_pelaksanaan","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function editnaskah()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		$this->db->join("dosen","dosen.user=naskah_akademik.user");
		$this->db->where("naskah_akademik.id_naskah",$this->uri->segment(3));
		$this->db->order_by("naskah_akademik.tahun_naskah","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function selecthki()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		//$this->db->where("user",$this->session->userdata('sesi_id'));
		
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectpros()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		//$this->db->where("user",$this->session->userdata('sesi_id'));
		
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectbuku()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		// $this->db->where("user",$this->session->userdata('sesi_id'));
		
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectkarya()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("karya_monumental");
		// $this->db->where("user",$this->session->userdata('sesi_id'));
		
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectnaskah()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		// $this->db->where("user",$this->session->userdata('sesi_id'));
		
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function selectjurnal()
	{
		$data = array();
		$in = explode(',',$this->session->userdata('sesi_dosen'));
		$this->db->select("*");
		$this->db->from("jurnal");
		// $this->db->where("user",$this->session->userdata('sesi_id'));
		// $this->db->or_where("authorlain",$this->session->userdata('sesi_dosen'));
		// $this->db->where("status_jurnal","Published");
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function selectjurnalaward($user,$dosen)
	{
		$data = array();
		$query = "SELECT jurnal.*,usulan.pengusul usul,usulan_pkm.pengusul musul,usulan.anggotadosen udosen, usulan_pkm.anggotadosen mdosen FROM `jurnal` 
			LEFT JOIN usulan on usulan.id_usulan=jurnal.usulan
			LEFT JOIN usulan_pkm on usulan_pkm.id_usulan=jurnal.usulan
			WHERE jurnal.`tahun_publikasi` = '".date('Y')."' 
				and jurnal.status_jurnal='Published' and (jurnal.user='".$user."' 
			         	or (usulan.pengusul='".$user."' or find_in_set('".$dosen."',(select anggotadosen from usulan where id_usulan=jurnal.usulan))) 
			         	or (usulan_pkm.pengusul='".$user."' or find_in_set('".$dosen."',(select anggotadosen from usulan_pkm where id_usulan=jurnal.usulan))
			            or (find_in_set('".$dosen."',jurnal.authorlain)))
			       ) order by jurnal.modified desc";
		
		$hasil = $this->db->query($query);
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function selecthkiaward($user,$dosen)
	{
		$data = array();
		$query = "SELECT hki.*,usulan.pengusul usul,usulan_pkm.pengusul musul,usulan.anggotadosen udosen, usulan_pkm.anggotadosen mdosen FROM `hki` 
			LEFT JOIN usulan on usulan.id_usulan=hki.usulan
			LEFT JOIN usulan_pkm on usulan_pkm.id_usulan=hki.usulan
			WHERE hki.`tahun_pelaksanaan` = '".date('Y')."' 
				and hki.status='Granted' and (hki.user='".$user."' 
			         	or (usulan.pengusul='".$user."' or find_in_set('".$dosen."',(select anggotadosen from usulan where id_usulan=hki.usulan))) 
			         	or (usulan_pkm.pengusul='".$user."' or find_in_set('".$dosen."',(select anggotadosen from usulan_pkm where id_usulan=hki.usulan))
			            or (find_in_set('".$dosen."',hki.authorlain)))
			      ) order by hki.modified desc";
		
		$hasil = $this->db->query($query);
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function dashjurnal()
	{
		$data = array();
		$in = explode(',',$this->session->userdata('sesi_dosen'));
		$this->db->select("*");
		$this->db->from("jurnal");
		// $this->db->where("user",$this->session->userdata('sesi_id'));
		// $this->db->or_where("authorlain",$this->session->userdata('sesi_dosen'));
		
		$this->db->order_by("modified","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function simpanpenelitian($file)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post('dana',true));
		
		$data = array(
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"jenis"				=> $this->input->post("jenis",true),
				"bidang"			=> $this->input->post("bidang",true),
				"tujuan"			=> $this->input->post("tujuan",true),
				"sumberdana"		=> $this->input->post("sumber",true),
				"institusi"			=> $this->input->post("institusi",true),
				"dana"				=> $dana,
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"file_laporan_akhir"=> $file,
				"user"				=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
				);
		$this->db->insert("penelitian_tambahan",$data);
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Penelitian Tambahan telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function updatepenelitian($file)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post("dana",true));
		
		if($file<>'') {
				$data = array(
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"jenis"				=> $this->input->post("jenis",true),
				"bidang"			=> $this->input->post("bidang",true),
				"tujuan"			=> $this->input->post("tujuan",true),
				"sumberdana"		=> $this->input->post("sumber",true),
				"institusi"			=> $this->input->post("institusi",true),
				"dana"				=> $dana,
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"file_laporan_akhir"=> $file,
				"modified"			=> $waktu
				);
		}
		else
		{
				$data = array(
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"jenis"				=> $this->input->post("jenis",true),
				"bidang"			=> $this->input->post("bidang",true),
				"tujuan"			=> $this->input->post("tujuan",true),
				"sumberdana"		=> $this->input->post("sumber",true),
				"institusi"			=> $this->input->post("institusi",true),
				"dana"				=> $this->input->post("dana",true),
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"modified"			=> $waktu
				);
		}
		$this->db->where("id_penelitian",$this->input->post("id",true));
		$this->db->update("penelitian_tambahan",$data);
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Penelitian Tambahan telah diupdate oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpanpengabdian($pendukung,$laporan)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post("dana",true));
		
		$data = array(
				"jenis"				=> $this->input->post("jenis",true),
				"tingkat"			=> $this->input->post("tingkat",true),
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"dana"				=> $dana,
				"sumberdana"		=> $this->input->post("sumberdana",true),
				"tglmulai"			=> $this->input->post("tglmulai",true),
				"tglakhir"			=> $this->input->post("tglakhir",true),
				"iptek"				=> $this->input->post("iptek",true),
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"mhs"				=> $this->input->post("mhs",true),
				"alumni"			=> $this->input->post("alumni",true),
				"staff"				=> $this->input->post("staff",true),
				"jenis_mitra"		=> $this->input->post("jenismitra",true),
				"mitra"				=> $this->input->post("mitra",true),
				"bidang"			=> $this->input->post("bidang",true),
				"omzet"				=> $this->input->post("omzet",true),
				"dana_pendamping"	=> $this->input->post("pendamping",true),
				"filependukung"		=> $pendukung,
				"filelaporan"		=> $laporan,
				"user"				=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
				);
		$this->db->insert("pengabdian_tembahan",$data);
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Pengabdian Tambahan telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function updatepengabdian($pendukung,$laporan)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post("dana",true));
		
		if($pendukung<>'' && $laporan<>'') {
				$data = array(
				"jenis"				=> $this->input->post("jenis",true),
				"tingkat"			=> $this->input->post("tingkat",true),
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"dana"				=> $dana,
				"sumberdana"		=> $this->input->post("sumberdana",true),
				"tglmulai"			=> $this->input->post("tglmulai",true),
				"tglakhir"			=> $this->input->post("tglakhir",true),
				"iptek"				=> $this->input->post("iptek",true),
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"mhs"				=> $this->input->post("mhs",true),
				"alumni"			=> $this->input->post("alumni",true),
				"staff"				=> $this->input->post("staff",true),
				"jenis_mitra"		=> $this->input->post("jenismitra",true),
				"mitra"				=> $this->input->post("mitra",true),
				"bidang"			=> $this->input->post("bidang",true),
				"omzet"				=> $this->input->post("omzet",true),
				"dana_pendamping"	=> $this->input->post("pendamping",true),
				"filependukung"		=> $pendukung,
				"filelaporan"		=> $laporan,
				"user"				=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
				);
		}
		elseif($pendukung<>'' && $laporan=='') {
				$data = array(
				"jenis"				=> $this->input->post("jenis",true),
				"tingkat"			=> $this->input->post("tingkat",true),
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"dana"				=> $dana,
				"sumberdana"		=> $this->input->post("sumberdana",true),
				"tglmulai"			=> $this->input->post("tglmulai",true),
				"tglakhir"			=> $this->input->post("tglakhir",true),
				"iptek"				=> $this->input->post("iptek",true),
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"mhs"				=> $this->input->post("mhs",true),
				"alumni"			=> $this->input->post("alumni",true),
				"staff"				=> $this->input->post("staff",true),
				"jenis_mitra"		=> $this->input->post("jenismitra",true),
				"mitra"				=> $this->input->post("mitra",true),
				"bidang"			=> $this->input->post("bidang",true),
				"omzet"				=> $this->input->post("omzet",true),
				"dana_pendamping"	=> $this->input->post("pendamping",true),
				"filependukung"		=> $pendukung,
				"modified"			=> $waktu
				);
		}
		elseif($pendukung=='' && $laporan<>'') {
				$data = array(
				"jenis"				=> $this->input->post("jenis",true),
				"tingkat"			=> $this->input->post("tingkat",true),
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"dana"				=> $dana,
				"sumberdana"		=> $this->input->post("sumberdana",true),
				"tglmulai"			=> $this->input->post("tglmulai",true),
				"tglakhir"			=> $this->input->post("tglakhir",true),
				"iptek"				=> $this->input->post("iptek",true),
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"mhs"				=> $this->input->post("mhs",true),
				"alumni"			=> $this->input->post("alumni",true),
				"staff"				=> $this->input->post("staff",true),
				"jenis_mitra"		=> $this->input->post("jenismitra",true),
				"mitra"				=> $this->input->post("mitra",true),
				"bidang"			=> $this->input->post("bidang",true),
				"omzet"				=> $this->input->post("omzet",true),
				"dana_pendamping"	=> $this->input->post("pendamping",true),
				"filelaporan"		=> $laporan,
				"modified"			=> $waktu
				);
		}
		else
		{
				$data = array(
				"jenis"				=> $this->input->post("jenis",true),
				"tingkat"			=> $this->input->post("tingkat",true),
				"judul"				=> $this->input->post("judul",true),
				"tahun"				=> $this->input->post("tahun",true),
				"dana"				=> $dana,
				"sumberdana"		=> $this->input->post("sumberdana",true),
				"tglmulai"			=> $this->input->post("tglmulai",true),
				"tglakhir"			=> $this->input->post("tglakhir",true),
				"iptek"				=> $this->input->post("iptek",true),
				"ketua"				=> $this->input->post("idketua",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"anggota"			=> $this->input->post("iddosen",true),
				"mhs"				=> $this->input->post("mhs",true),
				"alumni"			=> $this->input->post("alumni",true),
				"staff"				=> $this->input->post("staff",true),
				"jenis_mitra"		=> $this->input->post("jenismitra",true),
				"mitra"				=> $this->input->post("mitra",true),
				"bidang"			=> $this->input->post("bidang",true),
				"omzet"				=> $this->input->post("omzet",true),
				"dana_pendamping"	=> $this->input->post("pendamping",true),
				"modified"			=> $waktu
				);
		}
		$this->db->where("id_pengabdian",$this->input->post("id",true));
		$this->db->update("pengabdian_tembahan",$data);
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Pengabdian Tambahan telah diupdate oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpanjurnal($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("user",$this->session->userdata('sesi_id'));
		$this->db->where("id_jurnal",$this->input->post("id",true));
		$hasil = $this->db->get();
		
		$hitdata = $hasil->num_rows();
		
		if($hitdata>0) 
		{
			if($file<>'') {
				$data = array(
				"judul"				=> $this->input->post("judul",true),
				"nama_jurnal"		=> $this->input->post("namajurnal",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jenis_publikasi"	=> $this->input->post("jenispublikasi",true),
				"status_jurnal"		=> $this->input->post("statusjurnal",true),
				"peran_penulis"		=> $this->input->post("peranpenulis",true),
				"tahun_publikasi"	=> $this->input->post("tahun",true),
				"volume"			=> $this->input->post("volume",true),
				"nomor"				=> $this->input->post("nomor",true),
				"hal_awal"			=> $this->input->post("awal",true),
				"hal_akhir"			=> $this->input->post("akhir",true),
				"url"				=> $this->input->post("url",true),
				"issn"				=> $this->input->post("issn",true),
				"file_jurnal"		=> $file,
				"modified"			=> $waktu
				);
			}
			else
			{
				$data = array(
				"judul"				=> $this->input->post("judul",true),
				"nama_jurnal"		=> $this->input->post("namajurnal",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jenis_publikasi"	=> $this->input->post("jenispublikasi",true),
				"status_jurnal"		=> $this->input->post("statusjurnal",true),
				"peran_penulis"		=> $this->input->post("peranpenulis",true),
				"tahun_publikasi"	=> $this->input->post("tahun",true),
				"volume"			=> $this->input->post("volume",true),
				"nomor"				=> $this->input->post("nomor",true),
				"hal_awal"			=> $this->input->post("awal",true),
				"hal_akhir"			=> $this->input->post("akhir",true),
				"url"				=> $this->input->post("url",true),
				"issn"				=> $this->input->post("issn",true),
				"modified"			=> $waktu
				);
			}
			$this->db->where("id_jurnal",$this->input->post("id",true));
			$this->db->update("jurnal",$data);
		}
		else
		{
			$data = array(
				"user"				=> $this->session->userdata('sesi_id'),
				"judul"				=> $this->input->post("judul",true),
				"nama_jurnal"		=> $this->input->post("namajurnal",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jenis_publikasi"	=> $this->input->post("jenispublikasi",true),
				"status_jurnal"		=> $this->input->post("statusjurnal",true),
				"peran_penulis"		=> $this->input->post("peranpenulis",true),
				"tahun_publikasi"	=> $this->input->post("tahun",true),
				"volume"			=> $this->input->post("volume",true),
				"nomor"				=> $this->input->post("nomor",true),
				"hal_awal"			=> $this->input->post("awal",true),
				"hal_akhir"			=> $this->input->post("akhir",true),
				"url"				=> $this->input->post("url",true),
				"issn"				=> $this->input->post("issn",true),
				"file_jurnal"		=> $file,
				"modified"			=> $waktu
				);
			$this->db->insert("jurnal",$data);
		}
		
		// echo $this->db->last_query();exit;
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Luaran Penelitian - Jurnal telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpanhki($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("id_hki",$this->input->post("id",true));
		$hasil = $this->db->get();
		
		$hitdata = $hasil->num_rows();
		
		if($hitdata>0) 
		{
			if($file<>'') {
			$data = array(
				"judul"					=> $this->input->post("judul",true),
				"jenis_hki"				=> $this->input->post("jenishki",true),
				"authorlain"			=> $this->input->post("iddosen",true),
				"jmlanggota"			=> $this->input->post("jmlanggota",true),
				"sbgluaran"				=> $this->input->post("sebagai",true),
				"tahun_pelaksanaan"		=> $this->input->post("tahunpelaksanaan",true),
				"nomor_pendaftaran"		=> $this->input->post("nomordaftar",true),
				"status"				=> $this->input->post("status",true),
				"nomor_hki"				=> $this->input->post("nomorhki",true),
				"url_dokumen"			=> $this->input->post("url",true),
				"file_hki"				=> $file,
				"modified"				=> $waktu
				);
			}
			else
			{
				$data = array(
				"judul"					=> $this->input->post("judul",true),
				"jenis_hki"				=> $this->input->post("jenishki",true),
				"authorlain"			=> $this->input->post("iddosen",true),
				"jmlanggota"			=> $this->input->post("jmlanggota",true),
				"sbgluaran"				=> $this->input->post("sebagai",true),
				"tahun_pelaksanaan"		=> $this->input->post("tahunpelaksanaan",true),
				"nomor_pendaftaran"		=> $this->input->post("nomordaftar",true),
				"status"				=> $this->input->post("status",true),
				"nomor_hki"				=> $this->input->post("nomorhki",true),
				"url_dokumen"			=> $this->input->post("url",true),
				"modified"				=> $waktu
				);
			}
			$this->db->where("id_hki",$this->input->post("id",true));
			$this->db->update("hki",$data);
		}
		else
		{
			$data = array(
				"user"					=> $this->session->userdata('sesi_id'),
				"judul"					=> $this->input->post("judul",true),
				"jenis_hki"				=> $this->input->post("jenishki",true),
				"authorlain"			=> $this->input->post("iddosen",true),
				"jmlanggota"			=> $this->input->post("jmlanggota",true),
				"sbgluaran"				=> $this->input->post("sebagai",true),
				"tahun_pelaksanaan"		=> $this->input->post("tahunpelaksanaan",true),
				"nomor_pendaftaran"		=> $this->input->post("nomordaftar",true),
				"status"				=> $this->input->post("status",true),
				"nomor_hki"				=> $this->input->post("nomorhki",true),
				"url_dokumen"			=> $this->input->post("url",true),
				"file_hki"				=> $file,
				"modified"				=> $waktu
				);
			$this->db->insert("hki",$data);
		}
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "HKI telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpanprosiding($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("prosiding");
		$this->db->where("id_prosiding",$this->input->post("id",true));
		$hasil = $this->db->get();
		
		$hitdata = $hasil->num_rows();
		
		if($hitdata>0) 
		{
			if($file<>'') {
			$data = array(
				"judul"				=> $this->input->post("judul",true),
				"nama_prosiding"	=> $this->input->post("namaprosiding",true),
				"tahun"				=> $this->input->post("tahunprosiding",true),
				"statuspro"			=> $this->input->post("status",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"peran_penulis"		=> $this->input->post("peran",true),
				"volume"			=> $this->input->post("volume",true),
				"nomor"				=> $this->input->post("nomor",true),
				"isbn_issn"			=> $this->input->post("isbn",true),
				"nomor"				=> $this->input->post("nomor",true),
				"url"				=> $this->input->post("url",true),
				"jenis_prosiding"	=> $this->input->post("jenis",true),
				"file_prosiding"	=> $file,
				"modified"			=> $waktu
				);
			}
			else
			{
				$data = array(
				"judul"				=> $this->input->post("judul",true),
				"nama_prosiding"	=> $this->input->post("namaprosiding",true),
				"tahun"				=> $this->input->post("tahunprosiding",true),
				"statuspro"			=> $this->input->post("status",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"peran_penulis"		=> $this->input->post("peran",true),
				"volume"			=> $this->input->post("volume",true),
				"nomor"				=> $this->input->post("nomor",true),
				"isbn_issn"			=> $this->input->post("isbn",true),
				"nomor"				=> $this->input->post("nomor",true),
				"url"				=> $this->input->post("url",true),
				"jenis_prosiding"	=> $this->input->post("jenis",true),
				"modified"			=> $waktu
				);
			}
			$this->db->where("id_prosiding",$this->input->post("id",true));
			$this->db->update("prosiding",$data);
		}
		else
		{
			$data = array(
				"user"				=> $this->session->userdata('sesi_id'),
				"judul"				=> $this->input->post("judul",true),
				"nama_prosiding"	=> $this->input->post("namaprosiding",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"statuspro"			=> $this->input->post("status",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"tahun"				=> $this->input->post("tahunprosiding",true),
				"peran_penulis"		=> $this->input->post("peran",true),
				"volume"			=> $this->input->post("volume",true),
				"nomor"				=> $this->input->post("nomor",true),
				"isbn_issn"			=> $this->input->post("isbn",true),
				"nomor"				=> $this->input->post("nomor",true),
				"url"				=> $this->input->post("url",true),
				"jenis_prosiding"	=> $this->input->post("jenis",true),
				"file_prosiding"	=> $file,
				"modified"			=> $waktu
				);
			$this->db->insert("prosiding",$data);
		}
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Prosiding telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpanbuku($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("buku");
		$this->db->where("id_buku",$this->input->post("id",true));
		$hasil = $this->db->get();
		
		$hitdata = $hasil->num_rows();
		
		if($hitdata>0) 
		{
			if($file<>'') {
			$data = array(
				"judul"			=> $this->input->post("judul",true),
				"tahun_terbit"	=> $this->input->post("tahun",true),
				"jmlanggota"	=> $this->input->post("jmlanggota",true),
				"authorlain"	=> $this->input->post("iddosen",true),
				"sbgluaran"		=> $this->input->post("sebagai",true),
				"isbn"			=> $this->input->post("isbn",true),
				"jml_halaman"	=> $this->input->post("halaman",true),
				"penerbit"		=> $this->input->post("penerbit",true),
				"url"			=> $this->input->post("url",true),
				"file_buku"		=> $file,
				"modified"		=> $waktu
				);
			}
			else
			{
				$data = array(
					"judul"			=> $this->input->post("judul",true),
					"tahun_terbit"	=> $this->input->post("tahun",true),
					"jmlanggota"	=> $this->input->post("jmlanggota",true),
					"sbgluaran"		=> $this->input->post("sebagai",true),
					"authorlain"	=> $this->input->post("iddosen",true),
					"isbn"			=> $this->input->post("isbn",true),
					"jml_halaman"	=> $this->input->post("halaman",true),
					"penerbit"		=> $this->input->post("penerbit",true),
					"url"			=> $this->input->post("url",true),
					"modified"		=> $waktu
				);
			}
			$this->db->where("id_buku",$this->input->post("id",true));
			$this->db->update("buku",$data);
		}
		else
		{
			$data = array(
				"user"			=> $this->session->userdata('sesi_id'),
				"judul"			=> $this->input->post("judul",true),
				"sbgluaran"		=> $this->input->post("sebagai",true),
				"jmlanggota"	=> $this->input->post("jmlanggota",true),
				"authorlain"	=> $this->input->post("iddosen",true),
				"tahun_terbit"	=> $this->input->post("tahun",true),
				"isbn"			=> $this->input->post("isbn",true),
				"jml_halaman"	=> $this->input->post("halaman",true),
				"penerbit"		=> $this->input->post("penerbit",true),
				"url"			=> $this->input->post("url",true),
				"file_buku"		=> $file,
				"modified"		=> $waktu
				);
			$this->db->insert("buku",$data);
		}
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Buku telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpankarya($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("karya_monumental");
		$this->db->where("id_karya",$this->input->post("id",true));
		$hasil = $this->db->get();
		
		$hitdata = $hasil->num_rows();
		
		if($hitdata>0) 
		{
			if($file<>'') {
			$data = array(
				"jenis_karya"		=> $this->input->post("jenis",true),
				"level_karya"		=> $this->input->post("level",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"tahun_pelaksanaan"	=> $this->input->post("tahun",true),
				"deskripsi"			=> $this->input->post("deskripsi",true),
				"url"				=> $this->input->post("url",true),
				"dokumen"			=> $file,
				"modified"			=> $waktu
				);
			}
			else
			{
				$data = array(
					"jenis_karya"		=> $this->input->post("jenis",true),
					"level_karya"		=> $this->input->post("level",true),
					"jmlanggota"		=> $this->input->post("jmlanggota",true),
					"sbgluaran"			=> $this->input->post("sebagai",true),
					"authorlain"		=> $this->input->post("iddosen",true),
					"tahun_pelaksanaan"	=> $this->input->post("tahun",true),
					"deskripsi"			=> $this->input->post("deskripsi",true),
					"url"				=> $this->input->post("url",true),
					"modified"			=> $waktu
				);
			}
			$this->db->where("id_karya",$this->input->post("id",true));
			$this->db->update("karya_monumental",$data);
		}
		else
		{
			$data = array(
				"user"				=> $this->session->userdata('sesi_id'),
				"jenis_karya"		=> $this->input->post("jenis",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"level_karya"		=> $this->input->post("level",true),
				"tahun_pelaksanaan"	=> $this->input->post("tahun",true),
				"deskripsi"			=> $this->input->post("deskripsi",true),
				"url"				=> $this->input->post("url",true),
				"dokumen"			=> $file,
				"modified"			=> $waktu
				);
			$this->db->insert("karya_monumental",$data);
		}
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Karya Monumental telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
	
	function simpannaskah($file)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		$this->db->where("id_naskah",$this->input->post("id",true));
		$hasil = $this->db->get();
		
		$hitdata = $hasil->num_rows();
		
		if($hitdata>0) 
		{
			if($file<>'') {
			$data = array(
				"tahun_naskah"		=> $this->input->post("tahun",true),
				"jenis_naskah"		=> $this->input->post("jenis",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"judul"				=> $this->input->post("judul",true),
				"peruntukan_naskah"	=> $this->input->post("untuk",true),
				"peran_penyusun"	=> $this->input->post("peran",true),
				"tgl_serah"			=> $this->input->post("tgl",true),
				"pejabat_penerima"	=> $this->input->post("pejabat",true),
				"url"				=> $this->input->post("url",true),
				"dokumen"			=> $file,
				"modified"			=> $waktu
				);
			}
			else
			{
			$data = array(
				"tahun_naskah"		=> $this->input->post("tahun",true),
				"jenis_naskah"		=> $this->input->post("jenis",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"judul"				=> $this->input->post("judul",true),
				"peruntukan_naskah"	=> $this->input->post("untuk",true),
				"peran_penyusun"	=> $this->input->post("peran",true),
				"tgl_serah"			=> $this->input->post("tgl",true),
				"pejabat_penerima"	=> $this->input->post("pejabat",true),
				"url"				=> $this->input->post("url",true),
				"modified"			=> $waktu
				);
			}
			$this->db->where("id_naskah",$this->input->post("id",true));
			$this->db->update("naskah_akademik",$data);
		}
		else
		{
			$data = array(
				"user"				=> $this->session->userdata('sesi_id'),
				"tahun_naskah"		=> $this->input->post("tahun",true),
				"jenis_naskah"		=> $this->input->post("jenis",true),
				"sbgluaran"			=> $this->input->post("sebagai",true),
				"jmlanggota"		=> $this->input->post("jmlanggota",true),
				"authorlain"		=> $this->input->post("iddosen",true),
				"judul"				=> $this->input->post("judul",true),
				"peruntukan_naskah"	=> $this->input->post("untuk",true),
				"peran_penyusun"	=> $this->input->post("peran",true),
				"tgl_serah"			=> $this->input->post("tgl",true),
				"pejabat_penerima"	=> $this->input->post("pejabat",true),
				"url"				=> $this->input->post("url",true),
				"dokumen"			=> $file,
				"modified"			=> $waktu
				);
			$this->db->insert("naskah_akademik",$data);
		}
		
		
		//masukan logs sistem
		$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->input->post("jenis",true)." telah disubmit oleh ".$this->session->userdata("sesi_nama")." pada ".tgl_indo($waktu,1)
				);
		$this->db->insert("logs",$data);
		//akhir masukan logs sistem
	}
}