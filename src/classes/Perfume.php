<?php
// classes/PerfumeModel.php

class PerfumeModel
{
    private \mysqli $db;

    public function __construct(\mysqli $conn)
    {
        $this->db = $conn;
    }

    /**
     * Return all perfumes as an array.
     * @return array<int,array>
     */
    public function getAll(): array
    {
        $out = [];
        $res = $this->db->query("SELECT * FROM perfumes ORDER BY created_at DESC");
        while ($row = $res->fetch_assoc()) {
            $out[] = $row;
        }
        return $out;
    }
    public function getPerfumesByCategory(string $column, string $value): \mysqli_result
    {
        // whitelist columns to prevent SQL injection
        $allowed = ['size','category','durability','fragrance'];
        if (!in_array($column, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid filter column: $column");
        }

        $sql = "SELECT id, name, description, fragrance, size, durability, image, created_at
                  FROM perfumes
                 WHERE `$column` = ?
              ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $value);
        $stmt->execute();
        return $stmt->get_result();
    }
    
}
