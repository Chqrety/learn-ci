<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    protected $productModel;

    function __construct()
    {
        $this->productModel = new ProductModel();
    }

    /*
    fungsi dibawah ini yang bertanggung jawab untuk
    menangani request dari http://localhost:8080/produk/edit/23
    */
    public function edit($id)
    {
        //pada fungsi harus diberi variable untuk menerima value dari parameter
        //contohnya menggunakan variable $id

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah')
        ];

        $this->productModel->update($id, $dataForm);
    }

    public function index()
    {
        return view('produk/index', [
            'products' => $this->productModel->findAll()
        ]);
    }
}
