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
git clone https://github.com/shintafebriyanti15200334/expense-system
Atau salin project ke folder:
htdocs/expense-system <br>
2.2	Masuk ke Folder Project
cd expense-system <br>
2.3	Install Dependency PHP
composer install <br>
2.4	Install Dependency Frontend
npm install <br>
2.5	Copy File Environment
cp .env.example .env
Windows CMD:
copy .env.example .env <br>
2.6	Generate Application Key
php artisan key:generate <br>
2.7	Membuat Database
expense_system <br>
2.8	Konfigurasi Database <br>
.env <br>
DB_CONNECTION=mysql <br>
DB_HOST=127.0.0.1 <br>
DB_PORT=3306 <br>
DB_DATABASE=expense_system <br>
DB_USERNAME=root <br>
DB_PASSWORD= <br>
2.9	Jalankan Migration
php artisan migrate <br>
2.10	Jalankan Seeder
php artisan db:seed <br>
atau
php artisan migrate:fresh –seed <br>
2.11	Menjalankan Vite
npm run dev <br>
2.12	Menjalankan Laravel
php artisan serve 
Akses:
http://127.0.0.1:8000
atau
http://localhost/expense-system/public <br>

3	Struktur Database
Di PDF ERD nya 

4	Workflow Approval
≤ Rp5.000.000 : Staff → SPV → Finance <br>
> Rp5.000.000 s/d Rp10.000.000 : Staff → Manager → Finance <br>
> Rp10.000.000 : Staff → Director → Finance <br>
PO Produk : Staff → Director → Finance <br>
Status akhir: Paid

5	Akun Login Testing
<br>
Role	Email	Password <br>
Staff	staff@test.com	password <br>
SPV	spv@test.com	password <br>
Manager	manager@test.com	password <br>
Director	director@test.com	password <br>
Finance	finance@test.com	password <br>

6	Fitur Sistem
7	Login Multi Role <br>
•	Dashboard <br>
•	Pengajuan Transaksi Pengeluaran <br>
•	Upload Multiple (bisa upload lebih dari satu) <br>
•	Approval SPV <br>
•	Approval Manager <br>
•	Approval Director <br>
•	Budget Control <br>
•	Pembayaran Finance <br>
•	Export Data (Pdf dan Excel) <br>
•	Riwayat Pengajuan, Riwayat Approval, dan Riwayat Finance <br>
•	Dashboard statistic <br>
•	Activity log <br>
•	Audit trail <br>
•	API endpoint <br>

8	Hak Akses Pengguna

Role	Hak Akses <br>
Staff	Membuat pengajuan <br>
SPV	Approval pertama jika < 5.000.000 <br>
Manager	Approval pertama jika > 5.000.000 <br>
Director	Approval terakhir <br>
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
