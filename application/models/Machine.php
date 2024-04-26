<?php

class Machine extends CI_Model
{
    public $id_machine;
    public $code_area;
    public $code_line;
    public $code_machine;
    public $name_machine;

    public function get_all_machine()
    {
        $this->db->select('tbl_machine.*, tbl_area.name_area, tbl_line.name_line');
        $this->db->from('tbl_machine');
        $this->db->join('tbl_area', 'tbl_machine.code_area = tbl_area.code_area', 'left');
        $this->db->join('tbl_line', 'tbl_machine.code_line = tbl_line.code_line', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function check_existing_code_machine()
    {
        $this->code_machine = $this->input->post('code_machine');
        $this->db->where('code_machine', $this->code_machine);
        $query = $this->db->get('tbl_machine');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function save_machine()
    {
        $this->id_machine   = uniqid();
        $this->code_area    = $this->input->post('area');
        $this->code_line    = $this->input->post('line'); // Perbaiki di sini, ubah code_area menjadi line
        $this->code_machine = $this->input->post('code_machine');
        $this->name_machine = $this->input->post('name_machine');

        $data = [
            'id_machine'    => $this->id_machine,
            'code_area'     => $this->code_area,
            'code_line'     => $this->code_line,
            'code_machine'  => $this->code_machine,
            'name_machine'  => $this->name_machine
        ];

        $query = $this->db->insert('tbl_machine', $data);
        if ($query) {
            return [
                'success' => true,
                'message' => 'Data added successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to add data'
            ];
        }
    }

    public function update_machine()
    {
        $this->id_machine   = $this->input->post('id_machine');
        $this->code_area    = $this->input->post('code_area_now');
        $this->code_line    = $this->input->post('code_line_now');
        $this->code_machine = $this->input->post('code_machine');
        $this->name_machine = $this->input->post('name_machine');

        $data = [
            'code_area' => $this->code_area,
            'code_line' => $this->code_line,
            'code_machine' => $this->code_machine,
            'name_machine' => $this->name_machine
        ];

        $update = $this->db->update('tbl_machine', $data, ['id_machine' => $this->id_machine]);

        if ($update) {
            return [
                'success' => true,
                'message' => 'Data Line Updated Successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update line'
            ];
        }
    }

    public function delete_machine()
    {
        $this->id_machine = $this->input->post('id_machine');

        $query = $this->db->delete('tbl_machine', ['id_machine' => $this->id_machine]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Machine Delete Successfully'
            ];
        }
    }

    public function check_code_line_code_machine($code_line, $code_machine)
    {
        $this->db->where('code_line', $code_line);
        $this->db->where('code_machine', $code_machine);
        $query = $this->db->get('tbl_machine');
        return $query->num_rows() > 0;
    }


    public function get_machine_by_line()
    {
        $code_line = $this->input->get('code_line');
        $this->db->where('code_line', $code_line); // Sesuaikan dengan nama kolom yang sesuai dalam tabel 'tbl_machine'
        $query = $this->db->get('tbl_machine'); // Ambil data dari tabel 'tbl_machine' berdasarkan kode garis

        return $query->result();
    }

    public function upload_excel($data)
    {
        $query = $this->db->insert('tbl_machine', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Machine data uploaded successfully'
            ];
        }
    }
}
