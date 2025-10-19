<?php
require_once __DIR__ . '/Database.php';

class Allergenen
{
    private PDO $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function getVoorProduct(int $productId): array
    {
        $stmt = $this->db->prepare("CALL usp_AllergenenVoorProduct(:pid)");
        $stmt->execute([':pid' => $productId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while ($stmt->nextRowset()) {}
        return $rows;
    }
}
