<?php
require_once __DIR__ . '/Database.php';

class Magazijn
{
    private PDO $db;
    public function __construct() { $this->db = Database::getConnection(); }

    public function getOverzicht(): array
    {
        $stmt = $this->db->query("CALL usp_MagazijnOverzicht()");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while ($stmt->nextRowset()) {}
        return $rows;
    }
}
