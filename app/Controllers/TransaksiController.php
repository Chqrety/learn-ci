<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\RajaOngkirService;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->cart = service('cart');
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        $data = [
            'items' => $this->cart->contents(),
            'total' => $this->cart->total()
        ];

        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $this->cart->insert([
            'id' => $this->request->getPost('id'),
            'qty' => 1,
            'price' => $this->request->getPost('harga'),
            'name' => $this->request->getPost('nama'),
            'options' => [
                'foto' => $this->request->getPost('foto')
            ]
        ]);

        session()->setFlashdata(
            'success',
            'Produk berhasil ditambahkan ke keranjang.
            <a href="' . base_url('keranjang') . '">Lihat</a>'
        );

        return redirect()->to(base_url('/'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $item) {
            $qty = $this->request->getPost('qty' . $i++);

            $this->cart->update([
                'rowid' => $item['rowid'],
                'qty' => $qty
            ]);
        }

        session()->setFlashdata(
            'success',
            'Keranjang berhasil diperbarui'
        );

        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);

        session()->setFlashdata(
            'success',
            'Produk berhasil dihapus dari keranjang'
        );

        return redirect()->to(base_url('keranjang'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();

        session()->setFlashdata(
            'success',
            'Keranjang berhasil dikosongkan'
        );

        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
    {
        $data = [
            'items' => $this->cart->contents(),
            'total' => $this->cart->total()
        ];

        return view('v_checkout', $data);
    }

    public function destinations()
    {
        $search = $this->request->getGet('q');

        // 1. Buat key cache unik berdasarkan keyword pencarian (lowercase + md5)
        $searchKey = !empty($search) ? strtolower(trim($search)) : 'all';
        $cacheKey = 'cache_dest_' . md5($searchKey);

        // 2. Cek apakah hasil olahan data keyword ini sudah ada di cache lokal
        if ($cachedResults = cache($cacheKey)) {
            // Jika ada, langsung return data dari cache (0 kuota API terpakai!)
            return $this->response->setJSON([
                'results' => $cachedResults
            ]);
        }

        // 3. Jika tidak ada di cache, jalankan service API aslimu
        $service = new RajaOngkirService();
        $response = $service->getDestination($search);

        $results = [];
        $data = $response['data'] ?? [];

        foreach ($data as $item) {
            $results[] = [
                'id' => $item['id'],
                'text' => $item['label']
            ];
        }

        // 4. Simpan hasil array $results yang sudah bersih ke cache selama 30 hari (2592000 detik)
        if (!empty($results)) {
            cache()->save($cacheKey, $results, 2592000);
        }

        // 5. Kembalikan respon JSON ke frontend Select2
        return $this->response->setJSON([
            'results' => $results
        ]);
    }

    public function costs()
    {
        $origin = '64999';
        $destination = $this->request->getGet('destination');
        $weight = '1000';
        $courier = 'jne';

        $service = new RajaOngkirService();
        $response = $service->getCost($origin, $destination, $weight, $courier);

        $results = [];
        $data = $response['data'] ?? [];

        foreach ($data as $item) {
            $results[] = [
                'service' => $item['service'],
                'description' => $item['description'],
                'cost' => $item['cost'],
                'etd' => $item['etd']
            ];
        }

        return $this->response->setJSON($results);
    }

    public function buy()
    {
        // Load helper transaksi
        helper('TransaksiHelper');

        $transactionModel = new TransactionModel();
        $transactionDetailModel = new TransactionDetailModel();
        $productModel = new ProductModel();

        // 1. Ambil session menggunakan key 'cart_contents' sesuai hasil debug
        $cart_contents = session()->get('cart_contents') ?? [];
        if (empty($cart_contents)) {
            return redirect()->to('keranjang')->with('error', 'Keranjang kosong.');
        }

        // 2. Hitung total_harga berdasarkan properti 'price' dan 'qty'
        $total_harga = 0;
        foreach ($cart_contents as $key => $item) {
            // Skip key pembantu seperti 'cart_total' atau 'total_items' jika ada di dalam array
            if (!is_array($item)) {
                continue;
            }

            $price = $item['price'] ?? 0;
            $qty = $item['qty'] ?? 0;
            $total_harga += $price * $qty;
        }

        $voucher_code = $this->request->getPost('voucher_code');
        $ongkir = $this->request->getPost('ongkir') ?? 0;

        // Hitung komponen biaya tambahan via helper
        $diskon_voucher = hitung_diskon_voucher($total_harga, $voucher_code);
        $ppn = hitung_ppn($total_harga);
        $biaya_admin = hitung_biaya_admin($total_harga);

        // Hitung hasil grand total akhir
        $subtotal_akhir = $total_harga - $diskon_voucher + $ppn + $biaya_admin;
        $grand_total = $subtotal_akhir + $ongkir;

        // Siapkan data transaksi untuk database
        $data_transaction = [
            'username' => session()->get('username'),
            'total_harga' => $total_harga,
            'ongkir' => $ongkir,
            'status' => 'pending',
            'ppn' => $ppn,
            'biaya_admin' => $biaya_admin,
            'voucher_code' => !empty($voucher_code) ? strtoupper(trim($voucher_code)) : null,
            'diskon_voucher' => $diskon_voucher,
            'grand_total' => $grand_total
        ];

        // Proses simpan data menggunakan database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $transactionModel->insert($data_transaction);
        $transaction_id = $transactionModel->getInsertID();

        foreach ($cart_contents as $key => $item) {
            if (!is_array($item)) {
                continue;
            }

            $transactionDetailModel->insert([
                'transaction_id' => $transaction_id,
                'product_id' => $item['id'],
                'jumlah' => $item['qty'],
                'sub_total' => $item['subtotal'],
            ]);

            // Potong stok produk
            $product = $productModel->find($item['id']);
            if ($product) {
                $productModel->update($item['id'], [
                    'stok' => $product['stok'] - $item['qty']
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses transaksi.');
        }

        // Bersihkan session keranjang setelah checkout berhasil
        session()->remove('cart_contents');

        return redirect()->to('history')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function history()
    {
        $username = session()->get('username');

        $transactions = $this->transactionModel->where('username', $username)->findAll();
        $transactionIds = array_column($transactions, 'id');

        $products = $this->transactionDetailModel->getProductsByTransactionIds($transactionIds);

        $data = [
            'username' => $username,
            'transactions' => $transactions,
            'products' => $products
        ];

        return view('v_history', $data);
    }
}