<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use Dompdf\Dompdf;

class ProdukController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    public function index()
    {
        helper(['form', 'url']);

        $data = [
            'products' => $this->model->findAll()
        ];

        return view('produk/index', $data);
    }

    public function create()
    {
        $dataFoto = $this->request->getFile('foto');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah')
        ];

        if ($dataFoto && $dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataFoto->move('img/', $fileName);

            $data['foto'] = $fileName;
        }

        $this->model->insert($data);

        return redirect()->to(base_url('produk'))->with('success', 'Data Berhasil Ditambah');
    }

    public function edit($id = null)
    {
        $dataProduk = $this->model->find($id);

        if (!$dataProduk) {
            return redirect()->to(base_url('produk'))->with('failed', 'Produk tidak ditemukan');
        }

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah')
        ];

        if ($this->request->getPost('check') == 1) {
            if ($dataProduk['foto'] != '' and file_exists("img/" . $dataProduk['foto'] . "")) {
                unlink("img/" . $dataProduk['foto']);
            }

            $dataFoto = $this->request->getFile('foto');

            if ($dataFoto->isValid()) {
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('img/', $fileName);

                $dataForm['foto'] = $fileName;
            }
        }

        $this->model->update($id, $dataForm);

        return redirect()->to(base_url('produk'))->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id = null)
    {
        $dataProduk = $this->model->find($id);

        if (!$dataProduk) {
            return redirect()->to(base_url('produk'))->with('failed', 'Produk tidak ditemukan');
        }

        $this->model->delete($id);

        return redirect()->to(base_url('produk'))->with('success', 'Data Berhasil Dihapus');
    }

    public function download()
    {
        $products = $this->model->findAll();

        $html = view('produk/download_pdf', [
            'products' => $products
        ]);

        $filename = date('Y-m-d-H-i-s') . '-produk.pdf';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename, [
            'Attachment' => true
        ]);
    }
}