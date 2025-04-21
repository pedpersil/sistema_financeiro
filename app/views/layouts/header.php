<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema Financeiro Pessoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Ícones Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- jQuery (obrigatório pro DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">

    <style>
        /* Tema Escuro Estelar */
        body {
            background-color: #0c0e1c;
            color: #e0e0ff;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #1a1f38, #0c0e1c);
            border-bottom: 1px solid #292c4b;
        }

        .navbar-brand, .nav-link {
            color: #cfd3ff !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #8ab4f8 !important;
        }

        .container {
            max-width: 960px;
        }

        .btn, .form-control, .form-select {
            background-color: #1a1f38;
            color: #ffffff;
            border: 1px solid #39446a;
        }

        .form-control:focus, .form-select:focus {
            border-color: #8ab4f8;
            box-shadow: 0 0 0 0.2rem rgba(138, 180, 248, 0.25);
        }

        .text-danger {
            color: #ff6b6b !important;
        }

        table.table-dark {
            background-color: #121426;
        }

        .table-dark th, .table-dark td {
            border-color: #2c2f4d;
        }

        .shadow-sm {
            box-shadow: 0 0 15px rgba(138, 180, 248, 0.1) !important;
        }
    </style>
</head>
<body>
    
<!-- Loader -->
<div id="pageLoader" style="position: fixed; z-index: 9999; background: #121212; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
    <img src="<?= BASE_URL ?>/images/loading.gif" alt="Carregando..." style="width: 80px;">
</div>

<script>
// Remove o loader após o carregamento da página
window.addEventListener('load', function () {
    const loader = document.getElementById('pageLoader');
    if (loader) {
        loader.style.transition = "opacity 0.5s ease";
        loader.style.opacity = "0";
        setTimeout(() => loader.remove(), 500);
    }
});
</script>

<nav class="navbar navbar-expand-lg mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/dashboard">🌌 Sistema Financeiro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon text-white"></span>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION[SESSION_NAME])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/transacoes">Transações</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/categorias">Categorias</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/relatorios">Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/alterar-senha">Alterar Senha</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="<?= BASE_URL ?>/logout"><i class="bi bi-box-arrow-right"></i>Sair</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/register">Cadastro</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
