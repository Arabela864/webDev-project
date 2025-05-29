<?php
class DashboardStats
{
    private \mysqli $db;

    public function __construct(\mysqli $conn)
    {
        $this->db = $conn;
    }

    public function countOrders(): int
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM orders");
        return (int) ($res->fetch_assoc()['cnt'] ?? 0);
    }

    public function countUsers(): int
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM users WHERE `role` ='user'");
        return (int) ($res->fetch_assoc()['cnt'] ?? 0);
    }
    public function searchPerfumes(string $keyword): array
{
    $stmt = $this->db->prepare("SELECT * FROM perfumes WHERE name LIKE CONCAT('%', ?, '%')");

    if (!$stmt) {
        error_log("Prepare failed: " . $this->db->error);
        return [];
    }

    $stmt->bind_param("s", $keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    $perfumes = [];
    while ($row = $result->fetch_assoc()) {
        $perfumes[] = $row;
    }

    $stmt->close();
    return $perfumes;
}

}
