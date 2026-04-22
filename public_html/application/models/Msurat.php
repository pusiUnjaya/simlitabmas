<?php
class Msurat extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function selectusulan($tahun)
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("(ro.pengusul=" . $this->session->userdata('sesi_id') . " or FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan WHERE id_usulan=ro.id_usulan)))");
		}

		$this->db->where("ro.reviewer <> ", "");
		$this->db->like("ro.tglmulai", $tahun);
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function penelitian($periode, $prodi)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->join("dosen", "dosen.user=usulan.pengusul");
		$this->db->where("YEAR(usulan.tglmulai)", $periode);
		$this->db->order_by("usulan.tglmulai", "desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function pengabdian($periode, $prodi)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("YEAR(usulan_pkm.tglmulai)", $periode);
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		//$this->db->where("status","finish");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function selectdasar()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dasar");
		$this->db->order_by("iddasar", "desc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function selectterbit()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("terbitsurat");
		$this->db->order_by("tahun", "desc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function simpanterbit()
	{
		$waktu = date('Y-m-d H:i:s');
		$action = $this->input->post("action", true);

		$data = array(
			"tahun"	=> $this->input->post("tahun", true),
			"jenis"	=> $this->input->post("jenis", true),
			"semester"	=> $this->input->post("semester", true),
			"surat_tugas"	=> $this->input->post("surat_tugas", true),
			"surat_kontrak"	=> $this->input->post("surat_kontrak", true),
			"akhirkontrak"	=> $this->input->post("akhirkontrak", true),
			"skepkontrak"	=> $this->input->post("skepkontrak", true)
		);

		if ($action == 'add') {
			$proses = $this->db->insert("terbitsurat", $data);
			$keterangan = ' telah menambah Terbit Surat';
		} else {
			$this->db->where("idsurat", $this->input->post("idsurat", true));
			$proses = $this->db->update("terbitsurat", $data);
			$keterangan = ' telah mengubah Terbit Surat ID: ' . $this->input->post("idsurat", true);
		}

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		if ($proses) {
			$data = array(
				"tgl" => date('Y-m-d'),
				"keterangan" => $this->session->userdata('sesi_nama') . $keterangan . tgl_indo($waktu, 1)
			);
			$this->db->insert("logs", $data);
			return true;
		} else
			return false;
	}

	function dasartugaspkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dasar");
		$this->db->where("jenis", "Surat Tugas Pengabdian");
		$this->db->where("status", 1);
		$this->db->order_by("urutan", "asc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function dasarkontrakpkm()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dasar");
		$this->db->where("jenis", "Surat Kontrak Pengabdian");
		$this->db->where("status", 1);
		$this->db->order_by("urutan", "asc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function dasartugasriset()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dasar");
		$this->db->where("jenis", "Surat Tugas Penelitian");
		$this->db->where("status", 1);
		$this->db->order_by("urutan", "asc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function dasarkontrakriset()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dasar");
		$this->db->where("jenis", "Surat Kontrak Penelitian");
		$this->db->where("status", 1);
		$this->db->order_by("urutan", "asc");

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function detaildasar($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dasar");
		$this->db->where("iddasar", $id);

		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function selectusulanpkm($tahun)
	{
		$data = array();
		$this->db->select("*,ro.reviewer cek");
		$this->db->from("usulan_pkm as ro");
		$this->db->join("dosen", "dosen.user=ro.pengusul");

		if ($this->session->userdata('sesi_status') <> 1) {
			$this->db->where("(ro.pengusul=" . $this->session->userdata('sesi_id') . " or FIND_IN_SET('" . $this->session->userdata('sesi_dosen') . "',(SELECT anggotadosen from usulan_pkm WHERE id_usulan=ro.id_usulan)))");
		}

		$this->db->where("ro.reviewer <> ", "");
		$this->db->like("ro.tglmulai", $tahun);
		$this->db->order_by("ro.tglmulai", "desc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function simpan()
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"nomortugas"	=> $this->input->post("tugas", true),
			"nomorkontrak"	=> $this->input->post("kontrak", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $this->input->post("usulan", true));
		$this->db->update("usulan", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah mengisikan Nomor Surat Dokumen Proposal Penelitian " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function setujuipenelitian($id_usulan)
	{
		$waktu = date('Y-m-d H:i:s');
		$setuju = 'Setuju ' . $waktu;

		$data = array(
			"suratkontrak"	=> $setuju,
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id_usulan);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menyetujui Surat Kontrak Penelitian " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function setujuipkm($id_usulan)
	{
		$waktu = date('Y-m-d H:i:s');
		$setuju = 'Setuju ' . $waktu;

		$data = array(
			"suratkontrak"	=> $setuju,
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id_usulan);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menyetujui Surat Kontrak PKM " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}


	function simpanpkm()
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"nomortugas"	=> $this->input->post("tugas", true),
			"nomorkontrak"	=> $this->input->post("kontrak", true),
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $this->input->post("usulan", true));
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah mengisikan Nomor Surat Dokumen Proposal Pengabdian " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpankontrakpkm($id, $file)
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"suratkontrak"	=> $file,
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan_pkm", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah upload Surat Kontrak Pengabdian " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpankontrakpenelitian($id, $file)
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"suratkontrak"	=> $file,
			"modified"		=> $waktu
		);

		$this->db->where("id_usulan", $id);
		$this->db->update("usulan", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah upload Surat Kontrak Penelitian " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function simpandasar()
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"teks"			=> $this->input->post("teks", true),
			"jenis"			=> $this->input->post("jenis", true),
			"tahun"			=> $this->input->post("tahun", true),
			"urutan"		=> $this->input->post("urutan", true),
			"modified"		=> $waktu
		);

		$this->db->insert("dasar", $data);

		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menambah Dasar Hukum Surat " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function updatedasar()
	{
		$waktu = date('Y-m-d H:i:s');

		$data = array(
			"teks"			=> $this->input->post("teks", true),
			"jenis"			=> $this->input->post("jenis", true),
			"tahun"			=> $this->input->post("tahun", true),
			"urutan"		=> $this->input->post("urutan", true),
			"modified"		=> $waktu
		);

		$this->db->where("iddasar", $this->input->post("id", true));
		$this->db->update("dasar", $data);

		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menambah Dasar Hukum Surat " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function pakaidasar($id)
	{
		$data = array(
			"status"	=> 1
		);

		$this->db->where("iddasar", $id);
		$this->db->update("dasar", $data);
	}

	function tidakdasar($id)
	{
		$data = array(
			"status"	=> 0
		);

		$this->db->where("iddasar", $id);
		$this->db->update("dasar", $data);
	}

	function hapusdasar()
	{
		$waktu = date('Y-m-d H:i:s');

		$this->db->where("iddasar", $id);
		$this->db->delete("dasar");

		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menghapus Dasar Hukum Surat " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}
}
