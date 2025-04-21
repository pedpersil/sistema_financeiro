<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center text-white">Login</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/login" method="POST" class="bg-dark text-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Senha:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-light">Entrar</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
