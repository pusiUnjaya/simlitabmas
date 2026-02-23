<?php
class Mdosenluar extends CI_Model
{
	private $table = 'dosenluar';

	function __construct()
	{
		parent::__construct();
	}

	public function get_all()
	{
		return $this->db->get($this->table)->result();
	}

	public function get_by_id($id)
	{
		return $this->db->get_where($this->table, ['id_dosen' => $id])->row();
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$this->db->where('id_dosen', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		$this->db->where('id_dosen', $id);
		return $this->db->delete($this->table);
	}

	public function get_negara()
	{
		return $this->db->get('m_negara')->result();
	}

	public function add($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function search_dosenluar($q, $page, $selected_id = null)
	{
		$this->db->select('dosenluar.id_dosen as id, dosenluar.id_dosen, dosenluar.nidn, dosenluar.namalengkap, dosenluar.namadepartmen, dosenluar.namainstitusi, m_negara.kode_negara, m_negara.nama_negara as negara, negara_institusi.nama_negara as negara_institusi');
		$this->db->from($this->table);
		$this->db->join('m_negara', 'dosenluar.id_negara = m_negara.id_negara', 'left');
		$this->db->join('m_negara as negara_institusi', 'dosenluar.id_negara_institusi = negara_institusi.id_negara', 'left');
		$this->db->like('dosenluar.namalengkap', $q);
		if ($selected_id) {
			$this->db->or_where('dosenluar.id_dosen', $selected_id);
		}
		$this->db->limit(10, ($page - 1) * 10);
		return $this->db->get()->result();
	}
}
