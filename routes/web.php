<?php

require_once __DIR__ . '/../config/Database.php';

// Controllers
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/TransactionController.php';
require_once __DIR__ . '/../app/controllers/CategoryController.php';
require_once __DIR__ . '/../app/controllers/ReportController.php';

// Conexão com o banco
$db = (new Database())->connect();

// Inicializar Controllers
$authController = new AuthController();
$transactionController = new TransactionController();
$categoryController = new CategoryController();
$reportController = new ReportController();

// URI e método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/controle_financeiro/public'; // ajuste conforme seu ambiente
$uri = str_replace($basePath, '', $uri);
$method = $_SERVER['REQUEST_METHOD'];


// Página inicial / dashboard (rota protegida)
if ($uri === '/') {
    require __DIR__ . '/../middleware/auth.php';
    require __DIR__ . '/../app/views/dashboard.php';
}

elseif ($uri === '/dashboard') {
    require __DIR__ . '/../middleware/auth.php';
    require __DIR__ . '/../app/views/dashboard.php';
}

// Autenticação
elseif ($uri === '/login' && $method === 'GET') {
    $authController->showLogin();
} elseif ($uri === '/login' && $method === 'POST') {
    $authController->login();
} elseif ($uri === '/register' && $method === 'GET') {
    $authController->showRegister();
} elseif ($uri === '/register' && $method === 'POST') {
    $authController->register();
} elseif ($uri === '/logout') {
    $authController->logout();
} elseif ($uri == '/alterar-senha') {
    if ($method == 'GET') {
        $authController->changePasswordForm();
    } elseif ($method == 'POST') {
        $authController->changePassword();
    }
}


// Transações (Entradas e Saídas)
elseif ($uri === '/transacoes') {
    require __DIR__ . '/../middleware/auth.php';
    $transactionController->index();
} elseif ($uri === '/transacoes/create') {
    require __DIR__ . '/../middleware/auth.php';
    $transactionController->create();
} elseif ($uri === '/transacoes/store' && $method === 'POST') {
    require __DIR__ . '/../middleware/auth.php';
    $transactionController->store();
} elseif (preg_match('/\/transacoes\/edit\/(\d+)/', $uri, $matches)) {
    require __DIR__ . '/../middleware/auth.php';
    $transactionController->edit($matches[1]);
} elseif (preg_match('/\/transacoes\/update\/(\d+)/', $uri, $matches) && $method === 'POST') {
    require __DIR__ . '/../middleware/auth.php';
    $transactionController->update($matches[1]);
} elseif (preg_match('/\/transacoes\/delete\/(\d+)/', $uri, $matches)) {
    require __DIR__ . '/../middleware/auth.php';
    $transactionController->delete($matches[1]);
}


// Categorias
elseif ($uri === '/categorias') {
    require __DIR__ . '/../middleware/auth.php';
    $categoryController->index();
} elseif ($uri === '/categorias/create') {
    require __DIR__ . '/../middleware/auth.php';
    $categoryController->create();
} elseif ($uri === '/categorias/store' && $method === 'POST') {
    require __DIR__ . '/../middleware/auth.php';
    $categoryController->store();
} elseif (preg_match('/\/categorias\/edit\/(\d+)/', $uri, $matches)) {
    require __DIR__ . '/../middleware/auth.php';
    $categoryController->edit($matches[1]);
} elseif (preg_match('/\/categorias\/update\/(\d+)/', $uri, $matches) && $method === 'POST') {
    require __DIR__ . '/../middleware/auth.php';
    $categoryController->update($matches[1]);
} elseif (preg_match('/\/categorias\/delete\/(\d+)/', $uri, $matches)) {
    require __DIR__ . '/../middleware/auth.php';
    $categoryController->delete($matches[1]);
}


// Relatórios
elseif ($uri === '/relatorios') {
    require __DIR__ . '/../middleware/auth.php';
    $reportController->index();
} elseif ($uri === '/relatorios/pdf') {
    require __DIR__ . '/../middleware/auth.php';
    $reportController->exportPdf();
} elseif ($uri === '/relatorios/excel') {
    require __DIR__ . '/../middleware/auth.php';
    $reportController->exportExcel();
}


// Página de erro 404
else {
    http_response_code(404);
    echo "Página não encontrada.";
}
