<?php

class KaryawanModel extends CI_Model
{
    public function getKaryawan($id = null)
    {
        if ($id == null) {
            return $this->db->get('tb_karyawan')->result_array();
        } else {
            return $this->db->get_where('tb_karyawan', ['id' => $id])->result_array();
        }
    }

    public function deleteKaryawan($id)
    {
        $this->db->delete('tb_karyawan', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createKaryawan($data)
    {
        $this->db->insert('tb_karyawan', $data);
        return $this->db->affected_rows();
    }

    public function updateKaryawan($data, $id)
    {
        $this->db->update('tb_karyawan', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
