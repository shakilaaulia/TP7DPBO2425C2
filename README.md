# TP7DPBO2425C2 
## JANJI
Saya Shakila Aulia dengan NIM 2403086 mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

---
## Deskripsi Umum Tema Website           
Website ini mengambil tema "Manajemen Penjualan Roti Sederhana" yang digunakan untuk mengelola data produk roti, pelanggan, dan pesanan. Dalam website ini user dapat menggunakan fitur diantaranya:
- Menampilkan daftar produk roti beserta harga dan stok, dapat menambah, mengedit serta menghapus juga.
- Menambahkan, mengubah. dan menghapus pelanggan yang melakukan pembelian.
- Membuat, mengedit, dan menghapus pesanan ini berelasi dengan produk dan pelanggan.
- Menjaga agar stok produk otomatis berkurang saat ada pesanan baru, dan bertambah kembali saat pesanan dibatalkan atau dihapus.

## Penjelasan Databse
Database bernama "toko_roti", dalam database ini terdapat 3 tabel utama yaitu:
1. Tabel Produk
- id_produk - INT (PK, AUTO_INCREMENT)
- nama_produk - VARCHAR(100)
- harga - INT
- stok - INT

2. Tabel Pelanggan
- id_pelanggan - INT (PK, AUTO_INCREMENT)
- nama_pelanggan - VARCHAR(100)
- email - VARCHAR(100)
- no_hp - VARCHAR(20)

3. Tabel Pesanan
- id_pesanan - INT (PK, AUTO_INCREMENT)
- id_pelanggan - INT (FK) -> Relasi ke pelanggan.id_pelanggan
- id_produk  - INT (FK) -> Relasi ke produk.id_produk
- jumlah - INT
- total_harga - INT
- tanggal_pesanan - DATE

## Penjelasan Struktur File
1. config/db.php
Berisi koneksi ke database menggunakan PDO. Semua kelas lain (Produk, Pelanggan, Pesanan) mewarisi koneksi ini agar query database bisa dijalankan.
2. class/Produk.php
Menangani semua proses CRUD produk:
- getAllProduk() = ambil semua data produk
- addProduk() = tambah produk baru
- updateProduk() = ubah data produk
- deleteProduk() = hapus produk
3. class/Pelanggan.php
Berfungsi untuk mengelola data pelanggan:
- Tambah, ubah, hapus pelanggan (sama seperti produk)
- Menampilkan daftar pelanggan
4. class/Pesanan.php
Kelas paling penting, mengelola transaksi pesanan:
- addPesanan() = menambah pesanan baru -> stok produk otomatis berkurang
- updatePesanan() = mengubah pesanan -> stok lama dikembalikan, stok baru dikurangi
- deletePesanan() = menghapus pesanan -> stok dikembalikan ke produk semula
- getAllPesanan()  menampilkan daftar pesanan beserta nama pelanggan & produk
5. index.php
File utama yang mengatur tampilan halaman menggunakan templating system:
- header.php & footer.php selalu dipanggil di setiap halaman
- Navigasi menggunakan ?page= untuk berpindah antara Produk, Pelanggan, dan Pesanan
6. view/ Folder
Menampilkan data dalam bentuk tabel dan form input:
- produk.php → daftar dan form CRUD produk
- pelanggan.php → daftar pelanggan dan form CRUP Pelanggan
- pesanan.php → daftar pesanan (nama pelanggan & produk tampil jelas) serta CRUD Pesanan

## Penjelasan Alur Program 
1. Inisialisasi Program
- Program dijalankan melalui file utama index.php.
- Sistem mengimpor koneksi database dari config/db.php menggunakan PDO.
- Objek dari masing-masing class (Produk, Pelanggan, dan Pesanan) dibuat untuk mengakses fungsi CRUD.

2. Sistem Navigasi dan Templating
- Website menggunakan sistem templating sederhana yang terdiri dari header.php, footer.php, dan main content.
- Navigasi halaman diatur menggunakan parameter ?page= pada URL.
- Setiap halaman utama seperti Produk, Pelanggan, dan Pesanan ditampilkan berdasarkan nilai $_GET['page'].

3. Manajemen Data Produk
- User dapat menambah, melihat, memperbarui, dan menghapus data produk roti.
- Data produk meliputi nama, harga, dan jumlah stok.
- Semua perubahan tersimpan di tabel produk.

4. Manajemen Data Pelanggan
- User mencatat data pelanggan baru meliputi nama, email, dan nomor telepon.
- Data disimpan di tabel pelanggan untuk digunakan dalam transaksi pesanan.

5. Proses Transaksi (Pesanan)
- User memilih pelanggan dan produk untuk membuat pesanan baru.
- Sistem menghitung total harga otomatis berdasarkan harga produk dan jumlah yang dipesan.
- Saat pesanan dibuat, stok produk langsung berkurang secara otomatis.
- Data transaksi disimpan di tabel pesanan.

6. Update Pesanan
Saat pesanan diperbarui:
- Stok lama dikembalikan terlebih dahulu.
- Stok baru dikurangi sesuai jumlah pesanan terbaru.
- Total harga diperbarui sesuai harga produk dan jumlah baru.

7. Hapus Pesanan
Saat pesanan dihapus:
- Data pesanan dihapus dari tabel pesanan.
- Stok produk dikembalikan sesuai jumlah yang sebelumnya dipesan.

Semua proses dilakukan dalam satu transaksi database untuk mencegah error data (menggunakan beginTransaction(), commit(), rollBack()).

## Dokumentasi
Page Produk
![produk](https://github.com/user-attachments/assets/0816dbb8-c517-4f9e-b310-a75f15f2589c)

Page Pelanggan
![pelanggan](https://github.com/user-attachments/assets/7be301ca-61d8-4f6f-88b1-4bb990427530)

Page Pesanan
![pesanan](https://github.com/user-attachments/assets/2951b1d7-194c-4a54-b2f4-ad6acca8d897)



