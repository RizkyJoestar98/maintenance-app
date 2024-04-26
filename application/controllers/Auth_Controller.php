<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
    }

    public function index()
    {
        redirect('auth/login');
    }

    public function login()
    {
        $session    = $this->session->userdata('email');
        $id_role    = $this->session->userdata('id_role');
        if ($session == null && $id_role == null) {
            $this->load->view('auth/auth_login');
        } else {
            $response = [
                'email'         => $this->session->userdata('email'),
                'id_users'      => $this->session->userdata('id_users'),
                'id_department' => $this->session->userdata('id_department'),
                'id_role'       => $this->session->userdata('id_role')
            ];

            if ($response['id_role'] == 1) {
                redirect('admin/dashboard');
            } elseif ($response['id_role'] == 2) {
                redirect('users/dashboard');
            }
        }
    }

    public function verify_login()
    {
        $verify = $this->Auth->login();

        // If login is successful, include session data in the response
        if ($verify['success']) {
            // Response data
            $response = [
                'success'   => true,
                'message'   => $verify['message'],
                'email'     => $this->session->userdata('email'),
                'id_users'  => $this->session->userdata('id_users'),
                'id_role'   => $this->session->userdata('id_role'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => $verify['message'],
            ];
        }
        echo json_encode($response);
    }


    public function registration()
    {
        $session = $this->session->userdata('email');

        if ($session == null) {
            $this->load->view('auth/auth_registration');
        } else {
            $response = [
                'email'         => $this->session->userdata('email'),
                'id_users'      => $this->session->userdata('id_users'),
                'id_department' => $this->session->userdata('id_department'),
                'id_role'       => $this->session->userdata('id_role')
            ];

            if ($response['id_department'] == 1 && $response['id_role'] == 1) {
                redirect('admin/dashboard');
            } elseif ($response['id_department'] == 1 && $response['id_role'] == 2) {
                echo "Redirec Users Maintenance";
            } elseif ($response['id_department'] == 2 && $response['id_role'] == 1) {
                echo "Redirec Admin Production";
            } elseif ($response['id_department'] == 2 && $response['id_role'] == 2) {
                echo "Redirec Users Production";
            }
        }
    }

    public function check_email()
    {

        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_email = $this->Auth->check_existing_email();

        if ($existing_email) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }
    public function save_registration()
    {
        $save = $this->Auth->registration();

        if ($save['success'] == true) {
            $response = [
                'success'   => $save['success'],
                'message'   => $save['message']
            ];
        } else {
            $response = [
                'success'   => false,
                'message'   => form_error()
            ];
        }
        echo json_encode($response);
    }
}
