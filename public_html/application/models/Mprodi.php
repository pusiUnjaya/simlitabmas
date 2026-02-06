<?php
class Mprodi extends CI_Model
{
    public function get_all()
    {
		return $this->db
            ->from('prodi')
    		->order_by('prodi', 'asc')
            ->get()
            ->result();
    }

    public function get_by_fakultas($id_fak)
    {
		return $this->db
            ->from('prodi')
		    ->where('fakultas', $id_fak)
    		->order_by('prodi', 'asc')
            ->get()
            ->result();
    }

    public function get_by_id($id)
    {
		return $this->db
            ->from('prodi')
		    ->where('id_prodi', $id)
            ->get()
            ->row();
    }

    public function get_by_dosen($id_dosen)
    {
		return $this->db
            ->select('prodi.*')
            ->from('dosen')
            ->join('prodi', 'dosen.prodi = prodi.id_prodi')
		    ->where('dosen.id_dosen', $id_dosen)
            ->get()
            ->row();
    }

    public function get_by_user($id_user)
    {
		return $this->db
            ->select('prodi.*')
            ->from('users')
            ->join('prodi', 'users.prodi = prodi.id_prodi')
		    ->where('users.id_user', $id_user)
            ->get()
            ->row();
    }

    public function get_fakultas()
    {
		return $this->db
            ->from('fakultas')
		    // ->where('jenis <>', '1')
    		->order_by('id_fak', 'asc')
            ->get()
            ->result();
    }
}