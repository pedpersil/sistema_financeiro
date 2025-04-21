<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-white text-center mb-4">Editar Categoria</h2>

    <form action="<?= BASE_URL ?>/categorias/update/<?= $category['id'] ?>" method="POST" class="bg-dark text-white p-4 rounded">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Tipo:</label>
            <select name="type" class="form-select" required>
                <option value="receita" <?= $category['type'] === 'receita' ? 'selected' : '' ?>>Receita</option>
                <option value="despesa" <?= $category['type'] === 'despesa' ? 'selected' : '' ?>>Despesa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-light">Atualizar</button>
        <a href="<?= BASE_URL ?>/categorias" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
