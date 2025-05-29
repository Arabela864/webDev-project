<?php
class OrderModel
{
    private \mysqli $db;

    public function __construct(\mysqli $conn)
    {
        $this->db = $conn;
    }

    /**
     * Add a new order (cart entry).
     *
     * @param int $userId
     * @param int $perfumeId
     * @param int $quantity
     * @return bool
     */
    public function add(int $userId, int $perfumeId, int $quantity): bool
{
    $this->db->begin_transaction();

    try {
        // 1. Creează comanda în orders
        $stmt = $this->db->prepare(
            "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $orderId = $this->db->insert_id;

        // 2. Află prețul parfumului
        $stmtPrice = $this->db->prepare(
            "SELECT price FROM perfumes WHERE id = ?"
        );
        $stmtPrice->bind_param("i", $perfumeId);
        $stmtPrice->execute();
        $priceResult = $stmtPrice->get_result();
        $row = $priceResult->fetch_assoc();
        $unitPrice = $row['price'];

        // 3. Inserează în order_items
        $stmt2 = $this->db->prepare(
            "INSERT INTO order_items (order_id, perfume_id, quantity, unit_price)
             VALUES (?, ?, ?, ?)"
        );
        $stmt2->bind_param("iiid", $orderId, $perfumeId, $quantity, $unitPrice);
        $stmt2->execute();

        $this->db->commit();
        return true;
    } catch (\mysqli_sql_exception $e) {
        $this->db->rollback();
        throw $e;
    }
}


    /**
     * Fetch all orders for a given user.
     *
     * @param int $userId
     * @return array<int,array>
     */
    public function getByUser(int $userId): array
    {
        $out = [];
        $stmt = $this->db->prepare(
            "SELECT 
                o.id AS order_id,
                p.name AS product,
                i.quantity,
                o.order_date AS date
             FROM orders o
             JOIN order_items i ON o.id = i.order_id
             JOIN perfumes p ON i.perfume_id = p.id
             WHERE o.user_id = ?
             ORDER BY o.order_date DESC"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
    
        while ($row = $res->fetch_assoc()) {
            $out[] = $row;
        }
    
        return $out;
    }
    
}
