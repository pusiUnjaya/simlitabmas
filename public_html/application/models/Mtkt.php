<?php
Class Mtkt extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function indikator_lengkap()
    {
        $data = array();

        $hasil = $this->db
            ->select('j.id AS id_jenis, j.nama AS jenis, tkt.tingkat, tkt.definisi, i.nomor, i.indikator')
            ->from('jenis_tkt AS j')
            ->join('tkt', 'tkt.id_jenis = j.id', 'left')
            ->join('indikator_tkt AS i', 'i.id_jenis = j.id AND i.tingkat = tkt.tingkat', 'left')
            ->order_by('j.id', 'asc')
            ->order_by('tkt.tingkat', 'asc')
            ->order_by('i.nomor', 'asc')
            ->get();

        foreach ($hasil->result() as $row) {
            if (!isset($data[$row->id_jenis]) && !is_null($row->id_jenis)) {
                $data[$row->id_jenis] = (object) array(
                    'id_jenis' => $row->id_jenis,
                    'jenis' => $row->jenis,
                    'tkt' => array(),
                );
            }

            if (!isset($data[$row->id_jenis]->tkt[$row->tingkat]) && !is_null($row->tingkat)) {
                $data[$row->id_jenis]->tkt[$row->tingkat] = (object) array(
                    'tingkat' => $row->tingkat,
                    'definisi' => $row->definisi,
                    'indikator' => array(),
                );
            }

            if (!isset($data[$row->id_jenis]->tkt[$row->tingkat]->indikator[$row->nomor]) && !is_null($row->nomor)) {
                $data[$row->id_jenis]->tkt[$row->tingkat]->indikator[$row->nomor] = (object) array(
                    'nomor' => $row->nomor,
                    'indikator' => $row->indikator,
                );
            }
        }

        return $data;
    }

	function capaian($id)
	{
        $data = array();

        if (!empty($id)) {
            $hasil = $this->db
                ->select('*')
                ->from('tkt_usulan')
                ->where('id_usulan', $id)
                ->get();

            foreach ($hasil->result() as $row) {
                $data[$row->id_jenis_tkt][$row->tingkat][$row->no_indikator] = $row->capaian;
            }
        }

		return $data;
	}

    function jenistkt()
    {
        $data = array();
        $this->db->select("*");
        $this->db->from("jenis_tkt");
        $hasil = $this->db->get();
        
        if($hasil->num_rows() > 0)
        {
            $data = $hasil->result();
        }
        return $data;
    }


    function simpan($id, $data)
    {
        $this->db
            ->where('id_usulan', $id)
            ->delete('tkt_usulan');
        $jenis = $data['jenis'];
        foreach ($data['capaian'] as $tingkat => $indikator) {
            $total = 0;
            foreach ($indikator as $no => $capaian) {
                $capaian = +$capaian;
                if (!$capaian) continue;
                $total += $capaian;
                $this->db
                    ->insert('tkt_usulan', [
                        'id_usulan' => $id,
                        'id_jenis_tkt' => $jenis,
                        'tingkat' => $tingkat,
                        'no_indikator' => $no,
                        'capaian' => $capaian,
                    ]);
            }

            $jenistkt = $jenis;
            $capaiantkt = $tingkat;

            $mean = $total/count($indikator);
            if ($mean <= 80) break;
        }
        //update data usulan terkait tkt
        $data = array(
            "kategoritkt" => $jenistkt,
            "capaiantkt"  => $capaiantkt
            );
            
        $this->db->where("id_usulan",$id);
        $this->db->update("usulan",$data);
    }

    function ukur_tkt($data) {
        $hasil = 1;
        foreach ($data as $tingkat => $indikator) {
            $total = 0;
            foreach ($indikator as $no => $capaian) {
                $capaian = +$capaian;
                if (!$capaian) continue;
                $total += $capaian;
            }
            $mean = $total/count($indikator);
            if ($mean > 80) $hasil++;
        }
        return $hasil;
    }
}