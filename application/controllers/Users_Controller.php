<?php
require 'vendor/autoload.php';
class Users_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
        $this->load->model('Users');
        $this->load->model('Material');
        $this->load->model('Category');
        $this->load->model('Area');
        $this->load->model('Line');
        $this->load->model('Machine');
        $this->load->model('Uom');
        $this->load->model('Location');
        $this->load->model('Transaction');
        $this->load->model('Manage_users');
    }

    public function index()
    {
        redirect('users/dashboard');
    }

    public function dashboard()
    {
        $session    = $this->session->userdata('email');
        $id_role    = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'             => 'Users | Dashboard',
                'title_page'            => 'Dashboard',
                'bread_crumb'           => 'Dashboard',
                'title_card'            => 'Maintenance Appilication',
                'session'               => $this->Users->check_login($session),
                'id_users'              => $this->session->userdata('id_users'),
                'count_material'        => $this->Material->count_material_list(),
                'count_goods_receive'   => $this->Transaction->get_count_goods_receive(),
                'count_goods_issue'     => $this->Transaction->get_count_goods_issue(),
                'count_history_transaction' => $this->Transaction->get_count_history_transaction()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/dashboard/v_dashboard', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    //-------------------------------- Material List --------------------------------\\
    public function material_list()
    {
        $session = $this->session->userdata('email');
        $id_role    = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Material List',
                'title_page'    => 'Material List',
                'bread_crumb'   => 'Material List',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'material'      => $this->Material->get_all_material(),
                'location'      => $this->Location->get_all_location()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/material/material_list/v_material_list', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function add_material_list()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');

        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Add Material List',
                'title_page'    => 'Material List',
                'title_card'    => 'Form Add Material List',
                'bread_crumb'   => 'Form Add Material List',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'uom'           => $this->Uom->get_all_uom()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/material/material_list/v_add_material_list', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function save_material()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');

        if ($session && ($id_role == 2)) {
            $save   = $this->Material->save_material();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            } else {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }

    public function upload_excel_material()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload_status = $this->upload_doc_material();
            if ($upload_status != false) {
                $inputFileName = 'assets/uploads/material/' . $upload_status;
                $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);
                $count_Rows = 0;
                $success_count = 0;
                $duplicate_count = 0; // Tambahkan variabel untuk menghitung jumlah duplikat
                foreach ($sheet->getRowIterator() as $key => $row) {
                    if ($key != 1) { // Mulai dari baris kedua
                        $code_material          = $spreadsheet->getActiveSheet()->getCell('A' . $row->getRowIndex())->getValue();
                        $code_category          = $spreadsheet->getActiveSheet()->getCell('B' . $row->getRowIndex())->getValue();
                        $part_name              = $spreadsheet->getActiveSheet()->getCell('C' . $row->getRowIndex())->getValue();
                        $part_type              = $spreadsheet->getActiveSheet()->getCell('D' . $row->getRowIndex())->getValue();
                        $part_number_maker      = $spreadsheet->getActiveSheet()->getCell('E' . $row->getRowIndex())->getValue();
                        $part_code_machine      = $spreadsheet->getActiveSheet()->getCell('F' . $row->getRowIndex())->getValue();
                        $part_drawing           = $spreadsheet->getActiveSheet()->getCell('G' . $row->getRowIndex())->getValue();
                        $maker                  = $spreadsheet->getActiveSheet()->getCell('H' . $row->getRowIndex())->getValue();
                        $additional_description = $spreadsheet->getActiveSheet()->getCell('I' . $row->getRowIndex())->getValue();
                        $code_area              = $spreadsheet->getActiveSheet()->getCell('J' . $row->getRowIndex())->getValue();
                        $code_line              = $spreadsheet->getActiveSheet()->getCell('K' . $row->getRowIndex())->getValue();
                        $machine                = $spreadsheet->getActiveSheet()->getCell('L' . $row->getRowIndex())->getValue();
                        $life_time_part         = $spreadsheet->getActiveSheet()->getCell('M' . $row->getRowIndex())->getValue();
                        $qty_on_machine         = $spreadsheet->getActiveSheet()->getCell('N' . $row->getRowIndex())->getValue();
                        $qty_stock              = $spreadsheet->getActiveSheet()->getCell('O' . $row->getRowIndex())->getValue();
                        $uom                    = $spreadsheet->getActiveSheet()->getCell('P' . $row->getRowIndex())->getValue();
                        $location               = $spreadsheet->getActiveSheet()->getCell('Q' . $row->getRowIndex())->getValue();
                        $specification_material = strtoupper(implode(', ', array_filter([$part_name, $part_type, $part_number_maker, $part_code_machine, $part_drawing, $maker, $additional_description])));

                        // Cek apakah kode material kosong
                        if ($code_material == null) {
                            // Jika kosong, cek apakah kode kategori kosong juga
                            if ($code_category == null) {
                                // Jika keduanya kosong, cari kode kategori berdasarkan nama bagian
                                $code_category = $this->Material->get_code_category($part_name);
                            }
                            // Setelah mendapatkan kode kategori, generate kode material berdasarkan kategori
                            $code_material = $this->Material->generate_material_code($code_category);
                        }

                        // Cek apakah spesifikasi ada yang sama persis
                        $check_specification = $this->Material->check_specification_material($specification_material);
                        if (!$check_specification) {
                            // Jika tidak ada yang sama persis, lanjutkan proses
                            // Cek apakah kode material sudah ada
                            $is_exist = $this->Material->check_code_material($code_material);
                            if (!$is_exist) {
                                $id_material = uniqid();
                                $data = array(
                                    'id_material'               => $id_material,
                                    'code_material'             => $code_material,
                                    'code_category'             => $code_category,
                                    'part_name'                 => $part_name,
                                    'part_type'                 => $part_type,
                                    'part_number_maker'         => $part_number_maker,
                                    'part_code_machine'         => $part_code_machine,
                                    'part_drawing'              => $part_drawing,
                                    'maker'                     => $maker,
                                    'additional_description'    => $additional_description,
                                    'specification_material'    => $specification_material,
                                    'code_area'                 => $code_area,
                                    'code_line'                 => $code_line,
                                    'machine'                   => $machine,
                                    'life_time_part'            => $life_time_part,
                                    'qty_on_machine'            => $qty_on_machine,
                                    'qty_stock'                 => $qty_stock,
                                    'uom'                       => $uom,
                                    'location'                  => $location
                                );

                                $this->Material->upload_excel($data);
                                $success_count++;
                            } else {
                                $duplicate_count++; // Tambahkan jumlah duplikat
                            }
                        } else {
                            $duplicate_count++; // Tambahkan jumlah duplikat karena spesifikasi yang sama telah ada
                        }

                        $count_Rows++;
                    }
                }

                unlink($inputFileName);
                $response = [
                    'success' => true,
                    'message' => [
                        'success' => $success_count,
                        'total' => $count_Rows
                    ]
                ];

                if ($duplicate_count > 0) {
                    // Tambahkan pesan untuk duplikat jika ada
                    $response['message']['duplicate_count'] = $duplicate_count;
                }
            } else {
                $response = [
                    'success'   => false,
                    'message'   => 'upload hanya mendukung file dalam format csv|xlsx|xls'
                ];
            }
            echo json_encode($response);
        } else {
            redirect('users/material');
        }
    }

    function upload_doc_material()
    {
        $uploadPath = 'assets/uploads/material/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE); // FOR CREATING DIRECTORY IF ITS NOT EXIST
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('upload_material')) {
            $fileData = $this->upload->data();
            return $fileData['file_name'];
        } else {
            return false;
        }
    }
    //-------------------------------- Material List --------------------------------\\


    //-------------------------------- Category --------------------------------\\
    public function category()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');

        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Category',
                'title_page'    => 'Category',
                'bread_crumb'   => 'Category',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'category'      => $this->Category->get_all_category()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/category/v_category', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }
    public function add_category()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Add Category',
                'title_page'    => 'Category',
                'title_card'    => 'Form Add Category',
                'bread_crumb'   => 'Form Add Category',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users')
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/category/v_add_category');
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function check_code_category()
    {
        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_code_category = $this->Category->check_existing_code_category();
        if ($existing_code_category) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }

    public function save_category()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Category->save_category();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }

    public function upload_excel_category()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload_status = $this->upload_doc_category();
            if ($upload_status != false) {
                $inputFileName = 'assets/uploads/category/' . $upload_status;
                $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);
                $count_Rows = 0;
                $success_count = 0;
                $duplicate_count = 0; // Tambahkan variabel untuk menghitung jumlah duplikat
                foreach ($sheet->getRowIterator() as $key => $row) {
                    if ($key != 1) { // Mulai dari baris kedua
                        $code_category  = $spreadsheet->getActiveSheet()->getCell('A' . $row->getRowIndex())->getValue();
                        $name_category  = $spreadsheet->getActiveSheet()->getCell('B' . $row->getRowIndex())->getValue();

                        // Periksa apakah kode kategori sudah ada
                        $is_exist = $this->Category->check_code_category($code_category);
                        if (!$is_exist) {
                            $id_category = uniqid();
                            $data = array(
                                'id_category'   => $id_category,
                                'code_category' => $code_category,
                                'name_category' => $name_category,
                            );

                            $this->Category->upload_excel($data);
                            $success_count++;
                        } else {
                            $duplicate_count++; // Tambahkan jumlah duplikat
                        }
                        $count_Rows++;
                    }
                }
                unlink($inputFileName);
                $response = [
                    'success' => true,
                    'message' => [
                        'success' => $success_count,
                        'total' => $count_Rows
                    ]
                ];

                if ($duplicate_count > 0) {
                    // Tambahkan pesan untuk duplikat jika ada
                    $response['message']['duplicate_count'] = $duplicate_count;
                }
            } else {
                $response = [
                    'success'   => false,
                    'message'   => 'upload hanya mendukung file dalam format csv|xlsx|xls'
                ];
            }
            echo json_encode($response);
        } else {
            redirect('users/category');
        }
    }

    function upload_doc_category()
    {
        $uploadPath = 'assets/uploads/category/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE); // FOR CREATING DIRECTORY IF ITS NOT EXIST
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('upload_category')) {
            $fileData = $this->upload->data();
            return $fileData['file_name'];
        } else {
            return false;
        }
    }

    public function get_all_category()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'session'   => $this->Users->check_login($session),
                'id_users'  => $this->session->userdata('id_users'),
                'category'  => $this->Category->get_all_category()
            ];
            echo json_encode($data); // Memastikan bahwa data dikirim sebagai JSON
        }
    }
    //-------------------------------- Category --------------------------------\\


    //-------------------------------- Area --------------------------------\\
    public function area()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');

        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Area',
                'title_page'    => 'Area',
                'bread_crumb'   => 'Area',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'area'          => $this->Area->get_all_area()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/area/v_area', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function check_code_area()
    {

        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_code_area = $this->Area->check_existing_code_area();

        if ($existing_code_area) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }

    public function add_area()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Add Area',
                'title_page'    => 'Area',
                'title_card'    => 'Form Add Area',
                'bread_crumb'   => 'Form Add Area',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users')
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/area/v_add_area');
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function save_area()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Area->save_area();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }

    public function get_all_area()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $data = [
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'area'          => $this->Area->get_all_area()
            ];
        }
        echo json_encode($data);
    }
    //-------------------------------- Area --------------------------------\\

    //-------------------------------- Line --------------------------------\\
    public function line()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Line',
                'title_page'    => 'Line',
                'bread_crumb'   => 'Line',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'line'          => $this->Line->get_all_line()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/material/line/v_line', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function add_line()
    {
        $session = $this->session->userdata('email');
        $id_role = $this->session->userdata('id_role');
        if ($session && ($id_role == 2)) {
            $data = [
                'title_tab'     => 'Users | Add Line',
                'title_page'    => 'Line',
                'title_card'    => 'Form Add Line',
                'bread_crumb'   => 'Form Add Line',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'area'          => $this->Area->get_all_area()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/line/v_add_line', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function check_code_line()
    {

        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_code_line = $this->Line->check_existing_code_line();

        if ($existing_code_line) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }

    public function save_line()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Line->save_line();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }
    //-------------------------------- Line --------------------------------\\

    //-------------------------------- Machine --------------------------------\\
    public function machine()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Machine',
                'title_page'    => 'Machine',
                'bread_crumb'   => 'Machine',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'machine'       => $this->Machine->get_all_machine()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view(
                'users/sidebar/v_sidebar',
                $data
            );
            $this->load->view('users/material/machine/v_machine', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function check_code_machine()
    {

        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_code_line = $this->Machine->check_existing_code_machine();

        if ($existing_code_line) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }

    public function add_machine()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');

        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Add Machine',
                'title_page'    => 'Machine',
                'title_card'    => 'Form Add Machine',
                'bread_crumb'   => 'Form Add Machine',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users')
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/machine/v_add_machine');
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function save_machine()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Machine->save_machine();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }

    public function upload_excel_machine()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload_status = $this->upload_doc_machine();
            if ($upload_status != false) {
                $inputFileName = 'assets/uploads/machine/' . $upload_status;
                $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);
                $count_Rows = 0;
                $success_count = 0;
                $duplicate_count = 0; // Tambahkan variabel untuk menghitung jumlah duplikat
                foreach ($sheet->getRowIterator() as $key => $row) {
                    if ($key != 1) { // Mulai dari baris kedua
                        $code_area  = $spreadsheet->getActiveSheet()->getCell('A' . $row->getRowIndex())->getValue();
                        $code_line  = $spreadsheet->getActiveSheet()->getCell('B' . $row->getRowIndex())->getValue();
                        $code_machine  = $spreadsheet->getActiveSheet()->getCell('C' . $row->getRowIndex())->getValue();
                        $name_machine  = $spreadsheet->getActiveSheet()->getCell('D' . $row->getRowIndex())->getValue();

                        // Periksa apakah kode kategori sudah ada
                        $is_exist = $this->Machine->check_code_line_code_machine($code_line, $code_machine);
                        if (!$is_exist) {
                            $id_machine = uniqid();
                            $data = array(
                                'id_machine'    => $id_machine,
                                'code_area'     => $code_area,
                                'code_line'     => $code_line,
                                'code_machine'  => $code_machine,
                                'name_machine'  => $name_machine,
                            );

                            $this->Machine->upload_excel($data);
                            $success_count++;
                        } else {
                            $duplicate_count++; // Tambahkan jumlah duplikat
                        }
                        $count_Rows++;
                    }
                }
                unlink($inputFileName);
                $response = [
                    'success' => true,
                    'message' => [
                        'success' => $success_count,
                        'total' => $count_Rows
                    ]
                ];

                if ($duplicate_count > 0) {
                    // Tambahkan pesan untuk duplikat jika ada
                    $response['message']['duplicate_count'] = $duplicate_count;
                }
                echo json_encode($response);
            } else {
                $response = [
                    'success'   => false,
                    'message'   => 'upload hanya mendukung file dalam format csv|xlsx|xls'
                ];
                echo json_encode($response);
            }
        } else {
            redirect('users/machine');
        }
    }
    function upload_doc_machine()
    {
        $uploadPath = 'assets/uploads/machine/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE); // FOR CREATING DIRECTORY IF ITS NOT EXIST
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('upload_machine')) {
            $fileData = $this->upload->data();
            return $fileData['file_name'];
        } else {
            return false;
        }
    }

    //-------------------------------- Machine --------------------------------\\


    //-------------------------------- UOM --------------------------------\\
    public function uom()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Uom',
                'title_page'    => 'Uom',
                'bread_crumb'   => 'Uom',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'uom'           => $this->Uom->get_all_uom()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/material/uom/v_uom', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function add_uom()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Add Uom',
                'title_page'    => 'Uom',
                'title_card'    => 'Form Add Uom',
                'bread_crumb'   => 'Form Add Uom',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users')
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/uom/v_add_uom');
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function check_code_uom()
    {

        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_code_uom = $this->Uom->check_existing_code_uom();

        if ($existing_code_uom) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }

    public function save_uom()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Uom->save_uom();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }

    //-------------------------------- UOM --------------------------------\\



    //----------------------------- LOCATION --------------------------------\\

    public function location()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Location',
                'title_page'    => 'Location',
                'bread_crumb'   => 'Location',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'location'      => $this->Location->get_all_location()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/material/location/v_location', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function add_location()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Add Location',
                'title_page'    => 'Location',
                'title_card'    => 'Form Add Location',
                'bread_crumb'   => 'Form Add Location',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users')
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/material/location/v_add_location');
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function check_code_location()
    {

        // Lakukan pengecekan ke database untuk memeriksa keberadaan email
        $existing_code_location = $this->Location->check_existing_code_location();

        if ($existing_code_location) {
            // Email sudah digunakan, kirimkan response 'false'
            echo json_encode(FALSE);
        } else {
            // Email tersedia, kirimkan response 'true'
            echo json_encode(TRUE);
        }
    }

    public function save_location()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Location->save_location();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }

    public function upload_excel_location()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $upload_status = $this->upload_doc_location();
            if ($upload_status != false) {
                $inputFileName = 'assets/uploads/location/' . $upload_status;
                $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);
                $count_Rows = 0;
                $success_count = 0;
                $duplicate_count = 0; // Tambahkan variabel untuk menghitung jumlah duplikat
                foreach ($sheet->getRowIterator() as $key => $row) {
                    if ($key != 1) { // Mulai dari baris kedua
                        $code_location  = $spreadsheet->getActiveSheet()->getCell('A' . $row->getRowIndex())->getValue();
                        $name_location  = $spreadsheet->getActiveSheet()->getCell('B' . $row->getRowIndex())->getValue();

                        // Periksa apakah kode kategori sudah ada
                        $is_exist = $this->Location->check_code_location($code_location);
                        if (!$is_exist) {
                            $id_location = uniqid();
                            $data = array(
                                'id_location'   => strtoupper($id_location),
                                'code_location' => strtoupper($code_location),
                                'name_location' => strtoupper($name_location),
                            );

                            $this->Location->upload_excel($data);
                            $success_count++;
                        } else {
                            $duplicate_count++; // Tambahkan jumlah duplikat
                        }
                        $count_Rows++;
                    }
                }
                unlink($inputFileName);
                $response = [
                    'success' => true,
                    'message' => [
                        'success' => $success_count,
                        'total' => $count_Rows
                    ]
                ];

                if ($duplicate_count > 0) {
                    // Tambahkan pesan untuk duplikat jika ada
                    $response['message']['duplicate_count'] = $duplicate_count;
                }
            } else {
                $response = [
                    'success'   => false,
                    'message'   => 'upload hanya mendukung file dalam format csv|xlsx|xls'
                ];
            }
            echo json_encode($response);
        } else {
            redirect('users/location');
        }
    }

    function upload_doc_location()
    {
        $uploadPath = 'assets/uploads/location/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE); // FOR CREATING DIRECTORY IF ITS NOT EXIST
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('upload_location')) {
            $fileData = $this->upload->data();
            return $fileData['file_name'];
        } else {
            return false;
        }
    }

    //----------------------------- LOCATION --------------------------------\\



    //------------------------ DETAIL MATERIAL LIST -----------------------------\\

    public function detail_material_list()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $length = 10;
            $data = [
                'title_tab'     => 'Users | Material List',
                'title_page'    => 'Material List',
                'bread_crumb'   => 'Material List',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'material'      => $this->Material->get_all_material(),
                'location'      => $this->Location->get_all_location()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/material/detail_material_list/v_detail_material_list', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    //------------------------ DETAIL MATERIAL LIST ------------------------------\\



    //---------------------------- TRANSACTION --------------------------------\\

    //---------------------------- GOODS RECEIVE
    public function goods_receive()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {

            $data = [
                'title_tab'     => 'Users | Goods Receive',
                'title_page'    => 'Goods Receive',
                'bread_crumb'   => 'Goods Receive',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'goods_receive' => $this->Transaction->get_all_good_receive()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/transaction/goods_receive/v_goods_receive', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function cek_scan_barcode()
    {
        $barcode = $this->input->post('barcode');

        $cek_scan_barcode = $this->Material->cek_scan_barcode($barcode);

        if ($cek_scan_barcode) {
            $response = [
                'success'   => true,
                'message'   => 'Material Code ' . $barcode . ' Is Found'
            ];
        } else {
            $response = [
                'success'   => false,
                'message'   => 'Material Code ' . $barcode . ' Not Found'
            ];
        }

        echo json_encode($response);
    }

    public function add_goods_receive()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $length = 10;
            $data = [
                'title_tab'     => 'Users | Add Goods Receive',
                'title_page'    => 'Goods Receive',
                'title_card'    => 'Form Add Goods Receive',
                'bread_crumb'   => 'Form Add Goods Receive',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'id_transaction'       => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length)
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/transaction/goods_receive/v_add_goods_receive', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function save_good_receive()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save   = $this->Transaction->save_good_receive();

            if ($save['success'] == true) {
                $response = [
                    'success'   => $save['success'],
                    'message'   => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }
    //---------------------------- GOODS RECEIVE

    //---------------------------- GOODS ISSUE
    public function goods_issue()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Goods Issue',
                'title_page'    => 'Goods Issue',
                'bread_crumb'   => 'Goods Issue',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users'),
                'goods_issue'   => $this->Transaction->get_all_good_issue()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/transaction/goods_issue/v_goods_issue', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function add_goods_Issue()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $length = 10;
            $data = [
                'title_tab'         => 'Users | Add Goods Issue',
                'title_page'        => 'Goods Issue',
                'title_card'        => 'Form Add Goods Issue',
                'bread_crumb'       => 'Form Add Goods Issue',
                'session'           => $this->Users->check_login($session),
                'id_users'          => $this->session->userdata('id_users'),
                'id_transaction'    => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length)
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/transaction/goods_issue/v_add_goods_issue', $data);
            $this->load->view('template/footer');
        } else {
            redirect('auth/login');
        }
    }

    public function save_goods_issue()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $save = $this->Transaction->save_goods_issue();

            if ($save['success'] == true) {
                $response = [
                    'success' => $save['success'],
                    'message' => $save['message']
                ];
            } else {
                // Jika ada kesalahan, tampilkan pesan kesalahan
                $response = [
                    'success' => false,
                    'message' => $save['message']
                ];
            }
        } else {
            redirect('auth/login');
        }

        echo json_encode($response);
    }
    //---------------------------- GOODS ISSUE



    //---------------------------- HISTORY TRANSACTION

    public function history_transaction()
    {
        $session = $this->session->userdata('email');

        if ($session) {
            $data = [
                'title_tab'             => 'Users | History Transaction',
                'title_page'            => 'History Transaction',
                'bread_crumb'           => 'History Transaction',
                'session'               => $this->Users->check_login($session),
                'id_users'              => $this->session->userdata('id_users'),
                'transaction_detail'    => $this->Transaction->get_transaction_detail()
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar', $data);
            $this->load->view('users/transaction/history/v_history', $data);
            $this->load->view('template/footer');
        }
    }

    public function search_filter()
    {
        // Ambil nilai dari input form
        $start_date = $this->input->post('start_filter');
        $end_date = $this->input->post('end_filter');

        // Lakukan validasi tanggal
        if ($start_date == '' || $end_date == '') {
            $response = [
                'success'   => false,
                'message'   => 'Pilih Tanggal Awal dan Tanggal Akhir', // menggunakan toastr info
                'date'      => null
            ];
        } else if ($start_date > $end_date) {
            $response = [
                'success'   => false,
                'message'   => 'End date cannot be earlier than start date.', // menggunakan toastr error
                'date'      => false
            ];
        } else {
            // Lakukan pencarian data berdasarkan rentang tanggal
            $filtered_data = $this->Transaction->get_filtered_data($start_date, $end_date);

            // Jika tidak ada data yang ditemukan
            if (empty($filtered_data)) {
                $response = [
                    'success' => true,
                    'message' => 'No data found for the selected date range.', // menggunakan toastr info
                    'data'    => null
                ];
            } else {
                // Tambahkan nomor urutan (no) ke setiap baris data
                $counter = 1;
                foreach ($filtered_data as &$row) {
                    $row->no = $counter++;
                }

                // Kembalikan data beserta nomor urutan sebagai bagian dari respons
                $response = [
                    'success' => true,
                    'message' => 'Data successfully retrieved.', // menggunakan toastr success
                    'data'    => $filtered_data
                ];
            }
        }

        // Keluarkan respons sebagai JSON
        echo json_encode($response);
    }

    //---------------------------- HISTORY TRANSACTION



    //------------------------------- CHANGE PASSWORD ---------------------------------------\\

    public function change_password()
    {
        $session    = $this->session->userdata('email');
        $role       = $this->session->userdata('id_role');
        if ($session && $role == 2) {
            $data = [
                'title_tab'     => 'Users | Change Password',
                'title_page'    => 'Change Password',
                'title_card'    => 'Change Password',
                'bread_crumb'   => 'Change Password',
                'session'       => $this->Users->check_login($session),
                'id_users'      => $this->session->userdata('id_users')
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/datatable');
            $this->load->view('users/sidebar/v_sidebar');
            $this->load->view('users/change_password/v_change_password');
            $this->load->view('template/footer');
        }
    }

    public function save_change_password()
    {
        $session_email          = $this->session->userdata('email');
        $old_password           = $this->input->post('old_password');
        $new_password           = $this->input->post('new_password');
        $retype_new_password    = password_hash($this->input->post('retype_new_password'), PASSWORD_DEFAULT);

        $cek_old_password   = $this->Auth->check_login($session_email);

        if ($cek_old_password) {
            if (password_verify($old_password, $cek_old_password['password'])) {
                $data = [
                    'password'  => $retype_new_password
                ];

                $save   = $this->Auth->change_password($data);

                if ($save) {
                    $response = [
                        'success'   => true,
                        'message'   => 'Password Success Change'
                    ];
                }
            } else {
                $response = [
                    'success'   => false,
                    'message'   => 'Password Lama Kamu Salah, Tidak Cocok'
                ];
            }
        }
        echo json_encode($response);
    }

    //------------------------------- CHANGE PASSWORD ---------------------------------------\\

    public function post_to_pdf()
    {
        $material_codes = $this->input->post('material_codes');

        if (!empty($material_codes)) {
            // Simpan material codes dalam sesi
            $this->session->set_userdata('material_codes', $material_codes);

            // Respon sukses
            $response = [
                'success' => true,
                'message' => 'Material codes received successfully',
                'data' => $material_codes
            ];
        } else {
            // Respon gagal jika tidak ada material codes
            $response = [
                'success' => false,
                'message' => 'No material codes received'
            ];
        }

        echo json_encode($response);
    }

    public function print_label_pdf()
    {
        $this->load->library('pdfgenerator');

        // Ambil material codes dari sesi
        $material_codes = $this->session->userdata('material_codes');

        if (!empty($material_codes)) {


            // Query database untuk mendapatkan data sesuai dengan material codes yang dipilih
            $selected_data = $this->Material->get_data_by_code_material($material_codes);

            if (!empty($selected_data)) {
                // Jika data ditemukan, lanjutkan dengan menghasilkan PDF
                // ...
                // (kode untuk menghasilkan PDF)
                // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
                $this->load->library('pdfgenerator');

                // title dari pdf
                $this->data['title_pdf'] = 'Print Label Material Code';
                $this->data['material_codes'] = $selected_data;

                // filename dari pdf ketika didownload
                $file_pdf = 'Print Label Material Code';
                // setting paper
                $paper = 'A4';
                //orientasi paper potrait / landscape
                $orientation = "portrait";

                $html = $this->load->view('users/material/material_list/print_label_pdf', $this->data, true);

                // run dompdf
                $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

                // Hapus material codes dari sesi setelah digunakan
                $this->session->unset_userdata('material_codes');

                // Respon sukses
                $response = [
                    'success' => true,
                    'message' => 'PDF generated successfully'
                ];
            } else {
                // Respon gagal jika data tidak ditemukan
                $response = [
                    'success' => false,
                    'message' => 'No data found for selected material codes'
                ];
            }
        } else {
            // Respon gagal jika tidak ada material codes
            $response = [
                'success' => false,
                'message' => 'No material codes available'
            ];
        }

        echo json_encode($response);
    }

    public function material_list_pdf()
    {
        $this->load->library('pdfgenerator');

        // Ambil material codes dari sesi
        $material_codes = $this->session->userdata('material_codes');

        if (!empty($material_codes)) {


            // Query database untuk mendapatkan data sesuai dengan material codes yang dipilih
            $selected_data = $this->Material->get_data_by_code_material($material_codes);

            if (!empty($selected_data)) {
                // Jika data ditemukan, lanjutkan dengan menghasilkan PDF
                // ...
                // (kode untuk menghasilkan PDF)
                // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
                $this->load->library('pdfgenerator');

                // title dari pdf
                $this->data['title_pdf'] = 'Materia List';
                $this->data['material_codes'] = $selected_data;

                // filename dari pdf ketika didownload
                $file_pdf = 'Material List';
                // setting paper
                $paper = 'A4';
                //orientasi paper potrait / landscape
                $orientation = "landscape";

                $html = $this->load->view('users/material/material_list/material_list_pdf', $this->data, true);

                // run dompdf
                $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

                // Hapus material codes dari sesi setelah digunakan
                $this->session->unset_userdata('material_codes');

                // Respon sukses
                $response = [
                    'success' => true,
                    'message' => 'PDF generated successfully'
                ];
            } else {
                // Respon gagal jika data tidak ditemukan
                $response = [
                    'success' => false,
                    'message' => 'No data found for selected material codes'
                ];
            }
        } else {
            // Respon gagal jika tidak ada material codes
            $response = [
                'success' => false,
                'message' => 'No material codes available'
            ];
        }

        echo json_encode($response);
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
