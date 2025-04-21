<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-white text-center mb-4">Nova Categoria</h2>

    <form action="<?= BASE_URL ?>/categorias/store" method="POST" class="bg-dark text-white p-4 rounded">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipo:</label>
            <select name="type" class="form-select" required>
                <option value="receita">Receita</option>
                <option value="despesa">Despesa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-light">Salvar</button>
        <a href="<?= BASE_URL ?>/categorias" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
