<?php
require_once 'config/db.php';

class Pesanan
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function getAllPesanan()
    {
        $sql = "SELECT 
                    pesanan.id_pesanan,
                    pelanggan.nama_pelanggan,
                    produk.nama_produk,
                    pesanan.id_pelanggan,
                    pesanan.id_produk,
                    pesanan.jumlah,
                    pesanan.total_harga,
                    pesanan.tanggal_pesan
                FROM pesanan
                INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.id_pelanggan
                INNER JOIN produk ON pesanan.id_produk = produk.id_produk
                ORDER BY pesanan.tanggal_pesan ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPesananById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPesanan($id_pelanggan, $id_produk, $jumlah)
    {
        $stmt = $this->db->prepare("SELECT harga, stok FROM produk WHERE id_produk = ?");
        $stmt->execute([$id_produk]);
        $produk = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produk || $produk['stok'] < $jumlah)
            return false;

        $total = $produk['harga'] * $jumlah;

        try {
            $this->db->beginTransaction();

            $insert = $this->db->prepare("INSERT INTO pesanan (id_pelanggan, id_produk, jumlah, total_harga, tanggal_pesan) 
                                          VALUES (?, ?, ?, ?, CURDATE())");
            $insert->execute([$id_pelanggan, $id_produk, $jumlah, $total]);

            $updateStok = $this->db->prepare("UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
            $updateStok->execute([$jumlah, $id_produk]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updatePesanan($id_pesanan, $id_pelanggan, $id_produk, $jumlah_baru)
    {
        $this->db->beginTransaction();

        $stmt = $this->db->prepare("SELECT id_produk, jumlah FROM pesanan WHERE id_pesanan = ?");
        $stmt->execute([$id_pesanan]);
        $pesanan_lama = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pesanan_lama) {
            $this->db->rollBack();
            return false;
        }

        $id_produk_lama = $pesanan_lama['id_produk'];
        $jumlah_lama = $pesanan_lama['jumlah'];

        // Kembalikan stok lama dulu
        $stmt = $this->db->prepare("UPDATE produk SET stok = stok + ? WHERE id_produk = ?");
        $stmt->execute([$jumlah_lama, $id_produk_lama]);

        // Ambil info produk baru
        $stmt = $this->db->prepare("SELECT harga, stok FROM produk WHERE id_produk = ?");
        $stmt->execute([$id_produk]);
        $produk = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produk || $produk['stok'] < $jumlah_baru) {
            $this->db->rollBack();
            return false;
        }

        $total_baru = $produk['harga'] * $jumlah_baru;

        // Update pesanan
        $update = $this->db->prepare("UPDATE pesanan 
                                      SET id_pelanggan = ?, id_produk = ?, jumlah = ?, total_harga = ?
                                      WHERE id_pesanan = ?");
        $update->execute([$id_pelanggan, $id_produk, $jumlah_baru, $total_baru, $id_pesanan]);

        // Kurangi stok baru
        $stmt = $this->db->prepare("UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
        $stmt->execute([$jumlah_baru, $id_produk]);

        $this->db->commit();
        return true;
    }

    public function deletePesanan($id_pesanan)
    {
        $this->db->beginTransaction();

        $stmt = $this->db->prepare("SELECT id_produk, jumlah FROM pesanan WHERE id_pesanan = ?");
        $stmt->execute([$id_pesanan]);
        $pesanan = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pesanan) {
            // Kembalikan stok produk
            $updateStok = $this->db->prepare("UPDATE produk SET stok = stok + ? WHERE id_produk = ?");
            $updateStok->execute([$pesanan['jumlah'], $pesanan['id_produk']]);

            $delete = $this->db->prepare("DELETE FROM pesanan WHERE id_pesanan = ?");
            $delete->execute([$id_pesanan]);
        }

        $this->db->commit();
        return true;
    }
}
?>
