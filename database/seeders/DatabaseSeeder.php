<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles Users
        $manager = User::create([
            'name' => 'Budi Santoso',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manajer',
        ]);

        $admin = User::create([
            'name' => 'Agus Wijaya',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin_gudang',
        ]);

        // 2. Seed Categories
        $cotton = Category::create(['name' => 'Cotton']);
        $polyester = Category::create(['name' => 'Polyester']);
        $silk = Category::create(['name' => 'Silk']);

        // 3. Seed Suppliers
        $sup1 = Supplier::create([
            'name' => 'PT Asietex Cottonindo',
            'contact' => '+62 811-2233-4455',
            'address' => 'Jl. Raya Karawang Barat No. 12, Karawang, Jawa Barat',
        ]);
        $sup2 = Supplier::create([
            'name' => 'Indo Filament Corp',
            'contact' => '+62 812-3456-7890',
            'address' => 'Kawasan Industri Jababeka Phase III, Cikarang, Bekasi',
        ]);
        $sup3 = Supplier::create([
            'name' => 'Sumatra Silk Mills',
            'contact' => '+62 813-9876-5432',
            'address' => 'Jl. Jenderal Sudirman No. 89, Medan, Sumatera Utara',
        ]);

        // 4. Seed Products
        $p1 = Product::create([
            'category_id' => $cotton->id,
            'name' => 'Cotton Yarn 30S',
            'color' => 'Super White',
            'unit' => 'kg',
            'current_stock' => 120,
        ]);
        $p2 = Product::create([
            'category_id' => $polyester->id,
            'name' => 'Polyester DTY 150/48',
            'color' => 'Navy Blue',
            'unit' => 'kg',
            'current_stock' => 5, // Low stock alert!
        ]);
        $p3 = Product::create([
            'category_id' => $silk->id,
            'name' => 'Mulberry Raw Silk Yarn',
            'color' => 'Natural White',
            'unit' => 'roll',
            'current_stock' => 45,
        ]);
        $p4 = Product::create([
            'category_id' => $cotton->id,
            'name' => 'Viscose Rayon Fiber',
            'color' => 'Bright White',
            'unit' => 'kg',
            'current_stock' => 80,
        ]);

        // 5. Seed some initial transactions to populate the tables
        Transaction::create([
            'type' => 'in',
            'product_id' => $p1->id,
            'supplier_id' => $sup1->id,
            'quantity' => 150,
            'transaction_date' => now()->subDays(3),
            'notes' => 'Initial bulk purchase Cotton Yarn 30S',
        ]);
        Transaction::create([
            'type' => 'out',
            'product_id' => $p1->id,
            'supplier_id' => null,
            'quantity' => 30,
            'transaction_date' => now()->subDays(2),
            'notes' => 'Sent to weaving department',
        ]);
        Transaction::create([
            'type' => 'in',
            'product_id' => $p2->id,
            'supplier_id' => $sup2->id,
            'quantity' => 15,
            'transaction_date' => now()->subDays(4),
            'notes' => 'Restock Polyester DTY',
        ]);
        Transaction::create([
            'type' => 'out',
            'product_id' => $p2->id,
            'supplier_id' => null,
            'quantity' => 10,
            'transaction_date' => now()->subDays(1),
            'notes' => 'Sent to knitting department',
        ]);
        Transaction::create([
            'type' => 'in',
            'product_id' => $p3->id,
            'supplier_id' => $sup3->id,
            'quantity' => 45,
            'transaction_date' => now()->subHours(6),
            'notes' => 'Imported Mulberry Raw Silk',
        ]);
    }
}
