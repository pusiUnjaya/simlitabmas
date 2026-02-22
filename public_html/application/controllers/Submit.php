<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submit extends CI_Controller
{

	private $sesi_id;
	private $sesi_status;

	function __construct()
	{
		parent::__construct();

		$this->sesi_id = $this->session->userdata('sesi_id');
		$this->sesi_status = $this->session->userdata('sesi_status');

		$this->load->model('msubmit', '', TRUE);
		$this->load->model('msubmitpribadi', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('mtkt', '', TRUE);
	}

	private function check_login()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
	}

	public function index()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		if ($this->sesi_status <> 1 && $this->sesi_status <> 4) {
			$dosen = $this->mdosen->ambildosen($this->sesi_id);
			$data['iddosen'] = $dosen['id_dosen'];
			$data['review'] = $this->msubmit->usulanreview($dosen['id_dosen'], $pilih);
			// echo $this->db->last_query();exit;	
			$data['hit'] = $this->msubmit->hitusulanreview($dosen['id_dosen'], $pilih);
		}

		if ($this->sesi_status == 4) {
			$dosen = $this->mdosen->ambildosen($this->sesi_id);
			$data['hit'] = $this->msubmit->hitusulanreview($dosen['id_dosen'], $pilih);
			$data['review'] = $this->msubmit->usulanreview($dosen['id_dosen'], $pilih);
		}

		$data['masa'] = $pilih;
		$data['bukaan'] = $this->msubmitpribadi->bukaan();
		$data['usulan'] = $this->msubmit->pilihusulan($pilih);
		// echo $this->db->last_query();exit;	
		$data['cekusulan'] = $this->msubmit->jmlusulan($this->sesi_id);

		$access = $this->sesi_status == 1 ? 'admin' : ($this->sesi_status == 4 ? 'rev' : '');
		$data['page'] = "submit/usulanbaru$access";
		$this->load->view('dashboard/dashboard', $data);
	}

	function tkt($id_usulan = null, $jenis_tkt = null)
	{
		$this->check_login();

		empty($id_usulan) and redirect('submit/tkt/new');
		($id_usulan == 'new') and $id_usulan = null;

		$this->load->model('mtkt', '', true);
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['id_usulan'] = $id_usulan;
		$data['indikator'] = $this->mtkt->indikator_lengkap();
		$data['capaian'] = $this->mtkt->capaian($id_usulan);
		// die('<pre>'.print_r($data['capaian'], true));
		$data['jenis'] = $jenis_tkt ?: (
			empty($data['capaian']) ? 1 : (
				array_reverse(array_keys($data['capaian']))[0]
			)
		);
		$data['tingkat'] = empty($data['capaian'][$data['jenis']]) ? 1 : (
			array_reverse(array_keys($data['capaian'][$data['jenis']]))[0]
		);

		$data['page'] = 'submit/tkt';
		$this->load->view('dashboard/dashboard', $data);
	}

	function simpan_tkt()
	{
		$this->check_login();

		$this->load->model('mtkt', '', true);

		$id = $this->input->post('id_usulan');
		$jenis = $this->input->post('jenis_tkt');

		$data = [
			'jenis' => $jenis,
			'capaian' => $this->input->post('capaian')[$jenis],
		];
		// die('<pre>'.print_r($data, true));
		if (!empty($id)) {
			$this->mtkt->simpan($id, $data);
			// echo $this->db->last_query();exit;

			$this->session->set_flashdata('result', 'Data TKT Telah Sukses Disimpan!');
			redirect("submit/edit/$id");
		} else {
			$this->session->set_userdata('tkt', $data);
			redirect('submit/tambahusulan');
		}
	}

	function progress()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['usulan'] = $this->msubmit->progressusulan($pilih);
		// echo $this->db->last_query();exit;	

		$data['page'] = 'submit/progresusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function eksporusulan($tahun = null)
	{
		$this->check_login();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['usulan'] = $this->msubmit->eksporusulan($tahun ?: date('Y'));
		// echo $this->db->last_query();exit;

		$this->load->view('submit/eksporusulan', $data);
	}

	function eksporplot()
	{
		$this->check_login();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['usulan'] = $this->msubmit->usulanplot();

		$this->load->view('submit/eksporusulan', $data);
	}

	function eksporhasilreview()
	{
		$this->check_login();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['hasilreview'] = $this->msubmit->hasilreview();

		$this->load->view('submit/eksporhasilreview', $data);
	}

	function dasar($status)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->msubmit->kaplingusulan("Dasar", $status);

		$data['page'] = 'submit/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function terapan($status)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->msubmit->kaplingusulan("Terapan", $status);

		$data['page'] = 'submit/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function pengembangan($status)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->msubmit->kaplingusulan("Pengembangan", $status);

		$data['page'] = 'submit/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kejuangan($status)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->msubmit->kaplingusulan("Kejuangan", $status);

		$data['page'] = 'submit/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function plotreviewer()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->msubmit->usulanrev();
		// echo $this->db->last_query();exit;

		$data['page'] = 'submit/plotreviewer';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editreview($id_usulan)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['review'] = $this->msubmit->lihatisianreview($id_usulan, $this->sesi_id);

		$data['page'] = 'submit/editreview';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editreviewlaporan($id_usulan)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['review'] = $this->msubmit->lihatisianreviewlaporan($id_usulan, $this->sesi_id);

		$data['page'] = 'submit/editreviewlaporan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detail($id)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->sesi_status <> 1) {
			$dosen = $this->mdosen->ambildosen($this->sesi_id);
			$data['iddosen'] = $dosen['id_dosen'];
		}
		$data['usulan'] = $this->msubmit->detailusulan($id);

		$data['page'] = 'submit/detailusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function simpananggotasetuju($id_usulan)
	{
		$this->check_login();

		$this->msubmit->simpananggotasetuju($id_usulan);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Anda telah melakukan Persetujuan atas Usulan Penelitian!');
		redirect("submit/detail/$id_usulan");
	}

	function kaprodicek($id_usulan)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->sesi_status <> 1) {
			$dosen = $this->mdosen->ambildosen($this->sesi_id);
			$data['iddosen'] = $dosen['id_dosen'];
		}
		$data['usulan'] = $this->msubmit->detailusulan($id_usulan);

		$data['page'] = 'submit/kaprodiliatusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function edit($id)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['dosen'] = $this->mdosen->select();
		$data['mahasiswa'] = [];
		$data['usulan'] = $this->msubmit->detailusulan($id);

		$data['page'] = 'submit/editdoku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function addmhs()
	{
		$this->check_login();

		$this->msubmit->addmhs();
		$mhs = $this->msubmit->mahasiswa();

		$data = "<option value=''>-- Pilih salah satu --</option>";
		foreach ($mhs as $value) {
			$data .= "<option value='" . $value->npm . "'>" . $value->namamhs . "(" . $value->namafak . "/" . $value->namaprodi . ")</option>";
		}
		echo $data;
	}

	function rab($id_usulan)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		// $data['total'] = $this->msubmit->bahan($id_usulan);
		$data['total'] = $this->msubmit->totalrab($id_usulan);
		$data['bahan'] = $this->msubmit->bahan($id_usulan);
		$data['kumpul'] = $this->msubmit->kumpuldata($id_usulan);
		$data['sewa'] = $this->msubmit->sewaalat($id_usulan);
		$data['analis'] = $this->msubmit->analisisdata($id_usulan);
		$data['lapor'] = $this->msubmit->lapordanluar($id_usulan);

		$data['page'] = 'submit/datarabusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function dosen_add()
	{
		$data = [
			'nidn' => $this->input->post('nidn'),
			'peran' => $this->input->post('peran'),
			'tugas' => $this->input->post('tugas'),
		];

		$this->session->set_userdata('datadosen', $data);

		$output = '';
		$no = 0;
		$query = $this->mdosen->datadosen($this->input->post('nidn'));
		foreach ($this->session->userdata('datadosen') as $items) {
			$no++;
			$output .= '
                        <tr>
                                <td>' . $no . '</td>
                                <td>' . $items['nidn'] . '</td>
                                <td>' . $query['namalengkap'] . '</td>
                                <td>' . $items['peran'] . '</td>
                                <td>' . $items['tugas'] . '</td>
                                <td><button type="button" id="' . $items['nidn'] . '" class="hapus_cart btn btn-danger btn-xs">Batal</button></td>
                        </tr>
                ';
		}

		echo $output;
	}

	function eksporab($id_usulan)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['date'] = date('dmYHis');
		// $data['total'] = $this->msubmit->bahan($id_usulan);
		$data['total'] = $this->msubmit->totalrab($id_usulan);
		$data['bahan'] = $this->msubmit->bahan($id_usulan);
		$data['kumpul'] = $this->msubmit->kumpuldata($id_usulan);
		$data['sewa'] = $this->msubmit->sewaalat($id_usulan);
		$data['analis'] = $this->msubmit->analisisdata($id_usulan);
		$data['lapor'] = $this->msubmit->lapordanluar($id_usulan);

		$this->load->view('submit/eksporab', $data);
	}

	function tambahrab()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'submit/inputrab';
		$this->load->view('dashboard/dashboard', $data);
	}

	function simpanrab($id_usulan)
	{
		$this->check_login();

		$this->msubmit->simpanrab($id_usulan);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data RAB Telah Sukses Disimpan!');
		redirect("submit/rab/$id_usulan");
	}

	function simpanrelevansi($id_usulan)
	{
		$this->check_login();

		$this->msubmit->simpanrelevansi($id_usulan);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Relevansi Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/$id_usulan");
	}

	function tambahusulan()
	{
		$this->check_login();

		// Set Deadline Unggah Usulan
		$bukaan = $this->msubmitpribadi->bukaan();
		$now = date('Y-m-d H:i:s');
		// $begin = new DateTime(date('Y-m-d H:i:s'));
		// $end = new DateTime('2024-05-19 23:59:59');
		// $diff = $begin->diff($end);
		// echo "Selisihnya adalah : " . $diff->format("%d hari %h jam %i menit");
		if ($now > $bukaan['tgltutup']) {
			$this->session->set_flashdata('error', 'Mohon Maaf Waktu Unggah Proposal Penelitian Sudah Habis!!!!');
			redirect('submit');
		}
		// Akhir Set Deadline Unggah Usulan

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['fakultas'] = $this->mdosen->fakultas();
		$data['dosen'] = $this->mdosen->select();
		$data['mahasiswa'] = [];

		$data['page'] = 'submit/doku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function riwayat()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['dosen'] = $this->msubmit->histori($pilih);

		$data['page'] = 'submit/histori';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kemajuan()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['revkemajuan'] = $this->msubmit->revkemajuan($pilih);
		$data['hitrevkemajuan'] = $this->msubmit->hitrevkemajuan($pilih);
		$data['kemajuan'] = $this->msubmit->kemajuan($pilih);
		// echo $this->db->last_query();exit;	

		$data['page'] = 'submit/kemajuan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kaprodi()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['kaprodi'] = $this->msubmit->kaprodisetuju($pilih);
		// echo $this->db->last_query();exit;
		$data['hit'] = $this->msubmit->hitkaprodisetuju($pilih);
		$data['histori'] = $this->msubmit->historikaprodisetuju($pilih);

		$data['page'] = 'submit/kaprodi';
		$this->load->view('dashboard/dashboard', $data);
	}

	function laporan()
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['usulan'] = $this->msubmit->laporan($pilih);
		// $data['direview'] = $this->msubmit->direview($pilih);
		// echo $this->db->last_query();exit;
		$data['direview'] = $this->msubmit->direview($pilih);
		// echo $this->db->last_query();exit;
		$data['hitdireview'] = $this->msubmit->jmldireview($pilih);

		$access = $this->sesi_status == 4 ? 'rev' : '';
		$data['page'] = "submit/laporan$access";
		$this->load->view('dashboard/dashboard', $data);
	}

	function detaillaporan($id_usulan)
	{
		$this->check_login();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->sesi_status <> 1) {
			$dosen = $this->mdosen->ambildosen($this->sesi_id);
			$data['iddosen'] = $dosen['id_dosen'];
		}
		$data['usulan'] = $this->msubmit->detailapakhir($id_usulan);
		$data['hasilreviewnya'] = $this->msubmit->hasilreviewnya($id_usulan);
		$data['hitreview'] = $this->msubmit->hithasilreview($id_usulan);
		$data['sah'] = $this->msubmit->siapuploadsah($id_usulan);
		$data['setuju'] = $this->msubmit->siapsetuju($id_usulan);
		// echo $this->db->last_query();exit;
		$data['laporan'] = $this->msubmit->detailusulan($id_usulan);

		$data['page'] = 'submit/detaillaporan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function load_prodi($fak)
	{
		$this->check_login();

		$query = $this->msubmit->prodi($fak);
		$data = "<option value=''>-- Pilih Prodi --</option>";
		foreach ($query as $value) {
			$data .= "<option value='" . $value->id_prodi . "'>" . $value->prodi . "</option>";
		}

		echo $data;
	}

	function simpankemajuan()
	{
		$this->check_login();

		$config['file_name'] = 'lap_kemajuan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpankemajuan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Laporan Kemajuan Penelitian Telah Sukses Disimpan!');
		redirect("submit/kemajuan");
	}

	function simpanlegalisir($id_usulan)
	{
		$this->check_login();

		$config['file_name'] = 'usulan_legal' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanlegalisir($id_usulan, $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Usulan Penelitian dengan Pengesahan Telah Sukses Disimpan!');
		redirect("submit/detail/$id_usulan");
	}

	function simpanrevisikaprodi()
	{
		$this->check_login();

		$config['file_name'] = 'revisi_usulan_kaprodi' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanrevisikaprodi($this->input->post("id", true), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Revisi Usulan Penelitian Telah Sukses Disimpan!');
		redirect("submit");
	}

	function simpanlaporan()
	{
		$this->check_login();

		$kode = $this->input->post("idus", true);
		$config['file_name'] = 'laporan_akhir' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanlaporan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/" . $kode);
	}

	function simpanrevisilaporan()
	{
		$this->check_login();

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'revisi_laporan_akhir' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanrevisilaporan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Revisi Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/" . $kode);
	}

	function simpanlaporanakhir()
	{
		$this->check_login();

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'revisi_laporan_akhir_pengesahan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanlaporanakhir($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Laporan Akhir Penelitian dengan Pengesahan Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/" . $kode);
	}

	function simpanjurnal()
	{
		$this->check_login();

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'jurnal' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanjurnal($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Luaran Penelitian - Jurnal Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/" . $kode);
	}

	function simpanhki()
	{
		$this->check_login();

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'hki' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanhki($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Luaran Penelitian - HKI Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/" . $kode);
	}

	function simpan()
	{
		$this->check_login();

		$config['file_name'] = 'file_usulan_penelitian_' . $this->sesi_id . '_' . date('his');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $data["file_name"];

		try {
			$id = $this->msubmit->simpan($file);
			$this->mtkt->simpan($id, $this->session->userdata('tkt'));
			// echo $this->db->last_query();exit;	

			$nidn = $this->input->post('m_id');
			$tugas = $this->input->post('m_tugas');
			$data = array_map(
				function ($x) {
					return array_combine(['id_usulan', 'anggota', 'tugas', 'jenis_anggota', 'skema'], $x);
				},
				array_map(
					null,
					array_fill(0, count($nidn), $id),
					array_merge($nidn),
					array_merge($tugas),
					array_merge(array_fill(0, count($nidn), 'Dosen')),
					array_merge(array_fill(0, count($nidn), 'Penelitian'))
				)
			);
			$this->db->insert_batch('peran', $data);

			$npm = $this->input->post('p_id');
			$mtugas = $this->input->post('p_tugas');
			$data = array_map(
				function ($x) {
					return array_combine(['id_usulan', 'anggota', 'tugas', 'jenis_anggota', 'skema'], $x);
				},
				array_map(
					null,
					array_fill(0, count($npm), $id),
					array_merge($npm),
					array_merge($mtugas),
					array_merge(array_fill(0, count($npm), 'Mahasiswa')),
					array_merge(array_fill(0, count($npm), 'Penelitian'))
				)
			);
			$this->db->insert_batch('peran', $data);

			$this->session->set_flashdata('result', 'Usulan berhasil dikirimkan');
			redirect('submit');
		} catch (Exception $e) {
			$this->session->set_flashdata('input', $this->input->post());
			$this->session->set_flashdata('error', $e->getMessage());
			redirect('submit');
		}


		// $this->session->set_flashdata('result', 'Data Penelitian/PkM Telah Sukses Disimpan!');
		// redirect("submit");
	}

	function update()
	{
		$this->check_login();

		$config['file_name'] = 'file_usulan_penelitian_' . $this->sesi_id . '_' . date('his');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->msubmit->updateusulan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Penelitian/PkM Telah Sukses Disimpan!');
		redirect("submit");
	}

	function kirim()
	{
		$this->check_login();

		empty($id) and $id = $this->input->post("idusul", true);
		$this->msubmit->kirim($id);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Penelitian/PkM Telah Sukses Dikirim!');
		redirect("submit");
	}

	function setuju()
	{
		$this->check_login();

		$this->msubmit->prodisetuju();
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Penelitian Telah Sukses Diverifikasi Prodi!');
		redirect("submit/kaprodi");
	}

	function tolak($id)
	{
		$this->check_login();

		$this->msubmit->tolak($id);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Penelitian Telah Sukses Ditolak!');
		redirect("submit/kaprodi");
	}

	function plotdosen()
	{
		$this->check_login();

		$this->msubmit->plotdosen();
		// echo $this->db->last_query();exit;	
		$this->session->set_userdata('sesi_nama', $this->input->post('namalengkap', true));

		$this->session->set_flashdata('result', 'Data Plot Reviewer Telah Sukses Disimpan!');
		redirect("submit/plotreviewer");
	}

	function simpanreview($id_usulan)
	{
		$this->check_login();

		$config['file_name'] = 'hasil_review' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanreview($id_usulan, $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Hasil Review Penelitian Telah Sukses Disimpan!');
		redirect("submit/detail/$id_usulan");
	}

	function mintarevisilaporan($id_usulan)
	{
		$this->check_login();

		$config['file_name'] = 'review_laporan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->msubmit->mintarevisilaporan($id_usulan, $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Review Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/$id_usulan");
	}

	function simpanreviewlaporan($id_usulan)
	{
		$this->check_login();

		// $config['file_name'] = 'review_laporan' . '_' . date('dmyhis');
		// $config['upload_path'] = './assets/uploadbox/';
		// $config['allowed_types'] = 'pdf';
		// $this->load->library('upload', $config);

		// $this->upload->do_upload("hasilreview");
		// $data = $this->upload->data();

		// $file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		// $this->msubmit->simpanreviewlaporan($id_usulan, $file);
		$this->msubmit->simpanreviewlaporan($id_usulan);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Review Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/$id_usulan");
	}

	function updatereview($id)
	{
		$this->check_login();

		$config['file_name'] = 'hasil_review' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->msubmit->updatereview($id, $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Hasil Review Penelitian Telah Sukses Diupdate!');
		redirect("submit/detail/$id");
	}

	function updatereviewlaporan($id)
	{
		$this->check_login();

		$config['file_name'] = 'review_laporan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->msubmit->updatereviewlaporan($id, $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Hasil Review Laporan Akhir Penelitian Telah Sukses Diupdate!');
		redirect("submit/detaillaporan/$id");
	}

	function simpanperbaikan($id)
	{
		$this->check_login();

		$config['file_name'] = 'revisi_usulan' . '_' . date('dmYhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("revisi");
		$data = $this->upload->data();

		$file = $_FILES['revisi']['size'] && $_FILES['revisi']['name'] ? $data["file_name"] : '';
		$this->msubmit->simpanperbaikan($id, $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Perbaikan Usulan Penelitian Telah Sukses Disimpan!');
		redirect("submit/detail/$id");
	}

	function simpansetuju($id)
	{
		$this->check_login();

		// $config['file_name'] = $this->input->post('hasilreview');
		$this->msubmit->simpansetuju($id);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Status Usulan Penelitian Disetujui/Tidak Disetujui Telah Sukses Disimpan!');
		redirect("submit/detail/$id");
	}

	function simpanrealisasidana()
	{
		$this->check_login();

		// $config['file_name'] = $this->input->post('hasilreview');
		$this->msubmit->simpanrealisasidana($this->input->post('idus'));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Realisasi Dana Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/" . $this->input->post('idus'));
	}

	function simpansetujulaporan($id)
	{
		$this->check_login();

		// $config['file_name'] = $this->input->post('hasilreview');
		$this->msubmit->simpansetujulaporan($id);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Status Laporan Akhir Penelitian Disetujui/Tidak Disetujui Telah Sukses Disimpan!');
		redirect("submit/detaillaporan/$id");
	}

	function hapus($id)
	{
		$this->check_login();

		$this->msubmit->hapus($id);

		$this->session->set_flashdata('result', 'Data Penelitian/PkM Telah Sukses Dihapus!');
		redirect('submit');
	}

	function mhs_add()
	{
		$this->msubmit->addmhs([
			'namamhs' => $this->input->post('namamhs'),
			'npm' => $this->input->post('npm'),
		]);

		echo json_encode(["status" => true]);
	}

	function hapusrab($id_rab, $id_usulan)
	{
		$this->check_login();

		$this->msubmit->hapusrab($id_rab);

		$this->session->set_flashdata('result', 'Data Rincian RAB Telah Sukses Dihapus!');
		redirect("submit/rab/$id_usulan");
	}

	function anggotadosen($id)
	{
		header('Content-Type: application/json');
		echo json_encode(array_map(function ($x) {
			$y = $this->mdosen->namadosen($x);
			$y['id'] = $x;
			return $y;
		}, explode(
			',',
			$this->db
				->select('anggotadosen')
				->get_where('usulan', ['id_usulan' => $id])
				->row()
				->anggotadosen
		)));
	}

	function load_anggota_dosen($id)
	{
		header('Content-Type: application/json');

		// Cek login, jika tidak login langsung return JSON error dan exit
		if (empty($this->session->userdata('sesi_user'))) {
			echo json_encode([
				'status' => false,
				'data' => [],
				'message' => 'Sesi habis. Silahkan login terlebih dahulu!'
			]);
			return;
		}

		// Jika login, lanjutkan ambil data
		$resdata = $this->msubmit->perananggota($id, 'Penelitian');
		echo json_encode([
			'status' => true,
			'data' => $resdata,
			'message' => ''
		]);
	}

	function load_anggota_mhs($id)
	{
		header('Content-Type: application/json');

		// Cek login, jika tidak login langsung return JSON error dan exit
		if (empty($this->session->userdata('sesi_user'))) {
			echo json_encode([
				'status' => false,
				'data' => [],
				'message' => 'Sesi habis. Silahkan login terlebih dahulu!'
			]);
			return;
		}

		// Jika login, lanjutkan ambil data
		$resdata = $this->msubmit->peranmhs($id, 'Penelitian');
		echo json_encode([
			'status' => true,
			'data' => $resdata,
			'message' => ''
		]);
	}



	private function aksiAnggota($aksi, $jenis)
	{
		$jenis = $jenis == 'dosen' ? 'Dosen' : 'Mahasiswa';
		if ($aksi == 'add') {


			$sv = $this->msubmit->addanggota([
				'id_usulan' => $this->input->post('id_usulan', true),
				'anggota' => $this->input->post('anggota', true),
				'tugas' => $this->input->post('tugas', true),
				'jenis_anggota' => $jenis,
				'skema' => 'Penelitian'
			]);
			if (!$sv) {
				echo json_encode([
					'status' => false,
					'message' => 'Gagal menambahkan anggota ' . $jenis . '!'
				]);
				return;
			}

			echo json_encode([
				'status' => true,
				'message' => 'Anggota ' . $jenis . ' berhasil ditambahkan!'
			]);
			return;
		} else if ($aksi == 'edit') {
			$dt = [
				'tugas' => $this->input->post('tugas', true),
				'anggota' => $this->input->post('anggota', true),
			];

			$id = $this->input->post('id', true);

			$sv = $this->msubmit->updateanggota($id, $dt);
			if (!$sv) {
				echo json_encode([
					'status' => false,
					'message' => 'Gagal memperbarui anggota ' . $jenis . '!'
				]);
				return;
			}

			echo json_encode([
				'status' => true,
				'message' => 'Anggota ' . $jenis . ' berhasil diperbarui!'
			]);
			return;
		} else if ($aksi == 'delete') {
			$sv = $this->msubmit->deleteanggota($this->input->post('id', true));
			if (!$sv) {
				echo json_encode([
					'status' => false,
					'message' => 'Gagal menghapus anggota ' . $jenis . '!'
				]);
				return;
			}

			echo json_encode([
				'status' => true,
				'message' => 'Anggota ' . $jenis . ' berhasil dihapus!'
			]);
			return;
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Aksi tidak dikenali!'
			]);
			return;
		}
	}

	function simpan_anggota()
	{
		header('Content-Type: application/json');

		// Cek login, jika tidak login langsung return JSON error dan exit



		if (empty($this->session->userdata('sesi_user'))) {
			echo json_encode([
				'status' => false,
				'message' => 'Sesi habis. Silahkan login terlebih dahulu!'
			]);
			return;
		}

		try {
			$aksi = $this->input->post('aksi', true);
			$jenis = $this->input->post('jenis', true);


			//cek apakah usulan usulan belum dikirim, jika sudah dikirim maka tidak bisa tambah anggota
			$id_usulan = $this->input->post('id_usulan', true);
			$usulan = $this->db->get_where('usulan', ['id_usulan' => $id_usulan])->row();
			if ($usulan->status == 'Usulan Baru') {
				$this->aksiAnggota($aksi, $jenis);
				return;
			} else {
				echo json_encode([
					'status' => false,
					'message' => 'Usulan sudah dikirim, tidak bisa menambah anggota!'
				]);
				return;
			}
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'message' => $e->getMessage()
			]);
		}
	}

	function search_mahasiswa()
	{
		header('Content-Type: application/json');
		$all_sessiondata = $this->session->all_userdata();
		// Cek login, jika tidak login langsung return JSON error dan exit
		if (empty($this->session->userdata('sesi_user'))) {
			echo json_encode([
				'status' => false,
				'data' => $all_sessiondata,
				'message' => 'Sesi habis. Silahkan login terlebih dahulu!'
			]);
			return;
		}

		$q = $this->input->post('q', true);
		$page = $this->input->post('page', true) ?: 1;
		$selected = $this->input->post('selected', true);
		$mahasiswa = $this->msubmit->search_mahasiswa($q, $page, $selected);
		echo json_encode([
			'status' => true,
			'data' => $mahasiswa,
			'message' => $q
		]);
	}
}
