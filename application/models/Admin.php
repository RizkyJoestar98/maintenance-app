<?php
require_once(APPPATH . 'models/Auth.php');

class Admin extends Auth
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category');
        $this->load->model('Area');
        $this->load->model('Line');
        $this->load->model('Machine');
        $this->load->model('Uom');
        $this->load->model('Material');
        $this->load->model('Transaction');
        $this->load->model('Manage_users');
        $this->load->model('Location');
    }

    public function generate_material_code()
    {
        return $this->Material->generate_material_code();
    }

    public function generate_material_code_upload($code_category)
    {
        return $this->Material->generate_material_code($code_category);
    }

    public function get_code_category($part_name)
    {
        return $this->Material->get_code_category($part_name);
    }

    public function save_material()
    {
        return $this->Material->save_material();
    }
    public function update_material()
    {
        return $this->Material->update_material();
    }
    public function delete_material()
    {
        return $this->Material->delete_material();
    }
    public function get_all_material()
    {
        return $this->Material->get_all_material();
    }
    public function get_count_material()
    {
        return $this->Material->count_material_list();
    }
    public function get_count_goods_receive()
    {
        return $this->Transaction->get_count_goods_receive();
    }
    public function get_count_goods_issue()
    {
        return $this->Transaction->get_count_goods_issue();
    }
    public function upload_material($data)
    {
        return $this->Material->upload_excel($data);
    }
    public function check_code_material($code_material)
    {
        return $this->Material->check_code_material($code_material);
    }

    //---------------------------------- Category ----------------------------------\\
    public function get_all_category()
    {
        return $this->Category->get_all_category();
    }
    public function check_existing_code_category()
    {
        return $this->Category->check_existing_code_category();
    }
    public function check_code_category($code_category)
    {
        return $this->Category->check_code_category($code_category);
    }
    public function save_category()
    {
        return $this->Category->save_category();
    }
    public function update_category()
    {
        return $this->Category->update_category();
    }
    public function delete_category()
    {
        return $this->Category->delete_category();
    }
    public function upload_category($data)
    {
        return $this->Category->upload_excel($data);
    }
    //---------------------------------- Category ----------------------------------\\

    //---------------------------------- Area ----------------------------------\\
    public function get_all_area()
    {
        return $this->Area->get_all_area();
    }
    public function check_existing_code_area()
    {
        return $this->Area->check_existing_code_area();
    }
    public function save_area()
    {
        return $this->Area->save_area();
    }
    public function update_area()
    {
        return $this->Area->update_area();
    }
    public function delete_area()
    {
        return $this->Area->delete_area();
    }
    //---------------------------------- Area ----------------------------------\\

    //---------------------------------- Line ----------------------------------\\
    public function get_all_line()
    {
        return $this->Line->get_all_line();
    }
    public function get_line_by_area()
    {
        return $this->Line->get_line_by_area();
    }
    public function check_existing_code_line()
    {
        return $this->Line->check_existing_code_line();
    }
    public function save_line()
    {
        return $this->Line->save_line();
    }
    public function update_line()
    {
        return $this->Line->update_line();
    }
    public function delete_line()
    {
        return $this->Line->delete_line();
    }
    //---------------------------------- Line ----------------------------------\\


    //---------------------------------- Machine ----------------------------------\\
    public function get_all_machine()
    {
        return $this->Machine->get_all_machine();
    }
    public function check_existing_code_machine()
    {
        return $this->Machine->check_existing_code_machine();
    }
    public function save_machine()
    {
        return $this->Machine->save_machine();
    }
    public function update_machine()
    {
        return $this->Machine->update_machine();
    }
    public function delete_machine()
    {
        return $this->Machine->delete_machine();
    }
    public function check_code_line_code_machine($code_line, $code_machine)
    {
        return $this->Machine->check_code_line_code_machine($code_line, $code_machine);
    }
    public function upload_machine($data)
    {
        return $this->Machine->upload_excel($data);
    }
    public function get_machine_by_line()
    {
        return $this->Machine->get_machine_by_line();
    }
    //---------------------------------- Machine ----------------------------------\\

    //---------------------------------- UOM ----------------------------------\\
    public function get_all_uom()
    {
        return $this->Uom->get_all_uom();
    }
    public function check_existing_code_uom()
    {
        return $this->Uom->check_existing_code_uom();
    }
    public function save_uom()
    {
        return $this->Uom->save_uom();
    }
    public function update_uom()
    {
        return $this->Uom->update_uom();
    }
    public function delete_uom()
    {
        return $this->Uom->delete_uom();
    }
    //---------------------------------- UOM ----------------------------------\\



    //---------------------------------- UOM ----------------------------------\\
    public function get_all_goods_receive()
    {
        return $this->Transaction->get_all_good_receive();
    }
    public function save_goods_receive()
    {
        return $this->Transaction->save_good_receive();
    }

    public function update_goods_receive()
    {
        return $this->Transaction->update_goods_receive();
    }

    public function delete_transaction()
    {
        return $this->Transaction->delete_transaction();
    }

    public function get_all_goods_issue()
    {
        return $this->Transaction->get_all_good_issue();
    }
    public function save_goods_issue()
    {
        return $this->Transaction->save_goods_issue();
    }

    public function update_goods_issue()
    {
        return $this->Transaction->update_goods_issue();
    }

    public function get_transaction_detail()
    {
        return $this->Transaction->get_transaction_detail();
    }

    public function get_count_users()
    {
        return $this->Manage_users->get_count_users();
    }
    public function manage_users()
    {
        return $this->Manage_users->get_all_users();
    }

    public function update_manage_users()
    {
        return $this->Manage_users->update_manage_users();
    }

    public function get_all_location()
    {
        return $this->Location->get_all_location();
    }

    public function check_existing_code_location()
    {
        return $this->Location->check_existing_code_location();
    }
    public function check_code_location($code_location)
    {
        return $this->Location->check_code_location($code_location);
    }

    public function save_location()
    {
        return $this->Location->save_location();
    }
    public function update_location()
    {
        return $this->Location->update_location();
    }
    public function delete_location()
    {
        return $this->Location->delete_location();
    }

    public function upload_location($data)
    {
        return $this->Location->upload_excel($data);
    }
}
