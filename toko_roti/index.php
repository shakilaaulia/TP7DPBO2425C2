<?php
require_once 'class/Produk.php';
require_once 'class/Pelanggan.php';
require_once 'class/Pesanan.php';

$produk = new Produk();
$pelanggan = new Pelanggan();
$pesanan = new Pesanan();

$page = $_GET['page'] ?? 'home';

if ($page == 'produk' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add']))
        $produk->addProduk($_POST['nama'], $_POST['harga'], $_POST['stok']);
    if (isset($_POST['update']))
        $produk->updateProduk($_POST['id'], $_POST['nama'], $_POST['harga'], $_POST['stok']);
}
if ($page == 'produk' && isset($_GET['delete']))
    $produk->deleteProduk($_GET['delete']);

if ($page == 'pelanggan' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add']))
        $pelanggan->addPelanggan($_POST['nama'], $_POST['email'], $_POST['no_hp']);
    if (isset($_POST['update']))
        $pelanggan->updatePelanggan($_POST['id'], $_POST['nama'], $_POST['email'], $_POST['no_hp']);
}
if ($page == 'pelanggan' && isset($_GET['delete']))
    $pelanggan->deletePelanggan($_GET['delete']);

if ($page == 'pesanan' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add']))
        $pesanan->addPesanan($_POST['id_pelanggan'], $_POST['id_produk'], $_POST['jumlah']);
    if (isset($_POST['update']))
        $pesanan->updatePesanan($_POST['id'], $_POST['id_pelanggan'], $_POST['id_produk'], $_POST['jumlah']);
}
if ($page == 'pesanan' && isset($_GET['delete']))
    $pesanan->deletePesanan($_GET['delete']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Toko Roti Shakila</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'view/header.php'; ?>

    <main class="container">
        <?php if ($page == 'home'): ?>
            <section class="hero">
                <h1>Selamat Datang di <span>Toko Roti Shakila</span></h1>
                <p>Nikmati roti segar setiap hari dengan cita rasa terbaik!</p>
            </section>
            <nav class="menu">
                <a href="?page=produk">Produk</a>
                <a href="?page=pelanggan">Pelanggan</a>
                <a href="?page=pesanan">Pesanan</a>
            </nav>

        <?php elseif ($page == 'produk'): ?>
            <?php include 'view/produk.php'; ?>

        <?php elseif ($page == 'pelanggan'): ?>
            <?php include 'view/pelanggan.php'; ?>

        <?php elseif ($page == 'pesanan'): ?>
            <?php include 'view/pesanan.php'; ?>
        <?php endif; ?>
    </main>

    <?php include 'view/footer.php'; ?>
</body>

</html>