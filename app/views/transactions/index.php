<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-white">Minhas Transações</h2>
        <a href="<?= BASE_URL ?>/transacoes/create" class="btn btn-light">Nova Transação</a>
    </div>

    <div class="table-responsive bg-dark text-white p-3 rounded shadow-sm">
        <table id="tabela-transacoes" class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($t['date']))) ?></td>
                        <td><?= htmlspecialchars($t['category_name']) ?> (<?= $t['type'] ?>)</td>
                        <td><?= htmlspecialchars($t['description']) ?></td>
                        <td class="<?= $t['type'] === 'despesa' ? 'text-danger' : 'text-success' ?>">
                            R$ <?= number_format($t['amount'], 2, ',', '.') ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/transacoes/edit/<?= $t['id'] ?>" class="btn btn-sm btn-outline-warning">Editar</a>
                            <a href="<?= BASE_URL ?>/transacoes/delete/<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir transação?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabela-transacoes').DataTable({
            "scrollX": true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
