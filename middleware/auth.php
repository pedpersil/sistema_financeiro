<?php
session_name(SESSION_NAME);
session_start();

if (!isset($_SESSION[SESSION_NAME])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}
