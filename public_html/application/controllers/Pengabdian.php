<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengabdian extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('msubmitpribadi', '', TRUE);
	}

	public function index()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');

		if ($this->session->userdata('sesi_status') <> 1) {
			$dosen = $this->mdosen->ambildosen($this->session->userdata('sesi_id'));
			$data['iddosen'] = $dosen['id_dosen'];
			$data['review'] = $this->mpengabdian->usulanreview($dosen['id_dosen']);
			// echo $this->db->last_query();exit;
			$data['hit'] = $this->mpengabdian->hitusulanreview($dosen['id_dosen']);
		}

		$data['masa'] = $pilih;
		$data['usulan'] = $this->mpengabdian->usulan($pilih);
		// echo $this->db->last_query();exit;
		$data['cekusulan'] = $this->mpengabdian->jmlusulan($this->session->userdata('sesi_id'));
		// echo $this->db->last_query();exit;

		$access = $this->session->userdata('sesi_status') == 1 ? 'admin' : '';
		$data['page'] = "pkm/usulanbaru$access";
		$this->load->view('dashboard/dashboard', $data);
	}

	function eksporusulan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['usulan'] = $this->mpengabdian->eksporusulan($this->uri->segment(3));

		$this->load->view('pkm/eksporusulan', $data);
	}

	function eksporhasilreview()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['hasilreview'] = $this->mpengabdian->hasilreview();

		$this->load->view('pkm/eksporhasilreview', $data);
	}

	function simpanlegalisir()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'usulanpkm_legal' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanlegalisir($this->uri->segment(3), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Usulan Pengabdian dengan Pengesahan Telah Sukses Disimpan!');
		redirect("pengabdian/detail/" . $this->uri->segment(3));
	}

	function insidental()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->mpengabdian->kaplingusulan("Insidental", $this->uri->segment(3));

		$data['page'] = 'pkm/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function noninsidental()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->mpengabdian->kaplingusulan("Noninsidental", $this->uri->segment(3));

		$data['page'] = 'pkm/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function pengembangan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->mpengabdian->kaplingusulan("Pengembangan", $this->uri->segment(3));

		$data['page'] = 'pkm/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kejuangan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->mpengabdian->kaplingusulan("Kejuangan", $this->uri->segment(3));

		$data['page'] = 'pkm/dasar';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kaprodi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['kaprodi'] = $this->mpengabdian->kaprodisetuju($pilih);
		$data['hit'] = $this->mpengabdian->hitkaprodisetuju($pilih);
		$data['histori'] = $this->mpengabdian->historikaprodisetuju($pilih);
		// echo $this->db->last_query();exit;	

		$data['page'] = 'pkm/kaprodi';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kaprodicek()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->session->userdata('sesi_status') <> 1) {
			$dosen = $this->mdosen->ambildosen($this->session->userdata('sesi_id'));
			$data['iddosen'] = $dosen['id_dosen'];
		}
		$data['usulan'] = $this->mpengabdian->detailusulan($this->uri->segment(3));

		$data['page'] = 'pkm/kaprodiliatusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function eksporab()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['date'] = date('dmYHis');
		//$data['total'] = $this->msubmit->bahan($this->uri->segment(3));
		$data['total'] = $this->mpengabdian->totalrab($this->uri->segment(3));
		$data['bahan'] = $this->mpengabdian->bahan($this->uri->segment(3));
		$data['kumpul'] = $this->mpengabdian->kumpuldata($this->uri->segment(3));
		$data['sewa'] = $this->mpengabdian->sewaalat($this->uri->segment(3));
		$data['analis'] = $this->mpengabdian->analisisdata($this->uri->segment(3));
		$data['lapor'] = $this->mpengabdian->lapordanluar($this->uri->segment(3));

		$this->load->view('pkm/eksporab', $data);
	}

	function setuju()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->prodisetuju();
		// echo $this->db->last_query();exit;

		$this->session->set_flashdata('result', 'Data Pengabdian Telah Sukses Diverifikasi Prodi!');
		redirect("pengabdian/kaprodi");
	}

	function simpanrevisikaprodi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'revisi_usulan_pkm_kaprodi' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanrevisikaprodi($this->input->post("id", true), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Revisi Usulan Pengabdian Telah Sukses Disimpan!');
		redirect("pengabdian");
	}

	function tolak()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->tolak($this->uri->segment(3));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Pengabdian Telah Sukses Ditolak!');
		redirect("pengabdian/kaprodi");
	}

	function hitbaru()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->db->select("*");
		$this->db->from("usulan_pkm");
		$this->db->join("dosen", "dosen.user=usulan_pkm.pengusul");
		$this->db->where("usulan_pkm.status", "Usulan Dikirim");
		$this->db->where("dosen.prodi", $this->session->userdata('sesi_prodi'));
		$this->db->like("usulan_pkm.modified", date('Y'));
		$this->db->order_by("usulan_pkm.tglmulai", "desc");
		$hasil = $this->db->get();

		return $hasil->num_rows();
	}

	function plotreviewer()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->mpengabdian->usulanrev();

		$data['page'] = 'pkm/plotreviewer';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editreview()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['review'] = $this->mpengabdian->lihatisianreview($this->uri->segment(3), $this->session->userdata('sesi_id'));

		$data['page'] = 'pkm/editreview';
		$this->load->view('dashboard/dashboard', $data);
	}

	function editreviewlaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['review'] = $this->mpengabdian->lihatisianreviewlaporan($this->uri->segment(3), $this->session->userdata('sesi_id'));

		$data['page'] = 'pkm/editreviewlaporan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detail()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->session->userdata('sesi_status') <> 1) {
			$dosen = $this->mdosen->ambildosen($this->session->userdata('sesi_id'));
			$data['iddosen'] = $dosen['id_dosen'];
		}
		$data['usulan'] = $this->mpengabdian->detailusulan($this->uri->segment(3));
		// echo $this->db->last_query();exit;

		$data['page'] = 'pkm/detailusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function edit()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['usulan'] = $this->mpengabdian->detailusulan($this->uri->segment(3));
		$data['riset'] = $this->mpengabdian->daftariset();
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['dosen'] = $this->mdosen->select();

		$data['page'] = 'pkm/editdoku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function rab()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		// $data['total'] = $this->mpengabdian->bahan($this->uri->segment(3));
		$data['total'] = $this->mpengabdian->totalrab($this->uri->segment(3));
		$data['bahan'] = $this->mpengabdian->bahan($this->uri->segment(3));
		$data['kumpul'] = $this->mpengabdian->kumpuldata($this->uri->segment(3));
		$data['sewa'] = $this->mpengabdian->sewaalat($this->uri->segment(3));
		$data['analis'] = $this->mpengabdian->analisisdata($this->uri->segment(3));
		$data['lapor'] = $this->mpengabdian->lapordanluar($this->uri->segment(3));

		$data['page'] = 'pkm/datarabusulan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function tambahrab()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['page'] = 'pkm/inputrab';
		$this->load->view('dashboard/dashboard', $data);
	}

	function simpanrab()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->simpanrab($this->uri->segment(3));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data RAB Telah Sukses Disimpan!');
		redirect("pengabdian/rab/" . $this->uri->segment(3));
	}

	function tambahusulan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['riset'] = $this->mpengabdian->daftariset();
		$data['fakultas'] = $this->mdosen->fakultas();
		$data['dosen'] = $this->mdosen->select();
		$data['mahasiswa'] = [];

		$bukaan = $this->msubmitpribadi->bukaan();
		$now = date('Y-m-d H:i:s');
		if ($now > $bukaan['tgltutup']) {
			$this->session->set_flashdata('alert', 'Mohon Maaf Waktu Unggah Proposal Pengabdian Sudah Habis!!!!');
			redirect('pengabdian');
		}

		$data['page'] = 'pkm/doku';
		$this->load->view('dashboard/dashboard', $data);
	}

	function riwayat()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['dosen'] = $this->mpengabdian->histori($pilih);

		$data['page'] = 'pkm/histori';
		$this->load->view('dashboard/dashboard', $data);
	}

	function kemajuan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['revkemajuan'] = $this->mpengabdian->revkemajuan();
		$data['hitrevkemajuan'] = $this->mpengabdian->hitrevkemajuan();

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['kemajuan'] = $this->mpengabdian->kemajuan($pilih);
		// echo $this->db->last_query();exit;

		$data['page'] = 'pkm/kemajuan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function laporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$pilih = empty($this->input->post('periode')) ? date('Y') : $this->input->post('periode');
		$data['usulan'] = $this->mpengabdian->laporan($pilih);
		// echo $this->db->last_query();exit;
		$data['direview'] = $this->mpengabdian->direview($pilih);
		$data['hitdireview'] = $this->mpengabdian->jmldireview($pilih);

		$data['page'] = 'pkm/laporan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function detaillaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		if ($this->session->userdata('sesi_status') <> 1) {
			$dosen = $this->mdosen->ambildosen($this->session->userdata('sesi_id'));
			$data['iddosen'] = $dosen['id_dosen'];
		}

		$data['usulan'] = $this->mpengabdian->detailapakhir($this->uri->segment(3));
		// echo $this->db->last_query();exit;
		$data['laporan'] = $this->mpengabdian->detailusulan($this->uri->segment(3));
		// echo $this->db->last_query();exit;

		$data['page'] = 'pkm/detaillaporan';
		$this->load->view('dashboard/dashboard', $data);
	}

	function load_prodi($fak)
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$query = $this->mpengabdian->prodi($fak);
		$data = "<option value=''>-- Pilih Prodi --</option>";
		foreach ($query as $value) {
			$data .= "<option value='" . $value->id_prodi . "'>" . $value->prodi . "</option>";
		}

		echo $data;
	}

	function simpankemajuan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'lap_kemajuan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		// echo $this->upload->display_errors();exit;
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';

		$this->mpengabdian->simpankemajuan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Laporan Kemajuan Penelitian Telah Sukses Disimpan!');
		redirect("pengabdian/kemajuan");
	}

	function simpanlaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'laporan_akhir' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanlaporan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $kode);
	}

	function simpanrevisilaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'revisi_laporan_akhir' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanrevisilaporan($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Revisi Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $kode);
	}

	function simpanlaporanakhir()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$kode = $this->input->post("id", true);
		$config['file_name'] = 'laporan_akhir_pengesahan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanlaporanakhir($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Laporan Akhir Penelitian dengan Pengesahan Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $kode);
	}

	function simpanjurnal()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		// $this->output->enable_profiler(true);
		$kode = $this->input->post("id", true);
		$config['file_name'] = 'jurnal' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanjurnal($file);
		// echo $this->db->last_query();exit;

		$this->session->set_flashdata('result', 'Luaran Pengabdian - Jurnal Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $kode);
	}

	function simpanhki()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		//$this->output->enable_profiler(true);
		$kode = $this->input->post("id", true);
		$config['file_name'] = 'hki' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanhki($file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Luaran Pengabdian - HKI Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $kode);
	}

	function simpanrelevansi()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->simpanrelevansi($this->uri->segment(3));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Relevansi PkM Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $this->uri->segment(3));
	}

	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'file_usulan_pkm_' . $this->session->userdata('sesi_id') . '_' . date('his');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();
		$file = $data["file_name"];

		try {
			$id = $this->mpengabdian->simpan($file);
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
					array_merge(array_fill(0, count($nidn), 'Pengabdian'))
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
					array_merge(array_fill(0, count($npm), 'Pengabdian'))
				)
			);
			$this->db->insert_batch('peran', $data);

			$this->session->set_flashdata('result', 'Usulan berhasil dikirimkan');
			redirect('pengabdian');
		} catch (Exception $e) {
			$this->session->set_flashdata('input', $this->input->post());
			$this->session->set_flashdata('error', $e->getMessage());
			redirect('pengabdian');
		}

		// $this->mpengabdian->simpan($file);
		// // echo $this->db->last_query();exit;	

		// $this->session->set_flashdata('result', 'Data PkM Telah Sukses Disimpan!');
		// redirect("pengabdian");
	}

	function update()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'file_usulan_pkm_' . $this->session->userdata('sesi_id') . '_' . date('his');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("fileupload");
		$data = $this->upload->data();

		$file = $_FILES['fileupload']['size'] && $_FILES['fileupload']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->updateusulan($file);
		// echo $this->db->last_query();exit;

		$this->session->set_flashdata('result', 'Data PkM Telah Sukses Disimpan!');
		redirect("pengabdian");
	}

	function kirim()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$idnya = $this->uri->segment(3) <> '' ? $this->uri->segment(3) : $this->input->post("idusul", true);
		$this->mpengabdian->kirim($idnya);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Pengabdian Telah Sukses Dikirim!');
		redirect("pengabdian");
	}

	function plotdosen()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->plotdosen();
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Data Plot Reviewer Telah Sukses Disimpan!');
		$this->session->set_userdata('sesi_nama', $this->input->post('namalengkap', true));
		redirect("pengabdian/plotreviewer");
	}

	function simpanreview()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'hasil_review' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Hasil Review Penelitian Telah Sukses Disimpan!');
		redirect("pengabdian/detail/" . $this->uri->segment(3));
	}

	function simpanreviewlaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'review_laporan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanreviewlaporan($this->uri->segment(3), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Review Laporan Akhir Penelitian Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $this->uri->segment(3));
	}

	function updatereview()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'hasil_review' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->updatereview($this->uri->segment(3), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Hasil Review Penelitian Telah Sukses Diupdate!');
		redirect("pengabdian/detail/" . $this->uri->segment(3));
	}

	function updatereviewlaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'review_laporan' . '_' . date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("hasilreview");
		$data = $this->upload->data();

		$file = $_FILES['hasilreview']['size'] && $_FILES['hasilreview']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->updatereviewlaporan($this->uri->segment(3), $file);
		// echo $this->db->last_query();exit;

		$this->session->set_flashdata('result', 'Hasil Review Laporan Akhir Penelitian Telah Sukses Diupdate!');
		redirect("pengabdian/detaillaporan/" . $this->uri->segment(3));
	}

	function simpanperbaikan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'revisi_usulan' . '_' . date('dmYhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("revisi");
		$data = $this->upload->data();

		$file = $_FILES['revisi']['size'] && $_FILES['revisi']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanperbaikan($this->uri->segment(3), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Perbaikan Usulan Pengabdian Telah Sukses Disimpan!');
		redirect("pengabdian/detail/" . $this->uri->segment(3));
	}

	function simpanperbaikanlap()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$config['file_name'] = 'revisi_laporan' . '_' . date('dmYhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);

		$this->upload->do_upload("revisi");
		$data = $this->upload->data();

		$file = $_FILES['revisi']['size'] && $_FILES['revisi']['name'] ? $data["file_name"] : '';
		$this->mpengabdian->simpanperbaikanlap($this->uri->segment(3), $file);
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Perbaikan Laporan Pengabdian Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $this->uri->segment(3));
	}

	function simpansetuju()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		// $config['file_name'] = $this->input->post('hasilreview');
		$this->mpengabdian->simpansetuju($this->uri->segment(3));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Status Usulan Penelitian Disetujui/Tidak Disetujui Telah Sukses Disimpan!');
		redirect("pengabdian/detail/" . $this->uri->segment(3));
	}

	function simpananggotasetuju()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->simpananggotasetuju($this->uri->segment(3));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Anda telah melakukan Persetujuan atas Usulan Pengabdian!');
		redirect("pengabdian/detail/" . $this->uri->segment(3));
	}

	function simpansetujulaporan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		// $config['file_name'] = $this->input->post('hasilreview');
		$this->mpengabdian->simpansetujulaporan($this->uri->segment(3));
		// echo $this->db->last_query();exit;	

		$this->session->set_flashdata('result', 'Status Laporan Akhir Penelitian Disetujui/Tidak Disetujui Telah Sukses Disimpan!');
		redirect("pengabdian/detaillaporan/" . $this->uri->segment(3));
	}

	function hapus()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->hapus($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Penelitian/PkM Telah Sukses Dihapus!');
		redirect('pengabdian');
	}

	function hapusrab()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$this->mpengabdian->hapusrab($this->uri->segment(3));

		$this->session->set_flashdata('result', 'Data Rincian RAB Telah Sukses Dihapus!');
		redirect('pengabdian/rab/' . $this->uri->segment(4));
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
				->get_where('usulan_pkm', ['id_usulan' => $id])
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
		$resdata = $this->msubmit->perananggota($id, 'Pengabdian');
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
		$resdata = $this->msubmit->peranmhs($id, 'Pengabdian');
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
				'skema' => 'Pengabdian'
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
			$sv = $this->msubmit->deleteanggota([
				'id' => $this->input->post('id', true),
			]);
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
			$usulan = $this->db->get_where('usulan_pkm', ['id_usulan' => $id_usulan])->row();
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
}
