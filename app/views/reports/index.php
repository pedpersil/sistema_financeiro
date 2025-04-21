<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2 class="text-center mb-4">Relatório Financeiro</h2>

<form method="GET" action="<?= BASE_URL ?>/relatorios" class="bg-dark p-4 rounded text-white mb-4">
    <div class="row">
        <div class="col-md-5 mb-3">
            <label>Data Inicial:</label>
            <input type="date" name="start_date" class="form-control" required value="<?= $_GET['start_date'] ?? '' ?>">
        </div>
        <div class="col-md-5 mb-3">
            <label>Data Final:</label>
            <input type="date" name="end_date" class="form-control" required value="<?= $_GET['end_date'] ?? '' ?>">
        </div>
        <div class="col-md-2 mb-3 d-flex align-items-end">
            <button type="submit" class="btn btn-light w-100">Filtrar</button>
        </div>
    </div>
</form>

<?php if (!empty($transactions)): ?>
    <div class="text-end mb-3">
        <a href="<?= BASE_URL ?>/relatorios/pdf?start_date=<?= $_GET['start_date'] ?>&end_date=<?= $_GET['end_date'] ?>" class="btn btn-danger" target="_blank">Exportar PDF</a>
        <a href="<?= BASE_URL ?>/relatorios/excel?start_date=<?= $_GET['start_date'] ?>&end_date=<?= $_GET['end_date'] ?>" class="btn btn-success" target="_blank">Exportar Excel</a>
    </div>

    <table class="table table-bordered table-dark table-hover">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['description']) ?></td>
                    <td><?= htmlspecialchars($t['category_name']) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['date'])) ?></td>
                    <td>R$ <?= number_format($t['amount'], 2, ',', '.') ?></td>
                    <td class="<?= $t['category_type'] === 'receita' ? 'text-success' : 'text-danger' ?>">
                        <?= ucfirst($t['category_type']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <h5>Resumo Financeiro</h5>
        <ul class="list-group">
            <li class="list-group-item bg-dark text-white">Total de Entradas: <strong class="text-success">R$ <?= number_format($totalIncome, 2, ',', '.') ?></strong></li>
            <li class="list-group-item bg-dark text-white">Total de Saídas: <strong class="text-danger">R$ <?= number_format($totalExpense, 2, ',', '.') ?></strong></li>
            <li class="list-group-item bg-dark text-white">Saldo Final: <strong class="<?= $balance >= 0 ? 'text-success' : 'text-danger' ?>">R$ <?= number_format($balance, 2, ',', '.') ?></strong></li>
        </ul>
    </div>

<?php elseif ($_GET): ?>
    <div class="alert alert-warning">Nenhum resultado encontrado no período informado.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
