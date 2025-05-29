<?php


class UserModel
{
    private \mysqli $db;

    public function __construct(\mysqli $conn)
    {
        $this->db = $conn;
    }

    /**
     * Fetch all non-admin users.
     * @return array<int,array>
     */
    public function getAllRegular(): array
    {
        $out = [];
        $stmt = $this->db->prepare("
            SELECT id, username, email, created_at
              FROM users
             WHERE role = 'user'
             ORDER BY created_at DESC
        ");
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $out[] = $row;
        }
        return $out;
    }

    /**
     * Delete a user by id.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
