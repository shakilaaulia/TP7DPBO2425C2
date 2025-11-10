<?php
$data = $pelanggan->getAllPelanggan();
$edit = isset($_GET['edit']) ? $pelanggan->getPelangganById($_GET['edit']) : null;
?>
<section>
    <h2>Kelola Pelanggan</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit['id_pelanggan'] ?? '' ?>">
        <input type="text" name="nama" placeholder="Nama Pelanggan" required
            value="<?= $edit['nama_pelanggan'] ?? '' ?>">
        <input type="email" name="email" placeholder="Email" required value="<?= $edit['email'] ?? '' ?>">
        <input type="text" name="no_hp" placeholder="No HP" required value="<?= $edit['no_hp'] ?? '' ?>">
        <button type="submit" name="<?= $edit ? 'update' : 'add' ?>">
            <?= $edit ? 'Perbarui' : 'Tambah' ?> Pelanggan
        </button>
        <?php if ($edit): ?>
            <a href="?page=pelanggan" class="btn-cancel">Batal</a>
        <?php endif; ?>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data as $p): ?>
            <tr>
                <td><?= $p['id_pelanggan'] ?></td>
                <td><?= $p['nama_pelanggan'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['no_hp'] ?></td>
                <td>
                    <a href="?page=pelanggan&edit=<?= $p['id_pelanggan'] ?>">Edit</a> |
                    <a href="?page=pelanggan&delete=<?= $p['id_pelanggan'] ?>"
                        onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>