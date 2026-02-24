<?php
class Mpengabdian extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function histori($tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm", "lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.file_laporan_akhir <>", "");
		$this->db->where("lap_akhir_pkm.status", "Laporan Disetujui Reviewer");
		$this->db->like("usulan_pkm.tglmulai", $tahun);
		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("usulan_pkm.pengusul", $this->session->userdata('sesi_id'));
		}
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function daftariset()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("lap_akhir", "lap_akhir.id_usulan=usulan.id_usulan");
		$this->db->where("lap_akhir.file_laporan_akhir <>", "");
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function judulriset($id)
	{
		$data = array();
		$this->db->select("usulan.id_usulan,usulan.judul");
		$this->db->from("usulan");
		$this->db->join("lap_akhir", "lap_akhir.id_usulan=usulan.id_usulan");
		$this->db->where("lap_akhir.file_laporan_akhir <>", "");
		$this->db->where("usulan.id_usulan", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function hitbaru()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.status", "Usulan Dikirim");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan_pkm.modified", date('Y'));
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function kaprodisetuju($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("(usulan_pkm.status='Usulan Dikirim' OR usulan_pkm.status='DiTolak')");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan_pkm.tglmulai", $pilih);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitkaprodisetuju($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("(usulan_pkm.status='Usulan Dikirim' OR usulan_pkm.status='DiTolak')");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan_pkm.tglmulai", $pilih);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function simpanrevisikaprodi($id, $revisi)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"filerevisi_kaprodi" => $revisi,
			"modified"			 => $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "File Revisi Usulan Pengabdian telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function historikaprodisetuju($pilih)
	{
		$data = array();
		$in = array('Usulan Dikirim', 'Usulan Baru', 'DiTolak');
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan_pkm.tglmulai", $pilih);
		$this->db->where_not_in("usulan_pkm.status", $in);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function setuju($id)
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"status"		=> 'Usulan Disetujui Prodi',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Pengabdian telah disetujui pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function prodisetuju()
	{
		$waktu = date('Y-m-d H:i:s');
		if ($this->input->post("sesuai", true) == 'Sesuai' && $this->input->post("multi", true) == 'Sudah')
			$status = 'Usulan Disetujui Prodi';
		else
			$status = 'DiTolak';

		$data = array(
			"status"		=> $status,
			"roadmap"		=> $this->input->post("sesuai", true),
			"multi"			=> $this->input->post("multi", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $this->input->post("usulan", true));
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Pengabdian telah diverifikasi Prodi pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function tolak($id)
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"status"		=> 'Usulan Baru',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Pengabdian telah ditolak pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function reviewer($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function hitketua($sem)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("pengusul", $this->session->userdata('sesi_id'));
		$this->db->where("semester", $sem);
		$this->db->where("YEAR(tglmulai)", date('Y'));
		$this->db->where("YEAR(modified)", date('Y'));

		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitketualampau()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("pengusul", $this->session->userdata('sesi_id'));
		$this->db->where("semester", "Genap");
		$this->db->where("YEAR(tglmulai)", (date('Y') - 1));
		$this->db->where("YEAR(modified)", date('Y'));
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function anggotamhs()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("mahasiswa");
		$this->db->order_by("namamhs", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitreviewer($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function revkemajuan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.reviewer", $this->session->userdata('sesi_dosen'));
		$this->db->where("YEAR(usulan_pkm.tglmulai)", date('Y'));
		$this->db->like("status", "Usulan Disetujui Reviewer");
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitrevkemajuan()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.reviewer", $this->session->userdata('sesi_dosen'));
		$this->db->where("YEAR(usulan_pkm.tglmulai)", date('Y'));
		$this->db->like("status", "Usulan Disetujui Reviewer");
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitambilmax($id, $dosen)
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan_pkm as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");
		$this->db->where("(ro.pengusul=" . $id . " or FIND_IN_SET('" . $dosen . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)))");

		$this->db->where_not_in("ro.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("YEAR(ro.tglmulai)", date('Y'));
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function kemajuan($pilih)
	{
		// $data = array();
		// $this->db->select("*");
		// $this->db->from("usulan_pkm");
		// $this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		// if($this->session->userdata('sesi_status')==3 || $this->session->userdata('sesi_status')==2) 
		// {
		// 	$this->db->where("usulan_pkm.pengusul",$this->session->userdata('sesi_id'));
		// }

		// // $this->db->like("status","Usulan Disetujui Reviewer");
		// $this->db->like("usulan_pkm.tglmulai",$pilih);
		// $this->db->order_by("usulan_pkm.tglmulai","desc");
		// $hasil = $this->db->get();

		$data = array();
		$this->db->select("pkm.*,dosen.prodi,pkm.reviewer cek");
		$this->db->from("usulan_pkm as pkm");
		$this->db->join("dosen", "dosen.user=pkm.pengusul");
		$this->db->join("lap_kemajuan_pkm", "lap_kemajuan_pkm.id_usulan=pkm.id_usulan", "left");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("(pkm.pengusul=" . $this->session->userdata('sesi_id') . " OR FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan_pkm WHERE id_usulan=pkm.id_usulan)))");
		}

		$this->db->where_not_in("pkm.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("pkm.tglmulai", $pilih);
		$this->db->order_by("pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function liatfilekemajuan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_kemajuan_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function liatfilelaporan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan <>", "");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function liatfilelapakhir($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan_akhir <>", "");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function hitlaporanakhir($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan <>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitrevisi($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_revisi <>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function liatfilerevisilap($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function sudahkemajuan($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_kemajuan_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function sudahlaporan($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan <>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function sudahrevisi($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_revisi <>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function laporansah($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan_akhir <>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function cekreviewernya($id)
	{
		$rev = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasilrev = $this->db->get();

		$rev = $hasilrev->row_array();

		$data = 0;
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("usulan_pkm.reviewer REGEXP ", $rev['id_dosen']);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function cekidrev($id)
	{
		$rev = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasilrev = $this->db->get();

		$rev = $hasilrev->row_array();

		return $rev;
	}

	function cekrevinya($usulan, $id)
	{
		$rev = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasilrev = $this->db->get();

		$rev = $hasilrev->row_array();

		$data = 0;
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("usulan_pkm.reviewer IN (select reviewer from usulan_pkm where id_usulan=" . $usulan_pkm . ")");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function direviewoleh($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->join("dosen", "dosen.user=hasilreview_pkm.reviewer");
		$this->db->where("hasilreview_pkm.usulan", $usulan);
		$this->db->where("hasilreview_pkm.skor <> ", "");
		$this->db->limit(1);
		$this->db->order_by('id_review', 'desc');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

		return $data;
	}

	function lapdireviewoleh($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->join("dosen", "dosen.user=hasilreview_laporan_pkm.reviewer");
		$this->db->where("hasilreview_laporan_pkm.usulan", $usulan);
		$this->db->where("hasilreview_laporan_pkm.skor <> ", "");
		$this->db->limit(1);
		$this->db->order_by('hasilreview_laporan_pkm.id_reviewlaporan', 'desc');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

		return $data;
	}

	function direview($tahun)
	{
		// $rev = array();
		// $this->db->select("*");
		// $this->db->from("dosen");
		// $this->db->where("user",$this->session->userdata('sesi_id'));
		// $hasilrev = $this->db->get();

		// $rev = $hasilrev->row_array();

		// $logrev = array();
		// $this->db->select("reviewer");
		// $this->db->from("usulan_pkm");
		// $this->db->where("pengusul",$this->session->userdata('sesi_id'));
		// $logrevi = $this->db->get();

		// $logrev = $logrevi->row_array();

		// $daftarnya = $logrev['reviewer'];

		$data = array();
		$this->db->select("*,usulan_pkm.reviewer as revnya");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm", "usulan_pkm.id_usulan=lap_akhir_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.file_laporan <> ", "");
		$this->db->like("usulan_pkm.tglmulai", $tahun);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

		return $data;
	}

	function jmldireview($tahun)
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer as revnya");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm", "usulan_pkm.id_usulan=lap_akhir_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.file_laporan <> ", "");
		$this->db->like("usulan_pkm.tglmulai", $tahun);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitdireview()
	{
		$rev = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $this->session->userdata('sesi_id'));
		$hasilrev = $this->db->get();

		$rev = $hasilrev->row_array();

		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm", "usulan_pkm.id_usulan=lap_akhir_pkm.id_usulan");
		$this->db->where("usulan_pkm.reviewer REGEXP ", $rev['id_dosen']);
		$this->db->where("lap_akhir_pkm.file_laporan <> ", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function laporan($pilih)
	{
		$data = array();
		// $this->db->select("*");
		// $this->db->from("usulan_pkm");
		// $this->db->join("dosen","dosen.user=usulan_pkm.pengusul");
		// $this->db->join("lap_kemajuan_pkm","lap_kemajuan_pkm.id_usulan=usulan_pkm.id_usulan");
		// if($this->session->userdata('sesi_status')==3 || $this->session->userdata('sesi_status')==2) 
		// {
		// 	$this->db->where("usulan_pkm.pengusul",$this->session->userdata('sesi_id'));
		// }
		// $this->db->like("status","Usulan Disetujui Reviewer");
		// $this->db->like("usulan_pkm.tglmulai",$pilih);
		// $this->db->order_by("usulan_pkm.tglmulai","desc");

		$this->db->select("*,pkm.reviewer cek");
		$this->db->from("usulan_pkm as pkm");
		$this->db->join("dosen", "dosen.user=pkm.pengusul");
		$this->db->join("lap_kemajuan_pkm", "lap_kemajuan_pkm.id_usulan=pkm.id_usulan");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("(pkm.pengusul=" . $this->session->userdata('sesi_id') . " OR FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan_pkm WHERE id_usulan=pkm.id_usulan)))");
		}

		// $this->db->where_not_in("pkm.status","Usulan Disetujui Reviewer");
		$this->db->like("pkm.tglmulai", $pilih);
		$this->db->order_by("pkm.tglmulai", "desc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function sbganggota($usulan)
	{
		$data = array();
		$this->db->select('*');
		$this->db->from('usulan_pkm as pkm');
		$this->db->where("FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan_pkm WHERE id_usulan='" . $usulan . "'))");
		$this->db->where('id_usulan', $usulan);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function simpanlegalisir($id, $legalisir)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"legalisir"		=> $legalisir,
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "File Usulan Pengabdian dengan Pengesahan telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function usulan($pilih)
	{
		$data = array();
		$this->db->select("DISTINCT(pkm.id_usulan) as idx, pkm.*, dosen.*, pkm.reviewer cek");
		$this->db->from("usulan_pkm as pkm");
		$this->db->join("dosen", "dosen.user=pkm.pengusul");
		$this->db->join("peran", "peran.id_usulan=pkm.id_usulan AND peran.skema='Pengabdian'", "left");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("(pkm.pengusul=" . $this->session->userdata('sesi_id') . " OR peran.anggota='" . $this->session->userdata('sesi_dosen') . "' OR FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan_pkm WHERE id_usulan=pkm.id_usulan)))");
		}

		$this->db->where_not_in("pkm.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("pkm.tglmulai", $pilih);
		$this->db->order_by("pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		//echo $this->db->last_query();
		return $data;
	}

	function pilihusulan($pilih)
	{
		$data = array();
		$this->db->select("*,pkm.reviewer cek");
		$this->db->from("usulan_pkm as pkm");
		$this->db->join("dosen", "dosen.user=pkm.pengusul");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("pkm.pengusul", $this->session->userdata('sesi_id'));
		}

		$this->db->where_not_in("pkm.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("pkm.tglmulai", $pilih);
		$this->db->order_by("pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function anggotausulan($id, $usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("anggotasetuju");
		$this->db->where("idanggota", $id);
		$this->db->where("id_usulan", $usulan);
		$this->db->where("jenis", "Pengabdian");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function hitanggotausulan($id, $usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("anggotasetuju");
		$this->db->where("idanggota", $id);
		$this->db->where("id_usulan", $usulan);
		$this->db->where("jenis", "Pengabdian");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function eksporusulan($tahun)
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer cek,usulan_pkm.id_usulan id_usulan");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul", 'left');
		$this->db->join("lap_kemajuan_pkm", "lap_kemajuan_pkm.id_usulan=usulan_pkm.id_usulan", 'left');
		$this->db->join("lap_akhir_pkm", "lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan", 'left');
		$this->db->like("usulan_pkm.tglmulai", $tahun);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hasilreview()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->join("usulan_pkm", "hasilreview_pkm.usulan=usulan_pkm.id_usulan");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->order_by("hasilreview_pkm.modified", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function usulanreview($id)
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer cek");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("find_in_set($id,usulan_pkm.reviewer)>", 0);
		$this->db->where_in("usulan_pkm.status", array("Usulan Disetujui Prodi", "Reviewed", "Usulan Disetujui Reviewer", "Usulan Disetujui Reviewer"));
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function jmlusulan($id)
	{
		$data = array();
		$tahun = date('Y');
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->like("tglmulai", $tahun);
		$this->db->where("pengusul", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitusulanreview($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("find_in_set($id,usulan_pkm.reviewer)>", 0);
		$this->db->where_in("usulan_pkm.status", array("Usulan Disetujui Prodi", "Reviewed", "Usulan Disetujui Reviewer", "Usulan Disetujui Reviewer"));
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function cekreview($rev, $usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->where("reviewer", $rev);
		$this->db->where("usulan", $usulan);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function lihathasilreviewlaporan($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->limit(1);
		$this->db->order_by('modified', 'desc');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

		return $data;
	}

	function lihathasilreview($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->limit(1);
		$this->db->order_by('modified', 'desc');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

		return $data;
	}

	function lihatisianreview($usulan, $reviewer)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->where("reviewer", $reviewer);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}

		return $data;
	}

	function lihatisianreviewlaporan($usulan, $reviewer)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->where("reviewer", $reviewer);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}

		return $data;
	}

	function lihatreviewlaporan($usulan, $reviewer)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->where("reviewer", $reviewer);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}

		return $data;
	}

	function kaplingusulan($a, $b)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.skema", $a);
		if ($b == 1)
			$this->db->where("usulan_pkm.status", "Usulan Baru");
		elseif ($b == 2)
			$this->db->where("usulan_pkm.status", "Usulan Dikirim");
		elseif ($b == 3)
			$this->db->where("usulan_pkm.status", "Usulan Disetujui");
		else
			$this->db->where("usulan_pkm.status", "Usulan Tidak Disetujui");

		if ($this->session->userdata('sesi_id') == 3) {
			$this->db->where("usulan_pkm.pengusul", $this->session->userdata('sesi_id'));
		}
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function usulanrev()
	{
		$data = array();
		$this->db->select("*,usulan_pkm.reviewer cek");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.status", "Usulan Disetujui Prodi");
		// $this->db->where("usulan_pkm.reviewer","");
		if ($this->session->userdata('sesi_id') == 3) {
			$this->db->where("usulan_pkm.pengusul", $this->session->userdata('sesi_id'));
		}
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function rab()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		// $this->db->where("jenis <>","1");
		$this->db->order_by("namalengkap", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function totalrab($id)
	{
		$data = array();
		$this->db->select("(select SUM(volume*hargasatuan) from rab_pkm where jenis='Bahan' AND usulan='$id') as bahan,(select SUM(volume*hargasatuan) from rab_pkm where jenis='Pengumpulan Data' AND usulan='$id') as kumpul,(select SUM(volume*hargasatuan) from rab_pkm where jenis='Sewa Peralatan' AND usulan='$id') as sewa,(select SUM(volume*hargasatuan) from rab_pkm where jenis='Analisis Data' AND usulan='$id') as analis, (select SUM(volume*hargasatuan) from rab_pkm where jenis='Pelaporan dan Luaran' AND usulan='$id') as lapor");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();

		// if($hasil->num_rows() > 0)
		// {
		$data = $hasil->row_array();
		// }
		return $data;
	}

	function cekrab($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function bahan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$this->db->where("jenis", 'Bahan');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function kumpuldata($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$this->db->where("jenis", 'Pengumpulan Data');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function sewaalat($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$this->db->where("jenis", 'Sewa Peralatan');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function analisisdata($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$this->db->where("jenis", 'Analisis Data');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function lapordanluar($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab_pkm");
		$this->db->where("usulan", $id);
		$this->db->where("jenis", 'Pelaporan dan Luaran');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function plotdosen()
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"reviewer"		=> $this->input->post("iddosen", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $this->input->post("id", true));
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Plot Reviewer PkM telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrab($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$dana = str_replace(".", "", $this->input->post('hargasatuan', true));

		$data = array(
			"item"				=> $this->input->post("item", true),
			"jenis"				=> $this->input->post("jenis", true),
			"satuan"			=> $this->input->post("satuan", true),
			"volume"			=> $this->input->post("volume", true),
			"hargasatuan"		=> $dana,
			"usulan"			=> $id
		);

		$this->db->insert("rab_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Usulan RAB PkM telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function fakultas()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("fakultas");
		// $this->db->where("jenis <>","1");
		$this->db->order_by("id_fak", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function tglterbit($tahun, $sem)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("terbitsurat");
		$this->db->where("jenis", "pengabdian");
		$this->db->where("tahun", $tahun);
		$this->db->where("semester", $sem);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function hitrev($usulan, $reviewer)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->where("reviewer", $reviewer);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitrevlap($usulan, $reviewer)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("usulan", $usulan);
		$this->db->where("reviewer", $reviewer);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function prodi($idfak)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prodi");
		$this->db->where("fakultas", $idfak);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hithistori()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("submit");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitjuangusulanbaru()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Baru");
		$this->db->where("skema", "Kejuangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitjuangusulandikirim()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Dikirim");
		$this->db->where("skema", "Kejuangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitjuangusulandisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Disetujui");
		$this->db->where("skema", "Kejuangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitjuangusulantidakdisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Kejuangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitkembangusulanbaru()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Baru");
		$this->db->where("skema", "Pengembangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitkembangusulandikirim()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Dikirim");
		$this->db->where("skema", "Pengembangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitkembangusulandisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Disetujui");
		$this->db->where("skema", "Pengembangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitkembangusulantidakdisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Pengembangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitnoninsidentalusulanbaru()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Baru");
		$this->db->where("skema", "Noninsidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitnoninsidentalusulandikirim()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Dikirim");
		$this->db->where("skema", "Noninsidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitnoninsidentalusulandisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Disetujui");
		$this->db->where("skema", "Noninsidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitnoninsidentalusulantidakdisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Noninsidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitinsidentalusulanbaru()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Baru");
		$this->db->where("skema", "Insidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitinsidentalusulandikirim()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Dikirim");
		$this->db->where("skema", "Insidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitinsidentalusulandisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Disetujui");
		$this->db->where("skema", "Insidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitinsidentalusulantidakdisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Insidental");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function namamhs($id)
	{
		$data = array();
		$this->db->select("namamhs,npm,fakultas,prodi");
		$this->db->from("mahasiswa");
		$this->db->where("idmhs", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function simpan($fileusulan)
	{
		$waktu = date('Y-m-d H:i:s');
		$luaran = $this->input->post("luaran", true);
		$dana = str_replace(".", "", $this->input->post('jmldana'));
		$store = '';
		$hit = count($luaran);
		for ($i = 0; $i < $hit; $i++) {
			$store .= $luaran[$i];
			if ($i < ($hit - 1))
				$store .= ',';
		}

		$data = array(
			"judul"				=> $this->input->post("judul", true),
			"skema"				=> $this->input->post("skema", true),
			"luaran"			=> $store,
			"namajurnal"		=> $this->input->post("namajurnal", true),
			"sumberdana"		=> $this->input->post("sumberdana", true),
			"jmldana"			=> $dana,
			// "anggotadosen"		=> $this->input->post("iddosen",true),
			// "anggotamhs"		=> $this->input->post("idmhs",true),
			"jumlahmhs"		    => count($this->input->post('m_id')),
			"ringkasan"			=> $this->input->post("ringkasan", true),
			"katakunci"			=> $this->input->post("katakunci", true),
			"tglmulai"			=> $this->input->post("tglmulai", true),
			"tglakhir"			=> $this->input->post("tglakhir", true),
			"semester"			=> $this->input->post("sem", true),
			"sumberpkm"			=> $this->input->post("sumberpkm", true),
			"fileusulan"		=> $fileusulan,
			"status"			=> 'Usulan Baru',
			"pengusul"			=> $this->session->userdata('sesi_id'),
			"modified"			=> $waktu
		);

		$this->db->insert("usulan_pkm", $data);

		$id = $this->db->insert_id();

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Usulan PkM dengan judul " . $this->input->post("judul", true) . " telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem

		return $id;
	}

	function cekdana($id)
	{
		$data = array();
		$this->db->select("jmldana,totaldana");
		$this->db->from("usulan_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function updateusulan($fileusulan)
	{
		$waktu = date('Y-m-d H:i:s');
		$luaran = $this->input->post("luaran", true);
		$dana = str_replace(".", "", $this->input->post('jmldana'));
		$store = '';
		$status	= $this->input->post("statususulan", true);
		$hit = count($luaran);
		for ($i = 0; $i < $hit; $i++) {
			$store .= $luaran[$i];
			if ($i < ($hit - 1))
				$store .= ',';
		}

		if ($fileusulan <> '' && $this->session->userdata('sesi_status') == 1 && $status <> '') {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"semester"			=> $this->input->post("sem", true),
				"sumberpkm"			=> $this->input->post("sumberpkm", true),
				"fileusulan"		=> $fileusulan,
				"status"			=> $status,
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		} elseif ($this->session->userdata('sesi_status') == 1 && $status <> '') {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"semester"			=> $this->input->post("sem", true),
				"sumberpkm"			=> $this->input->post("sumberpkm", true),
				"status"			=> $status,
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		} elseif ($fileusulan <> '') {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"fileusulan"		=> $fileusulan,
				"semester"			=> $this->input->post("sem", true),
				"sumberpkm"			=> $this->input->post("sumberpkm", true),
				//"status"			=> $this->input->post("statususulan",true),
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		} else {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"semester"			=> $this->input->post("sem", true),
				"sumberpkm"			=> $this->input->post("sumberpkm", true),
				// "status"			=> 'Usulan Baru',
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		}

		$this->db->where("id_usulan", $this->input->post("id", true));
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Usulan PkM dengan judul " . $this->input->post("judul", true) . " telah diupdate pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanreview($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true) . ',' . $this->input->post("poinlima", true) . ',' . $this->input->post("poinenam", true) . ',' . $this->input->post("pointujuh", true);
		$data = array(
			"usulan"				=> $id,
			"hasilreview"			=> $this->input->post("review", true),
			"skor"					=> $skor,
			"filereview"			=> $filereview,
			"reviewer"				=> $this->session->userdata("sesi_id"),
			"modified"				=> $waktu
		);

		$this->db->insert("hasilreview_pkm", $data);

		//update data usulan
		$data = array(
			"status"		=> 'Reviewed',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review PkM telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanreviewlaporan($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true);
		$data = array(
			"usulan"				=> $id,
			"hasilreview_laporan"	=> $this->input->post("review", true),
			"skor"					=> $skor,
			"filereview_laporan"	=> $filereview,
			"reviewer"				=> $this->session->userdata("sesi_id"),
			"modified"				=> $waktu
		);

		$this->db->insert("hasilreview_laporan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Laporan Akhir PkM telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function updatereview($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true) . ',' . $this->input->post("poinlima", true) . ',' . $this->input->post("poinenam", true) . ',' . $this->input->post("pointujuh", true);

		if ($filereview <> '') {
			$data = array(
				//"usulan"			=> $id,
				"hasilreview"		=> $this->input->post("review", true),
				"skor"				=> $skor,
				"filereview"		=> $filereview,
				//"reviewer"			=> $this->session->userdata("sesi_id"),
				"modified"			=> $waktu
			);
		} else {
			$data = array(
				//"usulan"			=> $id,
				"hasilreview"		=> $this->input->post("review", true),
				"skor"				=> $skor,
				//"reviewer"			=> $this->session->userdata("sesi_id"),
				"modified"			=> $waktu
			);
		}
		$this->db->where("id_review", $this->input->post("idreview", true));
		$this->db->update("hasilreview_pkm", $data);

		//update data usulan
		$data = array(
			"status"		=> 'Reviewed',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review PkM telah diupdate oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function updatereviewlaporan($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true);

		if ($filereview <> '') {
			$data = array(
				//"usulan"				=> $id,
				"hasilreview_laporan"	=> $this->input->post("review", true),
				"skor"					=> $skor,
				"filereview_laporan"	=> $filereview,
				//"reviewer"			=> $this->session->userdata("sesi_id"),
				"modified"			=> $waktu
			);
		} else {
			$data = array(
				//"usulan"				=> $id,
				"hasilreview_laporan"	=> $this->input->post("review", true),
				"skor"					=> $skor,
				//"reviewer"			=> $this->session->userdata("sesi_id"),
				"modified"			=> $waktu
			);
		}
		$this->db->where("id_reviewlaporan", $this->input->post("idlaporan", true));
		$this->db->update("hasilreview_laporan_pkm", $data);

		// echo $this->db->last_query();exit;

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Laporan Akhir PkM telah diupdate oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpankemajuan($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_kemajuan_pkm");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0) {
			$data = array(
				"lap_kemajuan"	=> $file,
				"date"			=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_kemajuan_pkm", $data);
		} else {
			$data = array(
				"id_usulan"		=> $this->input->post("id", true),
				"lap_kemajuan"	=> $file,
				"date"			=> $waktu
			);
			$this->db->insert("lap_kemajuan_pkm", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Laporan Kemajuan PkM telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function hitangg($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("peran");
		$this->db->where("id_usulan", $id);
		$this->db->where("skema", "Pengabdian");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function simpanlaporan($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0 && $file <> '') {
			$data = array(
				"file_laporan"	=> $file,
				"modified"		=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_akhir_pkm", $data);
		} elseif ($hitdata > 0 && $file == '') {
		} else {
			$data = array(
				"id_usulan"		=> $this->input->post("id", true),
				"file_laporan"	=> $file,
				"modified"		=> $waktu
			);
			$this->db->insert("lap_akhir_pkm", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Laporan Akhir PkM telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanlaporanakhir($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0 && $file <> '') {
			$data = array(
				"file_laporan_akhir"	=> $file,
				"modified"				=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_akhir_pkm", $data);
		} elseif ($hitdata > 0 && $file == '') {
		} else {
			$data = array(
				"id_usulan"				=> $this->input->post("id", true),
				"file_laporan"	=> $file,
				"modified"				=> $waktu
			);
			$this->db->insert("lap_akhir_pkm", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Laporan Akhir PkM dengan Pengesahan telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrevisilaporan($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0 && $file <> '') {
			$data = array(
				"file_revisi"	=> $file,
				"modified"		=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_akhir_pkm", $data);

			//masukan logs sistem
			$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Laporan Akhir PkM telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
			);
			$this->db->insert("logs", $data);
			//akhir masukan logs sistem
		}
	}

	function simpanjurnal($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("usulan", $this->input->post("id", true));
		$this->db->where("sbgluaran", "Luaran Pengabdian");
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0) {
			if ($file <> '') {
				$data = array(
					"judul"				=> $this->input->post("judul", true),
					"nama_jurnal"		=> $this->input->post("namajurnal", true),
					"jenis_publikasi"	=> $this->input->post("jenispublikasi", true),
					"status_jurnal"		=> $this->input->post("statusjurnal", true),
					"peran_penulis"		=> $this->input->post("peranpenulis", true),
					"tahun_publikasi"	=> $this->input->post("tahun", true),
					"volume"			=> $this->input->post("volume", true),
					"nomor"				=> $this->input->post("nomor", true),
					"hal_awal"			=> $this->input->post("awal", true),
					"hal_akhir"			=> $this->input->post("akhir", true),
					"url"				=> $this->input->post("url", true),
					"issn"				=> $this->input->post("issn", true),
					"file_jurnal"		=> $file,
					"modified"			=> $waktu
				);
			} else {
				$data = array(
					"judul"				=> $this->input->post("judul", true),
					"nama_jurnal"		=> $this->input->post("namajurnal", true),
					"jenis_publikasi"	=> $this->input->post("jenispublikasi", true),
					"status_jurnal"		=> $this->input->post("statusjurnal", true),
					"peran_penulis"		=> $this->input->post("peranpenulis", true),
					"tahun_publikasi"	=> $this->input->post("tahun", true),
					"volume"			=> $this->input->post("volume", true),
					"nomor"				=> $this->input->post("nomor", true),
					"hal_awal"			=> $this->input->post("awal", true),
					"hal_akhir"			=> $this->input->post("akhir", true),
					"url"				=> $this->input->post("url", true),
					"issn"				=> $this->input->post("issn", true),
					"modified"			=> $waktu
				);
			}
			$this->db->where("usulan", $this->input->post("id", true));
			$this->db->where("sbgluaran", "Luaran Pengabdian");
			$this->db->update("jurnal", $data);
		} else {
			$data = array(
				"usulan"			=> $this->input->post("id", true),
				"judul"				=> $this->input->post("judul", true),
				"nama_jurnal"		=> $this->input->post("namajurnal", true),
				"sbgluaran"			=> 'Luaran Pengabdian',
				"jenis_publikasi"	=> $this->input->post("jenispublikasi", true),
				"status_jurnal"		=> $this->input->post("statusjurnal", true),
				"peran_penulis"		=> $this->input->post("peranpenulis", true),
				"tahun_publikasi"	=> $this->input->post("tahun", true),
				"volume"			=> $this->input->post("volume", true),
				"nomor"				=> $this->input->post("nomor", true),
				"hal_awal"			=> $this->input->post("awal", true),
				"hal_akhir"			=> $this->input->post("akhir", true),
				"url"				=> $this->input->post("url", true),
				"issn"				=> $this->input->post("issn", true),
				"file_jurnal"		=> $file,
				"modified"			=> $waktu
			);
			$this->db->insert("jurnal", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Luaran PkM - Jurnal telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanhki($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("usulan", $this->input->post("id", true));
		$this->db->where("sbgluaran", "Luaran Pengabdian");
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0) {
			if ($file <> '') {
				$data = array(
					"judul"					=> $this->input->post("judul", true),
					"jenis_hki"				=> $this->input->post("jenishki", true),
					"tahun_pelaksanaan"		=> $this->input->post("tahunpelaksanaan", true),
					"nomor_pendaftaran"		=> $this->input->post("nomordaftar", true),
					"status"				=> $this->input->post("status", true),
					"nomor_hki"				=> $this->input->post("nomorhki", true),
					"url_dokumen"			=> $this->input->post("url", true),
					"file_hki"				=> $file,
					"modified"				=> $waktu
				);
			} else {
				$data = array(
					"judul"					=> $this->input->post("judul", true),
					"jenis_hki"				=> $this->input->post("jenishki", true),
					"tahun_pelaksanaan"		=> $this->input->post("tahunpelaksanaan", true),
					"nomor_pendaftaran"		=> $this->input->post("nomordaftar", true),
					"status"				=> $this->input->post("status", true),
					"nomor_hki"				=> $this->input->post("nomorhki", true),
					"url_dokumen"			=> $this->input->post("url", true),
					"modified"				=> $waktu
				);
			}
			$this->db->where("usulan", $this->input->post("id", true));
			$this->db->where("sbgluaran", "Luaran Pengabdian");
			$this->db->update("hki", $data);
		} else {
			$data = array(
				"usulan"			=> $this->input->post("id", true),
				"judul"					=> $this->input->post("judul", true),
				"jenis_hki"				=> $this->input->post("jenishki", true),
				"sbgluaran"				=> 'Luaran Pengabdian',
				"tahun_pelaksanaan"		=> $this->input->post("tahunpelaksanaan", true),
				"nomor_pendaftaran"		=> $this->input->post("nomordaftar", true),
				"status"				=> $this->input->post("status", true),
				"nomor_hki"				=> $this->input->post("nomorhki", true),
				"url_dokumen"			=> $this->input->post("url", true),
				"file_hki"				=> $file,
				"modified"				=> $waktu
			);
			$this->db->insert("hki", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Luaran PkM - HKI telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrelevansi($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('relevansi_pkm');
		$this->db->where('usulan', $id);
		$cek = $this->db->get();


		$data = array(
			"matakuliah"		=> $this->input->post("matakuliah", true),
			"bentuk_integrasi"	=> $this->input->post("integrasi", true),
			"usulan"			=> $id
		);

		if ($cek->num_rows() > 0) {
			$this->db->where("usulan", $id);
			$this->db->update("relevansi_pkm", $data);
		} else {
			$this->db->insert("relevansi_pkm", $data);
		}

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Relevansi Pengabdian telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function liatrelevansi()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("relevansi_pkm");
		$this->db->where("usulan", $this->uri->segment(3));
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function simpanperbaikan($id, $filerevisi)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"filerevisi"		=> $filerevisi,
			"modified"			=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Perbaikan Usulan PkM telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanperbaikanlap($id, $filerevisi)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"file_revisi"		=> $filerevisi,
			"modified"			=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("lap_akhir_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Perbaikan Laporan PkM telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpansetuju($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"status"		=> $this->input->post("setuju", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $id . '-' . $this->input->post("setuju", true) . ' oleh ' . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpananggotasetuju($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"id_usulan"	=> $id,
			"jenis"		=> $this->input->post("jenis", true),
			"idanggota"	=> $this->input->post("anggota", true),
			"setuju"	=> $this->input->post("setuju", true),
			"modified"	=> $waktu
		);
		$this->db->insert("anggotasetuju", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->input->post("anggota", true) . ' - ' . $this->input->post("setuju", true) . ' Usulan ' . $id . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpansetujulaporan($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"status"		=> $this->input->post("setuju", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("lap_akhir_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $id . '-' . $this->input->post("setuju", true) . ' oleh ' . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function ceksetuju($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("logs");
		$this->db->where("SUBSTRING_INDEX(keterangan, '-', 1)=", $id);
		$this->db->like("keterangan", 'Usulan Disetujui Reviewer');
		$this->db->like("keterangan", $this->session->userdata("sesi_nama"));
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function kirim($id)
	{
		$waktu = date('Y-m-d H:i:s');

		//update data usulan
		$data = array(
			"status"		=> 'Usulan Dikirim',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan PkM telah dikirim oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function update()
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"namalengkap"		=> $this->input->post("namalengkap", true),
			"jk"				=> $this->input->post("jk", true),
			"tmplahir"			=> $this->input->post("tmplahir", true),
			"tglahir"			=> $this->input->post("tglahir", true),
			"ktp"				=> $this->input->post("ktp", true),
			"nidn"				=> $this->input->post("nidn", true),
			"fakultas"			=> $this->input->post("fakultas", true),
			"prodi"				=> $this->input->post("prodi", true),
			"alamat"			=> $this->input->post("alamat", true),
			"jenjangpendidikan"	=> $this->input->post("jenjangpendidikan", true),
			"website"			=> $this->input->post("web", true),
			"jabatanakademik"	=> $this->input->post("jabatanakademik", true),
			"id_googlescholar"	=> $this->input->post("google", true),
			"id_scopus"			=> $this->input->post("scopus", true),
			"id_sinta"			=> $this->input->post("sinta", true),
			"modified"			=> $waktu
		);

		$this->db->where("id_dosen", $this->input->post("id_dosen", true));
		$this->db->update("dosen", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah mengubah data Dosen " . $this->input->post("namalengkap", true) . " " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function sudahisibelum()
	{
		$data = array();
		$thn = date('Y');
		$this->db->select("*");
		$this->db->from("kuesioner");
		$this->db->where("dosen", $this->session->userdata('sesi_id'));
		$this->db->like("kirim", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function detail($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function getidrev($id)
	{
		$data = array();
		$this->db->select("id_dosen,namalengkap,user");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function realjurnal($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("usulan", $id);
		$this->db->where("sbgluaran <> ", "Luaran Penelitian");
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function hitrealjurnal($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("usulan", $id);
		$this->db->where("sbgluaran <> ", "Luaran Penelitian");
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function cekpengusul($usulan, $pengusul)
	{
		$rev = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $pengusul);
		$hasilrev = $this->db->get();

		$rev = $hasilrev->row_array();

		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("pengusul", $pengusul);
		// $this->db->or_where("reviewer REGEXP ",$rev['id_dosen']);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function cekrevnya($usulan, $reviewer)
	{
		$rev = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $reviewer);
		$hasilrev = $this->db->get();

		$rev = $hasilrev->row_array();

		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("usulan_pkm.reviewer REGEXP ", $rev['id_dosen']);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function realhki($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("usulan", $id);
		$this->db->where("sbgluaran <> ", "Luaran Penelitian");
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function hitrealhki($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hki");
		$this->db->where("usulan", $id);
		$this->db->where("sbgluaran <> ", "Luaran Penelitian");
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function hitlapreview($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan_pkm");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function hitlap($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function hitlapakhir($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan <> ", "");
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function detailusulan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function lihatkemajuan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_kemajuan_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function detailapakhir($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir_pkm");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function cekbuka($id)
	{
		$data = array();
		$this->db->select("dosen.fakultas,opensubmit.status");
		$this->db->from("dosen");
		$this->db->where("dosen.user", $id);
		$this->db->join("opensubmit", "dosen.fakultas=opensubmit.id_open");
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function hapus($id)
	{
		$this->db->where("id_usulan", $id);
		$this->db->delete("usulan_pkm");

		$this->db->where("usulan", $id);
		$this->db->delete("rab_pkm");

		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menghapus data Usulan beserta RAB " . $id . " pada tanggal " . $wkt
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function hapusrab($id)
	{
		$this->db->where("id_rab", $id);
		$this->db->delete("rab_pkm");

		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menghapus Data Rincian RAB " . $id . " " . $wkt
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function addanggota($data)
	{
		return $this->db->insert("peran", $data);
	}


	function updateanggota($id, $data)
	{
		$this->db->where("idperan", $id);
		return $this->db->update("peran", $data);
	}


	function deleteanggota($id)
	{
		$this->db->where("idperan", $id);
		return $this->db->delete("peran");
	}
}
