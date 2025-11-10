<?php
require_once 'config/db.php';

class Pelanggan
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function getAllPelanggan()
    {
        $stmt = $this->db->query("SELECT * FROM pelanggan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPelangganById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPelanggan($nama, $email, $no_hp)
    {
        $stmt = $this->db->prepare("INSERT INTO pelanggan (nama_pelanggan, email, no_hp) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $email, $no_hp]);
    }

    public function updatePelanggan($id, $nama, $email, $no_hp)
    {
        $stmt = $this->db->prepare("UPDATE pelanggan SET nama_pelanggan = ?, email = ?, no_hp = ? WHERE id_pelanggan = ?");
        return $stmt->execute([$nama, $email, $no_hp, $id]);
    }

    public function deletePelanggan($id)
    {
        $stmt = $this->db->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
        return $stmt->execute([$id]);
    }
}
?>
