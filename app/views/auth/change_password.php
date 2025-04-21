<?php 
require_once __DIR__ . '/../layouts/header.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div class="container my-5">
    
    <h2 class="text-center mb-4">Alterar Senha</h2>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/alterar-senha" method="POST" class="bg-dark p-4 rounded text-white shadow-sm">
        <div class="mb-3">
            <label for="senha_atual" class="form-label">Senha Atual:</label>
            <input type="password" name="senha_atual" id="senha_atual" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nova_senha" class="form-label">Nova Senha:</label>
            <input type="password" name="nova_senha" id="nova_senha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-light w-100">Alterar Senha</button>
    </form>
</div>


<?php 
require_once __DIR__ . '/../layouts/footer.php';
?>
