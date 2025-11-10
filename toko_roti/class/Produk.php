<?php
require_once 'config/db.php';

class Produk
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function getAllProduk()
    {
        $stmt = $this->db->query("SELECT * FROM produk ORDER BY id_produk DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getProdukById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produk WHERE id_produk = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduk($nama, $harga, $stok)
    {
        $stmt = $this->db->prepare("INSERT INTO produk (nama_produk, harga, stok) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $harga, $stok]);
    }

    public function updateProduk($id, $nama, $harga, $stok)
    {
        $stmt = $this->db->prepare("UPDATE produk SET nama_produk = ?, harga = ?, stok = ? WHERE id_produk = ?");
        return $stmt->execute([$nama, $harga, $stok, $id]);
    }

    public function deleteProduk($id)
    {
        $stmt = $this->db->prepare("DELETE FROM produk WHERE id_produk = ?");
        return $stmt->execute([$id]);
    }
}
?>
