<?php

require_once __DIR__ . '/../../config/Database.php';

class Transaction
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function getAllByUser(int $userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT t.*, c.name AS category_name, c.type
            FROM transactions t
            JOIN categories c ON t.category_id = c.id
            WHERE t.user_id = :user_id
            ORDER BY t.date DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->conn->prepare("
            INSERT INTO transactions (user_id, category_id, description, amount, date)
            VALUES (:user_id, :category_id, :description, :amount, :date)
        ");
        return $stmt->execute([
            ':user_id'     => $data['user_id'],
            ':category_id' => $data['category_id'],
            ':description' => $data['description'],
            ':amount'      => $data['amount'],
            ':date'        => $data['date'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare("
            UPDATE transactions
            SET category_id = :category_id,
                description = :description,
                amount = :amount,
                date = :date
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id'          => $id,
            ':category_id' => $data['category_id'],
            ':description' => $data['description'],
            ':amount'      => $data['amount'],
            ':date'        => $data['date'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM transactions WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Soma receitas e despesas do mês atual
    public function getResumoMensal(int $userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT c.type, SUM(t.amount) AS total
            FROM transactions t
            JOIN categories c ON t.category_id = c.id
            WHERE t.user_id = :user_id
            AND MONTH(t.date) = MONTH(CURRENT_DATE())
            AND YEAR(t.date) = YEAR(CURRENT_DATE())
            GROUP BY c.type
        ");
        $stmt->execute([':user_id' => $userId]);

        $resumo = ['receita' => 0, 'despesa' => 0];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $resumo[$row['type']] = $row['total'];
        }

        return $resumo;
    }

    // Evolução dos saldos mês a mês (últimos 6 meses)
    public function getEvolucaoSaldos(int $userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT DATE_FORMAT(t.date, '%Y-%m') AS mes,
                SUM(CASE WHEN c.type = 'receita' THEN t.amount ELSE 0 END) AS total_receitas,
                SUM(CASE WHEN c.type = 'despesa' THEN t.amount ELSE 0 END) AS total_despesas
            FROM transactions t
            JOIN categories c ON t.category_id = c.id
            WHERE t.user_id = :user_id
            GROUP BY mes
            ORDER BY mes DESC
            LIMIT 6
        ");
        $stmt->execute([':user_id' => $userId]);
        return array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Summary of getByDateRange
     * @param string $start
     * @param string $end
     * @return array
     * 
     * [
    [
        'id' => 1,
        'description' => 'Salário',
        'amount' => 5000.00,
        'type' => 'income',
        'date' => '2025-04-01',
        'category_id' => 2,
        'user_id' => 1,
        'category_name' => 'Rendimentos',
        'category_type' => 'income',
        'user_name' => 'Pedro Silva',
        'user_email' => 'pedro@email.com'
    ]
     */
    public function getByDateRange(string $start, string $end): array {
        $userId = $_SESSION[SESSION_NAME]['id'];
    
        $sql = "
            SELECT 
                t.*, 
                c.name AS category_name, 
                c.type AS category_type,
                u.name AS user_name, 
                u.email AS user_email
            FROM transactions t
            INNER JOIN categories c ON t.category_id = c.id
            INNER JOIN users u ON t.user_id = u.id
            WHERE t.date BETWEEN :start AND :end
              AND t.user_id = :user_id
            ORDER BY t.date ASC
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':start', $start);
        $stmt->bindValue(':end', $end);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
