<?php
class Mdosen extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function select()
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

	function selectekspor()
	{
		$data = array();
		$this->db->select("*,d.fakultas,d.prodi");
		$this->db->from("dosen d");
		$this->db->join("users", "users.id_user=d.user");
		$this->db->where("users.verified", "1");
		$this->db->order_by("d.fakultas,d.prodi,d.namalengkap", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function selectkeprodi()
	{
		$data = array();
		$this->db->select("*,dosen.namalengkap namadosen");
		$this->db->from("dosen");
		$this->db->join("users", "users.id_user=dosen.user");
		$this->db->where("users.jenis", "2");
		$this->db->order_by("dosen.namalengkap", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function anggotadosen()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		// $this->db->where("jenis <>","1");
		$this->db->order_by("namalengkap", "asc");
		// $this->db->limit(10);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function pilihanreviewer()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("reviewer", "1");
		$this->db->order_by("namalengkap", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function namadosenprodi($id)
	{
		$data = array();
		$this->db->select("namalengkap,prodi,nidn");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function datadosen($id)
	{
		$data = array();
		$this->db->select("d.namalengkap,d.prodi,d.nidn,u.email,max(s.kolom1) skorsinta");
		$this->db->from("dosen d");
		$this->db->join("skor s", "s.user=d.user", "left");
		$this->db->join("users u", "u.id_user=s.user");
		$this->db->where("d.nidn", $id);
		$this->db->group_by("d.nidn,d.namalengkap,d.prodi,u.email");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
	}

	function datamhs($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("mahasiswa");
		$this->db->where("npm", $id);
		$this->db->group_by("namamhs,npm");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function namadosennya($id)
	{
		$data = array();
		$this->db->select("namalengkap,prodi,nidn");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		return $data;
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

	function selectprodi()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prodi");
		$this->db->order_by("prodi,fakultas", "asc");
		$hasil = $this->db->get();

		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		return $data;
	}

	function hitdosen()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function hitakunbaru()
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("users");
		$this->db->where("verified", "0");
		$this->db->where("prodi", $this->session->userdata('sesi_prodi'));
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function simpan()
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
			"user"				=> $this->session->userdata('sesi_id'),
			"modified"			=> $waktu
		);

		$this->db->insert("dosen", $data);

		//update data user
		// $data = array(
		// 		"namalengkap"	=> $this->input->post("namalengkap",true),
		// 		"modified"		=> $waktu
		// 		);

		// $this->db->where("id_user",$this->session->userdata('sesi_id'));
		// $this->db->update("users",$data);

		//masukan logs sistem
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => "Data Dosen dengan nama " . $this->input->post("namalengkap", true) . " telah ditambahkan pada " . tgl_indo($waktu, 1)
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

			/* echo '<pre>';
			print_r($data);
			echo '</pre>'; */
		
		$this->db->where("id_dosen",$this->input->post("id_dosen",true));
		$this->db->update("dosen",$data);	

		//update sesi
		$this->session->set_userdata('sesi_jafung', $this->input->post("jabatanakademik", true));
		$this->session->set_userdata('sesi_jenjang', $this->input->post("jenjangpendidikan", true));

		//update data user
		$data = array(
				"namalengkap"	=> $this->input->post("namalengkap",true),
				"fakultas"		=> $this->input->post("fakultas",true),
				"prodi"			=> $this->input->post("prodi",true),
				"modified"		=> $waktu
				);
		
		if($this->session->userdata('sesi_status')==1)
			$this->db->where("id_user",$this->input->post("id_user",true));
		else
		{
			$this->db->where("id_user",$this->session->userdata('sesi_id'));
			$this->session->set_userdata('sesi_nama', $this->input->post("namalengkap",true));
		}
		$this->db->update("users", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah mengubah data Dosen " . $this->input->post("namalengkap", true) . " " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
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

	function isreviewer($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$this->db->where("reviewer", '1');
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function ambildosen($id)
	{
		$data = array();
		$this->db->select("id_dosen");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function lihatreviewer($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$this->db->where("reviewer", '1');
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function reviewernya($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		$this->db->where("reviewer", $id);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function liatreviewernya($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		// $this->db->where("usulan.reviewer REGEXP ",$id);
		// $this->db->where_in("usulan.reviewer",$id);
		$this->db->where("FIND_IN_SET(" . $id . ",usulan.reviewer)>", 0);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function cekrevnya($id, $usulan)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("usulan");
		// $this->db->where("usulan.reviewer REGEXP ",$id);
		// $this->db->where_in("usulan.reviewer",$id);
		$this->db->where("FIND_IN_SET(" . $id . ",usulan.reviewer)>", 0);
		$this->db->where('id_usulan', $usulan);
		$hasil = $this->db->get();
		$data = $hasil->num_rows();

		return $data;
	}

	function skorsinta($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("skor");
		$this->db->where("user", $id);
		$this->db->order_by("modified", "desc");
		$this->db->limit(1);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function idsinta($id)
	{
		$data = array();
		$this->db->select("id_sinta");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function hitskorsinta($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("skor");
		$this->db->where("user", $id);
		$this->db->order_by("modified", "desc");
		$this->db->limit(1);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function cekdosen($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasil = $this->db->get();

		$data = $hasil->num_rows();

		return $data;
	}

	function selectreviewer()
	{
		$data = array();
		$this->db->select("dosen.*");
		$this->db->from("dosen");
		$this->db->join("users", "users.id_user=dosen.user");
		$this->db->where("users.jenis", "3");
		$this->db->or_where("users.jenis", "2");
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->result();
		}
		$hasil->free_result();
		return $data;
	}

	function setreviewer($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"reviewer"		=> 1,
			"modified"		=> $waktu
		);

		$this->db->where("id_dosen", $id);
		$this->db->update("dosen", $data);

		//ambil data dosen
		$dos = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$datados = $this->db->get();
		if ($datados->num_rows() > 0) {
			$dos = $datados->row_array();
		}

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah mengubah data Dosen " . $dos['namalengkap'] . " menjadi Reviewer pada tanggal " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function unsetreviewer($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"reviewer"		=> 0,
			"modified"		=> $waktu
		);

		$this->db->where("id_dosen", $id);
		$this->db->update("dosen", $data);

		//ambil data dosen
		$dos = array();
		$this->db->select("*");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$datados = $this->db->get();
		if ($datados->num_rows() > 0) {
			$dos = $datados->row_array();
		}

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah mengubah data Dosen " . $dos['namalengkap'] . " menjadi Dosen Biasa pada tanggal " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function open($fak)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"status"		=> 1,
			"modified"		=> $waktu
		);

		$this->db->where("id_open", $fak);
		$this->db->update("opensubmit", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah Membuka Submit Usulan Baru pada tanggal " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function close($id)
	{
		$waktu = date('Y-m-d H:i:s');
		$data = array(
			"status"		=> 0,
			"modified"		=> $waktu
		);

		$this->db->where("id_open", $id);
		$this->db->update("opensubmit", $data);

		//masukan logs sistem
		//$wkt = date('d-m-Y H:i:s');
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah Menutup Submit Usulan Baru pada tanggal " . tgl_indo($waktu, 1)
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}

	function cekbuka($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("opensubmit");
		$this->db->where("id_open", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function namafakultas($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("fakultas");
		$this->db->where("id_fak", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function namaprodi($id)
	{
		$data = array();
		$this->db->select("*");
		$this->db->from("prodi");
		$this->db->where("id_prodi", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function namadosen($id)
	{
		$data = array();
		$this->db->select("namalengkap,user,prodi,nidn,id_dosen");
		$this->db->from("dosen");
		$this->db->where("id_dosen", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function dosennya($id)
	{
		$data = array();
		$this->db->select("namalengkap,fakultas,prodi,nidn");
		$this->db->from("dosen");
		$this->db->where("user", $id);
		$hasil = $this->db->get();
		if ($hasil->num_rows() > 0) {
			$data = $hasil->row_array();
		}
		$hasil->free_result();
		return $data;
	}

	function hapus($id)
	{
		$this->db->where("id_dosen", $id);
		$this->db->delete("dosen");

		//masukan logs sistem
		$wkt = date('d-m-Y H:i:s');
		// $pengguna = str_replace('%20', ' ', $pengguna);
		$data = array(
			"tgl" => date('Y-m-d'),
			"keterangan" => $this->session->userdata('sesi_nama') . " telah menghapus data Dosen " . $id . " " . $wkt
		);
		$this->db->insert("logs", $data);
		//akhir masukan logs sistem
	}
}
