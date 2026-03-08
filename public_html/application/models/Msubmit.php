<?php
class MSubmit extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function histori($tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");
		$this->db->join("lap_akhir", "lap_akhir.id_usulan=ro.id_usulan");
		$this->db->where("lap_akhir.file_laporan_akhir <>", "");
		$this->db->where("lap_akhir.status", "Laporan Disetujui Reviewer 2");
		if ($this->session->userdata('sesi_status') <> 1) {
			// $this->db->where("usulan.pengusul",$this->session->userdata('sesi_id'));
			$this->db->where("(ro.pengusul=" . $this->session->userdata('sesi_id') . " or FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)))");
		}
		$this->db->like("ro.tglmulai", $tahun);
		$this->db->order_by("ro.tglmulai", "desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function historipkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->join("lap_akhir_pkm", "lap_akhir_pkm.id_usulan=usulan_pkm.id_usulan");
		$this->db->where("lap_akhir_pkm.status", "Laporan Disetujui");
		if ($this->session->userdata('sesi_id') == 3) {
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

	function revkemajuan($pilih)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		if ($this->session->userdata('sesi_status') <> 1)
			$this->db->where("find_in_set(" . $this->session->userdata('sesi_dosen') . ",usulan.reviewer)>", 0);
		$this->db->where("YEAR(usulan.tglmulai)", $pilih);
		// $this->db->where("usulan.status","Usulan Disetujui");
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitrevkemajuan($pilih)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		if ($this->session->userdata('sesi_status') <> 1)
			$this->db->where("find_in_set(" . $this->session->userdata('sesi_dosen') . ",usulan.reviewer)>", 0);
		$this->db->where("YEAR(usulan.tglmulai)", $pilih);
		// $this->db->where_in("usulan.status","Usulan Disetujui");
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function kemajuan($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");
		if ($this->session->userdata('sesi_status') == 3 || $this->session->userdata('sesi_status') == 2 || $this->session->userdata('sesi_status') == 4) {
			// $this->db->where("usulan.pengusul",$this->session->userdata('sesi_id'));
			$this->db->where("(ro.pengusul=" . $this->session->userdata('sesi_id') . " or FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)))");
		}
		//$this->db->like("status","Usulan Disetujui Reviewer");
		$this->db->like("ro.tglmulai", $pilih);
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function kaprodisetuju($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("(usulan.status='Usulan Dikirim' OR usulan.status='DiTolak')");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan.tglmulai", $pilih);
		$this->db->order_by("usulan.tglmulai", "desc");
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
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("usulan.status='Usulan Dikirim' OR usulan.status='DiTolak'");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan.tglmulai", $pilih);
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function historikaprodisetuju($pilih)
	{
		$data = array();
		$in = array('Usulan Dikirim', 'Usulan Baru', 'DiTolak');
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->like("usulan.tglmulai", $pilih);
		$this->db->where_not_in("usulan.status", $in);
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->order_by("usulan.tglmulai", "desc");
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
		$this->db->from("usulan");
		$this->db->like("tglmulai", $tahun);
		$this->db->where("pengusul", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function liatfilekemajuan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_kemajuan");
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
		$this->db->from("lap_akhir");
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
		$this->db->from("lap_akhir");
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
		$this->db->from("lap_akhir");
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
		$this->db->from("lap_akhir");
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
		$this->db->from("lap_akhir");
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
		$this->db->from("lap_kemajuan");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function sudahlaporan($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan<>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function sudahkirimrevisi($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_revisi <>", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function sudahrevisi($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir as l");
		$this->db->join("hasilreview_laporan as h", "h.usulan=l.id_usulan");
		$this->db->where("l.id_usulan", $id);
		$this->db->where("l.file_revisi <>", "");
		$this->db->where("h.skor <>", "");
		$this->db->where("h.reviewer", $this->session->userdata('sesi_id'));
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function laporansah($id)
	{
		$data = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
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
		$this->db->from("usulan");
		$this->db->where("usulan.reviewer REGEXP ", $rev['id_dosen']);
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
		$this->db->from("usulan");
		$this->db->where("usulan.reviewer IN (select reviewer from usulan where id_usulan=" . $usulan . ")");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

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
		// $this->db->from("usulan");
		// $this->db->where("pengusul",$this->session->userdata('sesi_id'));
		// $logrevi = $this->db->get();

		// $logrev = $logrevi->row_array();

		// $daftarnya = $logrev['reviewer'];

		$data = array();
		$this->db->select("*,usulan.reviewer as revnya");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->join("lap_akhir", "usulan.id_usulan=lap_akhir.id_usulan");
		$this->db->like("usulan.tglmulai", $tahun);
		$this->db->where("lap_akhir.file_laporan <> ", "");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

		return $data;
	}

	function jmldireview($tahun)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer as revnya");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->join("lap_akhir", "usulan.id_usulan=lap_akhir.id_usulan");
		$this->db->like("usulan.tglmulai", $tahun);
		$this->db->where("lap_akhir.file_laporan <> ", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function direviewoleh($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
		$this->db->join("dosen", "dosen.user=hasilreview.reviewer");
		$this->db->where("hasilreview.usulan", $usulan);
		$this->db->where("hasilreview.skor <> ", "");
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
		$this->db->from("hasilreview_laporan");
		$this->db->join("dosen", "dosen.user=hasilreview_laporan.reviewer");
		$this->db->where("hasilreview_laporan.usulan", $usulan);
		// $this->db->where("hasilreview_laporan.skor <> ","");
		$this->db->order_by('hasilreview_laporan.id_reviewlaporan', 'desc');
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}

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
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->join("lap_akhir", "usulan.id_usulan=lap_akhir.id_usulan");
		$this->db->where("usulan.reviewer REGEXP ", $rev['id_dosen']);
		$this->db->where("lap_akhir.file_laporan <> ", "");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitbaru()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("usulan.status", "Usulan Dikirim");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan.modified", date('Y'));
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitangg($id, $jenis = "Dosen")
	{
		$jns = "Dosen";
		if ($jenis == "mhs") {
			$jns = "Mahasiswa";
		}

		$data = array();
		$this->db->select("*");
		$this->db->from("peran");
		$this->db->where("id_usulan", $id);
		$this->db->where("skema", "Penelitian");
		$this->db->where("jenis_anggota", $jns);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function perananggota($id, $skema)
	{
		$data = array();
		$this->db->select("dosen.id_dosen, dosen.nidn, dosen.namalengkap,peran.tugas, peran.jenis_anggota, peran.idperan as id");
		$this->db->from("peran");
		$this->db->join("dosen", "dosen.id_dosen=peran.anggota");
		$this->db->where("peran.id_usulan", $id);
		$this->db->where("peran.skema", $skema);
		$this->db->where("peran.jenis_anggota", "Dosen");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function perananggotadosenluar($id, $skema)
	{
		$data = array();
		$this->db->select("peran.anggota,peran.tugas, peran.jenis_anggota, peran.idperan as id, dosenluar.namalengkap, dosenluar.nidn, dosenluar.namadepartmen, dosenluar.namainstitusi, m_negara.kode_negara, m_negara.nama_negara as negara, negara_institusi.nama_negara as negara_institusi");
		$this->db->from("peran");
		$this->db->join("dosenluar", "dosenluar.id_dosen=peran.anggota");
		$this->db->join("m_negara", "m_negara.id_negara=dosenluar.id_negara");
		$this->db->join("m_negara as negara_institusi", "negara_institusi.id_negara=dosenluar.id_negara_institusi");
		$this->db->where("peran.id_usulan", $id);
		$this->db->where("peran.skema", $skema);
		$this->db->where("peran.jenis_anggota", "Dosen Luar");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function peranmhs($id, $skema)
	{
		$data = array();
		$this->db->select("allmhs.npm, allmhs.namamhs,peran.tugas, peran.jenis_anggota, peran.idperan as id");
		$this->db->from("peran");
		$this->db->join("allmhs", "TRIM(allmhs.npm)=TRIM(peran.anggota)");
		$this->db->where("peran.id_usulan", $id);
		$this->db->where("peran.skema", $skema);
		$this->db->where("peran.jenis_anggota", "Mahasiswa");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function peranmhsid($id, $skema)
	{
		$data = array();
		$this->db->select("mahasiswa.npm, mahasiswa.namamhs,peran.tugas, peran.jenis_anggota, peran.idperan as id");
		$this->db->from("peran");
		$this->db->join("mahasiswa", "CAST(mahasiswa.idmhs AS CHAR)=peran.anggota");
		$this->db->where("peran.id_usulan", $id);
		$this->db->where("peran.skema", $skema);
		$this->db->where("peran.jenis_anggota", "Mahasiswa");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function laporan($pilih)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");
		// $this->db->join("lap_kemajuan","lap_kemajuan.id_usulan=ro.id_usulan");
		if ($this->session->userdata('sesi_status') == 3 || $this->session->userdata('sesi_status') == 2 || $this->session->userdata('sesi_status') == 4) {
			// $this->db->where("usulan.pengusul",$this->session->userdata('sesi_id'));
			$this->db->where("(ro.pengusul=" . $this->session->userdata('sesi_id') . " or FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)))");
		}
		//$this->db->like("status","Usulan Disetujui Reviewer");
		$this->db->like("ro.tglmulai", $pilih);
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function usulan()
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("ro.pengusul", $this->session->userdata('sesi_id'));
		}

		$this->db->where_not_in("ro.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->order_by("ro.tglmulai", "desc");
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
		$this->db->where("jenis", "Penelitian");
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
		$this->db->where("jenis", "Penelitian");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function nudeal($id, $usulan, $skema)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("anggotasetuju");
		$this->db->join("peran", "peran.id_usulan=anggotasetuju.id_usulan");
		$this->db->where("anggotasetuju.id_usulan", $usulan);
		$this->db->where("anggotasetuju.idanggota", $id);
		$this->db->where("jenis", $skema);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function nuhitanggota($id, $usulan, $skema)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("peran");
		$this->db->where("anggota", $id);
		$this->db->where("id_usulan", $usulan);
		$this->db->where("skema", $skema);
		$this->db->where("jenis_anggota", 'Dosen');
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function cekanggotasetuju($id, $usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("anggotasetuju");
		$this->db->where("idanggota", $id);
		// $this->db->where("FIND_IN_SET(idanggota,'".$list."')");
		$this->db->where("setuju", "Setuju");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("jenis", "Penelitian");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function cekresponanggota($usulan, $skema)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("anggotasetuju");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("jenis", $skema);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitanggotabaru($usulan, $skema)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("peran");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("skema", $skema);
		$this->db->where("jenis_anggota", 'Dosen');
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
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

	function addmhs()
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"namamhs"	=> $this->input->post("namamhs", true),
			"npm"		=> $this->input->post("npm", true),
			//	"hp"		=> $this->input->post("nomorhp",true),
			//	"email"		=> $this->input->post("emailmhs",true),
			"fakultas"	=> $this->input->post("fakultas", true),
			"prodi"		=> $this->input->post("prodi", true),
			"modified"	=> $waktu
		);
		$this->db->insert("mahasiswa", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . ' menambahkan mahasiswa bernama ' . $this->input->post("namamhs", true) . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function eksporusulan($tahun)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek,usulan.id_usulan id_usulan");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul", 'left');
		$this->db->join("lap_kemajuan", "lap_kemajuan.id_usulan=usulan.id_usulan", 'left');
		$this->db->join("lap_akhir", "lap_akhir.id_usulan=usulan.id_usulan", 'left');
		$this->db->like("usulan.tglmulai", $tahun);
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
			if ((count($data)) > 0) {
				foreach ($data as $key => $value) {
					$anggota = array();
					$this->db->select("peran.anggota, peran.jenis_anggota");
					$this->db->from("peran");
					$this->db->where("peran.id_usulan", $value->id_usulan);
					$hasilanggota = $this->db->get();

					if ($hasilanggota->num_rows() > 0) {
						$anggota = $hasilanggota->result();
						$data[$key]->anggota = $anggota;
					} else {
						$data[$key]->anggota = array();
					}
				}
			}
		}
		return $data;
	}

	function pilihusulan($tahun)
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");

		if ($this->session->userdata('sesi_status') <> 1) {
			// $this->db->where("ro.pengusul",$this->session->userdata('sesi_id'));
			$this->db->where("(ro.pengusul=" . $this->session->userdata('sesi_id') . " or FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)) or " . $this->session->userdata('sesi_dosen') . " IN(SELECT anggota from peran WHERE id_usulan=ro.id_usulan))");
		}

		$this->db->where_not_in("ro.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("ro.tglmulai", $tahun);
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitambilmax($id, $dosen)
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");
		$this->db->where("(ro.pengusul=" . $id . " or FIND_IN_SET('" . $dosen . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)))");

		$this->db->where_not_in("ro.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("YEAR(ro.tglmulai)", date('Y'));
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function statpilihusulan($tahun)
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");

		$this->db->where_not_in("ro.status", "Usulan Disetujui,Usulan Tidak Disetujui");
		$this->db->like("ro.tglmulai", $tahun);
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function progressusulan($pilih)
	{
		$data = array();
		$pilihan = array('Usulan Disetujui Prodi', 'Reviewed', 'Usulan Disetujui Reviewer 1', 'Usulan Disetujui Reviewer 2');
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where_in("usulan.status", $pilihan);
		$this->db->like("usulan.tglmulai", $pilih);
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function usulanplot()
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("usulan.pengusul", $this->session->userdata('sesi_id'));
		}

		$this->db->where("usulan.status", "Usulan Disetujui Prodi");
		$this->db->order_by("usulan.tglmulai", "desc");
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
		$this->db->from("hasilreview");
		$this->db->join("usulan", "hasilreview.usulan=usulan.id_usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->order_by("hasilreview.modified", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function usulanreview($id, $tahun)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("find_in_set($id,usulan.reviewer)>", 0);
		$this->db->where("YEAR(usulan.tglmulai)", $tahun);
		$this->db->where_in("usulan.status", array("Usulan Disetujui Prodi", "Reviewed", "Usulan Disetujui Reviewer 1", "Usulan Disetujui Reviewer 2"));
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function rekapreview($tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("v_usulan");
		$this->db->where("reviewer<>", 0);
		$this->db->where("YEAR(tglmulai)", $tahun);
		$this->db->where_in("status", array("Usulan Disetujui Prodi", "Reviewed", "Usulan Disetujui Reviewer 1", "Usulan Disetujui Reviewer 2"));
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function rekaphasilreview($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("v_hasilreview");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitusulanreview($id, $tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("find_in_set($id,usulan.reviewer)>", 0);
		$this->db->where("YEAR(usulan.tglmulai)", $tahun);
		$this->db->where_in("usulan.status", array("Usulan Disetujui Prodi", "Reviewed", "Usulan Disetujui Reviewer 1", "Usulan Disetujui Reviewer 2"));
		$this->db->order_by("tglmulai", "desc");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function usulanrevmaju($id, $tahun)
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("lap_kemajuan", "lap_kemajuan.id_usulan=usulan.id_usulan", "left");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("find_in_set($id,usulan.reviewer)>", 0);
		$this->db->where("YEAR(usulan.tglmulai)", $tahun);
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function cekreview($rev, $usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
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
		$this->db->from("hasilreview_laporan");
		$this->db->where("usulan", $usulan);
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
		$this->db->from("hasilreview");
		$this->db->where("usulan", $usulan);
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
		$this->db->from("hasilreview");
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
		$this->db->from("hasilreview_laporan");
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
		$this->db->from("hasilreview_laporan");
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
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("usulan.skema", $a);
		if ($b == 1)
			$this->db->where("usulan.status", "Usulan Baru");
		elseif ($b == 2)
			$this->db->where("usulan.status", "Usulan Dikirim");
		elseif ($b == 3)
			$this->db->where("usulan.status", "Usulan Disetujui Prodi");
		else
			$this->db->where("usulan.status", "Usulan Tidak Disetujui");

		if ($this->session->userdata('sesi_id') == 3) {
			$this->db->where("usulan.pengusul", $this->session->userdata('sesi_id'));
		}
		$this->db->order_by("usulan.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function usulanrev()
	{
		$data = array();
		$this->db->select("*,usulan.reviewer cek");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("usulan.status", "Usulan Disetujui Prodi");
		$this->db->like("usulan.tglmulai", date('Y'));
		// $this->db->where("usulan.reviewer","");
		if ($this->session->userdata('sesi_id') == 3) {
			$this->db->where("usulan.pengusul", $this->session->userdata('sesi_id'));
		}
		$this->db->order_by("usulan.tglmulai", "desc");
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
		$this->db->select("(select SUM(volume*hargasatuan) from rab where jenis='Bahan' AND usulan='" . $id . "') as bahan,(select SUM(volume*hargasatuan) from rab where jenis='Pengumpulan Data' AND usulan='" . $id . "') as kumpul,(select SUM(volume*hargasatuan) from rab where jenis='Sewa Peralatan' AND usulan='" . $id . "') as sewa,(select SUM(volume*hargasatuan) from rab where jenis='Analisis Data' AND usulan='" . $id . "') as analis, (select SUM(volume*hargasatuan) from rab where jenis='Pelaporan dan Luaran' AND usulan='" . $id . "') as lapor");
		$this->db->from("rab");
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
		$this->db->from("rab");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function bahan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("rab");
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
		$this->db->from("rab");
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
		$this->db->from("rab");
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
		$this->db->from("rab");
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
		$this->db->from("rab");
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
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Plot Reviewer Penelitian telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function setuju($id)
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"status"		=> 'Usulan Disetujui Prodi',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Penelitian telah disetujui pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function prodisetuju()
	{
		$waktu = date('Y-m-d H:i:s');
		$status = '';
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
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Penelitian telah diverifikasi Prodi pada " . tgl_indo($waktu, 1)
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
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Penelitian telah ditolak pada " . tgl_indo($waktu, 1)
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

		$this->db->insert("rab", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Usulan RAB Penelitian telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrelevansi($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('relevansi');
		$this->db->where('usulan', $id);
		$cek = $this->db->get();


		$data = array(
			"matakuliah"		=> $this->input->post("matakuliah", true),
			"bentuk_integrasi"	=> $this->input->post("integrasi", true),
			"usulan"			=> $id
		);

		if ($cek->num_rows() > 0) {
			$this->db->where("usulan", $id);
			$this->db->update("relevansi", $data);
		} else {
			$this->db->insert("relevansi", $data);
		}

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Relevansi Penelitian telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function liatrelevansi()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("relevansi");
		$this->db->where("usulan", $this->uri->segment(3));
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
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

	function hitrev($usulan, $reviewer)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview");
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
		$this->db->from("hasilreview_laporan");
		$this->db->where("usulan", $usulan);
		$this->db->where("reviewer", $reviewer);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function revsetuju($usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("status", 'Laporan Disetujui Reviewer 2');
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
		$this->db->from("usulan");
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
		$this->db->from("usulan");
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
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Disetujui Prodi");
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
		$this->db->from("usulan");
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
		$this->db->from("usulan");
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
		$this->db->from("usulan");
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
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Disetujui Prodi");
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
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Pengembangan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitterapanusulanbaru()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Baru");
		$this->db->where("skema", "Terapan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitterapanusulandikirim()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Dikirim");
		$this->db->where("skema", "Terapan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitterapanusulandisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Disetujui Prodi");
		$this->db->where("skema", "Terapan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitterapanusulantidakdisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Terapan");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitdasarusulanbaru()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Baru");
		$this->db->where("skema", "Dasar");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitdasarusulandikirim()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Dikirim");
		$this->db->where("skema", "Dasar");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitdasarusulandisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Disetujui Prodi");
		$this->db->where("skema", "Dasar");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitdasarusulantidakdisetujui()
	{
		$thn = date('Y');
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("status", "Usulan Tidak Disetujui");
		$this->db->where("skema", "Dasar");
		$this->db->like("modified", $thn);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function simpan($fileusulan)
	{
		$waktu = date('Y-m-d H:i:s');
		$luaran = $this->input->post("luaran", true);
		$dana = str_replace(".", "", $this->input->post('danaint'));
		$danaeks = str_replace(".", "", $this->input->post('danaeks'));
		$danamandiri = str_replace(".", "", $this->input->post('danaman'));

		$dana > 0 ? ($sumberi = 'Internal') : ($sumberi = '');
		$danamandiri > 0 ? ($sumberm = 'Mandiri') : ($sumberm = '');
		$danaeks > 0 ? ($sumbere = 'Eksternal') : ($sumbere = '');

		$sumberdana = $sumberi . ' ' . $sumberm . ' ' . $sumbere;

		$store = '';
		$hit = count($luaran);
		for ($i = 0; $i < $hit; $i++) {
			$store .= $luaran[$i];
			if ($i < ($hit - 1))
				$store .= ',';
		}

		$data = array(
			"judul"				=> $this->input->post("judul", true),
			"kategoritkt"		=> $this->input->post("kategoritkt", true),
			"capaiantkt"		=> $this->input->post("capaiantkt", true),
			"skema"				=> $this->input->post("skema", true),
			"luaran"			=> $store,
			"namajurnal"		=> $this->input->post("namajurnal", true),
			"nomorkerjasama"	=> $this->input->post("kerjasama", true),
			"sumberdana"		=> $sumberdana,
			"jmldana"			=> $dana,
			"danaeks"			=> $danaeks,
			"danamandiri"		=> $danamandiri,
			// "anggotadosen"		=> $this->input->post("iddosen",true),
			"jumlahmhs"		    => count($this->input->post('m_id')),
			// "anggotamhs"		=> $this->input->post("idmhs",true),
			"ringkasan"			=> $this->input->post("ringkasan", true),
			"katakunci"			=> $this->input->post("katakunci", true),
			"tglmulai"			=> $this->input->post("tglmulai", true),
			"tglakhir"			=> $this->input->post("tglakhir", true),
			"fileusulan"		=> $fileusulan,
			"status"			=> 'Usulan Baru',
			"pengusul"			=> $this->session->userdata('sesi_id'),
			"modified"			=> $waktu
		);

		$this->db->insert("usulan", $data);

		$id = $this->db->insert_id();

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Usulan Penelitian dengan judul " . $this->input->post("judul", true) . " telah ditambahkan pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
		return $id;
	}

	// function addmhs($data)
	// {
	// 	$this->db->insert("mahasiswa",$data);
	// }

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

	function mahasiswa()
	{
		$data = array();
		//$hasil = $this->db->query("SELECT mahasiswa.*, fakultas.fakultas namafak, prodi.prodi namaprodi FROM mahasiswa JOIN fakultas on fakultas.id_fak=mahasiswa.fakultas JOIN prodi on prodi.id_prodi=mahasiswa.prodi where concat('',mahasiswa.namamhs * 1) <> mahasiswa.namamhs GROUP BY mahasiswa.namamhs,mahasiswa.npm ORDER by fakultas.fakultas,prodi.prodi,mahasiswa.namamhs asc; ");
		$hasil = $this->db->query("SELECT mahasiswa.*, fakultas.fakultas namafak, prodi.prodi namaprodi FROM mahasiswa 
			JOIN fakultas on fakultas.id_fak=mahasiswa.fakultas JOIN prodi on prodi.id_prodi=mahasiswa.prodi 
			GROUP BY mahasiswa.namamhs,mahasiswa.npm ORDER by fakultas.fakultas,prodi.prodi,mahasiswa.namamhs asc; ");

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function allmhs()
	{
		$data = array();
		$hasil = $this->db->query("SELECT `idmhs`,`npm`,`namamhs`,`fakultas`,`prodi`,`status`,`thmasuk`,`hp`,`email`,`modified`,`namafak`,`namaprodi` FROM `v_allmhs`");

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function updateusulan($fileusulan)
	{
		$waktu = date('Y-m-d H:i:s');
		$luaran = $this->input->post("luaran", true);
		$dana = str_replace(".", "", $this->input->post('jmldana'));
		$danaeks = str_replace(".", "", $this->input->post('danaeks'));
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
				"kategoritkt"		=> $this->input->post("kategoritkt", true),
				"capaiantkt"		=> $this->input->post("capaiantkt", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"danaeks"			=> $danaeks,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"fileusulan"		=> $fileusulan,
				"status"			=> $status,
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		} elseif ($this->session->userdata('sesi_status') == 1 && $status <> '') {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"kategoritkt"		=> $this->input->post("kategoritkt", true),
				"capaiantkt"		=> $this->input->post("capaiantkt", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"danaeks"			=> $danaeks,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"status"			=> $status,
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		} elseif ($fileusulan <> '') {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"kategoritkt"		=> $this->input->post("kategoritkt", true),
				"capaiantkt"		=> $this->input->post("capaiantkt", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"danaeks"			=> $danaeks,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				"fileusulan"		=> $fileusulan,
				//"status"			=> $this->input->post("statususulan",true),
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		} else {
			$data = array(
				"judul"				=> $this->input->post("judul", true),
				"kategoritkt"		=> $this->input->post("kategoritkt", true),
				"capaiantkt"		=> $this->input->post("capaiantkt", true),
				"skema"				=> $this->input->post("skema", true),
				"luaran"			=> $store,
				"namajurnal"		=> $this->input->post("namajurnal", true),
				"sumberdana"		=> $this->input->post("sumberdana", true),
				"jmldana"			=> $dana,
				"danaeks"			=> $danaeks,
				"anggotadosen"		=> $this->input->post("iddosen", true),
				"anggotamhs"		=> $this->input->post("idmhs", true),
				"jumlahmhs"		    => $this->input->post("jumlahmhs", true),
				"ringkasan"			=> $this->input->post("ringkasan", true),
				"katakunci"			=> $this->input->post("katakunci", true),
				"tglmulai"			=> $this->input->post("tglmulai", true),
				"tglakhir"			=> $this->input->post("tglakhir", true),
				// "status"			=> 'Usulan Baru',
				//"pengusul"			=> $this->session->userdata('sesi_id'),
				"modified"			=> $waktu
			);
		}

		$this->db->where("id_usulan", $this->input->post("id", true));
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Usulan Penelitian dengan judul " . $this->input->post("judul", true) . " telah diupdate pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function tglterbit($tahun)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("terbitsurat");
		$this->db->where("jenis", "penelitian");
		$this->db->where("tahun", $tahun);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function mintarevisilaporan($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"usulan"				=> $id,
			"hasilreview_laporan"	=> $this->input->post("review", true),
			"filereview_laporan"	=> $filereview,
			"reviewer"				=> $this->session->userdata("sesi_id"),
			"modified"				=> $waktu
		);

		$this->db->insert("hasilreview_laporan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Laporan Akhir Penelitian telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanreview($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true) . ',' . $this->input->post("poinlima", true) . ',' . $this->input->post("poinenam", true) . ',' . $this->input->post("pointujuh", true) . ',' . $this->input->post("poinlapan", true) . ',' . $this->input->post("poinsembilan", true) . ',' . $this->input->post("poinsepuluh", true);
		$data = array(
			"usulan"			=> $id,
			"hasilreview"		=> $this->input->post("review", true),
			"skor"				=> $skor,
			"filereview"		=> $filereview,
			"rekomendasi"		=> $this->input->post("rekomendasi", true),
			"catatan"			=> $this->input->post("catatan", true),
			"reviewer"			=> $this->session->userdata("sesi_id"),
			"modified"			=> $waktu
		);

		$this->db->insert("hasilreview", $data);

		//update data usulan
		$data = array(
			"status"		=> 'Reviewed',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Penelitian telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	// function simpanreviewlaporan($id,$filereview)
	function simpanreviewlaporan($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true) . ',' . $this->input->post("poinlima", true) . ',' . $this->input->post("poinenam", true) . ',' . $this->input->post("pointujuh", true) . ',' . $this->input->post("poinlapan", true) . ',' . $this->input->post("poisembilan", true) . ',' . $this->input->post("poinsepuluh", true);
		$data = array(
			//"usulan"				=> $id,
			"hasilreview_laporan"	=> $this->input->post("review", true),
			"skor"					=> $skor,
			//"filereview_laporan"	=> $filereview,
			// "reviewer"				=> $this->session->userdata("sesi_id"),
			"modified"				=> $waktu
		);

		// $this->db->insert("hasilreview_laporan",$data);
		$this->db->where("usulan", $id);
		$this->db->where("reviewer", $this->session->userdata("sesi_id"));
		$this->db->update("hasilreview_laporan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Laporan Akhir Penelitian telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function updatereview($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true) . ',' . $this->input->post("poinlima", true) . ',' . $this->input->post("poinenam", true) . ',' . $this->input->post("pointujuh", true) . ',' . $this->input->post("poinlapan", true) . ',' . $this->input->post("poinsembilan", true) . ',' . $this->input->post("poinsepuluh", true);
		
		//echo '<pre>';
		//print_r($_POST);
		//echo '</pre>';

		if ($filereview <> '') {
			$data = array(
				//"usulan"			=> $id,
				"hasilreview"		=> $this->input->post("review", true),
				"skor"				=> $skor,
				"rekomendasi"			=> $this->input->post("rekomendasi", true),
				"catatan"			=> $this->input->post("catatan", true),
				"filereview"		=> $filereview,
				//"reviewer"			=> $this->session->userdata("sesi_id"),
				"modified"			=> $waktu
			);
		} else {
			$data = array(
				//"usulan"			=> $id,
				"hasilreview"		=> $this->input->post("review", true),
				"skor"				=> $skor,
				"rekomendasi"			=> $this->input->post("rekomendasi", true),
				"catatan"			=> $this->input->post("catatan", true),
				//"reviewer"			=> $this->session->userdata("sesi_id"),
				"modified"			=> $waktu
			);
		}
		$this->db->where("id_review", $this->input->post("idreview", true));
		$this->db->update("hasilreview", $data);

		//update data usulan
		$data = array(
			"status"		=> 'Reviewed',
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Penelitian telah diupdate oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function updatereviewlaporan($id, $filereview)
	{
		$waktu = date('Y-m-d H:i:s');
		$skor = $this->input->post("poinsatu", true) . ',' . $this->input->post("poindua", true) . ',' . $this->input->post("pointiga", true) . ',' . $this->input->post("poinempat", true) . ',' . $this->input->post("poinlima", true) . ',' . $this->input->post("poinenam", true) . ',' . $this->input->post("pointujuh", true) . ',' . $this->input->post("poinlapan", true) . ',' . $this->input->post("poisembilan", true) . ',' . $this->input->post("poinsepuluh", true);

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
		$this->db->update("hasilreview_laporan", $data);

		// echo $this->db->last_query();exit;

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Hasil Review Laporan Akhir Penelitian telah diupdate oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpankemajuan($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_kemajuan");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0) {
			$data = array(
				"lap_kemajuan"	=> $file,
				"date"			=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_kemajuan", $data);
		} else {
			$data = array(
				"id_usulan"		=> $this->input->post("id", true),
				"lap_kemajuan"	=> $file,
				"date"			=> $waktu
			);
			$this->db->insert("lap_kemajuan", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Laporan Kemajuan Penelitian telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanlaporan($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $this->input->post("idus", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0 && $file <> '') {
			$data = array(
				"file_laporan"		=> $file,
				"modified"			=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("idus", true));
			$this->db->update("lap_akhir", $data);
		} elseif ($hitdata > 0 && $file == '') {
		} else {
			$data = array(
				"id_usulan"		=> $this->input->post("idus", true),
				"file_laporan"	=> $file,
				"modified"		=> $waktu
			);
			$this->db->insert("lap_akhir", $data);

			$valid = array(
				"valdanainternal"	=> $this->input->post("danaint", true),
				"valdanamandiri"	=> $this->input->post("danaman", true),
				"valdanaeksternal"	=> $this->input->post("danaeks", true),
				"nomorkerjasama"	=> $this->input->post("kerjasama", true),
			);
			$this->db->where("id_usulan", $this->input->post("idus", true));
			$this->db->update("usulan", $valid);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Laporan Akhir Penelitian telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrealisasidana()
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $this->input->post("idus", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();
		$dana1 = str_replace(",", "", $this->input->post("danaint", true));
		$dana2 = str_replace(",", "", $this->input->post("danaman", true));
		$dana3 = str_replace(",", "", $this->input->post("danaeks", true));

		if ($hitdata > 0) {
			$valid = array(
				"valdanainternal"	=> $dana1,
				"valdanamandiri"	=> $dana2,
				"valdanaeksternal"	=> $dana3,
				"nomorkerjasama"	=> $this->input->post("kerjasama", true),
			);
			$this->db->where("id_usulan", $this->input->post("idus", true));
			$this->db->update("usulan", $valid);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Realisasi Dana Penelitian telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanlaporanakhir($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0 && $file <> '') {
			$data = array(
				"file_laporan_akhir"	=> $file,
				"modified"				=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_akhir", $data);
		} elseif ($hitdata > 0 && $file == '') {
		} else {
			$data = array(
				"id_usulan"				=> $this->input->post("id", true),
				"file_laporan_akhir"	=> $file,
				"modified"				=> $waktu
			);
			$this->db->insert("lap_akhir", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Laporan Akhir Penelitian dengan Pengesahan telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrevisilaporan($file)
	{
		$waktu = date('Y-m-d H:i:s');

		$hitdata = 0;
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $this->input->post("id", true));
		$hasil = $this->db->get();

		$hitdata = $hasil->num_rows();

		if ($hitdata > 0 && $file <> '') {
			$data = array(
				"file_revisi"	=> $file,
				"modified"		=> $waktu
			);
			$this->db->where("id_usulan", $this->input->post("id", true));
			$this->db->update("lap_akhir", $data);

			//masukan logs sistem
			$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => "Laporan Akhir Penelitian telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
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
		$this->db->where("sbgluaran", "Luaran Penelitian");
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
			$this->db->where("sbgluaran", "Luaran Penelitian");
			$this->db->update("jurnal", $data);
		} else {
			$data = array(
				"usulan"			=> $this->input->post("id", true),
				"judul"				=> $this->input->post("judul", true),
				"sbgluaran"			=> 'Luaran Penelitian',
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
			$this->db->insert("jurnal", $data);
		}


		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Luaran Penelitian - Jurnal telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
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
			$this->db->update("hki", $data);
		} else {
			$data = array(
				"usulan"				=> $this->input->post("id", true),
				"judul"					=> $this->input->post("judul", true),
				"sbgluaran"				=> 'Luaran Penelitian',
				"jenis_hki"				=> $this->input->post("jenishki", true),
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
			"keterangan" => "Luaran Penelitian - HKI telah disubmit oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanperbaikan($id, $filerevisi)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"filerevisi"		=> $filerevisi,
			"modified"			=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Perbaikan Usulan Penelitian telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanlegalisir($id, $legalisir)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"legalisir"		=> $legalisir,
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "File Usulan Penelitian dengan Pengesahan telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpanrevisikaprodi($id, $revisi)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"filerevisi_kaprodi" => $revisi,
			"modified"			 => $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "File Revisi Usulan Penelitian telah ditambahkan oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function revisetuju_usulan($id, $step)
	{
		$data = array();
		$this->db->select("dosen.namalengkap");
		$this->db->from("setuju_usulan");
		$this->db->join("dosen", "dosen.user=setuju_usulan.reviewer");
		$this->db->where("setuju_usulan.usulan", $id);
		$this->db->where("setuju_usulan.step", $step);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function namamhs($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("mahasiswa");
		$this->db->where("idmhs", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function allnamamhs($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("allmhs");
		$this->db->where("idmhs", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function allnamamhsfromnpm($npm)
	{
		$data = array();
		$this->db->select("allmhs.namamhs, prodi.prodi");
		$this->db->from("allmhs");
		$this->db->join("prodi", "prodi.id_prodi=allmhs.prodi", "left");
		$this->db->where("npm", $npm);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function simpansetuju($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"status"		=> $this->input->post("setuju", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//Simpan Reviewer yang setuju
		$setuju = array(
			"usulan"		=> $id,
			"reviewer"		=> $this->session->userdata("sesi_id"),
			"step"			=> $this->input->post("setuju", true),
			"modified"		=> $waktu
		);
		$this->db->insert("setuju_usulan", $setuju);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $id . '-' . $this->input->post("setuju", true) . ' oleh ' . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
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
		$this->db->update("lap_akhir", $data);

		//Simpan Reviewer yang setuju
		$setuju = array(
			"usulan"		=> $id,
			"reviewer"		=> $this->session->userdata("sesi_id"),
			"step"			=> $this->input->post("setuju", true),
			"modified"		=> $waktu
		);
		$this->db->insert("setuju_usulan", $setuju);

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
		$this->db->update("usulan", $data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Usulan Penelitian telah dikirim oleh " . $this->session->userdata("sesi_nama") . " pada " . tgl_indo($waktu, 1)
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

	function cekdana($id)
	{
		$data = array();
		$this->db->select("jmldana,danaeks,danamandiri");
		$this->db->from("usulan");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
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

	function realjurnal($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("jurnal");
		$this->db->where("usulan", $id);
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
		$this->db->from("usulan");
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
		$this->db->from("usulan");
		$this->db->where("id_usulan", $usulan);
		$this->db->where("usulan.reviewer REGEXP ", $rev['id_dosen']);
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
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function hitlapreview($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("hasilreview_laporan");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function hitlapakhir($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $id);
		$this->db->where("file_laporan_akhir <> ", "");
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function detailusulan($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
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
		$this->db->from("lap_kemajuan");
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
		$this->db->from("lap_akhir");
		$this->db->where("id_usulan", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function hasilreviewnya($id)
	{
		$data = array();
		$this->db->select("users.namalengkap,hasilreview_laporan.*");
		$this->db->from("hasilreview_laporan");
		$this->db->join("users", "users.id_user=hasilreview_laporan.reviewer");
		$this->db->where("usulan", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hithasilreview($id)
	{
		$this->db->select("*");
		$this->db->from("hasilreview_laporan as h");
		$this->db->join("lap_akhir as l", "h.usulan=l.id_usulan");
		$this->db->where("h.usulan", $id);
		$this->db->where("h.skor", "");
		$this->db->or_where("l.file_laporan_akhir<>", "");
		//$this->db->like("l.status","Laporan Disetujui Reviewer 2");
		$hasil = $this->db->get();

		return $hasil->num_rows();
	}

	function siapuploadsah($id)
	{
		$this->db->select("*");
		$this->db->from("hasilreview_laporan as h");
		$this->db->join("lap_akhir as l", "h.usulan=l.id_usulan");
		$this->db->where("h.usulan", $id);
		$this->db->where("h.skor<>", "");
		$this->db->where("l.file_revisi<>", "");
		$hasil = $this->db->get();

		return $hasil->num_rows();
	}

	function siapsetuju($id)
	{
		$this->db->select("*");
		$this->db->from("hasilreview_laporan as h");
		$this->db->join("lap_akhir as l", "h.usulan=l.id_usulan");
		$this->db->where("h.usulan", $id);
		$this->db->where("h.skor<>", "");
		$this->db->where("l.file_revisi<>", "");
		$hasil = $this->db->get();

		return $hasil->num_rows();
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
		$this->db->delete("usulan");

		$this->db->where("usulan", $id);
		$this->db->delete("rab");

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
		$this->db->delete("rab");

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

	function search_mahasiswa($q, $page, $npm_selected = '')
	{
		$this->db->select("npm as id, namamhs as text, `idmhs`,`npm`,`namamhs`,`fakultas`,`prodi`,`status`,`thmasuk`,`hp`,`email`,`modified`,`namafak`,`namaprodi`");
		$this->db->from("v_allmhs");

		if ($npm_selected != '') {
			$this->db->where("npm", $npm_selected);
		} else {
			$this->db->like("LOWER(namamhs)", strtolower($q));
			$this->db->or_like("LOWER(npm)", strtolower($q));
			$this->db->where("status", "Aktif");
		}


		$this->db->limit(10, ($page - 1) * 10);
		return $this->db->get()->result();
	}

	function cekSesiDosenIsAnggota($id_usulan)
	{
		$sesi_dosen = $this->session->userdata('sesi_dosen');
		$anggota_dosen = $this->db->select('anggota')->get_where('peran', ['id_usulan' => $id_usulan, 'jenis_anggota' => 'Dosen', 'anggota' => $sesi_dosen])->result_array();

		return (count($anggota_dosen)) > 0;
	}
}
