<?php

class Users extends CI_Model
{
    // Tidak ada atribut yang diperlukan untuk contoh ini
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
        $this->Auth_m = new Auth();
    }

    public function registration()
    {
        return $this->Auth_m->registration();
    }

    public function login()
    {
        return $this->Auth_m->login();
    }

    public function check_login($session)
    {
        return $this->Auth_m->check_login($session);
    }

    public function logout()
    {
        $this->session->unset_userdata('id_users');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_department');
        $this->session->unset_userdata('id_role');
        $this->session->unset_userdata('name_role');
        redirect('auth/login');
    }
}
