<?php

class Manage_users extends CI_Model
{
    public $id_users;
    public $name;
    public $email;
    public $id_role;
    public $is_active;

    public function get_count_users()
    {
        $this->db->where('id_role !=', 1); // Menetapkan kondisi where
        $count = $this->db->count_all_results('tbl_users'); // Menghitung jumlah baris yang memenuhi kriteria

        return $count; // Mengembalikan hasil perhitungan
    }
    public function get_all_users()
    {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->join('tbl_role', 'tbl_users.id_role = tbl_role.id_role', 'left');
        $this->db->where("(tbl_users.id_role = 0 OR tbl_users.id_role = 2 OR tbl_users.id_role = 3)"); // Menggunakan tanda kurung dan OR
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function update_manage_users()
    {
        $this->id_users     = $this->input->post('id_users');
        $this->name         = $this->input->post('name');
        $this->email        = $this->input->post('email');
        $this->id_role      = $this->input->post('id_role');
        $this->is_active    = $this->input->post('is_active');

        $data = [
            'name'      => $this->name,
            'email'     => $this->email,
            'id_role'   => $this->id_role,
            'is_active' => $this->is_active
        ];

        $query = $this->db->update('tbl_users', $data, ['id_users' => $this->id_users]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Users Successfully Update'
            ];
        } else {
            return [
                'success'   => false,
                'message'   => 'Data Users Failed Update'
            ];
        }
    }
}
