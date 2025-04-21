<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório Financeiro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background-color: #f0f0f0;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        .text-success {
            color: green;
            font-weight: bold;
        }
        .text-danger {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Relatório Financeiro</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Tipo</th>
            <th>Valor (R$)</th>
            <th>Data</th>
            <th>Usuário</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['description']) ?></td>
                <td><?= htmlspecialchars($t['category_name']) ?></td>
                <td class="<?= $t['category_type'] === 'receita' ? 'text-success' : 'text-danger' ?>">
                    <?= ucfirst($t['category_type']) ?>
                </td>
                <td><?= number_format($t['amount'], 2, ',', '.') ?></td>
                <td><?= date('d/m/Y', strtotime($t['date'])) ?></td>
                <td><?= htmlspecialchars($t['user_name']) ?></td>
                <td><?= htmlspecialchars($t['user_email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h4>Resumo Financeiro</h4>
<table>
    <tr>
        <th>Total de Entradas</th>
        <td style="color:green;">R$ <?= number_format($totalIncome, 2, ',', '.') ?></td>
    </tr>
    <tr>
        <th>Total de Saídas</th>
        <td style="color:red;">R$ <?= number_format($totalExpense, 2, ',', '.') ?></td>
    </tr>
    <tr>
        <th>Saldo Final</th>
        <td style="font-weight:bold; color:<?= $balance >= 0 ? 'green' : 'red' ?>;">
            R$ <?= number_format($balance, 2, ',', '.') ?>
        </td>
    </tr>
</table>

<p><strong>Total de registros:</strong> <?= count($transactions) ?></p>

</body>
</html>
