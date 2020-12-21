<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserServersideModel extends Model
{
    // Property yang dibutuhkan
    protected $table = "user";
    protected $column_order = [null, 'id_user', 'nama_user', 'tgllahir_user', 'nama_kewarganegaraan', null];
    protected $column_search = ['nama_user', 'tgllahir_user', 'nama_kewarganegaraan'];
    protected $order = ['nama_user' => 'asc'];
    protected $request;
    protected $model;

    function __construct(RequestInterface $request, $arguments = null)
    {
        parent::__construct();
        $this->request = $request;
    }

    private function _get_datatables_query()
    {
        // Mendefinisikan tabel dan join ke tabel lain
        $this->model = $this->table($this->table)->select('id_user, nama_user, tgllahir_user, nama_kewarganegaraan')->join('kewarganegaraan', 'kewarganegaraan.id_kewarganegaraan = user.id_kewarganegaraan-user');

        $i = 0;
        // Jika terdapat sebuah request pencarian
        if ($this->request->getVar('search')['value']) {
            foreach ($this->column_search as $column) {
                if ($i == 0) {
                    $this->model->groupStart();
                    $this->model->like($column, $this->request->getVar('search')['value']);
                } else {
                    $this->model->orLike($column, $this->request->getVar('search')['value']);
                }
                // Jika query sudah mencari ke semua kolom
                if (count($this->column_search) - 1 == $i) {
                    $this->model->groupEnd();
                }
                $i++;
            }
        }

        // Jika terdapat sebuah request pengurutan
        if ($this->request->getVar('order')) {
            // Jika diurutkan pada tabel ke-5
            if ($this->column_order[$this->request->getVar('order')['0']['column']] != null) {
                $this->model->orderBy($this->column_order[$this->request->getVar('order')['0']['column']], $this->request->getVar('order')['0']['dir']);
            }
        }

        // Jika tidak ada request pengurutan maka akan diurutkan sesuai nama_user
        else if (isset($this->order)) {
            $order = $this->order;
            $this->model->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        // Me-limit agar tidak semua data langsung di-load
        if ($this->request->getVar('length') != -1) {
            $this->model->limit($this->request->getVar('length'), $this->request->getVar('start'));
        }
        // Mengembalikan data sebagai array
        return $this->model->get()->getResultArray();
    }

    function count_filtered()
    {
        // Jumlah data yang ditemukan ketika ada filter
        $this->_get_datatables_query();
        return $this->model->countAllResults();
    }

    public function count_all()
    {
        // Menghitung semua data yang ada
        $tbl_storage = $this->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
