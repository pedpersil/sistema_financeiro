<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-white text-center mb-4">Editar Transação</h2>

    <form action="<?= BASE_URL ?>/transacoes/update/<?= $transaction['id'] ?>" method="POST" class="bg-dark text-white p-4 rounded">
        <div class="mb-3">
            <label>Categoria:</label>
            <select name="category_id" class="form-select" required>
                <option value="">Selecione uma categoria</option>
                <?php
                    // Carregar categorias do usuário (você pode mover isso para o controller se quiser manter o padrão)
                    require_once __DIR__ . '/../../models/Category.php';
                    $categoryModel = new Category();
                    $userId = $_SESSION[SESSION_NAME]['id'];
                    $categories = $categoryModel->getAllByUser($userId);

                    foreach ($categories as $category):
                ?>
                    <option value="<?= $category['id'] ?>"
                        <?= $category['id'] == $transaction['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?> (<?= $category['type'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Descrição:</label>
            <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($transaction['description']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Valor (R$):</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="<?= htmlspecialchars($transaction['amount']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Data:</label>
            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($transaction['date']) ?>" required>
        </div>

        <button type="submit" class="btn btn-light">Atualizar</button>
        <a href="<?= BASE_URL ?>/transacoes" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
