<?php
class Perfume
{
    private \mysqli $db;

    public function __construct(\mysqli $conn)
    {
        $this->db = $conn;
    }

    public function countAll(): int
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM perfumes");
        return (int) ($res->fetch_assoc()['cnt'] ?? 0);
    }
    /**
     * Insert a new perfume.
     * @param  array  $data  ['name','description','fragrance','size','durability','image']
     * @return bool
     */
    public function create(array $data): bool
    {

        $stmt = $this->db->prepare(
            "INSERT INTO perfumes
         (name, description, fragrance, size, durability, image)
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssssss",
            $data['name'],
            $data['description'],
            $data['category'],
            $data['size'],
            $data['durability'],
            $data['image']
        );
        return $stmt->execute();
    }

    /**
     * Fetch all perfumes.
     * @return array
     */
    public function getAll(): array
    {
        $rows = [];
        $result = $this->db->query("SELECT * FROM perfumes ORDER BY created_at DESC");
        while ($r = $result->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM perfumes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc() ?: null;
    }

    public function update(int $id, array $data): bool
    {
        // build dynamic SQL for image if provided
        $fields = "name=?,description=?,fragrance=?,size=?,durability=?";
        $types  = "sssss";
        $params = [
            $data['name'],
            $data['description'],
            $data['fragrance'],
            $data['size'],
            $data['durability'],
        ];

        if (!empty($data['image'])) {
            $fields .= ",image=?";
            $types  .= "s";
            $params[] = $data['image'];
        }

        $sql = "UPDATE perfumes SET $fields WHERE id=?";
        $types .= "i";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        // 1) Fetch the image name
        $stmt = $this->db->prepare("SELECT image FROM perfumes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($imageFile);
        $stmt->fetch();
        $stmt->close();

        // 2) Remove the file from disk
        $path = './../uploads/' . $imageFile;
        if (is_file($path)) {
            @unlink($path);
        }

        // 3) Delete the database record
        $stmt = $this->db->prepare("DELETE FROM perfumes WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
