<?php

class Area extends CI_Model
{
    public $id_area;
    public $code_area;
    public $name_area;

    public function get_all_area()
    {
        $query = $this->db->get('tbl_area');
        return $query->result();
    }
    public function check_existing_code_area()
    {
        $this->code_area = htmlspecialchars($this->input->post('code_area'), TRUE);
        $this->db->where('code_area', $this->code_area);
        $query = $this->db->get('tbl_area');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function save_area()
    {
        $this->id_area      = uniqid();
        $this->code_area    = strtoupper(htmlspecialchars($this->input->post('code_area'), TRUE));
        $this->name_area    = strtoupper(htmlspecialchars($this->input->post('name_area'), TRUE));

        $data = [
            'id_area'   => $this->id_area,
            'code_area' => $this->code_area,
            'name_area' => $this->name_area
        ];

        $query  = $this->db->insert('tbl_area', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data added successfully'
            ];
        }
    }

    public function update_area()
    {
        $this->id_area      = htmlspecialchars($this->input->post('id_area'), TRUE);
        $this->code_area    = htmlspecialchars($this->input->post('code_area'), TRUE);
        $this->name_area    = htmlspecialchars($this->input->post('name_area'), TRUE);

        $data = [
            'name_area' => $this->name_area
        ];

        $update = $this->db->update('tbl_area', $data, ['id_area' => $this->id_area]);

        if ($update) {
            return [
                'success' => true,
                'message' => 'Data Area Success Update'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update area'
            ];
        }
    }

    public function delete_area()
    {
        $this->id_area = $this->input->post('id_area');

        $query = $this->db->delete('tbl_area', ['id_area' => $this->id_area]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Success Delete'
            ];
        }
    }
}
