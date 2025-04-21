<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center text-white">Cadastrar</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/register" method="POST" class="bg-dark text-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Senha:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-light">Cadastrar</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
