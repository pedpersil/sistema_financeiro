<?php

require_once __DIR__ . '/../../config/Database.php';

class Category
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function getAllByUser(int $userId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE user_id = :user_id ORDER BY name ASC");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (user_id, name, type) VALUES (:user_id, :name, :type)");
        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':name'    => $data['name'],
            ':type'    => $data['type']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name = :name, type = :type WHERE id = :id");
        return $stmt->execute([
            ':id'   => $id,
            ':name' => $data['name'],
            ':type' => $data['type']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
