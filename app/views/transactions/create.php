<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-white text-center mb-4">Nova Transação</h2>

    <form action="<?= BASE_URL ?>/transacoes/store" method="POST" class="bg-dark text-white p-4 rounded">
        <div class="mb-3">
            <label>Categoria:</label>
            <select name="category_id" class="form-select" required>
                <!-- As categorias virão do banco depois -->
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= htmlspecialchars($categoria['id']) ?>"><?= htmlspecialchars($categoria['name']) ?> (<?= htmlspecialchars($categoria['type']) ?>)</option>                          
                <?php endforeach; ?> 
            </select>
        </div>
        <div class="mb-3">
            <label>Descrição:</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Valor (R$):</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Data:</label>
            <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <button type="submit" class="btn btn-light">Salvar</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
