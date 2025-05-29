<?php
class OrderModel
{
    private \mysqli $db;

    public function __construct(\mysqli $conn)
    {
        $this->db = $conn;
    }

    public function getAll(): array
    {
        $out = [];
        $sql = "
          SELECT
            o.id,
            u.username,
            -- p.name    AS product,
            -- o.quantity,
            o.order_date
          FROM orders o
          JOIN users   u ON o.user_id    = u.id
          -- JOIN perfumes p ON o.perfume_id = p.id
          ORDER BY o.order_date DESC
        ";
        $res = $this->db->query($sql);
        while ($row = $res->fetch_assoc()) {
            $out[] = $row;
        }
        return $out;
    }

    public function countAll(): int
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM orders");
        return (int)($res->fetch_assoc()['cnt'] ?? 0);
    }
}
