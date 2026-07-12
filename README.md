EXPENSE SYSTEM
Sistem Pengajuan Transaksi Pengeluaran Berbasis Laravel 12
1.	Requirement
PHP 8.2 atau lebih baru
Composer
VS Code
MySQL / Xampp
Node.js & NPM
Git (Opsional)

2.	Cara Instalasi
2.1	Clone Repository
git clone https://github.com/username/expense-system.git
Atau salin project ke folder:
htdocs/expense-system
2.2	Masuk ke Folder Project
cd expense-system
2.3	Install Dependency PHP
composer install
2.4	Install Dependency Frontend
npm install
2.5	Copy File Environment
cp .env.example .env
Windows CMD:
copy .env.example .env
2.6	Generate Application Key
php artisan key:generate
2.7	Membuat Database
expense_system
2.8	Konfigurasi Database
.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_system
DB_USERNAME=root
DB_PASSWORD=
2.9	Jalankan Migration
php artisan migrate
2.10	Jalankan Seeder
php artisan db:seed
atau
php artisan migrate:fresh –seed
2.11	Menjalankan Vite
npm run dev
2.12	Menjalankan Laravel
php artisan serve
Akses:
http://127.0.0.1:8000
atau
http://localhost/expense-system/public

3	Struktur Database
Di PDF ERD nya 

4	Workflow Approval
≤ Rp5.000.000 : Staff → SPV → Finance
> Rp5.000.000 s/d Rp10.000.000 : Staff → SPV → Manager → Finance
> Rp10.000.000 : Staff → SPV → Manager → Director → Finance
PO Produk : Staff → Director → Finance
Status akhir: Paid

5	Akun Login Testing

Role	Email	Password
Staff	staff@test.com	password
SPV	spv@test.com	password
Manager	manager@test.com	password
Director	director@test.com	password
Finance	finance@test.com	password

6	Fitur Sistem
7	Login Multi Role
•	Dashboard
•	Pengajuan Transaksi Pengeluaran
•	Upload Multiple (bisa upload lebih dari satu)
•	Approval SPV
•	Approval Manager
•	Approval Director
•	Budget Control
•	Pembayaran Finance
•	Export Data (Pdf dan Excel)
•	Riwayat Pengajuan, Riwayat Approval, dan Riwayat Finance
•	Dashboard statistic
•	Activity log 
•	Audit trail
•	API endpoint

8	Hak Akses Pengguna

Role	Hak Akses
Staff	Membuat pengajuan
SPV	Approval pertama
Manager	Approval kedua
Director	Approval terakhir
Finance	Pembayaran dan menyelesaikan transaksi

9	Teknologi
•	Laravel 12
•	PHP 8.2
•	MySQL / Xampp
•	Bootstrap 5
•	Laravel Breeze
•	Eloquent ORM
•	Author
•	Web Application Developer Test
