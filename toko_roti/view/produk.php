<?php
$data = $produk->getAllProduk();
$edit = isset($_GET['edit']) ? $produk->getProdukById($_GET['edit']) : null;
?>
<section>
    <h2>Kelola Produk</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit['id_produk'] ?? '' ?>">
        <input type="text" name="nama" placeholder="Nama Produk" required value="<?= $edit['nama_produk'] ?? '' ?>">
        <input type="number" name="harga" placeholder="Harga" required value="<?= $edit['harga'] ?? '' ?>">
        <input type="number" name="stok" placeholder="Stok" required value="<?= $edit['stok'] ?? '' ?>">
        <button type="submit" name="<?= $edit ? 'update' : 'add' ?>">
            <?= $edit ? 'Perbarui' : 'Tambah' ?> Produk
        </button>
        <?php if ($edit): ?>
            <a href="?page=produk" class="btn-cancel">Batal</a>
        <?php endif; ?>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data as $p): ?>
            <tr>
                <td><?= $p['id_produk'] ?></td>
                <td><?= $p['nama_produk'] ?></td>
                <td>Rp<?= number_format($p['harga'], 0, ',', '.') ?></td>
                <td><?= $p['stok'] ?></td>
                <td>
                    <a href="?page=produk&edit=<?= $p['id_produk'] ?>">Edit</a> |
                    <a href="?page=produk&delete=<?= $p['id_produk'] ?>"
                        onclick="return confirm('Hapus produk ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>