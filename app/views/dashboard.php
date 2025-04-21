<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../models/Transaction.php';

//session_name(SESSION_NAME);
//session_start();

$transactionModel = new Transaction();
$userId = $_SESSION[SESSION_NAME]['id'];
$resumo = $transactionModel->getResumoMensal($userId);
$evolucao = $transactionModel->getEvolucaoSaldos($userId);

$saldo = $resumo['receita'] - $resumo['despesa'];

$user = $_SESSION[SESSION_NAME] ?? null;
?>

<div class="container mt-4 text-white">
    <h2 class="text-center mb-4">Resumo Financeiro</h2>

    <div class="container mt-4 text-white">

    <div class="row text-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="bg-secondary bg-opacity-25 p-3 rounded shadow-sm w-100">
            <i class="bi bi-person-fill fs-4"></i>
            <p class="mb-1"><strong>Nome</strong></p>
            <p class="text-white"><?= htmlspecialchars($user['name']) ?></p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-secondary bg-opacity-25 p-3 rounded shadow-sm w-100">
            <i class="bi bi-envelope-fill fs-4"></i>
            <p class="mb-1"><strong>Email</strong></p>
            <p class="text-white"><?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>
</div>


    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="bg-success bg-opacity-25 p-3 rounded shadow-sm">
                <h4>Receitas</h4>
                <p class="fs-4 text">R$ <?= number_format($resumo['receita'], 2, ',', '.') ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-danger bg-opacity-25 p-3 rounded shadow-sm">
                <h4>Despesas</h4>
                <p class="fs-4 text">R$ <?= number_format($resumo['despesa'], 2, ',', '.') ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-primary bg-opacity-25 p-3 rounded shadow-sm">
                <h4>Saldo</h4>
                <p class="fs-4 <?= $saldo < 0 ? 'text-danger' : 'text' ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Gráfico de Pizza -->
        <div class="col-md-6">
            <div class="bg-dark p-4 rounded shadow-sm">
                <h5 class="text-center mb-3">Distribuição de Gastos</h5>
                <canvas id="graficoPizza"></canvas>
            </div>
        </div>

        <!-- Gráfico de Linha -->
        <div class="col-md-6">
            <div class="bg-dark p-4 rounded shadow-sm">
                <h5 class="text-center mb-3">Evolução de Saldo</h5>
                <canvas id="graficoLinha"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados PHP para JS
    const receitas = <?= json_encode($resumo['receita']) ?>;
    const despesas = <?= json_encode($resumo['despesa']) ?>;

    const dadosEvolucao = <?= json_encode($evolucao) ?>;
    const labels = dadosEvolucao.map(e => e.mes);
    const dataSaldo = dadosEvolucao.map(e => e.total_receitas - e.total_despesas);

    // Gráfico Pizza
    new Chart(document.getElementById('graficoPizza'), {
        type: 'pie',
        data: {
            labels: ['Receitas', 'Despesas'],
            datasets: [{
                data: [receitas, despesas],
                backgroundColor: ['#198754', '#dc3545'],
            }]
        }
    });

    // Gráfico Linha
    new Chart(document.getElementById('graficoLinha'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Saldo',
                data: dataSaldo,
                borderWidth: 2,
                tension: 0.4
            }]
        }
    });
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
