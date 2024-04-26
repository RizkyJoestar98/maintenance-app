<?php

class Uom extends CI_Model
{
    public $id_uom;
    public $code_uom;
    public $name_uom;

    public function get_all_uom()
    {
        $query = $this->db->get('tbl_uom');
        return $query->result();
    }

    public function check_existing_code_uom()
    {
        $code_uom = $this->input->post('code_uom');
        $this->db->where('code_uom', $code_uom);
        $query = $this->db->get('tbl_uom');
        return $query->num_rows() > 0;
    }

    public function save_uom()
    {
        $this->id_uom   = uniqid();
        $this->code_uom = htmlspecialchars($this->input->post('code_uom'));
        $this->name_uom = htmlspecialchars($this->input->post('name_uom'));

        $data = [
            'id_uom'    => $this->id_uom,
            'code_uom'  => $this->code_uom,
            'name_uom'  => $this->name_uom
        ];

        $query = $this->db->insert('tbl_uom', $data);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data added successfully'
            ];
        }
    }

    public function update_uom()
    {
        $this->id_uom   = $this->input->post('id_uom');
        $this->code_uom = $this->input->post('code_uom');
        $this->name_uom = $this->input->post('name_uom');

        $data = [
            'code_uom'  => strtoupper($this->code_uom),
            'name_uom'  => strtoupper($this->name_uom)
        ];

        $query = $this->db->update('tbl_uom', $data, ['id_uom' => $this->id_uom]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Update successfully'
            ];
        }
    }

    public function delete_uom()
    {
        $this->id_uom = $this->input->post('id_uom');

        $query = $this->db->delete('tbl_uom', ['id_uom' => $this->id_uom]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Line Delete Successfully'
            ];
        }
    }
}
