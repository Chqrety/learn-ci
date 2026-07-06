<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCheckoutFieldsToTransaction extends Migration
{
    public function up()
    {
        $fields = [
            'ppn' => [
                'type' => 'DOUBLE',
                'null' => true,
                'default' => null,
                'after' => 'ongkir',
            ],
            'biaya_admin' => [
                'type' => 'DOUBLE',
                'null' => true,
                'default' => null,
                'after' => 'ppn',
            ],
            'voucher_code' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
                'after' => 'biaya_admin',
            ],
            'diskon_voucher' => [
                'type' => 'DOUBLE',
                'null' => true,
                'default' => null,
                'after' => 'voucher_code',
            ],
            'grand_total' => [
                'type' => 'DOUBLE',
                'null' => true,
                'default' => null,
                'after' => 'diskon_voucher',
            ],
        ];

        // Menambahkan kolom-kolom di atas ke dalam tabel 'transaction'
        $this->forge->addColumn('transaction', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', ['ppn', 'biaya_admin', 'voucher_code', 'diskon_voucher', 'grand_total']);
    }
}
