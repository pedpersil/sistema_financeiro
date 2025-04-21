<?php

require_once __DIR__ . '/../../config/Database.php';

class User {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function create(string $name, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hash
        ]);
    }

    public function changePassword(int $id, string $newPassword): bool {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':id' => $id
        ]);
    }
    
    public function verifyPassword(int $id, string $password): bool {
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($password, $user['password']);
    }
    
}
