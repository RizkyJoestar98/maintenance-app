<?php

class Category extends CI_Model
{
    public $id_category;
    public $code_category;
    public $name_category;

    //---------------------------------- Category ----------------------------------\\
    public function get_all_category()
    {
        $query = $this->db->get('tbl_category');
        return $query->result();
    }
    public function check_existing_code_category()
    {
        $this->code_category = htmlspecialchars($this->input->post('code_category'), TRUE);
        $this->db->where('code_category', $this->code_category);
        $query = $this->db->get('tbl_category');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_code_category($code_category)
    {
        $this->db->where('code_category', $code_category);
        $query = $this->db->get('tbl_category');
        return $query->num_rows() > 0;
    }

    public function save_category()
    {
        $this->id_category      = uniqid();
        $this->code_category    = htmlspecialchars($this->input->post('code_category'), TRUE);
        $this->name_category    = htmlspecialchars($this->input->post('name_category'), TRUE);

        $data = [
            'id_category'   => $this->id_category,
            'code_category' => $this->code_category,
            'name_category' => $this->name_category
        ];

        $query  = $this->db->insert('tbl_category', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data added successfully'
            ];
        }
    }

    public function update_category()
    {
        $this->id_category      = htmlspecialchars($this->input->post('id_category'), TRUE);
        $this->code_category    = htmlspecialchars($this->input->post('code_category'), TRUE);
        $this->name_category    = htmlspecialchars($this->input->post('name_category'), TRUE);

        $data = [
            'name_category' => $this->name_category
        ];

        $update = $this->db->update('tbl_category', $data, ['id_category' => $this->id_category]);

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

    public function delete_category()
    {
        $this->id_category = $this->input->post('id_category');

        $query = $this->db->delete('tbl_category', ['id_category' => $this->id_category]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Success Delete'
            ];
        }
    }

    public function upload_excel($data)
    {
        $query = $this->db->insert('tbl_category', $data);
        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Category data uploaded successfully'
            ];
        }
    }
    //---------------------------------- Category ----------------------------------\\
}
