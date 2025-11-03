<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login
header('Location: ../login.html');
exit;
?>
