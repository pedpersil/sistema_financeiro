<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../config/config.php';

class AuthController {

    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showLogin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
        
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        include __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
        
        $error = $_SESSION['register_error'] ?? null;
        unset($_SESSION['register_error']);

        $success = $_SESSION['register_success'] ?? null;
        unset($_SESSION['register_success']);

        include __DIR__ . '/../views/auth/register.php';
    }

    public function login(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
        

        $userModel = new User();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_name(SESSION_NAME);
            session_start();
            $_SESSION[SESSION_NAME] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $_SESSION['login_error'] = 'Email ou senha inválidos.';
        header('Location: ' . BASE_URL . '/login');
    }

    public function register(): void {
        $userModel = new User();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }

        if ($userModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Email já está em uso.';
            header('Location: ' . BASE_URL . '/register');
            return;
        }

        $userModel->create($name, $email, $password);
        $_SESSION['register_success'] = 'Usuário criado com sucesso!';
        header('Location: ' . BASE_URL . '/register');
    }

    public function changePasswordForm(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
        
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);

        include __DIR__ . '/../views/auth/change_password.php';
    }

    public function changePassword(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION[SESSION_NAME]['id'];
            $currentPassword = $_POST['senha_atual'] ?? '';
            $newPassword = $_POST['nova_senha'] ?? '';

            $userModel = new User();
    
            if ($this->userModel->verifyPassword($id, $currentPassword)) {
                $this->userModel->changePassword($id, $newPassword);
                $_SESSION['success'] = 'Senha alterada com sucesso!';
            } else {
                $_SESSION['error'] = 'Senha atual incorreta.';
            }
    
            header('Location: ' . BASE_URL . '/alterar-senha');
            exit;
        }
    }
    

    public function logout(): void {
        session_name(SESSION_NAME);
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
    }
}
