<?php

require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../../config/config.php';

class CategoryController
{
    private Category $model;

    public function __construct()
    {
        $this->model = new Category();
    }

    public function index(): void
    {
        //session_name(SESSION_NAME);
        //session_start();

        $userId = $_SESSION[SESSION_NAME]['id'];
        $categories = $this->model->getAllByUser($userId);

        include __DIR__ . '/../views/categories/index.php';
    }

    public function create(): void
    {
        include __DIR__ . '/../views/categories/create.php';
    }

    public function store(): void
    {
        session_name(SESSION_NAME);
        session_start();

        $data = [
            'user_id' => $_SESSION[SESSION_NAME]['id'],
            'name'    => $_POST['name'] ?? '',
            'type'    => $_POST['type'] ?? 'despesa',
        ];

        $this->model->create($data);
        header('Location: ' . BASE_URL . '/categorias');
    }

    public function edit(int $id): void
    {
        $category = $this->model->find($id);
        include __DIR__ . '/../views/categories/edit.php';
    }

    public function update(int $id): void
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'type' => $_POST['type'] ?? 'despesa',
        ];

        $this->model->update($id, $data);
        header('Location: ' . BASE_URL . '/categorias');
    }

    public function delete(int $id): void
    {
        $this->model->delete($id);
        header('Location: ' . BASE_URL . '/categorias');
    }
}
