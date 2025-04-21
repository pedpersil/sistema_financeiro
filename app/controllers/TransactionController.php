<?php

require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../../config/config.php';

class TransactionController
{
    private Transaction $model;
    private Category $categoryModel;

    public function __construct()
    {
        $this->model = new Transaction();
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        //session_name(SESSION_NAME);
        //session_start();

        $userId = $_SESSION[SESSION_NAME]['id'];
        $transactions = $this->model->getAllByUser($userId);

        include __DIR__ . '/../views/transactions/index.php';
    }

    public function create(): void
    {
        $categorias = $this->categoryModel->getAllByUser($_SESSION[SESSION_NAME]['id']);
        include __DIR__ . '/../views/transactions/create.php';
    }

    public function store(): void
    {
        session_name(SESSION_NAME);
        session_start();

        $data = [
            'user_id'     => $_SESSION[SESSION_NAME]['id'],
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'],
            'amount'      => $_POST['amount'],
            'date'        => $_POST['date'],
        ];

        $this->model->create($data);

        header('Location: ' . BASE_URL . '/transacoes');
        exit;
    }

    public function edit(int $id): void
    {
        $transaction = $this->model->find($id);
        include __DIR__ . '/../views/transactions/edit.php';
    }

    public function update(int $id): void
    {
        $data = [
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'],
            'amount'      => $_POST['amount'],
            'date'        => $_POST['date'],
        ];

        $this->model->update($id, $data);
        header('Location: ' . BASE_URL . '/transacoes');
    }

    public function delete(int $id): void
    {
        $this->model->delete($id);
        header('Location: ' . BASE_URL . '/transacoes');
    }
}
