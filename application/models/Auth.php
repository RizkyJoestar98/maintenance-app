<?php
class Auth extends CI_Model
{
    public $name;
    public $email;
    public $password;

    public function login()
    {
        $this->email    = htmlspecialchars($this->input->post('email'), TRUE);
        $this->password = htmlspecialchars($this->input->post('password'), TRUE);

        $check_login    = $this->check_login($this->email);

        if ($check_login) {
            if (password_verify($this->password, $check_login['password'])) {
                if ($check_login['is_active'] == 1) {
                    // Set session if login is successful
                    $session_data = [
                        'email'         => $check_login['email'],
                        'id_users'      => $check_login['id_users'],
                        'id_role'       => $check_login['id_role'],
                    ];
                    $this->session->set_userdata($session_data);
                    if ($check_login['id_role'] == 1) {
                        return [
                            'success'   => true,
                            'message'   => 'Login Successfully as Maintenance Admin',
                            // 'id_role'   => 1
                        ];
                    } elseif ($check_login['id_role'] == 2) {
                        return [
                            'success'   => true,
                            'message'   => 'Login Successfully as Maintenance PIC',
                            // 'id_role'   => 2
                        ];
                    } elseif ($check_login['id_role'] == 3) {
                        return [
                            'success'   => true,
                            'message'   => 'Login Successfully as Maintenance Mechanic',
                            // 'id_role'   => 3
                        ];
                    }
                } else {
                    return [
                        'success'   => false,
                        'message'   => 'Account Not Active'
                    ];
                }
            } else {
                return [
                    'success'   => false,
                    'message'   => 'Email Or Password Is Wrong'
                ];
            }
        } else {
            return [
                'success'   => false,
                'message'   => 'Email Not Found'
            ];
        }
    }

    public function registration()
    {
        // Mengatur zona waktu ke Waktu Indonesia Barat (WIB)
        date_default_timezone_set('Asia/Jakarta');

        // Mendapatkan datetime saat ini di zona waktu Jakarta
        $current_datetime = date('Y-m-d H:i:s');

        $this->name     = htmlspecialchars($this->input->post('name'), TRUE);
        $this->email    = htmlspecialchars($this->input->post('email'), TRUE);
        $this->password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $data = [
            'id_users'      => uniqid(),
            'name'          => $this->name,
            'email'         => $this->email,
            'password'      => $this->password,
            'id_role'       => 0,
            'is_active'     => 0,
            'date_created'  => $current_datetime,
            'last_login'     => $current_datetime
        ];

        $query = $this->db->insert('tbl_users', $data);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Registration Success'
            ];
        }
    }
    public function check_login($email)
    {
        $query = $this->db->get_where('tbl_users', ['email' => $email]);
        return $query->row_array();
    }
    public function check_existing_email()
    {
        $this->email = htmlspecialchars($this->input->post('email'), TRUE);
        $this->db->where('email', $this->email);
        $query = $this->db->get('tbl_users');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function rules()
    {
        return [
            [
                'field'     => 'email',
                'label'     => 'Email',
                'rules'     => 'is_unique[tbl_users.email]',
                'errors'    => [
                    'is_unique' => 'Email has been used'
                ]
            ]
        ];
    }

    public function change_password($new_password)
    {
        $query = $this->db->update('tbl_users', $new_password, ['id_users' => $this->session->userdata('id_users')]);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function inheritance()
    {
        return 'Warisan';
    }
}
