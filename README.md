# Sistem Inventaris Bahan Baku Tekstil (Textile Raw Material Inventory System)

Sistem Inventaris Bahan Baku Tekstil adalah aplikasi berbasis web yang dibangun menggunakan **Laravel** (PHP) dan **TailwindCSS** (HTML/Blade). Aplikasi ini dirancang untuk mengelola data master (kategori, supplier, dan produk) serta mencatat transaksi keluar-masuk bahan baku secara real-time dengan pembaruan stok otomatis.

Aplikasi ini dilengkapi dengan **Role-Based Access Control (RBAC)** untuk membatasi akses fitur berdasarkan peran pengguna: **Manajer** dan **Admin Gudang**.

---

## Fitur Utama

1. **Dashboard Informatif**
    - Menampilkan total produk, total kategori, dan total supplier.
    - Peringatan otomatis untuk produk dengan **stok rendah** (stok di bawah 10 unit).
    - Daftar 5 transaksi terbaru untuk pelacakan cepat.

2. **Modul Data Master (Kategori, Supplier, Produk)**
    - **Manajer**: Memiliki akses penuh (Create, Read, Update, Delete) untuk mengelola Kategori, Supplier, dan Produk.
    - **Admin Gudang**: Memiliki akses baca saja (Read-only) untuk mendukung proses transaksi.

3. **Modul Transaksi (Inbound, Outbound, Returns)**
    - **Admin Gudang**: Dapat melakukan input transaksi baru (Masuk, Keluar, Retur) dan melihat riwayat transaksi.
    - **Manajer**: Dapat melihat semua riwayat transaksi untuk kebutuhan audit (Audit Log), namun tidak dapat membuat atau mengubah transaksi.

4. **Logika Stok Otomatis (Core Logic)**
    - Stok produk akan otomatis bertambah saat transaksi masuk (`in`).
    - Stok produk akan otomatis berkurang saat transaksi keluar (`out`) atau retur (`return`).
    - Validasi ketat untuk mencegah transaksi keluar (`out`) atau retur (`return`) jika stok produk tidak mencukupi.

---

## Kredensial Default (Seeder)

Gunakan akun berikut untuk masuk ke dalam sistem setelah melakukan seeding database atau mengimpor file SQL:

| Peran (Role)     | Email               | Password   | Hak Akses                                      |
| :--------------- | :------------------ | :--------- | :--------------------------------------------- |
| **Manajer**      | `manager@gmail.com` | `password` | Full CRUD Data Master, Read-Only Transaksi     |
| **Admin Gudang** | `admin@gmail.com`   | `password` | Read-Only Data Master, Create & Read Transaksi |

---

## File SQL Database

Unduh file SQL database langsung untuk impor manual:

- **[Download file database.zip](database.zip)** (Berisi struktur tabel dan data sampel).

---

## Langkah Instalasi & Cara Menjalankan Project

1. **Clone Repository**

    ```bash
    git clone <repository_url>
    cd assignment-test
    ```

2. **Install Dependency PHP**

    ```bash
    composer install
    ```

3. **Install Dependency Frontend**

    ```bash
    npm install
    ```

4. **Configure Environment File**

    ```bash
    copy .env.example .env
    ```

    _(Untuk macOS/Linux: `cp .env.example .env`)_  
    Sesuaikan konfigurasi database MySQL di file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=assignment_asietex
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Migrasi Database & Seeding Data**

    ```bash
    php artisan migrate:fresh --seed
    ```

    _(Alternatif: Anda bisa mengimpor file `database.sql` ke database MySQL `assignment_asietex` Anda)._

7. **Build Aset Frontend**

    ```bash
    npm run dev
    ```

8. **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di browser: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**.
