<?php

class Location extends CI_Model
{
    public $id_location;
    public $code_location;
    public $name_location;

    //---------------------------------- Category ----------------------------------\\
    public function get_all_location()
    {
        $query = $this->db->get('tbl_location');
        return $query->result();
    }

    public function check_existing_code_location()
    {
        $this->code_location = htmlspecialchars($this->input->post('code_location'), TRUE);
        $this->db->where('code_location', $this->code_location);
        $query = $this->db->get('tbl_location');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_code_location($code_location)
    {
        $this->db->where('code_location', $code_location);
        $query = $this->db->get('tbl_location');
        return $query->num_rows() > 0;
    }


    public function save_location()
    {
        $this->id_location      = uniqid();
        $this->code_location    = htmlspecialchars($this->input->post('code_location'), TRUE);
        $this->name_location    = htmlspecialchars($this->input->post('name_location'), TRUE);

        $data = [
            'id_location'   => $this->id_location,
            'code_location' => $this->code_location,
            'name_location' => $this->name_location
        ];

        $query  = $this->db->insert('tbl_location', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data added successfully'
            ];
        }
    }

    public function update_location()
    {
        $this->id_location      = htmlspecialchars($this->input->post('id_location'), TRUE);
        $this->code_location    = htmlspecialchars($this->input->post('code_location'), TRUE);
        $this->name_location    = htmlspecialchars($this->input->post('name_location'), TRUE);

        $data = [
            'name_location' => $this->name_location
        ];

        $update = $this->db->update('tbl_location', $data, ['id_location' => $this->id_location]);

        if ($update) {
            return [
                'success' => true,
                'message' => 'Data Category Success Update'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update category'
            ];
        }
    }

    public function delete_location()
    {
        $this->id_location = $this->input->post('id_location');

        $query = $this->db->delete('tbl_location', ['id_location' => $this->id_location]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Success Delete'
            ];
        }
    }

    public function upload_excel($data)
    {
        $query = $this->db->insert('tbl_location', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Category data uploaded successfully'
            ];
        }
    }
    //---------------------------------- Category ----------------------------------\\
}
