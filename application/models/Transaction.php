<?php

class Transaction extends CI_Model
{
    public $id_transaction;
    public $transaction_type;
    public $date;
    public $code_material;
    public $qty;
    public $identity_pic;
    public $description;

    public function get_count_goods_receive()
    {
        $this->db->where('transaction_type', 'GR'); // Menetapkan kondisi where
        $count = $this->db->count_all_results('tbl_transaction'); // Menghitung jumlah baris yang memenuhi kriteria

        return $count; // Mengembalikan hasil perhitungan
    }

    public function get_count_goods_issue()
    {
        $this->db->where('transaction_type', 'GI'); // Menetapkan kondisi where
        $count = $this->db->count_all_results('tbl_transaction'); // Menghitung jumlah baris yang memenuhi kriteria

        return $count; // Mengembalikan hasil perhitungan
    }

    public function get_count_history_transaction()
    {
        $count = $this->db->count_all_results('tbl_transaction');
        return $count;
    }
    public function get_all_good_receive()
    {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        $this->db->where('transaction_type', 'GR');
        $query = $this->db->get();
        return $query->result();
    }
    public function save_good_receive()
    {
        $this->id_transaction = $this->input->post('id_transaction');
        $this->transaction_type = 'GR';
        $this->date = $this->input->post('datetime');
        $formatted_datetime = date('Y-m-d H:i:s', strtotime($this->date));
        $this->code_material = $this->input->post('code_material');
        $this->qty = $this->input->post('quantity');
        $this->identity_pic = $this->input->post('identity_pic');
        $this->description = $this->input->post('description');

        $data = [
            'id_transaction'    => $this->id_transaction,
            'transaction_type'  => $this->transaction_type,
            'date'              => $formatted_datetime,
            'code_material'     => $this->code_material,
            'quantity'          => $this->qty,
            'identity_pic'      => $this->identity_pic,
            'description'       => $this->description,
        ];


        // Menggunakan try-catch untuk menangkap kesalahan SQL
        try {
            $query = $this->db->insert('tbl_transaction', $data);
            if ($query) {
                return [
                    'success' => true,
                    'message' => 'Data Receive Success'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to insert data'
                ];
            }
        } catch (Exception $e) {
            // Tangkap pesan kesalahan dari exception
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update_goods_receive()
    {
        $this->id_transaction   = $this->input->post('id_transaction');
        $this->transaction_type = 'GR';
        $this->date             = $this->input->post('date_transaction'); // Perbaikan: Gunakan 'date_transaction'
        $formatted_datetime     = date('Y-m-d H:i:s', strtotime($this->date));
        $this->code_material    = $this->input->post('code_material');
        $this->qty              = $this->input->post('quantity');
        $this->identity_pic     = $this->input->post('identity_pic');
        $this->description      = $this->input->post('description');

        $data = [
            'id_transaction'    => $this->id_transaction,
            'transaction_type'  => $this->transaction_type,
            'date'              => $formatted_datetime,
            'code_material'     => $this->code_material,
            'quantity'          => $this->qty,
            'identity_pic'      => $this->identity_pic,
            'description'       => $this->description,
        ];

        $query = $this->db->update('tbl_transaction', $data, ['id_transaction' => $this->id_transaction]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Issue Success'
            ];
        }
    }

    public function delete_transaction()
    {
        $this->id_transaction = $this->input->post('id_transaction');

        $query = $this->db->delete('tbl_transaction', ['id_transaction' => $this->id_transaction]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Success Delete !'
            ];
        }
    }

    public function get_all_good_issue()
    {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        $this->db->where('transaction_type', 'GI');
        $query = $this->db->get();
        return $query->result();
    }
    public function save_goods_issue()
    {
        $this->id_transaction   = $this->input->post('id_transaction');
        $this->transaction_type = 'GI';
        $this->date             = $this->input->post('datetime');
        $formatted_datetime     = date('Y-m-d H:i:s', strtotime($this->date));
        $this->code_material    = $this->input->post('code_material');
        $this->qty              = $this->input->post('quantity');
        $this->identity_pic     = $this->input->post('identity_pic');
        $this->description      = $this->input->post('description');

        $data = [
            'id_transaction'    => $this->id_transaction,
            'transaction_type'  => $this->transaction_type,
            'date'              => $formatted_datetime,
            'code_material'     => $this->code_material,
            'quantity'          => $this->qty,
            'identity_pic'      => $this->identity_pic,
            'description'       => $this->description,
        ];

        // Menggunakan try-catch untuk menangkap kesalahan SQL
        try {
            $query = $this->db->insert('tbl_transaction', $data);
            if ($query) {
                return [
                    'success' => true,
                    'message' => 'Data Issue Success'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to insert data'
                ];
            }
        } catch (Exception $e) {
            // Tangkap pesan kesalahan dari exception
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function update_goods_issue()
    {
        $this->id_transaction   = $this->input->post('id_transaction');
        $this->transaction_type = 'GI';
        $this->date             = $this->input->post('date_transaction'); // Perbaikan: Gunakan 'date_transaction'
        $formatted_datetime     = date('Y-m-d H:i:s', strtotime($this->date));
        $this->code_material    = $this->input->post('code_material');
        $this->qty              = $this->input->post('quantity');
        $this->identity_pic     = $this->input->post('identity_pic');
        $this->description      = $this->input->post('description');

        $data = [
            'id_transaction'    => $this->id_transaction,
            'transaction_type'  => $this->transaction_type,
            'date'              => $formatted_datetime,
            'code_material'     => $this->code_material,
            'quantity'          => $this->qty,
            'identity_pic'      => $this->identity_pic,
            'description'       => $this->description,
        ];

        $query = $this->db->update('tbl_transaction', $data, ['id_transaction' => $this->id_transaction]);

        if ($query) {
            return [
                'success'   => true,
                'message'   => 'Data Issue Success'
            ];
        }
    }


    public function get_transaction_detail()
    {
        $query = $this->db->get('tbl_transaction');
        return $query->result();
    }

    // Transaction_model
    public function get_filtered_data($start_date, $end_date)
    {
        // Lakukan query ke database untuk mengambil data berdasarkan rentang tanggal
        $this->db->select('*');
        $this->db->from('tbl_transaction'); // Ganti 'your_table' dengan nama tabel yang sesuai
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $query = $this->db->get();

        // Kembalikan hasil query sebagai array objek
        return $query->result();
    }
}
