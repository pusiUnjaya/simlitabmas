<?php
Class Mrekap extends CI_Model
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

	function luaranriset($id)
	{
		$data = array();
		$this->db->select('usulan.id_usulan, jurnal.status_jurnal,jurnal.file_jurnal,hki.status,hki.file_hki,prosiding.statuspro,prosiding.file_prosiding,buku.isbn,buku.file_buku,relevansi.matakuliah,relevansi.bentuk_integrasi');
		$this->db->from('usulan');
		$this->db->join('jurnal','jurnal.usulan=usulan.id_usulan','left');
		$this->db->join('hki','hki.usulan=usulan.id_usulan','left');
		$this->db->join('prosiding','prosiding.usulan=usulan.id_usulan','left');
		$this->db->join('buku','buku.usulan=usulan.id_usulan','left');
		$this->db->join('relevansi','relevansi.usulan=usulan.id_usulan','left');
		$this->db->where('usulan.id_usulan',$id);
		$this->db->where('jurnal.sbgluaran','Luaran Penelitian');
		$this->db->where('hki.sbgluaran','Luaran Penelitian');
		$this->db->where('prosiding.sbgluaran','Luaran Penelitian');
		$this->db->where('buku.sbgluaran','Luaran Penelitian');
		$hasil = $this->db->get();

		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}

	function luaranpkm($id)
	{
		$data = array();
		$this->db->select('usulan_pkm.id_usulan, jurnal.status_jurnal,jurnal.file_jurnal,hki.status,hki.file_hki,prosiding.statuspro,prosiding.file_prosiding,buku.isbn,buku.file_buku,relevansi_pkm.matakuliah,relevansi_pkm.bentuk_integrasi');
		$this->db->from('usulan_pkm');
		$this->db->join('jurnal','jurnal.usulan=usulan_pkm.id_usulan','left');
		$this->db->join('hki','hki.usulan=usulan_pkm.id_usulan','left');
		$this->db->join('prosiding','prosiding.usulan=usulan_pkm.id_usulan','left');
		$this->db->join('buku','buku.usulan=usulan_pkm.id_usulan','left');
		$this->db->join('relevansi_pkm','relevansi_pkm.usulan=usulan_pkm.id_usulan','left');
		$this->db->where('usulan_pkm.id_usulan',$id);
		// $this->db->where_in('jurnal.sbgluaran',array('Luaran PkM','Luaran Pengabdian'));
		// $this->db->where_in('hki.sbgluaran',array('Luaran PkM','Luaran Pengabdian'));
		// $this->db->where_in('prosiding.sbgluaran',array('Luaran PkM','Luaran Pengabdian'));
		// $this->db->where_in('buku.sbgluaran',array('Luaran PkM','Luaran Pengabdian'));
		$hasil = $this->db->get();

		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
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
	
	function tambahan($periode,$prodi)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("penelitian_tambahan");
		$this->db->join("dosen","dosen.user=penelitian_tambahan.user");
		$this->db->where("penelitian_tambahan.file_laporan_akhir <>","");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("penelitian_tambahan.tahun",$periode);
		$this->db->order_by("penelitian_tambahan.tahun","desc");
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
		$this->db->select("usulan.*,dosen.fakultas,dosen.prodi,jurnal.status_jurnal,jurnal.file_jurnal,hki.status statushki,hki.file_hki,prosiding.statuspro,prosiding.file_prosiding,buku.isbn,buku.file_buku,relevansi.matakuliah,relevansi.bentuk_integrasi,lap_akhir.file_laporan_akhir");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul","left");
		$this->db->join("jurnal","jurnal.usulan=usulan.id_usulan","left");
		$this->db->join("hki","hki.usulan=usulan.id_usulan","left");
		$this->db->join("prosiding","prosiding.usulan=usulan.id_usulan","left");
		$this->db->join("buku","buku.usulan=usulan.id_usulan","left");
		$this->db->join("relevansi","relevansi.usulan=usulan.id_usulan","left");
		$this->db->join("lap_akhir","lap_akhir.id_usulan=usulan.id_usulan","left");
		// $this->db->where("lap_akhir.file_revisi <>","");
		$this->db->where("usulan.pengusul <>","");
		$this->db->order_by("usulan.tglmulai desc, dosen.fakultas asc, dosen.prodi asc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function reviewpenelitian($tahun)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer revnya");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->where('year(usulan.tglmulai)', $tahun);
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function revisipenelitian($tahun)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer revnya");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->where('year(usulan.tglmulai)', $tahun);
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan.tglmulai desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function revisipkm($tahun)
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer revnya");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->where('year(usulan_pkm.tglmulai)', $tahun);
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, usulan_pkm.tglmulai desc");
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

	function hitnilaiusulanreviewer($usulan,$rev)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
		$this->db->where("usulan",$usulan);
		$this->db->where("reviewer",$rev);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();

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

	function detailrisetdosen($jenis,$id,$tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan as ro");
		if($jenis=='ketua')
			$this->db->where("pengusul",$id);
		else
			$this->db->where("FIND_IN_SET('".$id."',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan))");
		$this->db->where("YEAR(tglmulai)",$tahun);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function hitrisetdosen($jenis,$id,$tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan as ro");
		if($jenis=='ketua')
			$this->db->where("pengusul",$id);
		else
			$this->db->where("FIND_IN_SET('".$id."',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan))");
		$this->db->where("YEAR(tglmulai)",$tahun);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();

		return $data;
	}

	function detailpkmdosen($jenis,$id,$tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm as ro");
		if($jenis=='ketua')
			$this->db->where("pengusul",$id);
		else
			$this->db->where("FIND_IN_SET('".$id."',(SELECT anggotadosen from usulan_pkm WHERE id_usulan=ro.id_usulan))");
		$this->db->where("YEAR(tglmulai)",$tahun);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function hitpkmdosen($jenis,$id,$tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm as ro");
		if($jenis=='ketua')
			$this->db->where("pengusul",$id);
		else
			$this->db->where("FIND_IN_SET('".$id."',(SELECT anggotadosen from usulan_pkm WHERE id_usulan=ro.id_usulan))");
		$this->db->where("YEAR(tglmulai)",$tahun);
		$hasil = $this->db->get();
		
		$data = $hasil->num_rows();

		return $data;
	}

	function detailrevusulanpenelitian($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
		$this->db->join("usulan","usulan.id_usulan=hasilreview.usulan");
		$this->db->where("YEAR(hasilreview.modified)",$thn);
		$this->db->where("hasilreview.reviewer",$id);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
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

	function detailrevusulanpkm($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->join("usulan_pkm","usulan_pkm.id_usulan=hasilreview_pkm.usulan");
		$this->db->where("YEAR(hasilreview_pkm.modified)",$thn);
		$this->db->where("hasilreview_pkm.reviewer",$id);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
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

	function detailrevlaporanpenelitian($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan");
		$this->db->join("usulan","usulan.id_usulan=hasilreview_laporan.usulan");
		$this->db->join("lap_akhir","lap_akhir.id_usulan=hasilreview_laporan.usulan");
		$this->db->where("YEAR(hasilreview_laporan.modified)",$thn);
		$this->db->where("hasilreview_laporan.reviewer",$id);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
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

	function detailrevlappkm($id,$thn)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->join("usulan_pkm","usulan_pkm.id_usulan=hasilreview_laporan_pkm.usulan");
		$this->db->join("lap_akhir_pkm","lap_akhir_pkm.id_usulan=hasilreview_laporan_pkm.usulan");
		$this->db->where("YEAR(hasilreview_laporan_pkm.modified)",$thn);
		$this->db->where("hasilreview_laporan_pkm.reviewer",$id);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
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
	
	function reviewusulanpkm($tahun)
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer revnya");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->where('year(usulan_pkm.tglmulai)', $tahun);
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
		$this->db->select("usulan_pkm.*,dosen.fakultas,dosen.prodi,jurnal.status_jurnal,jurnal.file_jurnal,hki.status statushki,hki.file_hki,prosiding.statuspro,prosiding.file_prosiding,buku.isbn,buku.file_buku,relevansi.matakuliah,relevansi.bentuk_integrasi,lap_akhir_pkm.file_revisi,lap_akhir_pkm.file_laporan_akhir");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->join("jurnal","jurnal.usulan=usulan_pkm.id_usulan","left");
		$this->db->join("hki","hki.usulan=usulan_pkm.id_usulan","left");
		$this->db->join("prosiding","prosiding.usulan=usulan_pkm.id_usulan","left");
		$this->db->join("buku","buku.usulan=usulan_pkm.id_usulan","left");
		$this->db->join("relevansi","relevansi.usulan=usulan_pkm.id_usulan","left");
		$this->db->join("lap_akhir_pkm","lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan");
		// $this->db->where("lap_akhir_pkm.file_revisi <>","");
		$this->db->order_by("usulan_pkm.tglmulai desc,dosen.fakultas asc, dosen.prodi asc");
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
		$this->db->select("*,jurnal.judul juduljurnal");
		$this->db->from("jurnal");
		//$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
		$this->db->join("dosen","dosen.user=jurnal.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("jurnal.tahun_publikasi",$periode);
		$sebagai = str_replace("%20"," ",$sebagai);
		if($sebagai=='Luaran PkM')
		{
			$this->db->where_in("jurnal.sbgluaran",array('Luaran PkM','Luaran Pengabdian'));
		}
		else
			$this->db->where("jurnal.sbgluaran",$sebagai);
		
		$this->db->order_by("jurnal.tahun_publikasi","desc");
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
		$this->db->select("*,jurnal.judul juduljurnal");
		$this->db->from("jurnal");
		$sebagai = str_replace("%20"," ",$sebagai);
		if($sebagai=='Luaran Penelitian')
		{
			$this->db->join("usulan","usulan.id_usulan=jurnal.usulan");
			$this->db->join("users","users.id_user=usulan.pengusul");
		}
		else
		{
			$this->db->join("usulan_pkm","usulan_pkm.id_usulan=jurnal.usulan");
			$this->db->join("users","users.id_user=usulan_pkm.pengusul");
		}
		
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
		$this->db->select("*,jurnal.judul juduljurnal");
		$this->db->from("jurnal");
		$this->db->join("dosen","dosen.user=jurnal.user");
		$this->db->where("jurnal.usulan","");
		$this->db->where("jurnal.user<>","");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, jurnal.tahun_publikasi desc");
		$this->db->group_by("jurnal.judul");
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
		$this->db->select("*,jurnal.judul juduljurnal");
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

	function semuajurnalriset()
	{
		$data = array();
		$this->db->select("*,jurnal.judul juduljurnal");
		$this->db->from("jurnal");
		$this->db->join("usulan","usulan.id_usulan=jurnal.usulan","left");
		$this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->where("jurnal.sbgluaran","Luaran Penelitian");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, jurnal.tahun_publikasi desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function semuajurnalpkm()
	{
		$data = array();
		$this->db->select("*,jurnal.judul juduljurnal");
		$this->db->from("jurnal");
		$this->db->join("usulan_pkm","usulan_pkm.id_usulan=jurnal.usulan","left");
		$this->db->join("users","users.id_user=usulan_pkm.pengusul");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->where("jurnal.sbgluaran <>","Luaran Penelitian");
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc, jurnal.tahun_publikasi desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function lapkemajuanriset()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("lap_kemajuan","lap_kemajuan.id_usulan=usulan.id_usulan","left");
		$this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->where("YEAR(usulan.tglmulai)",date('Y'));
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function lapkemajuanpkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("lap_kemajuan_pkm","lap_kemajuan_pkm.id_usulan=usulan_pkm.id_usulan","left");
		$this->db->join("users","users.id_user=usulan_pkm.pengusul");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->where("YEAR(usulan_pkm.tglmulai)",date('Y'));
		$this->db->order_by("dosen.fakultas asc, dosen.prodi asc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function hki__($periode,$prodi,$sebagai)
	{
		$data = array();
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		//$this->db->join("usulan","usulan.id_usulan=hki.usulan");
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

	function hki($periode,$prodi,$sebagai)
	{
		$data = array();
		$luaran = array('Luaran PkM','Luaran Pengabdian');
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		// $this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=hki.user");
		if($prodi<>'Semua')
			$this->db->where("dosen.prodi",$prodi);
		$this->db->where("hki.tahun_pelaksanaan",$periode);
		if($sebagai=='Luaran PkM')
		{
			$this->db->where_in("hki.sbgluaran",$luaran);
		}
		else
			$this->db->where("hki.sbgluaran",$sebagai);
		$this->db->where("hki.usulan","");
		$this->db->where("hki.user <>","");
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
		$luaran = array('Luaran PkM','Luaran Pengabdian');
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		$this->db->join("usulan","usulan.id_usulan=hki.usulan","left");
		$this->db->join("users","users.id_user=usulan.pengusul");
		// $this->db->join("dosen","dosen.user=hki.user");
		if($prodi<>'Semua')
			$this->db->where("users.prodi",$prodi);
		$this->db->where("hki.tahun_pelaksanaan",$periode);
		if($sebagai=='Luaran PkM')
		{
			$this->db->where_in("hki.sbgluaran",$luaran);
		}
		else
			$this->db->where("hki.sbgluaran",$sebagai);
		$this->db->order_by("hki.tahun_pelaksanaan","desc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function hkiusulan__($periode,$prodi,$sebagai)
	{
		$data = array();
		$luaran = array('Luaran PkM','Luaran Pengabdian');
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		$this->db->where("hki.usulan<>","");
		if($prodi<>'Semua')
			$this->db->where("users.prodi",$prodi);
		$this->db->where("hki.tahun_pelaksanaan",$periode);
		if($sebagai=='Luaran PkM')
		{
			$this->db->where_in("hki.sbgluaran",$luaran);
		}
		else
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
		$luaran = array('Luaran PkM','Luaran Pengabdian');
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		// $this->db->join("users","users.id_user=usulan.pengusul");
		$this->db->join("dosen","dosen.user=hki.user");
		$this->db->where("hki.usulan","");
		$this->db->where("hki.user <>","");
		$this->db->order_by("hki.tahun_pelaksanaan desc,dosen.fakultas asc, dosen.prodi");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}
	
	function semuahkiusulan__()
	{
		$data = array();
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		$this->db->join("usulan","usulan.id_usulan=hki.usulan","left");
		$this->db->join("users","users.id_user=usulan.pengusul","left");
		$this->db->join("dosen","dosen.user=hki.user","left");
		$this->db->where("hki.usulan<>","");
		$this->db->order_by("hki.tahun_pelaksanaan desc, dosen.fakultas asc, dosen.prodi asc");
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->result();
		}
		return $data;
	}

	function getinfodosenriset($usulan)
	{
		$data = array();
		$this->db->select("dosen.namalengkap,dosen.nidn,dosen.fakultas,dosen.prodi,usulan.anggotadosen");
		$this->db->from("usulan");
		$this->db->join("dosen","dosen.user=usulan.pengusul");
		$this->db->where("usulan.id_usulan",$usulan);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}

	function getinfodosenpkm($usulan)
	{
		$data = array();
		$this->db->select("dosen.namalengkap,dosen.nidn,dosen.fakultas,dosen.prodi,usulan_pkm.anggotadosen");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.id_usulan",$usulan);
		$hasil = $this->db->get();
		
		if($hasil->num_rows() > 0)
		{
			$data = $hasil->row_array();
		}
		return $data;
	}

	function semuahkiusulan()
	{
		$data = array();
		$mana = array('Luaran Penelitian','Luaran Pengabdian');
		$this->db->select("*,hki.status statushki");
		$this->db->from("hki");
		$this->db->where("hki.usulan<>","");
		$this->db->where_in("hki.sbgluaran",$mana);
		$this->db->order_by("hki.tahun_pelaksanaan desc");
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
}