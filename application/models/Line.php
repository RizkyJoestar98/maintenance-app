<?php

class Line extends CI_Model
{
    public $id_line;
    public $code_area;
    public $code_line;
    public $name_line;

    public function get_all_line()
    {
        $this->db->select('*');
        $this->db->from('tbl_line');
        $this->db->join('tbl_area', 'tbl_area.code_area = tbl_line.code_area', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    public function check_existing_code_line()
    {
        $this->code_line = htmlspecialchars($this->input->post('code_line'), TRUE);
        $this->db->where('code_line', $this->code_line);
        $query = $this->db->get('tbl_line');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function save_line()
    {
        $this->id_line      = uniqid();
        $this->code_area    = strtoupper($this->input->post('area'));
        $this->code_line    = strtoupper(htmlspecialchars($this->input->post('code_line')));
        $this->name_line    = strtoupper(htmlspecialchars($this->input->post('name_line')));

        $data = [
            'id_line'       => $this->id_line,
            'code_area'     => $this->code_area,
            'code_line'     => $this->code_line,
            'name_line'     => $this->name_line
        ];

        $query  = $this->db->insert('tbl_line', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data added successfully'
            ];
        }
    }

    public function update_line()
    {
        $this->id_line      = $this->input->post('id_line');
        $this->code_area    = $this->input->post('code_area');
        $this->code_line    = $this->input->post('code_line');
        $this->name_line    = $this->input->post('name_line');

        $data = [
            'code_area' => $this->code_area,
            'code_line' => $this->code_line,
            'name_line' => $this->name_line
        ];

        $update = $this->db->update('tbl_line', $data, ['id_line' => $this->id_line]);

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

    public function delete_line()
    {
        $this->id_line = $this->input->post('id_line');

        $query = $this->db->delete('tbl_line', ['id_line' => $this->id_line]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Line Delete Successfully'
            ];
        }
    }

    public function get_line_by_area()
    {
        $code_area  = $this->input->get('code_area'); // Mengambil kode area dari parameter GET

        // Asumsikan Anda memiliki tabel 'lines' yang menyimpan data baris
        $this->db->where('code_area', $code_area);
        $query = $this->db->get('tbl_line'); // Mengambil data dari tabel 'lines' berdasarkan kode area

        return $query->result();
    }
}
