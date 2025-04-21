<!-- app/views/categories/index.php -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-white">Minhas Categorias</h2>
        <a href="<?= BASE_URL ?>/categorias/create" class="btn btn-light">Nova Categoria</a>
    </div>

    <div class="table-responsive bg-dark text-white p-3 rounded shadow-sm">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= ucfirst($category['type']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/categorias/edit/<?= $category['id'] ?>" class="btn btn-sm btn-outline-warning">Editar</a>
                            <a href="<?= BASE_URL ?>/categorias/delete/<?= $category['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir categoria?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
