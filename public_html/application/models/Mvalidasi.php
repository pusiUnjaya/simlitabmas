<?php
Class Mvalidasi extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function penelitian($periode,$prodi)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->join("lap_akhir","lap_akhir.id_usulan=usulan.id_usulan");
		$this->db->where("lap_akhir.file_laporan_akhir <>","");
		if($this->session->userdata('sesi_status')==2)
			$this->db->where("dosen.prodi",$this->session->userdata('sesi_prodi'));
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("YEAR(usulan.tglmulai)",$periode);
		$this->db->order_by("usulan.tglmulai","desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function reviewer()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("reviewer","1");
		$this->db->order_by("namalengkap","asc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function ketuapenelitian($id)
	{
		$data = array();
		$this->db->select("count(*) jml");
		$this->db->from("usulan");
		$this->db->where("pengusul",$id);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function anggotapenelitian($id,$list)
	{
		$data = array();
		$this->db->select("count(*) jml");
		$this->db->from("usulan");
		$this->db->where("FIND_IN_SET(".$id.",'".$list."')");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function ketuapengabdian($id)
	{
		$data = array();
		$this->db->select("count(*) jml");
		$this->db->from("usulan_pkm");
		$this->db->where("pengusul",$id);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function anggotapengabdian($id,$list)
	{
		$data = array();
		$this->db->select("count(*) jml");
		$this->db->from("usulan_pkm");
		$this->db->where("FIND_IN_SET(".$id.",'".$list."')");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	// function tambahan($periode,$prodi)
	// {
	// 	$data = array();
	// 	$this->db->select("*");
	// 	$this->db->from("penelitian_tambahan");
	// 	$this->db->join("dosen","dosen.user=penelitian_tambahan.user");
	// 	$this->db->where("penelitian_tambahan.file_laporan_akhir <>","");
	// 	if($prodi<>'Semua')
	// 		$this->db->where("dosen.prodi",$prodi);
	// 	$this->db->where("penelitian_tambahan.tahun",$periode);
	// 	$this->db->order_by("penelitian_tambahan.tahun","desc");
	// 	$hasil = $this->db->get();
		
	// 	if($hasil->num_rows() > 0)
	// 	{
	// 		$data = $hasil->result();
	// 	}
	// 	return $data;
	// }

	function risettambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("penelitian_tambahan");
		$this->db->join("dosen","dosen.user=penelitian_tambahan.user");
		$this->db->where("penelitian_tambahan.file_laporan_akhir <>","");
		// $this->db->where("YEAR(penelitian_tambahan.modified) >= ",2024);
		$this->db->where("penelitian_tambahan.validasi",0);
		$this->db->order_by("penelitian_tambahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function pkmtambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("pengabdian_tembahan");
		$this->db->join("dosen","dosen.user=pengabdian_tembahan.user");
		$this->db->where("pengabdian_tembahan.filelaporan <>","");
		// $this->db->where("YEAR(penelitian_tambahan.modified) >= ",2024);
		$this->db->where("pengabdian_tembahan.validasi",0);
		$this->db->order_by("pengabdian_tembahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuapenelitian()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->join("lap_akhir","lap_akhir.id_usulan=usulan.id_usulan");
		$this->db->where("lap_akhir.file_revisi <>","");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function reviewpenelitian()
	{
		$data = array();
		$this->db->select("*,usulan.reviewer revnya");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function nilaiusulanreviewer($usulan,$rev)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
		$this->db->where("usulan",$usulan);
		$this->db->where("reviewer",$rev);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function nilailaporanreviewer($usulan,$rev)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan");
		$this->db->where("usulan",$usulan);
		$this->db->where("reviewer",$rev);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function hitnilailaporanreviewer($usulan,$rev)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan");
		$this->db->where("usulan",$usulan);
		$this->db->where("reviewer",$rev);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}

	function hitrevusulanpenelitian($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
		$this->db->where("YEAR(modified)",$thn);
		$this->db->where("reviewer",$id);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}

	function hitrevusulanpkm($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->where("YEAR(modified)",$thn);
		$this->db->where("reviewer",$id);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}

	function hitrevlappenelitian($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan");
		$this->db->where("YEAR(modified)",$thn);
		$this->db->where("reviewer",$id);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}

	function hitrevlappkm($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("YEAR(modified)",$thn);
		$this->db->where("reviewer",$id);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();
		
		return $data;
	}
	
	function realisasijurnalpenelitian($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("usulan",$usulan);
		$this->db->where("sbgluaran",'Luaran Penelitian');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function realisasihkipenelitian($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("usulan",$usulan);
		$this->db->where("sbgluaran",'Luaran Penelitian');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function relevansipenelitian($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("relevansi");
		$this->db->where("usulan",$usulan);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function reviewlaporanpenelitian()
	{
		$data = array();
		$this->db->select("*,usulan.reviewer revnya");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function reviewusulanpkm()
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer revnya");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan_pkm.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function realisasijurnalpkm($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("usulan",$usulan);
		$this->db->where("sbgluaran <> ",'Luaran Penelitian');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function realisasihkipkm($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("usulan",$usulan);
		$this->db->where("sbgluaran <> ",'Luaran Penelitian');
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function relevansipkm($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("relevansi_pkm");
		$this->db->where("usulan",$usulan);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function nilaiusulanreviewerpkm($usulan,$rev)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->where("usulan",$usulan);
		$this->db->where("reviewer",$rev);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function reviewlaporanpkm()
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer revnya");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan_pkm.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function nilailaporanreviewerpkm($usulan,$rev)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("usulan",$usulan);
		$this->db->where("reviewer",$rev);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}
	
	function semuatambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("penelitian_tambahan");
		$this->db->join("dosen","dosen.user=penelitian_tambahan.user");
		$this->db->where("penelitian_tambahan.file_laporan_akhir <>","");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, penelitian_tambahan.tahun desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function pengabdian($periode,$prodi)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm","lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.file_revisi <>","");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("YEAR(usulan_pkm.tglmulai)",$periode);
		$this->db->order_by("usulan_pkm.tglmulai","desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function tambahanpkm($periode,$prodi)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("pengabdian_tembahan");
		$this->db->join("dosen","dosen.id_dosen=pengabdian_tembahan.ketua");
		$this->db->where("pengabdian_tembahan.filelaporan <>","");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("pengabdian_tembahan.tahun",$periode);
		$this->db->order_by("pengabdian_tembahan.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuapengabdian()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm","lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.file_revisi <>","");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan_pkm.tglmulai desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuatambahanpkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("pengabdian_tembahan");
		$this->db->join("dosen","dosen.id_dosen=pengabdian_tembahan.ketua");
		$this->db->where("pengabdian_tembahan.filelaporan <>","");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, pengabdian_tembahan.tahun desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function jurnal($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=jurnal.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("jurnal.tahun_publikasi",$periode);
		$this->db->where("jurnal.sbgluaran",$sebagai);
		
		$this->db->order_by("jurnal.tahun_publikasi","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function jurnaltambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->join("dosen","dosen.user=jurnal.user");
		$this->db->where("jurnal.tahun_publikasi>=",2023);
		$this->db->where("jurnal.validasi",0);
		$this->db->where("jurnal.usulan","");
		
		$this->db->order_by("jurnal.id_jurnal","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function hkitambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->join("dosen","dosen.user=hki.user");
		$this->db->where("hki.tahun_pelaksanaan",date('Y'));
		$this->db->where("hki.validasi",0);
		$this->db->where("hki.usulan","");
		
		$this->db->order_by("hki.id_hki","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function prosidingtambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		$this->db->join("dosen","dosen.user=prosiding.user");
		$this->db->where("prosiding.tahun",date('Y'));
		$this->db->where("prosiding.validasi",0);
		$this->db->where("prosiding.usulan","");
		
		$this->db->order_by("prosiding.id_prosiding","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function bukutambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		$this->db->join("dosen","dosen.user=buku.user");
		$this->db->where("buku.tahun_terbit",date('Y'));
		$this->db->where("buku.validasi",0);
		$this->db->where("buku.usulan","");
		
		$this->db->order_by("buku.id_buku","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function karyatambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("karya_monumental");
		$this->db->join("dosen","dosen.user=karya_monumental.user");
		$this->db->where("karya_monumental.tahun_pelaksanaan",date('Y'));
		$this->db->where("karya_monumental.validasi",0);
		$this->db->where("karya_monumental.usulan","");
		
		$this->db->order_by("karya_monumental.id_karya","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function naskahtambahan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		$this->db->join("dosen","dosen.user=naskah_akademik.user");
		$this->db->where("naskah_akademik.tahun_naskah",date('Y'));
		$this->db->where("naskah_akademik.validasi",0);
		$this->db->where("naskah_akademik.usulan","");
		
		$this->db->order_by("naskah_akademik.id_naskah","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function jurnalusulan($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("users","users.id_user=usulan.pengusul");
		if($prodi<>'Semua')
			$this->db->where("users.prodi",$prodi);
		$this->db->where("jurnal.tahun_publikasi",$periode);
		$this->db->where("jurnal.sbgluaran",$sebagai);
		
		$this->db->order_by("jurnal.tahun_publikasi","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuajurnal()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=jurnal.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, jurnal.tahun_publikasi desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuajurnalusulan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, jurnal.tahun_publikasi desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function hki($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=hki.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("hki.tahun_pelaksanaan",$periode);
		$this->db->where("hki.sbgluaran",$sebagai);
		$this->db->order_by("hki.tahun_pelaksanaan","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function hkiusulan($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		$this->db->join("usulan","usulan.id_usulan=hki.usulan");
		$this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=hki.user");
		if($prodi<>'Semua')
			$this->db->where("users.prodi",$prodi);
		$this->db->where("hki.tahun_pelaksanaan",$periode);
		$this->db->where("hki.sbgluaran",$sebagai);
		$this->db->order_by("hki.tahun_pelaksanaan","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuahki()
	{
		$data = array();
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=hki.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi, hki.tahun_pelaksanaan desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuahkiusulan()
	{
		$data = array();
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		$this->db->join("usulan","usulan.id_usulan=hki.usulan");
		$this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=hki.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, hki.tahun_pelaksanaan desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function prosiding($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=prosiding.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("prosiding.tahun",$periode);
		$this->db->where("prosiding.sbgluaran",$sebagai);
		$this->db->order_by("prosiding.tahun","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuaprosiding()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prosiding");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=prosiding.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, prosiding.tahun desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function buku($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=buku.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("buku.tahun_terbit",$periode);
		$this->db->where("buku.sbgluaran",$sebagai);
		$this->db->order_by("buku.tahun_terbit","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuabuku()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("buku");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=buku.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, buku.tahun_terbit desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function naskah($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=naskah_akademik.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("naskah_akademik.tahun_naskah",$periode);
		$this->db->where("naskah_akademik.sbgluaran",$sebagai);
		$this->db->order_by("naskah_akademik.tahun_naskah","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuanaskah()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("naskah_akademik");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=naskah_akademik.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, naskah_akademik.tahun_naskah desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function karya($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("karya_monumental");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=karya_monumental.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("karya_monumental.tahun_pelaksanaan",$periode);
		$this->db->where("karya_monumental.sbgluaran",$sebagai);
		$this->db->order_by("karya_monumental.tahun_pelaksanaan","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuakarya()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("karya_monumental");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=karya_monumental.user");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, karya_monumental.tahun_pelaksanaan desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function detailpenelitian()
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
	
	function detailpengabdian()
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
	
	function detailjurnal()
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
	
	function detailhki()
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

	function updateriset($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> $this->input->post("valid",true),
			"catatan"		=> $this->input->post("catatan",true),
			"modified"		=> $waktu
			);
			
		$this->db->where("id_penelitian",$id);
		$this->db->update("penelitian_tambahan",$data);
	}

	function updatepkm($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> $this->input->post("valid",true),
			"catatan"		=> $this->input->post("catatan",true),
			"modified"		=> $waktu
			);
			
		$this->db->where("id_pengabdian",$id);
		$this->db->update("pengabdian_tembahan",$data);
	}

	function updatejurnal()
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> $this->input->post("valid",true),
			"catatan"		=> $this->input->post("catatan",true),
			"modified"		=> $waktu
			);
			
		$this->db->where("id_jurnal",$this->input->post("usulan",true));
		$this->db->update("jurnal",$data);
	}

	function updatehki()
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> $this->input->post("valid",true),
			"catatan"		=> $this->input->post("catatan",true),
			"modified"		=> $waktu
			);
			
		$this->db->where("id_hki",$this->input->post("usulan",true));
		$this->db->update("hki",$data);
	}

	function updateprosiding($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> '1',
			"modified"		=> $waktu
			);
			
		$this->db->where("id_prosiding",$id);
		$this->db->update("prosiding",$data);
	}

	function updatebuku($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> '1',
			"modified"		=> $waktu
			);
			
		$this->db->where("id_buku",$id);
		$this->db->update("buku",$data);
	}

	function updatekarya($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> '1',
			"modified"		=> $waktu
			);
			
		$this->db->where("id_karya",$id);
		$this->db->update("karya_monumental",$data);
	}

	function updatenaskah($id)
	{
		$waktu = date('Y-m-d H:i:s');
		
		$data = array(
			"validasi"		=> '1',
			"modified"		=> $waktu
			);
			
		$this->db->where("id_naskah",$id);
		$this->db->update("naskah_akademik",$data);
	}
}