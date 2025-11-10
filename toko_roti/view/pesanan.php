<?php
$pesananList = $pesanan->getAllPesanan();
$produkList = $produk->getAllProduk();
$pelangganList = $pelanggan->getAllPelanggan();

if (isset($_POST['tambah_pesanan'])) {
    $pesanan->addPesanan($_POST['id_pelanggan'], $_POST['id_produk'], $_POST['jumlah']);
    header("Location: ?page=pesanan");
    exit;
}

if (isset($_POST['update_pesanan'])) {
    $pesanan->updatePesanan($_POST['id_pesanan'], $_POST['id_pelanggan'], $_POST['id_produk'], $_POST['jumlah']);
    header("Location: ?page=pesanan");
    exit;
}

if (isset($_GET['delete'])) {
    $pesanan->deletePesanan($_GET['delete']);
    header("Location: ?page=pesanan");
    exit;
}
?>

<h2>Daftar Pesanan</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Pelanggan</th>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($pesananList as $p): ?>
        <tr>
            <td><?= $p['id_pesanan'] ?></td>
            <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
            <td><?= htmlspecialchars($p['nama_produk']) ?></td>
            <td><?= $p['jumlah'] ?></td>
            <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
            <td><?= $p['tanggal_pesan'] ?></td>
            <td>
                <a href="?page=pesanan&edit=<?= $p['id_pesanan'] ?>">Edit</a> |
                <a href="?page=pesanan&delete=<?= $p['id_pesanan'] ?>"
                    onclick="return confirm('Yakin ingin hapus pesanan ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<hr>

<?php if (isset($_GET['edit'])):
    $editData = $pesanan->getPesananById($_GET['edit']);
    ?>
    <h3>Edit Pesanan</h3>
    <form method="POST">
        <input type="hidden" name="id_pesanan" value="<?= $editData['id_pesanan'] ?>">

        <label>Pelanggan:</label>
        <select name="id_pelanggan" required>
            <?php foreach ($pelangganList as $pl): ?>
                <option value="<?= $pl['id_pelanggan'] ?>" <?= $pl['id_pelanggan'] == $editData['id_pelanggan'] ? 'selected' : '' ?>>
                    <?= $pl['nama_pelanggan'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Produk:</label>
        <select name="id_produk" required>
            <?php foreach ($produkList as $pr): ?>
                <option value="<?= $pr['id_produk'] ?>" <?= $pr['id_produk'] == $editData['id_produk'] ? 'selected' : '' ?>>
                    <?= $pr['nama_produk'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" min="1" value="<?= $editData['jumlah'] ?>" required><br><br>

        <button type="submit" name="update_pesanan">Simpan Perubahan</button>
    </form>
<?php else: ?>
    <h3>Tambah Pesanan Baru</h3>
    <form method="POST">
        <label>Pelanggan:</label>
        <select name="id_pelanggan" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php foreach ($pelangganList as $pl): ?>
                <option value="<?= $pl['id_pelanggan'] ?>"><?= $pl['nama_pelanggan'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Produk:</label>
        <select name="id_produk" required>
            <option value="">-- Pilih Produk --</option>
            <?php foreach ($produkList as $pr): ?>
                <option value="<?= $pr['id_produk'] ?>"><?= $pr['nama_produk'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" min="1" required><br><br>

        <button type="submit" name="tambah_pesanan">Tambah Pesanan</button>
    </form>
<?php endif; ?>