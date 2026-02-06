<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends LPPM_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('msurat', '', TRUE);
		$this->load->model('mroadmap', '', TRUE);
		$this->load->model('msubmit', '', TRUE);
		$this->load->model('mpengguna', '', TRUE);
		$this->load->model('mpengabdian', '', TRUE);
		$this->load->model('mdosen', '', TRUE);
		$this->load->model('mprodi', '', TRUE);
	}
	
	public function nomor()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		if($this->input->post('periode')=='')
			$pilih = date('Y');
		else
			$pilih = $this->input->post('periode');
		
		$data['usulan'] = $this->msurat->selectusulan($pilih);
		$data['usulanpkm'] = $this->msurat->selectusulanpkm($pilih);
		// echo $this->db->last_query();exit;
		$data['page'] = 'surat/nomor';
		$this->load->view('dashboard/dashboard',$data);
	}

	function nomorpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		if($this->input->post('periode')=='')
			$pilih = date('Y');
		else
			$pilih = $this->input->post('periode');
		
		$data['usulan'] = $this->msurat->selectusulan($pilih);
		// echo $this->db->last_query();exit;
		$data['page'] = 'surat/nomorpenelitian';
		$this->load->view('dashboard/dashboard',$data);
	}

	function nomorpengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		if($this->input->post('periode')=='')
			$pilih = date('Y');
		else
			$pilih = $this->input->post('periode');
		
		$data['usulanpkm'] = $this->msurat->selectusulanpkm($pilih);
		// echo $this->db->last_query();exit;
		$data['page'] = 'surat/nomorpengabdian';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	public function penelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		if($this->input->post('periode')=='')
			$pilih = date('Y');
		else
			$pilih = $this->input->post('periode');
		
		$data['usulan'] = $this->msurat->selectusulan($pilih);
		$data['usulanpkm'] = $this->msurat->selectusulanpkm($pilih);
		// echo $this->db->last_query();exit;
		$data['page'] = 'surat/penelitian';
		$this->load->view('dashboard/dashboard',$data);
	}
	
	public function pengabdian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		if($this->input->post('periode')=='')
			$pilih = date('Y');
		else
			$pilih = $this->input->post('periode');
		
		$data['usulan'] = $this->msurat->selectusulan($pilih);
		$data['usulanpkm'] = $this->msurat->selectusulanpkm($pilih);
		// echo $this->db->last_query();exit;
		$data['page'] = 'surat/pengabdian';
		$this->load->view('dashboard/dashboard',$data);
	}

	function eksporkontrak($tahun = null, $prodi = null)
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['penelitian'] = $this->msurat->penelitian($tahun, $prodi);
		// echo $this->db->last_query();exit;

		$this->load->view('surat/eksporkontrak', $data);
	}

	function eksporkontrakpkm($tahun = null, $prodi = null)
	{
		$this->check_admin();

		$data = [];
		$data['date'] = date('dmYHis');
		$data['pengabdian'] = $this->msurat->pengabdian($tahun, $prodi);
		// echo $this->db->last_query();exit;

		$this->load->view('surat/eksporkontrakpkm', $data);
	}
	
	function tugaspkm($id_usulan)
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['tugas'] = $this->mpengabdian->detailusulan($id_usulan);
		$data['dasartugas'] = $this->msurat->dasartugaspkm();
		// echo $this->db->last_query();exit;
		// $this->load->view('surat/surat_tugas_pkm',$data);
		$this->load->library('pdf');
		// $this->pdf->set_paper('F4', 'portrait');
		$html = $this->load->view('surat/surat_tugas_pkm', $data,true);
		$this->pdf->createPDF($html, 'surat_tugas_pkm_'.date('dmYHis'), false);
	}

	function tugaspenelitian($id_usulan)
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['tugas'] = $this->msubmit->detailusulan($id_usulan);
		$data['dasartugas'] = $this->msurat->dasartugasriset();
		// echo $this->db->last_query();exit;
		$this->load->library('pdf');
		// $this->pdf->set_paper('F4', 'portrait');
		$html = $this->load->view('surat/surat_tugas_penelitian', $data,true);
		// echo $html;
		$this->pdf->createPDF($html, 'surat_tugas_penelitian_'.date('dmYHis'), false);
	}
	
	function kontrakpkm($id_usulan)
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['tugas'] = $this->mpengabdian->detailusulan($id_usulan);
		$data['dasartugas'] = $this->msurat->dasarkontrakpkm();
		// echo $this->db->last_query();exit;
		// $this->load->view('surat/surat_tugas_pkm',$data);
		$this->load->library('pdf');
		$html = $this->load->view('surat/surat_kontrak_pkm', $data,true);
		$this->pdf->createPDF($html, 'surat_kontrak_pkm_'.date('dmYHis'), false);
	}

	function kontrakpenelitian($id_usulan)
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');

		$data = [];
		$data['date'] = date('dmYHis');
		$data['tugas'] = $this->msubmit->detailusulan($id_usulan);
		$data['dasartugas'] = $this->msurat->dasarkontrakriset();
		// echo $this->db->last_query();exit;
		// $this->load->view('surat/surat_kontrak_penelitian', $data); return;
		$this->load->library('pdf');
		$html = $this->load->view('surat/surat_kontrak_penelitian', $data,true);
		$this->pdf->createPDF($html, 'surat_kontrak_penelitian_'.date('dmYHis'), false, 'a4');
	}
	
	function simpan()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$this->msurat->simpan();
		$this->session->set_flashdata('result', 'Nomor Surat Telah Sukses Ditambahkan!');
		//echo $this->db->last_query();exit;	
		redirect("surat/nomorpenelitian");
		
	}

	function simpankontrakpkm()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$id = $this->input->post('usulan',true);
		$config['file_name'] = 'surat_kontrak_pkm'.'_'.date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload',$config);
		
		$this->upload->do_upload("kontrak");
		$data = $this->upload->data();
		if($_FILES['kontrak']['size'] == 0 || $_FILES['kontrak']['name'] == "")
			$file = '';
		else
			$file = $data["file_name"];

		$this->msurat->simpankontrakpkm($id,$file);
		$this->session->set_flashdata('result', 'Surat Kontrak Pengabdian Telah Sukses Ditambahkan!');
		//echo $this->db->last_query();exit;	
		redirect("surat/pengabdian");
		
	}

	function simpankontrakpenelitian()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$id = $this->input->post('usulan',true);
		$config['file_name'] = 'surat_kontrak_penelitian'.'_'.date('dmyhis');
		$config['upload_path'] = './assets/uploadbox/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload',$config);
		
		$this->upload->do_upload("kontrak");
		$data = $this->upload->data();
		if($_FILES['kontrak']['size'] == 0 || $_FILES['kontrak']['name'] == "")
			$file = '';
		else
			$file = $data["file_name"];

		$this->msurat->simpankontrakpenelitian($id,$file);
		$this->session->set_flashdata('result', 'Surat Kontrak Penelitian Telah Sukses Ditambahkan!');
		//echo $this->db->last_query();exit;	
		redirect("surat/penelitian");
		
	}
	
	function simpanpkm()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$this->msurat->simpanpkm();
		$this->session->set_flashdata('result', 'Nomor Surat Telah Sukses Ditambahkan!');
		//echo $this->db->last_query();exit;	
		redirect("surat/nomorpengabdian");
		
	}

	function dasar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		$data['dasar'] = $this->msurat->selectdasar();
		// echo $this->db->last_query();exit;
		$data['page'] = 'surat/dasarsurat';
		$this->load->view('dashboard/dashboard',$data);
	}

	function tambahdasar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		$data['page'] = 'surat/tambahdasar';
		$this->load->view('dashboard/dashboard',$data);
	}

	function editdasar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		
		$data['dasar'] = $this->msurat->detaildasar($this->uri->segment(3));
		$data['page'] = 'surat/editdasar';
		$this->load->view('dashboard/dashboard',$data);
	}

	function simpandasar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$this->msurat->simpandasar();
		$this->session->set_flashdata('result', 'Dasar Hukum Telah Sukses Ditambahkan!');
		//echo $this->db->last_query();exit;	
		redirect("surat/dasar");
		
	}

	function updatedasar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$this->msurat->updatedasar();
		$this->session->set_flashdata('result', 'Dasar Hukum Telah Sukses Diupdate!');
		//echo $this->db->last_query();exit;	
		redirect("surat/dasar");
		
	}

	function pakaidasar()
	{
		empty($this->session->userdata('sesi_user')) and redirect('login');
		
		$this->msurat->pakaidasar($this->uri->segment(3));	
		redirect("surat/dasar");		
	}

	function tidakdasar()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->msurat->tidakdasar($this->uri->segment(3));	
		redirect("surat/dasar");		
	}

	function hapusdasar()
	{
		if($this->session->userdata('sesi_user')=='')
			redirect('login');
		
		$this->msurat->hapusdasar($this->uri->segment(3));	
		redirect("surat/dasar");		
	}

	public function izin($id = null, $action = null)
	{
		if ($this->is_admin()) {
			if (is_null($id)) {
				$this->izin_admin();
			} elseif (is_null($action)) {
				$this->izin_view($id, true);
			} elseif ($action == 'delete') {
				$this->izin_delete($id, true);
			} elseif ($action == 'approve') {
				$this->izin_approve($id);
			} elseif ($action == 'undo') {
				$this->izin_undo($id);
			} elseif ($action == 'download') {
				$this->izin_download($id, true);
			}
		} elseif ($this->is_dosen()) {
			if ($this->input->method() != 'post') {
				if (is_null($id)) {
					$this->izin_request();
				} elseif (is_null($action)) {
					$this->izin_view($id);
				} elseif ($action == 'delete') {
					$this->izin_delete($id);
				} elseif ($action == 'download') {
					$this->izin_download($id);
				}
			} else {
				$this->save_izin_request();
			}
		} else {
			redirect('/');
		}
	}

	private function izin_check_dosen($id)
	{
		$id_ketua = $this->db
			->select('id_dosen')
			->from('surat_izin_dosen')
			->where('id_surat', $id)
			->where('ketua', '1')
			->get()
			->row()
			->id_dosen;
		$id_ketua == $this->session->userdata('sesi_dosen') or redirect('surat/izin');
	}

	private function izin_admin()
	{
		$this->check_admin();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['surat'] = $this->db
			->select('si.*, sid.id_dosen')
			->from('surat_izin AS si')
			->join('surat_izin_dosen AS sid', 'sid.id_surat = si.id')
			->where('sid.ketua', '1')
			->order_by('si.waktu_pengajuan', 'DESC')
			->get()
			->result();

		$data['page'] = 'surat/izin_admin';
		$this->load->view('dashboard/dashboard', $data);
	}

	private function izin_request()
	{
		$this->check_dosen();

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';

		$data['penelitian'] = $this->msubmit->pilihusulan(date('Y'));
		$data['pengabdian'] = $this->mpengabdian->pilihusulan(date('Y'));
		$data['dosen'] = $this->mdosen->select();
		$data['surat'] = $this->db
			->select('si.*')
			->from('surat_izin AS si')
			->join('surat_izin_dosen AS sid', 'sid.id_surat = si.id')
			->where('sid.id_dosen', $this->session->userdata('sesi_dosen'))
			->where('sid.ketua', '1')
			->where('si.nomor is not null', null, false)
			->order_by('si.nomor', 'DESC')
			->get()
			->result();
		$data['permohonan'] = $this->db
			->select('si.*')
			->from('surat_izin AS si')
			->join('surat_izin_dosen AS sid', 'sid.id_surat = si.id')
			->where('sid.id_dosen', $this->session->userdata('sesi_dosen'))
			->where('sid.ketua', '1')
			->where('si.nomor', null)
			->order_by('si.waktu_pengajuan', 'DESC')
			->get()
			->result();

		// die('<pre>'.print_r($data['surat'], true));

		$data['page'] = 'surat/izin_request';
		$this->load->view('dashboard/dashboard', $data);
	}

	private function save_izin_request()
	{
		$this->check_dosen();

		try {
			empty(trim($this->input->post('judul'))) and $this->fail('Data judul harus diisi');
			empty($this->input->post('jenis')) and $this->fail('Data jenis harus dipilih');
			empty(trim($this->input->post('tertuju'))) and $this->fail('Data kepada (tujuan surat) harus diisi');
			empty(trim($this->input->post('tempat'))) and $this->fail('Data tempat yang dituju harus diisi');
			empty(trim($this->input->post('lokasi'))) and $this->fail('Data lokasi kegiatan harus diisi');

			$data = [
				'judul' => $this->input->post('judul'),
				'jenis' => $this->input->post('jenis'),
				'tertuju' => $this->input->post('tertuju'),
				'tempat' => $this->input->post('tempat'),
				'lokasi' => $this->input->post('lokasi'),
				'waktu_pengajuan' => date('Y-m-d H:i:s'),
			];
			$this->db->insert('surat_izin', $data);

			$id = $this->db->insert_id();
			$dosens = $this->input->post('m_id');
			$data = array_map(
				function($x) {
					return array_combine(['id_surat', 'id_dosen', 'ketua'], $x);
				},
				array_map(
					null,
					array_fill(0, count($dosens) + 1, $id),
					array_merge([$this->session->userdata('sesi_dosen')], $dosens),
					array_merge(['1'], array_fill(0, count($dosens), '0'))
				)
			);
			$this->db->insert_batch('surat_izin_dosen', $data);

			$this->session->set_flashdata('result', 'Permohonan berhasil dikirimkan');
			redirect('surat/izin');
		} catch (Exception $e) {
			$this->session->set_flashdata('input', $this->input->post());
			$this->session->set_flashdata('error', $e->getMessage());
			redirect('surat/izin#baru');
		}
	}

	private function izin_delete($id, $as_admin = false)
	{
		$as_admin ? $this->check_admin() : $this->check_dosen();
		$as_admin or $this->izin_check_dosen($id);

		$this->db->delete('surat_izin', ['id'=> $id]);

		$this->session->set_flashdata('result', 'Permohonan berhasil dihapus');
		redirect('surat/izin');
	}

	private function izin_view($id, $as_admin = false)
	{
		$as_admin ? $this->check_admin() : $this->check_dosen();
		$as_admin or $this->izin_check_dosen($id);

		$data = [];
		$data['active'] = 'active ';
		$data['show'] = 'show ';
		$data['admin'] = $as_admin;

		$data['surat'] = $this->db
			->get_where('surat_izin', ['id' => $id])
			->row();

		$dosen = array_map(function($x) {
			return $this->mdosen->namadosenprodi($x->id_dosen);
		}, $this->db
			->select('id_dosen')
			->order_by('ketua', 'DESC')
			->get_where('surat_izin_dosen', ['id_surat' => $id])
			->result()
		);
		$data['prodi'] = $this->mprodi->get_by_id($dosen[0]['prodi'])->prodi;
		$data['dosen'] = array_map(function($x) {
			return $x['namalengkap'];
		}, $dosen);

		$data['page'] = 'surat/izin_detail';
		$this->load->view('dashboard/dashboard', $data);
	}

	private function izin_approve($id)
	{
		$this->check_admin();

		try {
			$nomor = $this->input->post('nomor');
			$tanggal = $this->input->post('tanggal');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');

			empty($nomor) and $this->fail('Nomor surat harus diisi');
			empty($tanggal) and $this->fail('Tanggal surat harus diisi');

			$nomor = sprintf('%03d', $nomor);
			$this->db
				->where('id', $id)
				->update('surat_izin', [
					'nomor' => "B/$nomor/LPPMUNJAYA/$bulan/$tahun",
					'tanggal' => $tanggal,
				]);

			$this->session->set_flashdata('result', 'Permohonan disetujui, surat izin siap diunduh');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
		}
		redirect('surat/izin');
	}

	private function izin_undo($id)
	{
		$this->check_admin();

		$this->db
			->where('id', $id)
			->update('surat_izin', ['nomor' => null, 'tanggal' => null]);

		$this->session->set_flashdata('result', 'Persetujuan berhasil dibatalkan');
		redirect('surat/izin');
	}

	private function izin_download($id, $admin = false)
	{
		if (!$admin) {
			$this->check_dosen();
			$this->izin_check_dosen($id);
		}

		$data = $this->db
			->get_where('surat_izin', ['id' => $id])
			->row_array();

		$dosen = array_map(function($x) {
			return $this->mdosen->namadosenprodi($x->id_dosen);
		}, $this->db
			->select('id_dosen')
			->order_by('ketua', 'DESC')
			->get_where('surat_izin_dosen', ['id_surat' => $id])
			->result()
		);
		$data['prodi'] = $this->mprodi->get_by_id($dosen[0]['prodi'])->prodi;
		$data['dosen'] = join('/', array_map(function($x) {
			return $x['namalengkap'];
		}, $dosen));
		$data['nidn'] = join('/', array_map(function($x) {
			return $x['nidn'];
		}, $dosen));

		$this->load->library('pdf');
		$html = $this->load->view('surat/surat_izin', $data, true);
		$this->pdf->createPDF($html, 'surat-izin-'.date('Ymdhis'), false);
	}
}
